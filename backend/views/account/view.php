<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use app\models\Account;

/* @var $this yii\web\View */
/* @var $model app\models\Account */

$this->title = 'Cuenta Detalle';
//$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title"><?= Html::encode($this->title) ?></h3><?= ' - '.Yii::$app->json_manager->getJsonArrayValue($model->profile, ['first_name', 'first_surname']) ?>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div><!-- /.box-header -->
    <div class="box-body">
      <div class="row">
          <div class="col-sm-12">
              <div class="panel panel-default">
                  <div class="panel-body">
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
                    <?php Pjax::begin(['enablePushState' => false]); ?>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [                      // the owner name of the model
                                'label' => Yii::$app->field_generator->genNameLabel('identification'),
                                'value' => Yii::$app->json_manager->getJsonArrayValue($model->profile, ['identification']),
                            ],
                            [                      // the owner name of the model
                                'label' => 'Nombre',
                                'value' => Yii::$app->json_manager->getJsonArrayValue($model->profile, ['first_name', 'second_name', 'first_surname', 'second_surname']),
                            ],
                            [                      // the owner name of the model
                                'label' => Yii::$app->field_generator->genNameLabel('birth_date'),
                                'value' => Yii::$app->json_manager->getJsonArrayValue($model->profile, ['birth_date']),
                            ],
                            [                      // the owner name of the model
                                'label' => Yii::$app->field_generator->genNameLabel('gender'),
                                'value' => (Yii::$app->json_manager->getJsonArrayValue($model->profile, ['gender']) == 'Male') ? 'Masculino' : 'Femenino',
                            ],
                            [                      // the owner name of the model
                                'label' => Yii::$app->field_generator->genNameLabel('personal_address'),
                                'value' => Yii::$app->json_manager->getJsonArrayValue($model->contact, ['personal_address']),
                            ],
                            [                      // the owner name of the model
                                'label' => Yii::$app->field_generator->genNameLabel('personal_phone'),
                                'value' => Yii::$app->json_manager->getJsonArrayValue($model->contact, ['personal_phone']),
                            ],
                            [                      // the owner name of the model
                                'label' => Yii::$app->field_generator->genNameLabel('personal_email'),
                                'value' => Yii::$app->json_manager->getJsonArrayValue($model->contact, ['personal_email']),
                            ],
                            [                      // the owner name of the model
                                'label' => 'Compañia',
                                'value' => ($model['company_id']) ? $model->getCompany()->where('id = '.$model['company_id'])->one()['name'] : '',
                            ],
                            [                      // the owner name of the model
                                'label' => 'Rol',
                                'value' => ($model['rol_id']) ? $model->getRol()->where('id = '.$model['rol_id'])->one()['name'] : '',
                            ],
                            'user.username',
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
