#!/usr/bin/env python3
import os
import sys
import fnmatch

try:
    import tiktoken
except ImportError:
    print("Error: tiktoken no está instalado. Instálalo con `pip install tiktoken` y vuelve a intentarlo.")
    sys.exit(1)

# Modelo a usar para estimar tokens
MODEL_NAME = "gpt-4"

# Tipos de archivo a incluir
EXTS = {".php", ".js", ".ts", ".json", ".yml", ".yaml", ".env", ".dockerfile", "Dockerfile"}

# Nombre del fichero con patrones a ignorar
AIIGNORE = ".aiignore"

def load_ignore_patterns(ignore_file):
    """
    Carga patrones desde .aiignore, ignorando comentarios y líneas vacías.
    Cada línea puede usar comodines tipo '*.min.js' o 'vendor/**'.
    """
    patterns = []
    try:
        with open(ignore_file, encoding="utf-8") as f:
            for line in f:
                line = line.strip()
                if not line or line.startswith("#"):
                    continue
                patterns.append(line)
    except FileNotFoundError:
        # Si no existe .aiignore, no hay patrones que aplicar
        pass
    return patterns

def matches_any_pattern(path, patterns):
    """
    Comprueba si la ruta relativa al cwd encaja en alguno de los patrones .aiignore.
    Se normaliza con '/' para que fnmatch funcione de forma consistente.
    """
    rel = os.path.relpath(path, os.getcwd()).replace(os.sep, "/")
    for pat in patterns:
        if fnmatch.fnmatch(rel, pat):
            return True
    return False

def iter_files(root, ignore_patterns):
    """
    Recorre todos los archivos bajo 'root', excluyendo:
      1) rutas que matcheen .aiignore
      2) .git, node_modules y vendor
      3) extensiones no incluidas en EXTS
    """
    for dirpath, dirnames, filenames in os.walk(root):
        # Filtrar directorios por .aiignore
        dirnames[:] = [
            d for d in dirnames
            if not matches_any_pattern(os.path.join(dirpath, d), ignore_patterns)
        ]
        # Filtrar también .git, node_modules, vendor
        dirnames[:] = [
            d for d in dirnames
            if d not in (".git", "node_modules", "vendor")
        ]

        for fn in filenames:
            full = os.path.join(dirpath, fn)
            # Saltar si está en .aiignore
            if matches_any_pattern(full, ignore_patterns):
                continue
            ext = os.path.splitext(fn)[1].lower()
            if ext in EXTS or fn in ("Dockerfile",):
                yield full

def main():
    enc = tiktoken.encoding_for_model(MODEL_NAME)
    ignore_patterns = load_ignore_patterns(AIIGNORE)

    total_tokens = 0
    total_lines = 0
    files_info = []

    print("📂 Archivos analizados (respetando .aiignore):\n")

    for path in iter_files(".", ignore_patterns):
        try:
            with open(path, encoding="utf-8", errors="ignore") as f:
                text = f.read()
        except Exception:
            continue

        lines = text.count("\n") + 1
        num_tokens = len(enc.encode(text))

        total_tokens += num_tokens
        total_lines  += lines
        files_info.append((path, num_tokens, lines))

        print(f"✔ {path} → {num_tokens} tokens, {lines} líneas")

    # Resumen
    print(f"\n🔢 Total archivos: {len(files_info)}")
    print(f"📏 Total líneas: {total_lines}")
    print(f"🔤 Total tokens ({MODEL_NAME}): {total_tokens}")

    # Top 10 archivos más largos
    top = sorted(files_info, key=lambda x: x[1], reverse=True)[:10]
    print("\n📈 Archivos con más tokens:")
    for path, tokens, lines in top:
        print(f"🔹 {path} — {tokens} tokens, {lines} líneas")

    # Estimación de costes (input + output)
    rates = {
        'gpt-4-turbo':   (10.0, 30.0),
        'gpt-4':         (30.0, 60.0),
        'gpt-4-32k':     (60.0, 120.0),
        'gpt-3.5-turbo': (0.5, 1.5),
    }
    print("\n💵 Estimación de costos aproximados (USD):")
    for m, (r_in, r_out) in rates.items():
        cost_in  = total_tokens / 1_000_000 * r_in
        cost_out = total_tokens / 1_000_000 * r_out
        cost_tot = cost_in + cost_out
        print(f"  {m}: ~${cost_tot:.2f} (input ${cost_in:.2f} + output ${cost_out:.2f})")

if __name__ == "__main__":
    main()
