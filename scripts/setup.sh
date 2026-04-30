#!/bin/bash

# Script de configuración automática para IAMPAAAM

echo "========================================="
echo "Configurando entorno IAMPAAAM con Docker"
echo "========================================="

# Variables
PROJECT_PATH="/var/www/html/app_iampaam"
DB_NAME="iampaam_db"
DB_USER="iampaam_user"
DB_PASS="iampaam_password_$(date +%s | sha256sum | base64 | head -c 16)"

# 1. Crear estructura de directorios
echo "[1/8] Creando estructura de directorios..."
mkdir -p $PROJECT_PATH/docker/nginx
mkdir -p $PROJECT_PATH/scripts

# 2. Configurar PostgreSQL del host
echo "[2/8] Configurando PostgreSQL en el host..."

# Verificar si PostgreSQL está instalado
if ! command -v psql &> /dev/null; then
    echo "Instalando PostgreSQL..."
    sudo apt update
    sudo apt install -y postgresql postgresql-contrib
    sudo systemctl start postgresql
    sudo systemctl enable postgresql
fi

# Configurar PostgreSQL para aceptar conexiones externas
sudo sed -i "s/#listen_addresses = 'localhost'/listen_addresses = '*'/" /etc/postgresql/*/main/postgresql.conf

# Agregar regla de autenticación para Docker
if ! grep -q "172.17.0.0/16" /etc/postgresql/*/main/pg_hba.conf; then
    echo "host    all             all             172.17.0.0/16           md5" | sudo tee -a /etc/postgresql/*/main/pg_hba.conf
fi

sudo systemctl restart postgresql

# Crear base de datos y usuario
sudo -u postgres psql << EOF
CREATE DATABASE IF NOT EXISTS $DB_NAME;
CREATE USER IF NOT EXISTS $DB_USER WITH PASSWORD '$DB_PASS';
GRANT ALL PRIVILEGES ON DATABASE $DB_NAME TO $DB_USER;
\q
EOF

# 3. Actualizar .env con las credenciales generadas
echo "[3/8] Configurando archivo .env..."
if [ -f "$PROJECT_PATH/.env" ]; then
    sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$DB_PASS/" $PROJECT_PATH/.env
    sed -i "s/DB_DATABASE=.*/DB_DATABASE=$DB_NAME/" $PROJECT_PATH/.env
    sed -i "s/DB_USERNAME=.*/DB_USERNAME=$DB_USER/" $PROJECT_PATH/.env
else
    cp $PROJECT_PATH/.env.example $PROJECT_PATH/.env
    sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$DB_PASS/" $PROJECT_PATH/.env
    sed -i "s/DB_DATABASE=.*/DB_DATABASE=$DB_NAME/" $PROJECT_PATH/.env
    sed -i "s/DB_USERNAME=.*/DB_USERNAME=$DB_USER/" $PROJECT_PATH/.env
    sed -i "s/DB_CONNECTION=mysql/DB_CONNECTION=pgsql/" $PROJECT_PATH/.env
    sed -i "s/DB_HOST=127.0.0.1/DB_HOST=host.docker.internal/" $PROJECT_PATH/.env
fi

# 4. Levantar contenedores Docker
echo "[4/8] Levantando contenedores Docker..."
cd $PROJECT_PATH
docker-compose down
docker-compose up -d

# 5. Instalar dependencias de Composer
echo "[5/8] Instalando dependencias de Composer..."
sleep 10  # Esperar a que el contenedor esté listo
docker exec -it laravel_php82 composer install --no-interaction

# 6. Generar key de Laravel
echo "[6/8] Generando key de Laravel..."
docker exec -it laravel_php82 php artisan key:generate

# 7. Ejecutar migraciones
echo "[7/8] Ejecutando migraciones..."
docker exec -it laravel_php82 php artisan migrate --force

# 8. Configurar permisos
echo "[8/8] Configurando permisos..."
docker exec -it laravel_php82 chmod -R 775 storage bootstrap/cache
docker exec -it laravel_php82 chown -R www-data:www-data storage bootstrap/cache

echo "========================================="
echo "✅ Configuración completada exitosamente!"
echo "========================================="
echo "📝 Credenciales generadas:"
echo "   Base de datos: $DB_NAME"
echo "   Usuario: $DB_USER"
echo "   Contraseña: $DB_PASS"
echo ""
echo "🌐 Accede a la aplicación: http://localhost"
echo "📊 Comandos útiles:"
echo "   docker ps - Ver contenedores activos"
echo "   docker exec -it laravel_php82 bash - Entrar al contenedor"
echo "   docker-compose logs -f - Ver logs en tiempo real"
echo "========================================="
