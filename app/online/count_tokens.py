#!/usr/bin/env python3
import os
import sys

try:
    import tiktoken
except ImportError:
    print("Error: tiktoken no está instalado. Instálalo con `pip install tiktoken` y vuelve a intentarlo.")
    sys.exit(1)

# Modelo a usar para estimar tokens
MODEL_NAME = "gpt-4"

# Tipos de archivo a incluir
EXTS = {".php", ".js", ".ts", ".json", ".yml", ".yaml", ".env", ".dockerfile", "Dockerfile"}

# Recorrer archivos válidos del directorio
def iter_files(root):
    for dirpath, dirnames, filenames in os.walk(root):
        if any(excl in dirpath.split(os.sep) for excl in (".git", "node_modules", "vendor")):
            continue
        for fn in filenames:
            ext = os.path.splitext(fn)[1].lower()
            if ext in EXTS or fn in ("Dockerfile",):
                yield os.path.join(dirpath, fn)

def main():
    enc = tiktoken.encoding_for_model(MODEL_NAME)
    total_tokens = 0
    total_lines = 0
    files_info = []

    print("📂 Archivos analizados:\n")

    for path in iter_files("."):
        try:
            with open(path, encoding="utf-8", errors="ignore") as f:
                text = f.read()
        except Exception:
            continue

        lines = text.count("\n") + 1
        tokens = enc.encode(text)
        num_tokens = len(tokens)

        total_tokens += num_tokens
        total_lines += lines
        files_info.append((path, num_tokens, lines))

        print(f"✔ {path} → {num_tokens} tokens, {lines} líneas")

    print(f"\n🔢 Total archivos: {len(files_info)}")
    print(f"📏 Total líneas: {total_lines}")
    print(f"🔤 Total tokens ({MODEL_NAME}): {total_tokens}")

    # Mostrar los archivos más largos (por tokens)
    top = sorted(files_info, key=lambda x: x[1], reverse=True)[:10]
    print("\n📈 Archivos con más tokens:")
    for path, tokens, lines in top:
        print(f"🔹 {path} — {tokens} tokens, {lines} líneas")

    # Estimación de coste
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
