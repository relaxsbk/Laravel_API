<x-mail::message>
# Бронирование пользователя подтверждено!

Пользователь **{{$booking->user->name}}**<br>
    подтвердил бронь на **{{$booking->resource->name}}** <br>
Время **{{$booking->startTime()}}** по **{{$booking->endTime()}}**

<br>
{{ config('app.name') }}
</x-mail::message>
