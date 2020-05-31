<?php

declare(strict_types=1);

/* @var $model */
/* @var $className string */
/* @var $editUrl string|null */

use yii\helpers\Html;
use yii\widgets\DetailView;

echo Html::beginTag('div', ['class' => 'row']);
echo Html::beginTag('div', ['class' => 'col-sm-6']);
echo Html::a('&#8592 Back', '#', ['class' => 'btn btn-default', 'onClick' => 'window.history.back(); return false;']);
echo Html::endTag('div'); // .col-sm-6
echo Html::endTag('div'); // .row

try {
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $model->getDetailViewAttributes()
    ]);
} catch (Exception $e) {
    throw new DomainException($e->getMessage());
}

if ($editUrl) {
    echo Html::a(Yii::t('app', 'Edit'),
        [$editUrl, 'className' => $className, 'id' => $model->getPrimaryKey()],
        ['class' => 'btn btn-primary']
    );
}

