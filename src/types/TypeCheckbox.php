<?php

declare(strict_types=1);


namespace vsevolodryzhov\yii2ArControl\types;


use yii\base\Model;
use yii\widgets\ActiveField;
use yii\widgets\ActiveForm;

class TypeCheckbox implements TypeInterface
{

    public function print(ActiveForm $form, Model $model, string $attribute): ActiveField
    {
        return $form->field($model, $attribute)->checkbox([
            'label' => $model->getAttributeLabel($attribute),
            'template' => "<div class=\"col-sm-6 col-sm-offset-3\"><div class=\"checkbox\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n{error}\n{hint}\n</div></div>"
        ]);
    }
}