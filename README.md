# Online site for the selection of rooms and hotels - **GOROOMS**

This project was issued for revision of the administrative panel and personal account.

# Новые ветки для работы

1. `Production` - Ветка предназначенная только для принятый комитов. Принимать `Pull Request` имеет право
   только `Fulliton`.
2. `Development` - Ветка для тестирования нового кода. Разработчик обязан создать свою ветку и работать в ней. После
   работы обязательно проверить свой код на наличие ошибок. В случае удовлетворительной работы, создать `Pull Request`
   для `merge` в даннуя (`Development`) ветку. Если ваш код выдаёт ошибки, то все изменения будут `Rever` для последний
   стабильный комит
   (Связано с тем, что паралельно работают множество разработчиков, и администратору необходимо принимать новый код на
   заранее рабочем сайта, ибо множество ошибок могут положить другой функционал сайта)
3. `main_old` - Никто и никогда не должен трогать даннуя ветку. Наказание.
4. `fix-admin` - Данная ветка предоставляет резервный стабильно рабочий код. Всем запрещено её изменять.

Для принятия `Pull Request` необходимо написать лично главному разработчику в Telegram `@Fulliton`.

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

All photos are stored in `storage/app/public`. The data is divided into folders formed by dates. Use

**`php artisan storage:link`**

## Admin users

To create a user with administrator privileges

```php
php artisan users:create --email=admin@admin.com --password=123456 --name=Admin --is_admin=1
```

## Hotels (Moderation)

At the moment, the administrator and moderator sees all the hotels and rooms. Regular users see only accepted hotels.
The property `moderate` is responsible for the availability of the hotel vision, and the role of the administrator
is` is_admin`, and the moderator is `is_moderate`

```php
php artisan users:create --email=user@email.com --password=123456 --name=User --is_moderate=1
```

## New DB

Remove all data from the `costs` table, but make sure to do a` backup`.

```php
// All rooms
$rooms = \App\Models\Room::all();

// Periods
$periods = \App\Models\Period::all();

// All periods of the room
\App\Models\Room::fisrt()->costs->pluck('period')

// Beautiful information for the front
\App\Models\Period::first()->info

//Взять все категории из комнат для данного отеля
$hotel->rooms->pluck('category')->unique('category')

//Взять ве категории для данного отеля
$hotel->categories
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)