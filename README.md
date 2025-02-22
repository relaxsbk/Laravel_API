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
