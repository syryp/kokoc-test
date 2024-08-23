## О проекте
АПИ позволяющее выполнять CRUD по Пользователям
Так же есть роуты для добавления друзей и получения списков друзей
## Характеристики проекта
- PHP 8.2
- Laravel 11
## Как развернуть

- Стянуть проект с репы
- Выполнить ```composer install```
- Дублировать .env файл и насроить параметры касательно БД, тестилось на Postgres
- Выполнить ```php artisan migrate --seed```
- Выполнить ```php artisan serve```

## Как тестировать

Тестировалось через Postman

## Список роутов

*{хост}/api/v1/user*

- POST /create - params:{name, email}
- POST /update - params:{user_id, name, email}
- DELETE /{user_id} - params:{}
- GET /{user_id} - params:{}
- GET /list - params:{}
- POST /toggle-friend - params:{user_id, friend_id}
- GET /{user_id}/friends - params:{}
- GET /{user_id}/friends-friends - params:{}
