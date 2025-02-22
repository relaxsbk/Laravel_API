<x-mail::message>
# Ваше бронирование подтверждено!

Уважаемый **{{$booking->user->name}}**,<br>
Вы успешно забронировали **{{$booking->resource->name}}**<br>
    с **{{$booking->startTime()}}**<br>
    по **{{$booking->endTime()}}**.

<br>
{{ config('app.name') }}
</x-mail::message>
