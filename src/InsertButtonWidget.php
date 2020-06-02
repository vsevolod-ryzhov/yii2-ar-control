<?php

declare(strict_types=1);


namespace vsevolodryzhov\yii2ArControl;


use Exception;
use InvalidArgumentException;
use ReflectionClass;
use yii\helpers\Html;

class InsertButtonWidget
{
    /**
     * @var ArClassesStruct
     */
    private $classes;

    /**
     * @var EditableInterface
     */
    private $editableClass;

    /**
     * @var array
     */
    private $getParams;

    /**
     * @var string
     */
    private $editableShortClassName;

    /**
     * @var string
     */
    private $error;

    public function create(): string
    {
        return ($this->available()) ?
            Html::a('Add new', $this->classes->getEditableClass()::createInsertUrl($this->getParams), ['class' => 'btn btn-primary'])
            :
            Html::tag('p', $this->error);
    }

    public function __construct(ArClassesStruct $classes, array $getParams = [])
    {
        $this->classes = $classes;
        $this->getParams = $getParams;

        $this->editableClass = $classes->getEditableClass();
        if ($this->editableClass === null) {
            throw new InvalidArgumentException(get_class($this->classes->getBaseClass()) . ' has no implementation of ' . EditableInterface::class . ' interface');
        }

        try {
            $this->editableShortClassName = (new ReflectionClass($this->classes->getBaseClass()))->getShortName();
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    private function available(): bool
    {
        if ($this->editableClass->getAdditionalRequiredAttribute() === null || $this->additionalAttributeProvided()) {
            return true;
        }
        $this->error = 'Choose filter "' . $this->editableClass->getAttributeLabel($this->editableClass->getAdditionalRequiredAttribute()) . '" to create new object';
        return false;
    }

    private function additionalAttributeProvided(): bool
    {
        $key = $this->editableClass->getAdditionalRequiredAttribute();
        return isset($this->getParams[$this->editableShortClassName]) &&
            array_key_exists($key, $this->getParams[$this->editableShortClassName]) !== false &&
            !empty($this->getParams[$this->editableShortClassName][$key]);
    }
}