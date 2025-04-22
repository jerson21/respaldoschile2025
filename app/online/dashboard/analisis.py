#!/usr/bin/env python3
import os
import json
import openai
import fnmatch
import tiktoken
import time

# --- Configuración ---
# Asegúrate de que la variable de entorno OPENAI_API_KEY esté configurada
openai.api_key = os.getenv("OPENAI_API_KEY")
if not openai.api_key:
    print("Error: La variable de entorno OPENAI_API_KEY no está configurada.")
    print("Por favor, configúrala antes de ejecutar el script.")
    exit(1)

# !!! VERIFICA ESTE NOMBRE DEL MODELO !!!
# Ya cambiaste a 'gpt-4o-2024-05-13', lo cual es correcto.
# Mantenemos este nombre, pero asegúrate de que sea el que deseas usar y que esté disponible en tu cuenta.
# Tu límite de TPM para este modelo parece ser 30000, lo cual es bajo para gpt-4o.
# Si esto sigue causando problemas, podría ser un límite a nivel de cuenta que no podemos cambiar aquí.
MODEL = "gpt-4o-2024-05-13" # <--- ¡¡¡VERIFICA ESTO!!!

INPUT_DIR = "."  # Directorio raíz del proyecto a analizar
OUTPUT_SUMMARY = "project_understanding.txt"
AIIGNORE_FILE = ".aiignore"

# Temperaturas para las llamadas a la API
TEMPERATURE_ANALYSIS = 0.1
TEMPERATURE_SUMMARY = 0.2

# Límite de tokens para cada lote de análisis enviado a la API.
# REDUCIMOS AÚN MÁS ESTE VALOR para ajustarnos mejor a tu límite de 30000 TPM.
# Esto hará que cada solicitud sea más pequeña y aumentará las posibilidades de éxito.
# Aumentará el número total de lotes y el tiempo de ejecución.
MAX_TOKENS_PER_BATCH = 20000 # <--- REDUCIDO DE NUEVO

# Máximo de tokens para la respuesta del resumen final
MAX_OUTPUT_TOKENS_SUMMARY = 5000


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
             return len(text) // 4 # Aproximación muy груба
    return len(encoding.encode(text))

def api_call_with_retry(messages, model, temperature, max_tokens=None, retries=5, delay=5):
    """Realiza una llamada a la API de OpenAI con reintentos y manejo de RateLimit."""
    for i in range(retries):
        try:
            response = openai.chat.completions.create(
                model=model,
                messages=messages,
                temperature=temperature,
                max_tokens=max_tokens
            )
            # Asegurarse de que la respuesta tenga contenido
            if response and response.choices and response.choices[0].message and response.choices[0].message.content:
                 return response.choices[0].message.content
            elif i < retries - 1:
                 print(f"\nRespuesta vacía de la API (Intento {i+1}/{retries}). Reintentando en {delay} segundos...")
                 time.sleep(delay)
            else:
                 print(f"\nRespuesta vacía de la API después de {retries} reintentos.")
                 return None # Fallar si la respuesta está vacía después de todos los reintentos

        except openai.APIStatusError as e: # Capturar errores de estado HTTP (4xx, 5xx)
             print(f"\nError de API Status {e.status_code} (Intento {i+1}/{retries}): {e.response}")
             if e.status_code == 401: # Unauthorized - Clave API incorrecta
                 print("Error: Clave API no autorizada. Verifica tu OPENAI_API_KEY.")
                 return None # No tiene sentido reintentar si la clave es incorrecta
             if e.status_code == 404: # Not Found - Modelo incorrecto
                 print(f"Error: Modelo '{model}' no encontrado. Verifica el nombre del modelo en tu configuración.")
                 return None # No tiene sentido reintentar si el modelo no existe
             if e.status_code == 400 and "context_length_exceeded" in str(e.response): # Context window exceeded
                 print(f"Error: Ventana de contexto excedida. El lote es demasiado grande para el modelo '{model}'. Considera reducir MAX_TOKENS_PER_BATCH o usar un modelo con mayor ventana.")
                 return None # No tiene sentido reintentar si el lote es demasiado grande
             if i < retries - 1:
                 print(f"Reintentando en {delay} segundos...")
                 time.sleep(delay)
             else:
                 print(f"Error de API Status persistente después de {retries} reintentos.")
                 raise # Re-lanzar el último error si los reintentos se agotan
        except openai.RateLimitError as e: # Capturar errores de límite de tasa (429)
             print(f"\nError de Rate Limit (Intento {i+1}/{retries}): {e}")
             if i < retries - 1:
                 # Esperar un poco más en caso de Rate Limit con retroceso exponencial
                 wait_time = delay * (2 ** i)
                 print(f"Límite de tasa alcanzado. Reintentando en {wait_time} segundos...")
                 time.sleep(wait_time)
             else:
                 print(f"\nLímite de tasa persistente después de {retries} reintentos.")
                 raise
        except openai.APITimeoutError as e: # Capturar errores de timeout
             print(f"\nError de Timeout (Intento {i+1}/{retries}): {e}")
             if i < retries - 1:
                 print(f"Timeout. Reintentando en {delay} segundos...")
                 time.sleep(delay)
             else:
                 print(f"\nError de Timeout persistente después de {retries} reintentos.")
                 raise
        except Exception as e: # Capturar otros errores inesperados
            print(f"\nError inesperado (Intento {i+1}/{retries}): {e}")
            if i < retries - 1:
                print(f"Error inesperado. Reintentando en {delay} segundos...")
                time.sleep(delay)
            else:
                print(f"\nError inesperado persistente después de {retries} reintentos.")
                raise # Re-lanzar la excepción si los reintentos se agotan
    return None # Debería ser inalcanzable si se re-lanzan excepciones en el último intento


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
                # print(f"Ignorando: {file_path}") # Opcional: debug ignored files
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
        print("No se encontraron archivos relevantes para analizar.")
        return

    print(f"\nSe encontraron {len(all_files_content)} archivos elegibles para análisis.")

    # 2. Crear lotes de contenido de archivos para el análisis inicial
    analysis_batches_content = []
    current_batch_content = ""
    current_batch_tokens = 0
    batch_num = 1

    # Mensaje del sistema base para los lotes de análisis (define el rol para esta etapa)
    analysis_system_message_content = (
        "You are an AI expert assisting in the detailed code analysis of a web project."
        "You will receive content from specific files. Your task is to describe concisely and objectively "
        "the purpose of the file, key functions or classes it contains, main dependencies "
        "and its likely role within the overall project structure."
        "DO NOT attempt to summarize the entire project at this stage. Just describe the content of the files provided."
        "Format your response clearly, indicating the name of the file you are describing for each section."
        "If a file is empty or contains only configuration/minimal code, state that."
    )
    analysis_system_tokens = count_tokens(analysis_system_message_content)

    # Template del prompt de usuario para los lotes de análisis
    analysis_user_prompt_template = (
         "Analyze the content of the following code files and describe their purpose and key components:\n\n"
         "{files_content}"
    )
    # Estimar el overhead de tokens del prompt (mensaje de sistema + prompt de usuario sin contenido de archivo)
    # Sumamos también un buffer para la respuesta esperada de la API en cada lote (estimación).
    # Asegúrate de que el OVERHEAD + MAX_TOKENS_PER_BATCH < VENTANA_MODELO (considerando un buffer para la respuesta).
    # El overhead real de una llamada es sum(count_tokens(msg) for msg in messages).
    # Aquí estimamos el overhead de los prompts fijos para descontarlo del MAX_TOKENS_PER_BATCH "efectivo".
    fixed_prompt_overhead_tokens_est = analysis_system_tokens + count_tokens(analysis_user_prompt_template.format(files_content=""))
    response_buffer_tokens_est = 3000 # Estimación de tokens para la respuesta del modelo por lote

    print("\nCreando lotes de análisis (estimación de tokens)...")
    for file_path, content in all_files_content:
        # Incluir la ruta del archivo en el contenido enviado para que el modelo sepa de qué archivo es
        file_block = f"--- File: {file_path} ---\n{content}\n\n"
        file_block_tokens = count_tokens(file_block)

        # Calcular cuántos tokens restantes en el lote podemos aceptar
        # MAX_TOKENS_PER_BATCH es ahora el límite para el *contenido de los archivos* DENTRO del lote.
        # La comprobación es simple: ¿El archivo actual cabe en el espacio restante del lote de contenido?
        remaining_tokens_in_content_batch = MAX_TOKENS_PER_BATCH - current_batch_tokens

        # Si el archivo actual no cabe en el lote de contenido actual Y el lote actual NO está vacío
        if file_block_tokens > remaining_tokens_in_content_batch and current_batch_content:
            # Antes de cerrar el lote, verificar si el *mensaje total* excedería la ventana del modelo
            # si se agregara este archivo. Esto es una doble verificación, pero la principal es MAX_TOKENS_PER_BATCH
            # para el contenido. La comprobación del TPM es en la llamada a la API.

            # Cerramos el lote actual y comenzamos uno nuevo.
            analysis_batches_content.append(current_batch_content)
            # print(f"Lote {batch_num} listo ({current_batch_tokens} tokens de contenido). Iniciando nuevo lote.") # Opcional: debug batching
            batch_num += 1
            current_batch_content = file_block
            current_batch_tokens = file_block_tokens
        else:
            # Si el archivo cabe o si el lote actual está vacío, lo añadimos al lote actual.
            current_batch_content += file_block
            current_batch_tokens += file_block_tokens

    # Añadir el último lote si no está vacío
    if current_batch_content:
         analysis_batches_content.append(current_batch_content)
         # print(f"Lote {batch_num} listo ({current_batch_tokens} tokens de contenido).") # Opcional: debug batching

    if not analysis_batches_content:
        print("No se pudieron crear lotes de análisis con el contenido de los archivos.")
        return

    print(f"Se crearon {len(analysis_batches_content)} lotes para análisis inicial.")

    # 3. Enviar lotes de análisis a la API y recopilar respuestas
    analysis_responses = []
    print(f"\nEnviando {len(analysis_batches_content)} lotes de análisis a la API...")
    for i, batch_content in enumerate(analysis_batches_content):
        print(f"Procesando lote {i+1}/{len(analysis_batches_content)}...", end='', flush=True)

        # Construir mensajes incluyendo el overhead del prompt
        batch_messages = [
            {"role": "system", "content": analysis_system_message_content},
            {"role": "user", "content": analysis_user_prompt_template.format(files_content=batch_content)}
        ]

        try:
             # Llamada a la API para el análisis del lote actual
             response_text = api_call_with_retry(
                 messages=batch_messages,
                 model=MODEL,
                 temperature=TEMPERATURE_ANALYSIS,
                 # No ponemos max_tokens aquí para la respuesta de análisis, dejamos que el modelo decida
             )
             if response_text:
                 analysis_responses.append(response_text)
                 print(f"\rLote {i+1}/{len(analysis_batches_content)} procesado exitosamente.")
             else:
                 # Esto ocurre si api_call_with_retry devuelve None (después de todos los reintentos o error fatal)
                 analysis_responses.append(f"Error o respuesta vacía fatal para el lote {i+1}.") # Registrar si la llamada falló o dio vacío
                 print(f"\rError o respuesta vacía fatal para el lote {i+1}.")


             # Introduce un retardo entre llamadas exitosas o fallidas para mitigar el límite de TPM
             # Ajusta el tiempo según tu límite y el tamaño típico de tus lotes/respuestas.
             # 5 segundos es un punto de partida, puede que necesites más si el límite es estricto.
             time.sleep(5)

        except Exception as e: # Captura excepciones re-lanzadas por api_call_with_retry
             print(f"\nError fatal no manejado al procesar lote {i+1}: {e}")
             analysis_responses.append(f"Error fatal no manejado al procesar lote {i+1}: {e}") # Registrar el error fatal
             # No hay sleep aquí porque api_call_with_retry ya manejó los reintentos con espera,
             # pero un pequeño delay extra no hace daño si hubo un fallo total.
             time.sleep(5)


    # Limpiar línea de progreso final
    print("\r" + " " * 50, end='', flush=True)

    if not analysis_responses or all("Error fatal" in resp or "Error o respuesta vacía fatal" in resp for resp in analysis_responses):
        print("\nNo se recibieron respuestas de análisis válidas de la API. Abortando resumen.")
        return

    print(f"\nSe recibieron {len(analysis_responses)} respuestas de lotes de análisis.")

    # 4. Generar el resumen final de comprensión del proyecto
    print("\nGenerando resumen de entendimiento del proyecto...")

    # Mensaje del sistema para la etapa de resumen final
    patterns_list = ", ".join(ignore_patterns) if ignore_patterns else "(ninguno)"
    summary_system_message_content = (
         "Eres un experto en refactorización de proyectos web mixtos, con amplia experiencia "
         "en migrar monolitos PHP a arquitecturas limpias e integrar backends Node.js."
         "Basado en los análisis detallados de varios lotes de código que te he proporcionado anteriormente, "
         "sintetiza una comprensión global y exhaustiva del proyecto web. "
         "Debes ignorar conceptualmente las rutas definidas en .aiignore (" + patterns_list + ") y directorios comunes como node_modules o .git, ya que esos archivos no fueron incluidos en el análisis inicial."
         "Tu objetivo es ayudar a reorganizar y refactorizar este proyecto, manteniendo "
         "toda la lógica y funcionalidad actual, pero optimizando estructura y modularidad."
         "NO inventes información que no esté respaldada por los análisis previos que recibiste."
         "Presenta la información de forma estructurada según el prompt del usuario."
         "Si alguna sección no se pudo analizar debido a errores en los lotes o falta de información en ellos, menciónalo brevemente si es relevante, pero concéntrate en lo que sí pudiste analizar."
    )

    messages_for_summary = [
        {"role": "system", "content": summary_system_message_content}
    ]

    # Añadir las respuestas de cada lote de análisis como contexto (rol 'assistant)
    context_analysis_added = False
    for idx, resp_text in enumerate(analysis_responses, 1):
         # Omitir respuestas que fueron solo mensajes de error o vacías
         if "Error fatal al procesar lote" in resp_text or "Error o respuesta vacía fatal" in resp_text or not resp_text.strip():
             continue
         messages_for_summary.append({
             "role": "assistant",
             "content": f"=== Análisis Lote {idx} ===\n{resp_text}"
         })
         context_analysis_added = True

    if not context_analysis_added:
         print("\nAdvertencia: No se agregaron respuestas de análisis válidas al contexto para el resumen. El resumen será muy limitado.")


    # Prompt detallado de usuario para el resumen
    detailed_prompt = (
        "Basado en el análisis detallado de los lotes de código proporcionados anteriormente, "
        "por favor elabora un resumen **exhaustivo** de tu comprensión de este proyecto web y cómo nos ayudarás en su refactorización. "
        "Estructura tu respuesta cubriendo los siguientes puntos clave de manera numerada:\n\n"
        "1.  **Estructura de Carpetas y Archivos Clave:** Describe cada directorio y su propósito general según el análisis. Destaca los ficheros más relevantes encontrados y su función principal.\n\n"
        "2.  **Componentes Principales y Responsabilidades:** Identifica y describe los roles de los principales componentes de la aplicación encontrados (controllers, models, routes, views/templates, services, middlewares, scripts de entrada, etc.). ¿Cómo interactúan?\n\n"
        "3.  **Flujo de Datos y Lógica de Negocio Esencial:** Explica de alto nivel cómo se manejan las solicitudes entrantes. Describe el flujo típico de datos a través de los componentes. ¿Cómo se accede a la base de datos (si aplica)? ¿Qué tipo de validaciones o lógica crítica se observó?\n\n"
        "4.  **Integraciones y Dependencias Externas/Internas Actuales:** Menciona cualquier integración con servicios externos o internos, APIs, librerías o dependencias clave que hayas identificado en el código (ej. sistemas de autenticación, librerías de terceros, comunicación entre módulos).\n\n"
        "5.  **Convenciones, Patrones de Diseño o Configuraciones Críticas:** Describe cualquier patrón de diseño, convención de código (ej. MVC, nombres de archivos), o configuraciones importantes (ej. archivos de configuración, bootstrapping) que parezcan fundamentales para el funcionamiento actual del proyecto.\n\n"
        "6.  **Puntos Sensibles o Áreas de Interés Detectadas:** Basándote en los análisis de lotes, identifica si hay áreas del código que parezcan particularmente complejas, críticas para el rendimiento o la lógica de negocio (\"hotspots\") que requerirán atención cuidadosa durante la refactorización para preservar su funcionalidad. Si hubo errores en el análisis de lotes, menciona si eso impidió el análisis completo de alguna área.\n\n"
        "7.  **Propuesta de Pasos Iniciales para la Refactorización:** Sugiere un enfoque o los primeros pasos lógicos para comenzar la refactorización, teniendo en cuenta el objetivo de mantener la funcionalidad actual mientras se mejora la estructura y modularidad. ¿Qué áreas serían candidatas para refactorizar primero?\n\n"
        "Responde de forma clara, estructurada y numerada, demostrando tu rol de experto en refactorización de proyectos web y tu comprensión profunda basada en el análisis del código."
    )

    messages_for_summary.append({"role": "user", "content": detailed_prompt})

    # Calcular el número total de tokens para la llamada del resumen
    total_summary_prompt_tokens = sum(count_tokens(msg['content'], MODEL) for msg in messages_for_summary)
    print(f"\nTotal de tokens estimados para el prompt de resumen: {total_summary_prompt_tokens}")

    # Intentar obtener la ventana máxima del modelo configurado
    try:
        model_max_tokens = tiktoken.encoding_for_model(MODEL).max_model_tokens
    except KeyError:
        model_max_tokens = 128000 # Ventana típica de modelos gpt-4 de contexto largo
        print(f"Advertencia: Modelo '{MODEL}' no reconocido por tiktoken. Usando ventana de contexto de {model_max_tokens} como fallback.")


    if total_summary_prompt_tokens + MAX_OUTPUT_TOKENS_SUMMARY > model_max_tokens:
        print(f"Advertencia: El prompt del resumen ({total_summary_prompt_tokens} tokens) + respuesta esperada ({MAX_OUTPUT_TOKENS_SUMMARY} tokens)")
        print(f"puede exceder la ventana de contexto del modelo '{MODEL}' ({model_max_tokens} tokens).")
        print("El modelo puede truncar la respuesta. Considera reducir el número de archivos analizados,")
        print("el tamaño de MAX_TOKENS_PER_BATCH, o MAX_OUTPUT_TOKENS_SUMMARY.")


    # 5. Llamada a la API para obtener el resumen final
    try:
        print("Llamando a la API para generar el resumen final...")
        summary_text = api_call_with_retry(
            messages=messages_for_summary,
            model=MODEL,
            temperature=TEMPERATURE_SUMMARY,
            max_tokens=MAX_OUTPUT_TOKENS_SUMMARY # Limitar el tamaño del resumen de salida
        )

        if summary_text:
            # 6. Guardar resumen en un archivo de texto
            with open(OUTPUT_SUMMARY, "w", encoding="utf-8") as f:
                f.write(summary_text)

            print(f"\n¡Éxito! Resumen de comprensión del proyecto guardado en {OUTPUT_SUMMARY}")
        else:
            print("\nError: No se recibió respuesta del resumen de la API después de reintentos o la respuesta estaba vacía.")

    except Exception as e:
        print(f"\nError fatal no manejado al generar el resumen final después de reintentos: {e}")


if __name__ == "__main__":
    main()