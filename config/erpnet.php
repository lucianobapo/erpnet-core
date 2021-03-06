<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

//    'orm' => env('ERPNET_ORM', 'doctrine'), // 'doctriene' or 'eloquent'
    'orm' => env('ERPNET_ORM', 'eloquent'), // 'doctriene' or 'eloquent'

    // Other stuffs
//    'storeTraffic' => env('APP_STORE_TRAFFIC', false),
//    'orderItemCountMax' => env('ORDER_ITEM_COUNT_MAX', 3),
//    'orderAttachmentCountMax' => env('ORDER_ATTACHMENT_COUNT_MAX', 3),
//    'defaultMandante' => env('MANDANTE', 'teste'),
//    'deliveryOpen' => env('DELIVERY_OPEN', true),
//    'deliveryReturn' => env('DELIVERY_RETURN', 'none'),
//    'orderListCountMax' => env('ORDER_LIST_COUNT_MAX', 3),
//    'rootRole' => env('ROOT_ROLE', 'Root'),
//
//    'imageLocation' => 'images',
//    'thumbnailImageLocation' => 'thumbnails',
//    'attachmentLocation' => 'attachments',
//
//    'newOrderEmailAlert' => env('NEW_ORDER_EMAIL_ALERT', false),
//
//    'facebookMetaTags' => env('FACEBOOK_META_TAGS', false),
//    'googleAnalyticsId' => env('GOOGLE_ANALYTICS_ID', 'UA-59766919-1'),
//
//    'forceSiteSSL' => env('FORCE_SITE_SSL', false),
//
//    'document_types' => [
//        'cpf' => "CPF",
//        'cnpj' => "CNPJ",
//        'ie' => "IE",
//        'im' => "IM",
//        'rg' => "RG",
//    ],
//    'contact_types' => [
//        'email' => "E-mail",
//        'telefone' => "Telefone",
//        'whatsapp' => "WhatsApp",
//    ],
//
//    'order_confirmation_types' => [
//        'recebido',
//        'producao',
//        'pronto',
//        'entregando',
//        'entregue',
//        'pago',
//    ],
//
//    'reports' => [
//        'divisaoDoMes' => 15,
//        'divisaoDoDia' => 11,
//        'maxPodium' => 7,
//    ],
//
//    'backup_destination' => env('BACKUP_1','local'),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

//    'domain' => env('APP_DOMAIN','homestead.app'),
//    'sitePrefix' => 'http://',
    'emailLogo' => 'https://delivery.ilhanet.com/img/logo-delivery2.png',
    'siteCurrentUrl' => '//'.(isset($_SERVER["HTTP_HOST"])?$_SERVER["HTTP_HOST"]:env('APP_DOMAIN','homestead.app')),


];
