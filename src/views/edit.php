<?php

declare(strict_types=1);

/** @var $attributes array */
/* @var $model */
/* @var $shortClassName string */
/** @var $types array */
/** @var $ajax bool */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\redactor\widgets\Redactor;
use yii\widgets\ActiveForm;

echo Html::beginTag('div', ['class' => 'row']);
echo Html::beginTag('div', ['class' => 'col-sm-6']);
echo Html::a('&#8592 Back', '#', ['class' => 'btn btn-default', 'onClick' => 'window.history.back(); return false;']);
echo Html::endTag('div'); // .col-sm-6
echo Html::endTag('div'); // .row

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

foreach ($attributes as $attribute) {
    if (!isset($types[$attribute])) {
        continue;
    }
    $current_attribute_info = $types[$attribute];

    if (is_string($current_attribute_info)) {
        switch ($current_attribute_info) {
            case 'hidden':
                echo $form->field($model, $attribute)->hiddenInput()->label(false);
                break;
            case 'text':
                echo $form->field($model, $attribute)->textInput()->label($model->getAttributeLabel($attribute));
                break;
            case 'checkbox':
                echo $form->field($model, $attribute)->checkbox([
                    'label' => $model->getAttributeLabel($attribute),
                    'template' => "<div class=\"col-sm-6 col-sm-offset-3\"><div class=\"checkbox\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n{error}\n{hint}\n</div></div>"
                ]);
                break;
            case 'rawTextarea':
                echo $form->field($model, $attribute)->textarea(['class' => 'form-control']);
                break;
            case 'textarea':
                echo $form->field($model, 'body')->widget(Redactor::class, ['clientOptions' => ['minHeight' => 300]]);
                break;
            case 'file':
                echo $form->field($model, $attribute)->fileInput();
                break;
            case 'file_multiple':
                echo $form->field($model, $attribute.'[]')->fileInput(['multiple' => true]);
                break;
            case 'static':
                echo $model->attribute;
                break;
        }
    } elseif (is_array($types[$attribute]) && $current_attribute_info['type'] == 'select') {
        if (method_exists($model, $current_attribute_info['callback'])) {
            $data = $model->{$current_attribute_info['callback']}();
            $options = (isset($current_attribute_info['block_options'])) ? $current_attribute_info['block_options'] : [];
            $element_options = (isset($current_attribute_info['element_options'])) ? $current_attribute_info['element_options'] : [];
            echo $form->field($model, $attribute, $options)->dropDownList($data, $element_options);
        }
    } elseif (is_array($types[$attribute]) && $current_attribute_info['type'] == 'checkbox') {
        $options = (isset($current_attribute_info['block_options'])) ? $current_attribute_info['block_options'] : [];
        $element_options = (isset($current_attribute_info['element_options'])) ? $current_attribute_info['element_options'] : [];
        echo $form->field($model, $attribute, $options)->checkbox(array_merge([
            'label' => $model->getAttributeLabel($attribute),
            'template' => "<div class=\"col-sm-6 col-sm-offset-3\"><div class=\"checkbox\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n{error}\n{hint}\n</div></div>"
        ], $element_options));
    } elseif (is_array($types[$attribute]) && $current_attribute_info['type'] == 'radioListArray') {
        if (method_exists($model, $current_attribute_info['callback'])) {
            $data = $model->{$current_attribute_info['callback']}();
            $options = (isset($current_attribute_info['block_options'])) ? $current_attribute_info['block_options'] : [];
            $element_options = (isset($current_attribute_info['element_options'])) ? $current_attribute_info['element_options'] : [];
            $i = 0;
            foreach ($data as $radioList) {
                $model->{$attribute}[$i] = $radioList['selected'];
                echo $form->field($model, $attribute . '['.$i.']', $options)->dropDownList($radioList['items'], $element_options)->label($radioList['label']);
                $i++;
            }
        }
    } elseif (is_array($types[$attribute]) && $current_attribute_info['type'] == 'multiselect') {
        echo $form->field($model, $attribute)->dropDownList($model->{$current_attribute_info['data']}(), ['class' => 'form-control chzn-select', 'multiple' => 'true', 'options' => $model->{$current_attribute_info['selected']}()]);
    }
}
?>
    <div class="form-group prevent-hide">
        <div class="col-lg-offset-2 col-lg-10">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php
ActiveForm::end();