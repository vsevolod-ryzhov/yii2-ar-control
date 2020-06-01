<?php

declare(strict_types=1);


namespace vsevolodryzhov\yii2ArControl;


use Exception;
use ReflectionClass;
use UnexpectedValueException;
use yii\helpers\Url;

class InsertUrlGenerator
{
    /**
     * @param string $calledClassName
     * @param string $addLink
     * @param array $additionalAddAttributes
     * @param string $additionalRequiredAttribute
     * @param array $getParams
     * @return null|string
     */
    public static function createInsertUrl(
        string $calledClassName,
        string $addLink,
        array $additionalAddAttributes,
        string $additionalRequiredAttribute,
        array $getParams = null
    ): ?string
    {
        if ($additionalAddAttributes === null || $getParams === null) {
            // regular add link
            return Url::toRoute([$addLink, 'className' => $calledClassName]);
        }

        // link with default parameters
        $params[] = $addLink;
        $params['className'] = $calledClassName;
        $calledShortName = (new self)->getCalledClassName($calledClassName);

        // if isset required attribute - check if this attribute is provided in $additionalRequiredAttribute
        $canReturnUrl = ($additionalRequiredAttribute) ? false : true;

        $populated = (new self)->populateParams($getParams, $additionalAddAttributes);
        foreach ($populated as $attribute => $value) {
            if ($additionalRequiredAttribute === $attribute) {
                $canReturnUrl = true;
            }
            $params[$calledShortName . '[' . $attribute . ']'] = $value;
        }
        unset($populated);

        return ($canReturnUrl) ? Url::toRoute($params) : null;
    }

    private function populateParams(array $getParams, array $additionalAddAttributes): array
    {
        $ret = [];
        foreach ($getParams as $getCategory => $getCategoryValues) {
            if (!is_array($getCategoryValues)) {
                continue;
            }

            foreach ($getCategoryValues as $attribute => $value) {
                $attributeName = $getCategory . '[' . $attribute . ']';
                if (in_array($attributeName, $additionalAddAttributes, true)) {
                    $ret[$attribute] = $value;
                }
            }
        }

        return $ret;
    }

    private function getCalledClassName(string $calledClassName): string
    {
        try {
            $calledShortName = (new ReflectionClass($calledClassName))->getShortName();
        } catch (Exception $e) {
            throw new UnexpectedValueException($e->getMessage());
        }

        return $calledShortName;
    }
}