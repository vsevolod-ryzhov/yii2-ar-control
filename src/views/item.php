<?php

declare(strict_types=1);

/* @var $model */
/* @var $className string */
/* @var $editUrl string|null */

use yii\helpers\Html;
use yii\widgets\DetailView;

echo $this->render('_back');

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

