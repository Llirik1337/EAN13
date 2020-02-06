# Требования:
- PHP v7 и выше
- NPM v6 и выше
- Composer v1.9.2 и выше
# Настройка php.ini
1. Найти файл php.ini.
В терминале выполнив команду php -i и найти Loaded Configuration File => path-to-file/php.ini и отрыть этот файл

## MySql
1. В файле php.ini найти строчку ";extension=pdo_mysql" и удалить символ ';' и сохранить файл.

## PostgreSQL
1. В файле php.ini найти строчки ";extension=pdo_pgsql", ";extension=pgsql" и удалить символ ';' и сохранить файл.

# Настройка .env файла
1. Если файла ".env" нет то нужно скопировать файл ".env.exemple" и переименовать его в ".env"
2. В файле .env найти строки приведенные ниже и заменить в соответствии с настройками базы данных

>DB_CONNECTION=mysql     #Тип базы данных (для PostgreSQL в указать pgsql) <br/>
>DB_HOST=127.0.0.1       #IP хоста базы данных                             <br/>
>DB_PORT=3306            #Порт для подключения к хосту базы данных         <br/>
>DB_DATABASE=laravel     #Название базы данных                             <br/>
>DB_USERNAME=root        #Имя пользователя базы данных                     <br/>
>DB_PASSWORD=            #Пароль пользователя базы данных                  <br/>
>Дополнительные настройки можно посмотреть в файле по пути "config/database.php"
# Установка зависемостей
## Composer
Для установки зависемостей Composer нужно:
1. Открыть терминал.
2. Выполнить команду "composer install" если composer установлен глобально, если локально то следует выполнить команду "composer.phar install" и дождаться пока все зависемости установяться.

## NPM
Для установки зависемостей NPM нужно:
1. Открыть терминал.
2. Выполнить команду "npm install" и дождаться пока все зависемости установяться.

# Точка входа
Точкой входя являеться папка "public" сервер должен открывать её первой. Нужно либо создать символьную ссылку public_html на папку public либо открыть терминал и ввести комманду "php artisan serve" эта команда запустит локальный сервер.

# Создание таблиц в БД
Для создания таблиц в БД нужно в терминале из папки проекта выполнить комманду "php artisan migrate"

# Генирация ключа приложения
Для генерации ключа нужно в терминале из папки проекта выполнить команду "php artisan key:generate "
