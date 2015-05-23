<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Company */

$this->title = 'Mis Productos y Servicios';
//$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                      <li class="active"><a href="#tab_1-1" data-toggle="tab">Productos</a></li>
                      <li><a href="#tab_2-2" data-toggle="tab">Servicios</a></li>
                      <li class="pull-left header"></li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane active" id="tab_1-1">
                        <div class="">
                            <div class="panel-body">
                                <ul class="products-list product-list-in-box">
                                <?php if($modelProducts == NULL): ?>   
                                    <h3 class="box-title">No tienes productos guardados.</h3>
                                <?php endif; ?>    
                                <?php if($modelProducts != NULL): ?>      
                                    <?php foreach ($modelProducts as $key => $value): ?>
                                        <li class="item">
                                          <div class="product-img">
                                            <img src="/img/item/default-50x50.gif" alt="Product Image">
                                          </div>
                                          <div class="product-info">
                                              <a href="/item/<?= $value->id ?>" class="product-title"><?= $value->name ?> <span class="label bg-aqua pull-right">Bs. <?= number_format($value['inventories'][0]['price'], 2, ',', '.') ?></span></a>
                                            <span class="product-description">
                                              <?= ($value->description) ? $value->description : 'Sin Descripción' ?>
                                            </span>
                                          </div>
                                        </li><!-- /.item -->
                                    <?php endforeach; ?>
                                <?php endif; ?>      
                              </ul>
                            </div>
                        </div>
                      </div><!-- /.tab-pane -->
                      <div class="tab-pane" id="tab_2-2">
                          <div class="">
                            <div class="panel-body">
                                <ul class="products-list product-list-in-box">
                                <?php if($modelServices == NULL): ?>   
                                    <h3 class="box-title">No tienes servicios guardados.</h3>
                                <?php endif; ?>    
                                <?php if($modelServices != NULL): ?>    
                                    <?php foreach ($modelServices as $key => $value): ?>
                                        <li class="item">
                                          <div class="product-img">
                                            <img src="/img/item/default-50x50.gif" alt="Product Image">
                                          </div>
                                          <div class="product-info">
                                            <a href="/item/<?= $value->id ?>" class="product-title"><?= $value->name ?> <span class="label bg-green pull-right">Bs. <?= number_format($value['inventories'][0]['price'], 2, ',', '.') ?></span></a>
                                            <span class="product-description">
                                              <?= ($value->description) ? $value->description : 'Sin Descripción' ?>
                                            </span>
                                          </div>
                                        </li><!-- /.item -->
                                    <?php endforeach; ?>
                                <?php endif; ?>    
                              </ul>
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

