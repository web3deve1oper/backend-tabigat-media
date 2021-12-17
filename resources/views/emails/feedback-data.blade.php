@component('mail::message')
    # Обратная связть от: {{$full_name}}
    # Сообщение : {{$msg}}
    # Тип : {{$type}}
    # Email: {{$email}}

    Дата:
    {{now()->format('Y:m:d H:i:s')}}
@endcomponent
