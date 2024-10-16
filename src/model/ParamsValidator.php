<?php
namespace King\Yii2Validator\model;

use King\Yii2Validator\Validator;
use King\Yii2Validator\ValidatorModelInterface;
use Yii;
use yii\base\Component;

class ParamsValidator extends Component implements Validator
{
    /**
     * @var ValidatorModelInterface 参数验证模型.
     */
    protected $validatorModel;

    public function __construct(ValidatorModelInterface $validatorModel, $config = [])
    {
        $this->_setValidatorModel($validatorModel);

        parent::__construct($config);
    }

    public function _setValidatorModel(ValidatorModelInterface $validatorModel)
    {
        $this->validatorModel = $validatorModel;
    }

    /**
     * 验证函数.
     * @param array $data 验证的数据
     * @param array $rules 验证的规则.
     * @return array [参数1：true成功 false失败, 参数2：错误消息]
     */
    public function validate(array &$data, array $rules = [])
    {
        $this->validatorModel->setRules($rules);
        $this->validatorModel->load($data, '');
        $res = $this->validatorModel->validate();
        if (! $res) {
            $errorMsg = implode("\n",  $this->validatorModel->getErrorSummary(true));
            Yii::error(sprintf('参数验证失败：%s', $errorMsg));
            $responseData = [false, $errorMsg];
        } else {
            $defaultAttrKeyNameMap = [];
            foreach ($rules as $rule) {
                if (isset($rule[1]) && ('default' === $rule[1] || 'trim' === $rule[1] || 'filter' === $rule[1])) {
                    if (is_array($rule[0])) {
                        foreach ($rule[0] as $attyKeyName) {
                            $defaultAttrKeyNameMap[$attyKeyName] = $attyKeyName;
                        }
                    } else {
                        $defaultAttrKeyNameMap[(string)$rule[0]] = $rule[0];
                    }
                }
            }
            $responseData = [true, ''];
            foreach ($this->validatorModel->attributes() as $attributeName) {
                // 给default、filter和trim规则数据赋值
                if (isset($defaultAttrKeyNameMap[$attributeName])) {
                    $data[$attributeName] = $this->validatorModel->{$attributeName} ?? null;
                }
            }
        }

        return $responseData;
    }

    public function __call($name, $params)
    {
        if ($this->validatorModel->hasMethod($name)) {
            return call_user_func_array([$this->validatorModel, $name], $params);
        }

        return parent::__call($name, $params);
    }
}
