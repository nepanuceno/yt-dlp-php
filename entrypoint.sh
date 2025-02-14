#!/bin/sh
set -e
echo "Entrypoint script iniciado"
php-fpm
# Garanta que o diretório de cache do Composer tenha as permissões corretas
# mkdir -p /.composer/cache && chmod -R 777

# Caminho do arquivo que você quer verificar
arquivo="/var/www/tests/test.mp4"
echo "Verificando se o arquivo $arquivo existe..."

if [ -e "$arquivo" ]; then
    echo "O arquivo $arquivo existe."
else
    echo "Baixando arquivo de vídeo para teste..."
    yt-dlp -o /var/www/tests/test.mp4 https://youtu.be/eI9-q863KTc?si=phh8snfjGtveaXvD --no-cache-dir
fi

echo "Executando o comando composer install..."

echo "Adicionando pacotes"
composer require --dev phpunit/phpunit
composer require brick/date-time

echo "INstalando Pacotes"
composer install
echo "Executando Testes"
vendor/bin/phpunit --colors tests/Ffmpeg.php
# Comando para manter o container ativo
# tail -f /dev/null