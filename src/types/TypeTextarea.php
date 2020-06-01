<?php

declare(strict_types=1);


namespace vsevolodryzhov\yii2ArControl\types;


use yii\base\Model;
use yii\widgets\ActiveField;
use yii\widgets\ActiveForm;

class TypeTextarea implements TypeInterface
{

    public function print(ActiveForm $form, Model $model, string $attribute): ActiveField
    {
        return $form->field($model, $attribute)->textarea(['class' => 'form-control']);
    }
}