
#!/bin/bash

# Define os caminhos das pastas
SOURCE_DIR="/home/storage/3/fa/75/itqestoqueatacad1/public_html"
STOPPED_DIR="/home/storage/3/fa/75/itqestoqueatacad1/public_html_stopped"
OFFLINE_DIR="/home/storage/3/fa/75/itqestoqueatacad1/public_html_offline"

echo "Script - Stop"

echo "Informacoes de Memoria (free -lh):"
echo "-----------------------------------"
echo "$(free -lh)"
echo "-----------------------------------"

echo "Iniciando o movimento de arquivos..."

# 1. Mover arquivos de public_html para public_html_stopped
echo "Movendo arquivos de '$SOURCE_DIR' para '$STOPPED_DIR'..."
mv "$SOURCE_DIR"/* "$STOPPED_DIR"/

# Verifica se o movimento anterior foi bem-sucedido
if [ $? -eq 0 ]; then
    echo "Arquivos movidos com sucesso para '$STOPPED_DIR'."
else
    echo "Erro ao mover arquivos para '$STOPPED_DIR'. Verifique as permissões ou se a pasta existe."
    exit 1 # Sai do script com erro
fi

# 2. Copiar arquivos de public_html_offline para public_html (recursivamente)
echo "Copiando arquivos de '$OFFLINE_DIR' para '$SOURCE_DIR' (recursivamente)..."
cp -r "$OFFLINE_DIR"/* "$SOURCE_DIR"/

# Verifica se a cópia anterior foi bem-sucedida
if [ $? -eq 0 ]; then
    echo "Arquivos copiados com sucesso para '$SOURCE_DIR'."
else
    echo "Erro ao copiar arquivos para '$SOURCE_DIR'. Verifique as permissões ou se a pasta existe."
    exit 1 # Sai do script com erro
fi

echo "Processo concluído."
