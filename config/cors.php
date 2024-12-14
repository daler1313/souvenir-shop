<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Пути, для которых разрешены CORS-запросы

    'allowed_methods' => ['*'], // Разрешены все методы, если нужны только конкретные, можно ограничить (например, ['GET', 'POST'])

    //'allowed_origins' => ['*'], // Разрешены все источники. Для продакшн-среды ограничьте, например: ['http://localhost:4209']
    'allowed_origins' => ['http://localhost:4209'], // Разрешение только для определенного источника

    'allowed_origins_patterns' => [], // Если нужно, можно указать паттерны для источников (например, '/\.example\.com$/')

    'allowed_headers' => ['*'], // Разрешение всех заголовков. Можно уточнить для безопасности (например, ['Content-Type', 'Authorization'])
    
    'exposed_headers' => [], // Заголовки, которые могут быть доступны на стороне клиента

    'max_age' => 0, // Время кэширования CORS-запроса в секундах, можно оставить 0 для отсутствия кэширования

    'supports_credentials' => false, // Если нужно передавать куки или авторизационные данные, установить в true

];
