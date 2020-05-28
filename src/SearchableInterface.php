<?php

declare(strict_types=1);

namespace vsevolodryzhov\yii2ArControl;

use yii\data\ActiveDataProvider;

interface SearchableInterface
{
    const SCENARIO_SEARCH = 'search';

    // SEARCHABLE_CLASS_SUFFIX
    const SEARCHABLE_CLASS_SUFFIX = 'Search';

    public function search($params): ActiveDataProvider;
    public static function getGridColumns($searchModel = null): array;

    public function hasAccess(): bool;
}