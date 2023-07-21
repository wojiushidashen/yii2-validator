# yii2-validator
Yii2参数验证

## 1. 添加配置信息
> common/config/main.php
```php
<?php
    return [
        'id' => 'crontab-console',
        'basePath' => dirname(__DIR__),
        'controllerNamespace' => 'app\commands',
        'timeZone' => 'Asia/Shanghai',
        'aliases' => [
            '@bower' => '@vendor/bower-asset',
            '@npm' => '@vendor/npm-asset',
        ],
        // 配置依赖关系
        'container' => [
            'definitions' => [
                'King\Yii2Validator\ValidatorModelInterface' => 'King\Yii2Validator\model\ValidatorModel',
                'King\Yii2Validator\Validator' => 'King\Yii2Validator\model\ParamsValidator',
            ],
            'singletons' => [
            ],
        ],
        // 配置组件
        'components' => [
            'validator' => 'King\Yii2Validator\Validator',
        ]
    ];
```

## 2. 使用

### 依赖注入方式
> controller中使用
```php
<?php

use components\validator\Validator;

/**
 * 微信.
 */
class TestController extends \yii\rest\Controller
{
    public function actionAsyncOfficialAccountUsers(Validator $validator)
    {
        $data = $this->request->get();
        $rules = [
            [['appid', 'experiment_id', 'connection_id'], 'required'],
            [['experiment_id', 'connection_id'], 'number'],
            [['appid'], 'string'],
        ];
        list($res, $errMsg) = $validator->validate($data, $rules);
    }
}

```

### 组件方式
```php
<?php
    /* @var \King\Yii2Validator\model\ParamsValidator $validator */
    $validator = \Yii::$app->validator;
    
    $data = [
        'appid' => 'tesdasda', 
    ];
    $rules = [
        [['appid', 'experiment_id', 'connection_id'], 'required'],
        [['experiment_id', 'connection_id'], 'number'],
        [['appid'], 'string'],
    ];
    list($res, $errMsg) = $validator->validate($data, $rules);
```
