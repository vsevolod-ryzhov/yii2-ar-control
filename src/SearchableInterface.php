<?php

declare(strict_types=1);

namespace vsevolodryzhov\yii2ArControl;

use yii\data\ActiveDataProvider;

interface SearchableInterface
{
    public const SCENARIO_SEARCH = 'search';

    public const SEARCHABLE_CLASS_SUFFIX = 'Search';

    public function search($params): ActiveDataProvider;
    public function getDetailViewAttributes(): array;
    public static function getGridColumns($searchModel = null): array;

    public function hasAccess(): bool;

    public static function findOne($condition);
}