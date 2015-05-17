<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Account */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-form">
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>
    <div class="form-body">
        <div class="col-md-6">
          <?= $form->field($modelUser, 'username', ['template' => '{label}{input}{error}', 'options' => ['class' => '']]) ?>
          <?= $form->field($modelUser, 'email', ['template' => '{label}{input}{error}', 'options' => ['class' => '']]) ?>
          <?php $label_password = ($model->isNewRecord) ? 'password' : 'password_hash'; ?>  
          <?= $form->field($modelUser, $label_password, ['template' => '{label}{input}{error}', 'options' => ['class' => '', 'value'=>'']])->passwordInput() ?>
          <?= $form->field($model, 'rol_id', [])->dropDownList($rol, ['class'=>'form-control','prompt'=>'-- Seleccionar Rol --', 'onchange'=>'if($(this).val() == "3"){$("select#account-company_id").prop("disabled",false);}else{$("select#account-company_id").prop("disabled",true);}']) ?> 
          <?= $form->field($model, 'company_id', [])->dropDownList($company, ['class'=>'form-control','prompt'=>'-- Seleccionar Compañia --', 'disabled'=>'disabled']) ?>   
        </div>
        <div class="col-md-6">
          <?= Yii::$app->field_generator->genStaticInput($model,['first_name','first_surname'],'Profile') ?>
          <?= Yii::$app->field_generator->genStaticInput($model,['personal_phone'],'Contact') ?>
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
