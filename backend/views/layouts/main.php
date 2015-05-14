<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'My Project',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);

            if (Yii::$app->user->isGuest) 
            {
                $navItems=[
                    ['label' => 'Acerca de', 'url' => ['/site/about']],
                    ['label' => 'Contacto', 'url' => ['/site/about']],
                    ['label' => 'Entrar', 'url' => ['/user/login']]
                ];
            }else 
            {
                $navItems=[
                    ['label' => 'Inicio', 'url' => ['/site/index']],
                    ['label' => 'Cuenta', 'url' => ['/user/settings/']],
                    ['label' => 'Estatus', 'url' => ['/status/index']],
                    ['label' => 'Acerca de', 'url' => ['/site/about']],
                    ['label' => 'Contacto', 'url' => ['/site/about']],
//                    ['label' => 'Crear Cuenta', 'url' => ['/user/register']]
                ];
                array_push($navItems,['label' => 'Salir (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']]
                );
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $navItems,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; Ramon-Technology <?= date('Y') ?></p>
        <!--<p class="pull-right"><?= Yii::powered() ?></p>-->
        </div>
    </footer>

    <?php $this->endBody() ?>
    <script>
    jQuery(document).ready(function() {    
       $APP.UI.init();//js de ribela
    });
    </script>
    <!-- END JAVASCRIPTS --> 
</body>
</html>
<?php $this->endPage() ?>
