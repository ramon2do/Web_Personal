<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>
    <div class="form-body">
        <div class="col-md-6">
          <?php if($model->isNewRecord){ $hidden = 'display: none;'; }else{ $hidden = ''; } ?>  
          <?= $form->field($modelCategory, 'type_id', ['options' => ['id' => 'type']])->dropDownList($type, ['class'=>'form-control','size'=>'3']) ?>  
          <?= $form->field($modelSubCategory, 'category_id', ['options' => ['id' => 'category', 'style' => $hidden]])->dropDownList($category, ['class'=>'form-control','size'=>'6']) ?>    
          <?= $form->field($model, 'subcategory_id', ['options' => ['id' => 'subcategory', 'style' => $hidden]])->dropDownList($subcategory, ['class'=>'form-control','size'=>'6']) ?>
        </div>
        <div class="col-md-6">
          <?= ($model->company_id == NULL) ? $form->field($model, 'company_id')->dropDownList($company, ['class'=>'form-control','prompt'=>'-- Seleccionar Compañia --']) : NULL ?>  
          <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
          <?= $form->field($modelInventory, 'price')->textInput() ?>
          <?= $form->field($modelInventory, 'quantity')->textInput() ?>  
          <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>  
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
