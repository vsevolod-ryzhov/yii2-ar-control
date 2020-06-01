<?php

declare(strict_types=1);


namespace vsevolodryzhov\yii2ArControl\types;


use InvalidArgumentException;
use yii\base\Model;
use yii\widgets\ActiveField;
use yii\widgets\ActiveForm;

class TypeSelect implements TypeInterface
{
    /**
     * @var array
     */
    private $items;
    /**
     * @var array
     */
    private $elementOptions;
    /**
     * @var array
     */
    private $options;

    public function __construct(array $config)
    {
        if (empty($config['items'])) {
            throw new InvalidArgumentException(__CLASS__  . " must be instantiated with items array");
        }
        $this->items = $config['items'];
        $this->options = $config['options'] ?? [];
        $this->elementOptions = $config['elementOptions'] ?? [];
    }

    /**
     * @param ActiveForm $form
     * @param Model $model
     * @param string $attribute
     * @return ActiveField
     */
    public function print(ActiveForm $form, Model $model, string $attribute): ActiveField
    {
        return $form->field($model, $attribute, $this->options)->dropDownList($this->items, $this->elementOptions);
    }
}