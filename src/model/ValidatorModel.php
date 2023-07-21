<?php


namespace King\Yii2Validator\model;

use King\Yii2Validator\ValidatorModelInterface;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * 验证模型.
 */
class ValidatorModel extends ActiveRecord implements ValidatorModelInterface
{
    /**
     * @var array 规则.
     */
    private $_rules = [];

    /**
     * @var array 属性.
     */
    private $_attributes = [];

    /**
     * 设置路由规则.
     */
    public function setRules($rules)
    {
        $this->_rules = $rules;
        foreach ($rules as $item) {
            $this->_attributes = array_unique(ArrayHelper::merge($this->_attributes, (array) $item[0]));
        }
    }

    /**
     * 重写路由规则.
     */
    public function rules()
    {
        return $this->_rules;
    }

    /**
     * 重写可用属性规则.
     */
    public function attributes()
    {
        return $this->_attributes;
    }
}
