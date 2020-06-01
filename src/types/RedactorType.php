<?php

declare(strict_types=1);


namespace vsevolodryzhov\yii2ArControl\types;


use Exception;
use vsevolodryzhov\yii2ArControl\OutputException;
use yii\base\Model;
use yii\redactor\widgets\Redactor;
use yii\widgets\ActiveField;
use yii\widgets\ActiveForm;

class RedactorType implements TypeInterface
{
    private const REDACTOR_HEIGHT = 300;
    public function print(ActiveForm $form, Model $model, string $attribute): ActiveField
    {
        try {
            return $form->field($model, 'body')->widget(Redactor::class, ['clientOptions' => ['minHeight' => self::REDACTOR_HEIGHT]]);
        } catch (Exception $e) {
            throw new OutputException($e->getMessage());
        }
    }
}