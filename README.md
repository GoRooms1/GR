# Версии
Версия PHP: 7.4
На сервере используется 7.4
Laravel 7
Vue 2

# Установка проекта
composer i
composer u
php artisan key:generate
php artisan storage:link
composer dump-autoload
npm i
npm run dev

### Создание пользователя
* php artisan users:create --email=admin@admin.com --password=123456 --name=Admin --is_admin=true