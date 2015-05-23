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
<div class="profile-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <p>
                    <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?php if(Yii::$app->session->get('user.name_profile') == 'Administrador'): ?>
                        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    <?php endif; ?>
                    <?= Html::a('Nuevo Inventario', ['/item/create', 'id' => Yii::$app->session->get('user.company_id')], ['class' => 'btn btn-success']) ?>
                </p>  
                <?php Pjax::begin(['enablePushState' => false]); ?>
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
</div>
