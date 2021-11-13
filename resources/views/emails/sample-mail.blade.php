@component('mail::message')
# {{$title}}
Автор: {{$article['author']['full_name']}}

{{$body}}

@component('mail::button', ['url' => $articleUrl])
Перейти к чтению
@endcomponent

С уважением,<br>
Tabigat Media
@endcomponent
