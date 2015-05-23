<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Item */

$this->title = 'Articulo Detalle';
//$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
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
                                'label' => 'Compañia',
                                'value' => $model['company']['name'],
                            ],
                            [                      // the owner name of the model
                                'label' => 'Tipo',
                                'value' => \app\models\Category::find()->where(['id' => $model['subcategory']['category_id']])->one()->type->name,
                            ],
                            [                      // the owner name of the model
                                'label' => 'Categoría',
                                'value' => \app\models\Category::find()->where(['id' => $model['subcategory']['category_id']])->one()->name,
                            ],
                            [                      // the owner name of the model
                                'label' => 'Subcategoría',
                                'value' => $model['subcategory']['name'],
                            ],
                            'name',
                            'description:ntext',
                            [                      // the owner name of the model
                                'label' => 'Precio',
                                'value' => 'Bs. '.$model['inventories'][0]['price'],
                            ],
                            [                      // the owner name of the model
                                'label' => 'Cantidad',
                                'value' => $model['inventories'][0]['quantity'],
                            ],
                            [                      // the owner name of the model
                                'label' => 'Activo',
                                'value' => ($model['active']) ? 'Si' : 'No',
                            ],
                            [                      // the owner name of the model
                                'label' => 'Desactivación',
                                'value' => ($model['disable_date'] != NULL) ? date('d/m/Y H:i:s a', strtotime($model['disable_date'])) : '',
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
