<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        // '@bower' => '@vendor/bower',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
