<?php

declare(strict_types=1);


namespace vsevolodryzhov\yii2ArControl\types;


use InvalidArgumentException;
use yii\base\Model;
use yii\widgets\ActiveField;
use yii\widgets\ActiveForm;

class TypeChosen implements TypeInterface
{
    /**
     * @var mixed
     */
    private $items;

    /**
     * @var array|mixed
     */
    private $selected;

    public function __construct(array $config)
    {
        if (empty($config['items'])) {
            throw new InvalidArgumentException(__CLASS__  . " must be instantiated with items array");
        }
        $this->items = $config['items'];
        $this->selected = $config['selected'] ?? [];
    }

    public function print(ActiveForm $form, Model $model, string $attribute): ActiveField
    {
        return $form->field($model, $attribute)
        ->dropDownList($this->items,
            [
                'class' => 'form-control chosen-select',
                'multiple' => 'true',
                'options' => $this->selected
            ]
        );
    }
}