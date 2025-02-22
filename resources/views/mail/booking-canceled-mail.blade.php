<x-mail::message>
# Ваше бронирование отменено!

Уважаемый **{{$bookingData['user']}}**,<br>
Вы успешно отменили бронь на **{{$bookingData['resource']}}**.

<br>
{{ config('app.name') }}
</x-mail::message>
