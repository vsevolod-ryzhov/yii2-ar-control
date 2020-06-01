<?php

declare(strict_types=1);


namespace vsevolodryzhov\yii2ArControl\types;


use yii\base\Model;
use yii\widgets\ActiveField;
use yii\widgets\ActiveForm;

class TypeFile implements TypeInterface
{
    private const CONFIG_MULTIPLE_ITEM = 'multiple';

    private $multiple;

    public function __construct(array $config = [])
    {
        if ($config && isset($config[self::CONFIG_MULTIPLE_ITEM])) {
            $this->multiple = $config[self::CONFIG_MULTIPLE_ITEM];
        }
    }

    public function print(ActiveForm $form, Model $model, string $attribute): ActiveField
    {
        if (!$this->multiple) {
            $field = $form->field($model, $attribute)->fileInput();
        } else {
            $field = $form->field($model, $attribute.'[]')->fileInput(['multiple' => true]);
        }
        return $field;
    }
}