<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inventario';
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
                    <?= Html::a('Nuevo', ['create'], ['class' => 'btn btn-success', 'style' => 'margin-bottom: 10px;']) ?>
                    <?php Pjax::begin(['enablePushState' => false]); ?>
                    <?= GridView::widget([
                          'dataProvider' => $dataProvider,
                          'layout'=>"{items}",
                          'columns' => [
      //                        ['class' => 'yii\grid\SerialColumn'],
                              'name',
//                              'description:ntext',
                              [
                                  'attribute' => 'company_id',
                                  'content' => function($model) {
                                      $company = ($model['company_id']) ? $model->getCompany()->where('id = '.$model['company_id'])->one()['name'] : '';
                                      return $company;
                                  },
                              ],
                              [
                                  'attribute' => 'subcategory_id',
                                  'content' => function($model) {
                                      $company = ($model['subcategory_id']) ? $model->getSubCategory()->where('id = '.$model['subcategory_id'])->one()['name'] : '';
                                      return $company;
                                  },
                              ],            
                              [
                                  'attribute' => 'create_date',
                                  'content' => function($model) {
                                      $create_date = date('d/m/Y H:i:s a', strtotime($model['create_date']));
                                      return $create_date;
                                  },
                              ],         
                              [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view} {update} {delete} {link}',
//                                'buttons' => [
//                                    'view' => function ($url,$model) {
//                                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',$url, [
//                                                'id' => 'view',
//                                                'class' => 'modal-show',
//                                            ]);
//                                    },
//                                    'update' => function ($url,$model) {
//                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>',$url, [
//                                                'id' => 'update',
//                                                'class' => 'modal-show',
//                                            ]);
//                                    },        
//                                ],
                            ],
                          ],
                          'tableOptions' => [
                              'class' => 'table table-bordered table-striped dataTable',
                              'id' => 'dataTable',
                          ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                  </div>
              </div>
          </div>
      </div><!-- /.row -->
    </div><!-- ./box-body -->
</div>
