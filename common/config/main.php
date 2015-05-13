<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'constant' => [
            'class' => 'common\components\Constant',
        ],
        'field_generator' => [
            'class' => 'common\components\FieldGenerator',
        ],
        'json_manager' => [
            'class' => 'common\components\JsonManager',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                   '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
                ],
            ],
        ],
    ],
];
