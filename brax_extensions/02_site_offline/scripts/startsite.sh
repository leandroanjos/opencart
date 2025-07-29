
#!/bin/bash

# Define os caminhos das pastas
SOURCE_STOPPED_DIR="/home/storage/3/fa/75/itqestoqueatacad1/public_html_stopped"
TARGET_PUBLIC_DIR="/home/storage/3/fa/75/itqestoqueatacad1/public_html"

echo "Script - Start Site"

echo "Informações de Memória (free -lh):"
echo "-----------------------------------"
echo "$(free -lh)"
echo "-----------------------------------"


echo "Iniciando a cópia de arquivos de '$SOURCE_STOPPED_DIR' para '$TARGET_PUBLIC_DIR'..."

# Copiar arquivos de public_html_stopped para public_html (recursivamente)
# A opção '-r' garante que subpastas e seus conteúdos também sejam copiados.
# Por padrão, 'cp' irá sobrescrever arquivos existentes no destino.
cp -r "$SOURCE_STOPPED_DIR"/* "$TARGET_PUBLIC_DIR"/

# Verifica se a cópia foi bem-sucedida
if [ $? -eq 0 ]; then
    echo "Arquivos copiados com sucesso para '$TARGET_PUBLIC_DIR'."
else
    echo "Erro ao copiar arquivos para '$TARGET_PUBLIC_DIR'. Verifique as permissões ou se a pasta existe."
    exit 1 # Sai do script com erro
fi

echo "Processo de cópia concluído."
