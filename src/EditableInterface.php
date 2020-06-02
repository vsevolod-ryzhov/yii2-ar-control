<?php

declare(strict_types=1);


namespace vsevolodryzhov\yii2ArControl;


interface EditableInterface
{
    public const SCENARIO_INSERT = 'insert';
    public const SCENARIO_UPDATE = 'update';

    public const EDITABLE_CLASS_SUFFIX = 'Edit';

    /**
     * Edit scenarios (INSERT, UPDATE and etc)
     * @return array
     */
    public function scenarios(): array;

    /**
     * Get current scenario
     * @return mixed
     */
    public function getScenario();

    /**
     * Get editable attributes types
     * @return TypeCollection
     */
    public function attributeTypes(): TypeCollection;

    /**
     * Can user access to model edit
     * @return bool
     */
    public function hasAccess(): bool;

    /**
     * Attribute can change in current scenario
     * @param string $attribute
     * @return bool
     */
    public function isAttributeSave(string $attribute): bool;

    /**
     * Insert url to create new model
     * @param null $getParams
     * @return string|null
     */
    public static function createInsertUrl($getParams = null): ?string;

    /**
     * Get attribute, that must be provided to create new object
     * @return string|null
     */
    public function getAdditionalRequiredAttribute(): ?string;

    /**
     * Get attributes, initialized before insert form displayed
     * @return array|null
     */
    public function getAdditionalAddAttributes(): ?array;

    /**
     * Should be redeclared in ActiveRecord
     * @param $condition
     * @return mixed
     */
    public static function findOne($condition);

    /**
     * Should be redeclared in ActiveRecord
     * @param $attribute
     * @return mixed
     */
    public function getAttributeLabel($attribute);
}