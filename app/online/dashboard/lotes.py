#!/usr/bin/env python3
import os
# json, openai, time ya no son estrictamente necesarios en este script de solo guardar,
# pero mantendremos tiktoken para el conteo de tokens y fnmatch para .aiignore.
import fnmatch
import tiktoken
# import json
# import openai
# import time

# --- Configuración ---
# No necesitamos la clave API ni la temperatura ni el archivo de lotes de respuesta anteriores.
# Mantenemos el nombre del modelo solo para que el conteo de tokens sea consistente
# con el script de análisis real.
MODEL = "gpt-4o-2024-05-13" # Usado solo para el conteo de tokens con tiktoken
INPUT_DIR = "."  # Directorio raíz del proyecto a analizar
OUTPUT_BATCH_DIR = "lotes_analisis_guardados" # <--- NUEVA: Carpeta donde se guardarán los lotes
AIIGNORE_FILE = ".aiignore"

# Mantenemos este límite para replicar cómo se dividirían los lotes para el análisis.
# Usa el valor que resultó en ~90 lotes la última vez que funcionó la creación de lotes.
MAX_TOKENS_PER_BATCH = 20000 # Usando el valor que resultó en ~90 lotes en la ejecución anterior

# System and User prompt templates - Incluiremos esto en los archivos guardados para mostrar el contexto API
analysis_system_message_content = (
    "You are an AI expert assisting in the detailed code analysis of a web project."
    "You will receive content from specific files. Your task is to describe concisely and objectively "
    "the purpose of the file, key functions or classes it contains, main dependencies "
    "and its likely role within the overall project structure."
    "DO NOT attempt to summarize the entire project at this stage. Just describe the content of the files provided."
    "Format your response clearly, indicating the name of the file you are describing for each section."
    "If a file is empty or contains only configuration/minimal code, state that."
)

analysis_user_prompt_template = (
     "Analyze the content of the following code files and describe their purpose and key components:\n\n"
     "{files_content}"
)


# --- Funciones Auxiliares ---

def load_aiignore_patterns():
    """Carga patrones de exclusión desde .aiignore."""
    pats = []
    try:
        with open(AIIGNORE_FILE, encoding="utf-8") as f:
            for line in f:
                line = line.strip()
                # Ignorar líneas vacías y comentarios
                if line and not line.startswith("#"):
                    # Normalizar para fnmatch, especialmente barras al final para directorios
                    if line.endswith('/'):
                        pats.append(line.rstrip('/') + '/**') # Match contents of directory
                        pats.append(line.rstrip('/')) # Match the directory itself if needed (less common but possible)
                    else:
                        pats.append(line)
    except FileNotFoundError:
        print(f"Advertencia: No se encontró el archivo {AIIGNORE_FILE}. No se aplicarán exclusiones personalizadas.")
        pass # No patterns to load if file doesn't exist
    return pats

def should_ignore(file_path, ignore_patterns):
    """Verifica si una ruta de archivo debe ser ignorada."""
    # Normaliza la ruta para asegurar consistencia (ej: usa / en lugar de \)
    normalized_path = os.path.normpath(file_path).replace(os.sep, '/')

    # Ignorar siempre directorios comunes del entorno de desarrollo/git
    # Añadir "/" al final para asegurar que solo ignore directorios con ese nombre
    common_dir_ignores = ['/.git/', '/node_modules/', '/vendor/', '/build/', '/dist/', '/.vscode/', '/.idea/', '/__pycache__/']
    for common in common_dir_ignores:
        if common in normalized_path + '/': # Add '/' to normalized_path for checking if it ends with a common ignore dir
            return True

    # Ignorar archivos ocultos y directorios ocultos al principio de la ruta (excepto .aiignore)
    # Considera el caso de "./.aiignore"
    parts = normalized_path.split('/')
    # Ignorar si el primer elemento (después de .) empieza por punto, a menos que sea .aiignore en la raíz
    if parts and parts[0] == '.' and len(parts) > 1 and parts[1].startswith('.') and parts[1] != os.path.basename(AIIGNORE_FILE):
         return True
    # Ignorar cualquier parte del path que sea un directorio oculto (empieza por .)
    if any(part.startswith('.') and part != '.' and part != '..' for part in parts):
        return True


    # Verificar patrones cargados desde .aiignore
    for pattern in ignore_patterns:
         if fnmatch.fnmatch(normalized_path, pattern):
             return True

    return False

def count_tokens(text, model_name=MODEL):
    """Cuenta tokens en una cadena de texto usando tiktoken."""
    # Usar un modelo conocido por tiktoken si el MODEL configurado no se encuentra
    try:
        encoding = tiktoken.encoding_for_model(model_name)
    except KeyError:
        # Fallback a una codificación común compatible con modelos recientes como GPT-4
        try:
            encoding = tiktoken.get_encoding("cl100k_base")
            # print(f"Advertencia: Modelo '{model_name}' no encontrado por tiktoken, usando 'cl100k_base'.") # Opcional: debug warning
        except Exception as e:
             print(f"Error: No se pudo obtener codificación tiktoken para 'cl100k_base': {e}")
             # Fallback a un método de conteo muy simple si tiktoken falla (menos preciso)
             return len(text) // 4 # Aproximación muy груba
    return len(encoding.encode(text))

def get_file_content(file_path):
    """Lee el contenido de un archivo con manejo básico de errores de codificación."""
    try:
        # Intentar con codificación UTF-8 primero (la más común)
        with open(file_path, 'r', encoding='utf-8') as f:
            return f.read()
    except UnicodeDecodeError:
        # Si falla, intentar con otra codificación común (ej. latin-1)
        try:
            with open(file_path, 'r', encoding='latin-1') as f:
                return f.read()
        except Exception as e:
            #print(f"Error: No se pudo leer el archivo '{file_path}' con UTF-8 o latin-1: {e}") # Opcional: debug error
            return "" # Devolver cadena vacía si no se puede leer con encodings comunes
    except Exception as e:
        #print(f"Error: No se pudo leer el archivo '{file_path}': {e}") # Opcional: debug error
        return "" # Devolver cadena vacía si ocurre otro error


# --- Lógica Principal ---

def main():
    ignore_patterns = load_aiignore_patterns()

    all_files_content = [] # Lista para almacenar tuplas (ruta_archivo, contenido)

    # 1. Recopilar contenido de archivos elegibles
    print(f"Recopilando contenido de archivos desde '{os.path.abspath(INPUT_DIR)}' (excluyendo según .aiignore y patrones comunes)...")
    # Contar archivos y directorios totales para dar feedback
    total_items = 0
    # Primera pasada para estimar el total (puede ser lento en proyectos grandes)
    for root, dirs, files in os.walk(INPUT_DIR):
        total_items += len(dirs) + len(files) # Estimación rápida

    processed_items = 0
    for root, dirs, files in os.walk(INPUT_DIR):
        # Modificar dirs in-place para evitar recorrer directorios ignorados
        # Filtrar directorios ANTES de entrar en ellos
        dirs[:] = [d for d in dirs if not should_ignore(os.path.join(root, d), ignore_patterns)]

        for file in files:
            processed_items += 1
            file_path = os.path.join(root, file)

            # Mostrar progreso simple
            print(f"\rProcesando archivos: {processed_items} items...", end='', flush=True)

            if should_ignore(file_path, ignore_patterns):
                continue

            # Omitir archivos binarios o grandes que rara vez son útiles para el análisis de código
            if any(file_path.lower().endswith(ext) for ext in ['.jpg', '.png', '.gif', '.bin', '.pdf', '.zip', '.tar.gz', '.ico', '.svg', '.woff', '.woff2', '.tff', '.eot', '.dll', '.exe', '.a', '.so', '.obj', '.pyc', '.class']):
                 continue

            try:
                content = get_file_content(file_path)
                if content: # Solo añadir si se pudo leer contenido no vacío
                    all_files_content.append((file_path, content))
            except Exception as e:
                print(f"\nError al procesar archivo {file_path} (Excepción no manejada en get_file_content): {e}")


    print("\r" + " " * 50, end='', flush=True) # Limpiar línea de progreso
    if not all_files_content:
        print("No se encontraron archivos relevantes para guardar en lotes.")
        return

    print(f"\nSe encontraron {len(all_files_content)} archivos elegibles para batching.")

    # 2. Crear directorio de salida si no existe
    os.makedirs(OUTPUT_BATCH_DIR, exist_ok=True)
    print(f"Guardando lotes de contenido de archivos en el directorio: '{OUTPUT_BATCH_DIR}'")

    # 3. Crear lotes de contenido y guardarlos en archivos
    print("\nCreando y guardando lotes de análisis...")
    current_batch_content = ""
    current_batch_tokens = 0
    batch_num = 1

    # Calcular el overhead de los prompts fijos una vez
    fixed_prompt_overhead_tokens = count_tokens(analysis_system_message_content) + count_tokens(analysis_user_prompt_template.format(files_content=""))
    print(f"Estimación de tokens fijos por lote (System+User base): {fixed_prompt_overhead_tokens}")
    print(f"Límite de tokens de contenido por lote: {MAX_TOKENS_PER_BATCH}")


    for file_path, content in all_files_content:
        # Incluir la ruta del archivo en el contenido enviado para que el modelo sepa de qué archivo es
        # Este es el bloque que irá dentro de la sección {files_content} del prompt del usuario.
        file_block = f"--- File: {file_path} ---\n{content}\n\n"
        file_block_tokens = count_tokens(file_block)

        # Verificar si añadir este archivo excede el límite de tokens *para el contenido del lote*
        remaining_tokens_in_content_batch = MAX_TOKENS_PER_BATCH - current_batch_tokens

        # Si el archivo actual no cabe en el espacio restante del lote de contenido Y el lote actual NO está vacío
        if file_block_tokens > remaining_tokens_in_content_batch and current_batch_content:
            # Batch is full or file is too large for remaining space, save current batch
            batch_filename = os.path.join(OUTPUT_BATCH_DIR, f"batch_{batch_num}.txt")
            with open(batch_filename, "w", encoding="utf-8") as f:
                # Escribir la estructura completa del mensaje que se enviaría a la API
                f.write(f"--- Estructura del Mensaje de Solicitud de Análisis API de OpenAI (Lote {batch_num}) ---\n")
                f.write(f"--- Estimación de Tokens de Contenido: {current_batch_tokens}, Overhead Fijo: ~{fixed_prompt_overhead_tokens}, Total Estimado: ~{current_batch_tokens + fixed_prompt_overhead_tokens} ---\n\n")
                f.write("=== Mensaje del Sistema ===\n")
                f.write(analysis_system_message_content)
                f.write("\n\n=== Prompt del Usuario (incluyendo contenido del lote) ===\n")
                f.write(analysis_user_prompt_template.format(files_content=current_batch_content))
                f.write("\n\n--- Fin de la Estructura del Mensaje ---\n")
                # Opción alternativa: guardar solo el contenido crudo del lote
                # f.write(current_batch_content)
            print(f"Guardado {batch_filename} ({current_batch_tokens} tokens de contenido).")

            # Start a new batch with the current file
            batch_num += 1
            current_batch_content = file_block
            current_batch_tokens = file_block_tokens
        else:
            # Add file to the current batch
            current_batch_content += file_block
            current_batch_tokens += file_block_tokens

    # Save the last batch if it's not empty
    if current_batch_content:
        batch_filename = os.path.join(OUTPUT_BATCH_DIR, f"batch_{batch_num}.txt")
        with open(batch_filename, "w", encoding="utf-8") as f:
            # Escribir la estructura completa del mensaje
            f.write(f"--- Estructura del Mensaje de Solicitud de Análisis API de OpenAI (Lote {batch_num}) ---\n")
            f.write(f"--- Estimación de Tokens de Contenido: {current_batch_tokens}, Overhead Fijo: ~{fixed_prompt_overhead_tokens}, Total Estimado: ~{current_batch_tokens + fixed_prompt_overhead_tokens} ---\n\n")
            f.write("=== Mensaje del Sistema ===\n")
            f.write(analysis_system_message_content)
            f.write("\n\n=== Prompt del Usuario (incluyendo contenido del lote) ===\n")
            f.write(analysis_user_prompt_template.format(files_content=current_batch_content))
            f.write("\n\n--- Fin de la Estructura del Mensaje ---\n")
             # Opción alternativa: guardar solo el contenido crudo del lote
            # f.write(current_batch_content)
        print(f"Guardado {batch_filename} ({current_batch_tokens} tokens de contenido).")
        batch_num += 1 # Incrementar para contar el último lote en el total

    print(f"\nProceso de guardado de lotes completado. Total de lotes creados: {batch_num - 1}") # Restar 1 porque el último incremento es después de guardar


# --- Helper Function Implementations (copiar del script anterior) ---
# load_aiignore_patterns
# should_ignore
# count_tokens
# get_file_content

# Implementación de las funciones auxiliares (copia exacta del script anterior)

def load_aiignore_patterns():
    """Carga patrones de exclusión desde .aiignore."""
    pats = []
    try:
        with open(AIIGNORE_FILE, encoding="utf-8") as f:
            for line in f:
                line = line.strip()
                if line and not line.startswith("#"):
                    if line.endswith('/'):
                        pats.append(line.rstrip('/') + '/**')
                        pats.append(line.rstrip('/'))
                    else:
                        pats.append(line)
    except FileNotFoundError:
        print(f"Advertencia: No se encontró el archivo {AIIGNORE_FILE}. No se aplicarán exclusiones personalizadas.")
        pass
    return pats

def should_ignore(file_path, ignore_patterns):
    """Verifica si una ruta de archivo debe ser ignorada."""
    normalized_path = os.path.normpath(file_path).replace(os.sep, '/')
    common_dir_ignores = ['/.git/', '/node_modules/', '/vendor/', '/build/', '/dist/', '/.vscode/', '/.idea/', '/__pycache__/']
    for common in common_dir_ignores:
        if common in normalized_path + '/':
            return True
    parts = normalized_path.split('/')
    if parts and parts[0] == '.' and len(parts) > 1 and parts[1].startswith('.') and parts[1] != os.path.basename(AIIGNORE_FILE):
         return True
    if any(part.startswith('.') and part != '.' and part != '..' for part in parts):
        return True
    for pattern in ignore_patterns:
         if fnmatch.fnmatch(normalized_path, pattern):
             return True
    return False

def count_tokens(text, model_name=MODEL):
    """Cuenta tokens en una cadena de texto usando tiktoken."""
    try:
        encoding = tiktoken.encoding_for_model(model_name)
    except KeyError:
        try:
            encoding = tiktoken.get_encoding("cl100k_base")
        except Exception as e:
             print(f"Error: No se pudo obtener codificación tiktoken para 'cl100k_base': {e}")
             return len(text) // 4
    return len(encoding.encode(text))

def get_file_content(file_path):
    """Lee el contenido de un archivo con manejo básico de errores de codificación."""
    try:
        with open(file_path, 'r', encoding='utf-8') as f:
            return f.read()
    except UnicodeDecodeError:
        try:
            with open(file_path, 'r', encoding='latin-1') as f:
                return f.read()
        except Exception as e:
            return ""
    except Exception as e:
        return ""


if __name__ == "__main__":
    main()