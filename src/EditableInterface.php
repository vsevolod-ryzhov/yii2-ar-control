<?php

declare(strict_types=1);


namespace vsevolodryzhov\yii2ArControl;


interface EditableInterface
{
    public const SCENARIO_INSERT = 'insert';
    public const SCENARIO_UPDATE = 'update';

    public const EDITABLE_CLASS_SUFFIX = 'Edit';

    public function attributeTypes(): array;

    public function hasAccess(): bool;

    public static function createInsertUrl($getParams = null): ?string;
}