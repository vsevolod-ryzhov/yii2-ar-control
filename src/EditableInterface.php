<?php

declare(strict_types=1);


namespace vsevolodryzhov\yii2ArControl;


interface EditableInterface
{
    const SCENARIO_INSERT = 'insert';
    const SCENARIO_UPDATE = 'update';

    const EDITABLE_CLASS_SUFFIX = 'Edit';

    public function attributeTypes(): array;
    public function getDetailViewAttributes(): array;

    public static function createInsertUrl($getParams = null): ?string;
}