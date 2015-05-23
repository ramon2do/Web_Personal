<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>
<?= $form->field($model, 'subcategory_id', ['options' => ['id' => 'subcategory', 'style' => 'display: none;']])->dropDownList($subcategory, ['class'=>'form-control','size'=>'6']) ?>
<?php ActiveForm::end(); ?>

