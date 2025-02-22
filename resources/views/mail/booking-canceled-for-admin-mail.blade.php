<x-mail::message>
# Бронирование пользователя отменено!

Пользователь **{{$bookingData['user']}}** <br>
    отменил бронь на **{{$bookingData['resource']}}** <br>


<br>
{{ config('app.name') }}
</x-mail::message>
