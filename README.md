# Laravel_API

```bash
  composer install
```

>### Алиас для sail

```bash
  alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```

```bash
  sail up -d
```

>### Миграции и сиды

```bash
  sail artisan migrate --seed
```
>### Для тестов 

```bash
  sail artisan migrate --env=testing
```
>### Для отправки уведомления на почту использовал сервис mailtrap.io <br>
>### Все уведомления падают в очереди

```bash
  sail artisan queue:work
```

 ---
>### Все настройки по mailtrap есть у них на сайте.
>### Так же при создании миграций в env указывается почта админа для правильного создания такого пользователя 

---
## Администратор

+ email - admin@admin.com
+ password - admin11

>## Пароль меняется в сидаре, а почту можно задать свою в env файл(Обязательно смотреть env.example)

---

## Postman

>## Файл со всеми маршрутами и её документацией находятся в экспортированном файле json Laravel API
>## Этот файл нужно импортировать в Postman 
