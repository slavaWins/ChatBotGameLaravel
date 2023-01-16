@component('mail::message')
# Заголовок уведомления
## Заголовок уведомления 2

The body of your message.

`The body of your message.
`The body of your message.

@component('mail::button', ['url' => ''])
Тестовая кнопка
@endcomponent

Спасибо, что выбрали наш продукт!<br>
{{ config('app.name') }}
@endcomponent
