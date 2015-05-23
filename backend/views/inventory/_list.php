<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Company */

$this->title = 'Mis Avances';
//$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3><?= count($modelProducts) ?></h3>
                                <p>Productos</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pricetags"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                Más información <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3><?= count($modelServices) ?></h3>
                                <p>Servicios</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-android-restaurant"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                Más información <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                      <!-- small box -->
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3>44</h3>
                                <p>Comentarios</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-chatbubbles"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                Más información <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">
                                  <h3>65</h3>
                                  <p>Visitas</p>
                            </div>
                            <div class="icon">
                                  <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                  Más información <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
   