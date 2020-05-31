<?php

declare(strict_types=1);

/* @var $model */
/* @var $className string */
/* @var $canEdit boolean */

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

if ($canEdit) {
    echo Html::a(Yii::t('app', 'Edit'),
        ['edit', 'className' => $className, 'id' => $model->getPrimaryKey()],
        ['class' => 'btn btn-primary']
    );
}

