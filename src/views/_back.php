<?php

declare(strict_types=1);

use yii\helpers\Html;

echo Html::beginTag('div', ['class' => 'row']);
echo Html::beginTag('div', ['class' => 'col-sm-6']);
echo Html::a('&#8592 Back', '#', ['class' => 'btn btn-default', 'onClick' => 'window.history.back(); return false;']);
echo Html::endTag('div'); // .col-sm-6
echo Html::endTag('div'); // .row
echo Html::tag('hr');