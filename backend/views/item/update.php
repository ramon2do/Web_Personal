<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Item */

$this->title = 'Producto o Servicio Actualizar';
//$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="profile-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="row">
                    <?php Pjax::begin(['enablePushState' => false]); ?>
                    <?= $this->render('_form', [
                        'model' => $model,
                        'modelInventory' => $modelInventory,
                        'modelType' => $modelType,
                        'modelCategory' => $modelCategory,
                        'modelSubCategory' => $modelSubCategory,
                        'company' => $company,
                        'type' => $type,
                        'category' => $category,
                        'subcategory' => $subcategory,
                    ]) ?>
                    <?php Pjax::end(); ?>
                </div> 
            </div>
        </div>
    </div>
</div>
