<?php

declare(strict_types=1);


namespace vsevolodryzhov\yii2ArControl;


use DomainException;
use Exception;
use ReflectionClass;

class ClassFactory
{
    public static function getByOriginalClassName($className): ArClassesStruct
    {
        if (!class_exists($className)) {
            throw new DomainException("$className class doesn't exists");
        }

        $struct = new ArClassesStruct(new $className);

        $editableClassName = $className . EditableInterface::EDITABLE_CLASS_SUFFIX;
        if (class_exists($editableClassName)) {
            $struct->setEditableClass(new $editableClassName);
        }

        $searchableClassName = $className . SearchableInterface::SEARCHABLE_CLASS_SUFFIX;
        if (class_exists($searchableClassName)) {
            $struct->setSearchableClass(new $searchableClassName);
        }

        return $struct;
    }

    public static function getShortName($className): string
    {
        try {
            $short = (new ReflectionClass($className))->getShortName();
        } catch (Exception $e) {
            throw new DomainException("Can't get short name of provided class: " . $e->getMessage());
        }
        return $short;
    }
}