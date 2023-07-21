<?php

namespace King\Yii2Validator;

interface ValidatorModelInterface
{
    public function setRules($rules);

    public function rules();

    public function attributes();

    public function load($data, $formName = null);

    public function validate($attributeNames = null, $clearErrors = true);

    public function getErrorSummary($showAllErrors);

    public function hasMethod($name);
}
