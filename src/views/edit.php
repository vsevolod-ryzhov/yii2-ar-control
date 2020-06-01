<?php

declare(strict_types=1);

/* @var $this View */
/* @var $attributes array */
/* @var $model EditableInterface */
/* @var $shortClassName string */
/* @var $attributes TypeCollection */
/* @var $availableAttributes array */

use vsevolodryzhov\yii2ArControl\assets\ChosenAsset;
use vsevolodryzhov\yii2ArControl\EditableInterface;
use vsevolodryzhov\yii2ArControl\TypeCollection;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

ChosenAsset::register($this);

echo $this->render('_back');

$form_name = 'form-edit-' . $shortClassName;
$form = ActiveForm::begin([
    'id' => $form_name,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['form-ajax-validate', 'className' => get_class($model), 'id' => (empty($model->primaryKey)) ? null : $model->primaryKey]),
    'fieldConfig' => [
        'labelOptions' => ['class' => 'col-lg-3 control-label'],
    ],
    'options' => ['enctype' => 'multipart/form-data']
]);

foreach ($attributes as $name => $attribute) {
    if (!$model->isAttributeSave($name)) {
        continue;
    }
    echo $attribute->print($form, $model, $name);
}
?>
    <div class="form-group prevent-hide">
        <div class="col-lg-offset-2 col-lg-10">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php
ActiveForm::end();