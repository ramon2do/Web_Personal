<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Company */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-form">
    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
    ]); ?>
    <div class="form-body">
        <div class="col-md-6">
          <?= Yii::$app->field_generator->genStaticInput($model,['list_sector','list_activity','list_geoambit'],'Company_Type') ?>  
          <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>
          <?= Html::activeHiddenInput($model, 'code_number', ['disabled' => 'disabled']) ?>  
          <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
          <?= Yii::$app->field_generator->genStaticInput($model,['corporate_address','corporate_phone','corporate_mobile_phone','corporate_email'],'Contact') ?>
        </div>
        <div class="margin-top-10">
            <div class="col-md-6">

            </div>
            <div class="col-md-6" style="margin-top: 20px;">
              <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'float: right;']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
