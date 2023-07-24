<?php

class ValidatorTest extends \Codeception\Test\Unit
{
    protected $application;

    protected function _before()
    {
        defined('YII_ENV') or define('YII_ENV', 'dev');
        defined('YII_DEBUG') or define('YII_DEBUG', true);

        require __DIR__ . '/../vendor/autoload.php';
        require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

        $config = [
            'id' => 'crontab-console',
            'basePath' => dirname(__DIR__),
            'controllerNamespace' => 'app\commands',
            'timeZone' => 'Asia/Shanghai',
            'aliases' => [
                '@bower' => '@vendor/bower-asset',
                '@npm' => '@vendor/npm-asset',
            ],
            'container' => [
                'definitions' => [
                    'King\Yii2Validator\ValidatorModelInterface' => 'King\Yii2Validator\model\ValidatorModel',
                    'King\Yii2Validator\Validator' => 'King\Yii2Validator\model\ParamsValidator',
                ],
                'singletons' => [
                ],
            ],
            'components' => [
                'validator' => 'King\Yii2Validator\Validator',
            ]
        ];

        $this->application = new \yii\console\Application($config);
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $validator = Yii::$app->validator;

        $data = [
            'username' => 'test'
        ];
        $rules = [
            [['username'], 'required'],
            [['username'], 'integer'],
        ];
        list($res, $errorMsg) = $validator->validate($data, $rules);
        $this->assertFalse($res);
        $this->assertStringContainsString($errorMsg, '"Username must be an integer.');
    }
}
