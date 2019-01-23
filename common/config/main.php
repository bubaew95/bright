<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport', //'class' => 'yii\swiftmailer\Mailer',
                'host' => 'smtp.mail.ru',
                'username' => '',
                'password' => '',
                'port' => '465',
                'encryption' => 'ssl', 
            ],
        ],
		'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
];
