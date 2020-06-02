<?php

declare(strict_types=1);

/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $searchModel \vsevolodryzhov\yii2ArControl\SearchableInterface */
/* @var $insert string */

use yii\helpers\Html;

if ($insert) {
    echo $insert;
    echo Html::tag('hr');
}

try {
    echo yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered table-hover'],
        'layout' => "{summary}\n{items}\n{pager}",
        'columns' => $searchModel::getGridColumns($searchModel)
    ]);
} catch (Exception $e) {
    throw new DomainException($e->getMessage());
}