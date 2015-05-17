<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Company */

$this->title = 'Compañia Detalle';
//$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title"><?= Html::encode($this->title) ?></h3><?= ' - '.$model->name ?>
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
                    <p>
                        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'code',
                            'name',
                            [                      // the owner name of the model
                                'label' => Yii::$app->field_generator->genNameLabel('corporate_address'),
                                'value' => Yii::$app->json_manager->getJsonArrayValue($model->contact, ['corporate_address']),
                            ],
                            [                      // the owner name of the model
                                'label' => Yii::$app->field_generator->genNameLabel('corporate_phone'),
                                'value' => Yii::$app->json_manager->getJsonArrayValue($model->contact, ['corporate_phone']),
                            ],
                            [                      // the owner name of the model
                                'label' => Yii::$app->field_generator->genNameLabel('corporate_mobile_phone'),
                                'value' => Yii::$app->json_manager->getJsonArrayValue($model->contact, ['corporate_mobile_phone']),
                            ],
                            [                      // the owner name of the model
                                'label' => Yii::$app->field_generator->genNameLabel('corporate_email'),
                                'value' => Yii::$app->json_manager->getJsonArrayValue($model->contact, ['corporate_email']),
                            ],
                            [                      // the owner name of the model
                                'label' => 'Creación',
                                'value' => ($model['create_date']) ? date('d/m/Y H:i:s a', strtotime($model['create_date'])) : '',
                            ],
                        ],
                    ]) ?>
                    <?php Pjax::end(); ?>
                  </div>
              </div>
          </div>
      </div><!-- /.row -->
    </div><!-- ./box-body -->
</div>
