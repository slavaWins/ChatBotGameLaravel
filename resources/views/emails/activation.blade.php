@component('mail::message')

# Подтверждение регистрации

    Вы получили это письмо, потому что ваш адрес электронной почты был указан при регистрации на сайте {{ config('app.name') }}.



@component('mail::button', ['url' => $linkUrl])
Подтвердить
@endcomponent


Подтверждение необходимо для исключения несанкционированного использования вашего адреса электронной почты. Для подтверждения достаточно перейти по ссылке, дополнительных действий не требуется.


Спасибо, что выбрали наш продукт!<br>
{{ config('app.name') }}
@endcomponent
