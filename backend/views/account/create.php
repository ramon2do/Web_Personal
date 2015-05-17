<?php

use yii\helpers\Html;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model app\models\Account */

$this->title = 'Cuenta Nueva';
//$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div><!-- /.box-header -->
    <div class="box-body">
      <div class="row">
          <div class="col-sm-12">
              <div class="panel panel-default">
                  <div class="panel-body">
                    <?php Pjax::begin(['enablePushState' => false]); ?>
                    <?= $this->render('_form', [
                        'model' => $model,
                        'modelUser' => $modelUser,
                        'rol' => $rol,
                        'company' => $company,
                    ]) ?>
                    <?php Pjax::end(); ?>
                  </div>
              </div>
          </div>
      </div><!-- /.row -->
    </div><!-- ./box-body -->
</div>
