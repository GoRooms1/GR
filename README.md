# Online site for the selection of rooms and hotels - **GOROOMS**

This project was issued for revision of the administrative panel and personal account.

## Installation

Use the package manager [composer](https://getcomposer.org) and [npm](https://nodejs.org/en/) to install projects.

Before installing, import data into mysql and set up .env

```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gorooms
DB_USERNAME=root
DB_PASSWORD=
```

```bash
composer install
npm install
```

## Storage

All photos are stored in `storage/app/public`. The data is divided into folders formed by dates.
Use

**`php artisan storage:link`**

## Admin users

To create a user with administrator privileges

```php
php artisan users:create --email=admin@admin.com --password=123456 --name=Admin --is_admin=1
```

## Hotels (Moderation)

На данный момет администратор и модератор видит все отели и комнаты. Обычные же пользователи видят только принятые отели.
За доступность видения отелей отвечает свойство `moderate`, а роль администратора `is_admin`, и модератор `is_moderate`

```php
php artisan users:create --email=user@email.com --password=123456 --name=User --is_moderate=1
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)