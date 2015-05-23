<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>
<?= $form->field($modelSubCategory, 'category_id', ['options' => ['id' => 'category', 'style' => 'display: none;']])->dropDownList($category, ['class'=>'form-control','size'=>'6']) ?>    
<?php ActiveForm::end(); ?>

