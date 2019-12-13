<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'forceTranslation' => true,
                    'sourceLanguage' => 'en',
                    //'enableCaching' => true,
                    //'cachingDuration' => 20,
                ],
            ],
        ],
    ],
];
