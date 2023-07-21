<?php


namespace King\Yii2Validator;


interface Validator
{
    /**
     * 参数验证.
     * @param array $data 要验证的参数数组.
     * @param array $rules 验验证的规则.
     * @return mixed
     */
    public function validate(array $data, array $rules = []);
}
