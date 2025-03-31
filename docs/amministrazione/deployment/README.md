# Deployment SaluteOra

## Ambiente

### Requisiti
- PHP 8.2+
- MySQL 8.0+
- Redis 7.0+
- Nginx 1.20+
- Composer 2.0+
- Node.js 18+

### Configurazione Server
```nginx
server {
    listen 80;
    server_name saluteora.it;
    root /var/www/html/saluteora/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## CI/CD

### GitHub Actions
```yaml
name: Deploy

on:
  push:
    branches: [ main ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
          
      - name: Install Dependencies
        run: composer install --no-dev --optimize-autoloader
        
      - name: Build Assets
        run: |
          npm install
          npm run build
          
      - name: Deploy to Production
        uses: appleboy/ssh-action@master
        with:
          host: ${{ secrets.HOST }}
          username: ${{ secrets.USERNAME }}
          key: ${{ secrets.SSH_KEY }}
          script: |
            cd /var/www/html/saluteora
            git pull origin main
            composer install --no-dev --optimize-autoloader
            php artisan migrate --force
            php artisan config:cache
            php artisan route:cache
            php artisan view:cache
            npm run build
```

## Deployment Process

### 1. Preparazione
```bash
# Backup database
php artisan backup:run

# Backup files
tar -czf backup.tar.gz /var/www/html/saluteora

# Verifica spazio
df -h
```

### 2. Aggiornamento
```bash
# Pull ultime modifiche
git pull origin main

# Installazione dipendenze
composer install --no-dev --optimize-autoloader

# Migrazioni database
php artisan migrate --force

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Assets
npm install
npm run build
```

### 3. Verifica
```bash
# Verifica permessi
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Verifica logs
tail -f storage/logs/laravel.log

# Verifica cache
php artisan cache:clear
```

## Monitoraggio

### Logs
```bash
# Log applicazione
tail -f storage/logs/laravel.log

# Log nginx
tail -f /var/log/nginx/error.log
tail -f /var/log/nginx/access.log

# Log PHP-FPM
tail -f /var/log/php8.2-fpm.log
```

### Performance
```bash
# Monitoraggio CPU
top

# Monitoraggio memoria
free -m

# Monitoraggio disco
df -h

# Monitoraggio rete
iftop
```

## Rollback

### Database
```bash
# Rollback ultima migrazione
php artisan migrate:rollback

# Rollback a versione specifica
php artisan migrate:rollback --step=1
```

### Files
```bash
# Ripristino backup
tar -xzf backup.tar.gz -C /var/www/html/saluteora

# Ripristino database
php artisan backup:restore
```

## Manutenzione

### Cache
```bash
# Pulizia cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Logs
```bash
# Rotazione logs
logrotate /etc/logrotate.d/laravel

# Pulizia logs vecchi
find /var/www/html/saluteora/storage/logs -type f -mtime +30 -delete
``` 