#!/bin/sh

# Ajusta permissões para storage e bootstrap/cache
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache


# Espera o banco de dados MySQL ficar disponível
echo "Waiting for MySQL to be available..."

sleep 10

echo "MySQL is up - running migrations and seeders..."

php artisan migrate:fresh --seed --force

if [ ! -L /var/www/public/storage ]; then
  php artisan storage:link
fi

# Executa o comando padrão do container (php-fpm)
exec "$@"