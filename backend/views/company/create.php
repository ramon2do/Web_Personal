<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Company */

$this->title = 'Compañia Nueva';
//$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="row">
                    <?php Pjax::begin(['enablePushState' => false]); ?>
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                    <?php Pjax::end(); ?>
                </div>    
            </div>
        </div>
    </div>
</div>
