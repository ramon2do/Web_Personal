<?php

namespace backend\controllers;

use Yii;
use app\models\Account;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\Rol;
use app\models\Company;
use app\models\Token;
use dektrium\user\models\RegistrationForm;
use dektrium\user\traits\AjaxValidationTrait;
use dektrium\user\helpers\Password;

/**
 * AccountController implements the CRUD actions for Account model.
 */
class AccountController extends Controller
{
    use AjaxValidationTrait;
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Account models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Account;
        $dataProvider = new ActiveDataProvider([
            'query' => Account::find(),
        ]);

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Account model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->getRequest()->isAjax)
        {
            return $this->renderAjax('view', [
                'model' => $this->findModel($id),
            ]);
        }
        else
        {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
        
    }

    /**
     * Creates a new Account model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Account;
        $modelUser = \Yii::createObject(RegistrationForm::className());
        $this->performAjaxValidation($modelUser);
        $modelRol = new Rol;
        $modelCompany = new Company;

        $rol = $modelRol->getListRol();
        $company = $modelCompany->getListCompany();

        if(Yii::$app->request->post())
        {
            $post = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();
            if ($modelUser->load($post) && $modelUser->register()) 
            {
                $findAccount = Account::find()->innerJoin('user u', 'user_id = u.id')->where("username = '".$post['register-form']['username']."'")->one();
                $arrayDataAccount = $model->getArrayAccount($post);
                if ($findAccount->load($arrayDataAccount) && $findAccount->save()) 
                {
                    $transaction->commit();
                    \Yii::$app->session->setFlash('success', \Yii::t('user', 'La Cuenta ha Sido Guardada.'));
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{$transaction->rollBack();}
            }else{$transaction->rollBack();}
        }
        
        if(Yii::$app->getRequest()->isAjax)
        {
            return $this->renderAjax('create', [
                'model' => $model,
                'modelUser' => $modelUser,
                'rol' => $rol,
                'company' => $company,
            ]);
        }
        else
        {
            return $this->render('create', [
                'model' => $model,
                'modelUser' => $modelUser,
                'rol' => $rol,
                'company' => $company,
            ]);
        }
    }

    /**
     * Updates an existing Account model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelUser = User::findOne($model->user_id);
        $modelRol = new Rol;
        $modelCompany = new Company;

        $rol = $modelRol->getListRol();
        $company = $modelCompany->getListCompany();
        
        if(Yii::$app->request->post())
        {
            $post = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();
            $password = $post['User']['password_hash'];
            $post['User']['password_hash'] = Password::hash($password);
            if ($modelUser->load($post) && $modelUser->save()) 
            {
                $arrayDataAccount = $model->getArrayAccount($post,$model);
                if ($model->load($arrayDataAccount) && $model->save()) 
                {
                    $transaction->commit();
                    \Yii::$app->session->setFlash('success', \Yii::t('user', 'La Cuenta ha Sido Actualizada.'));
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{$transaction->rollBack();}
            }else{$transaction->rollBack();}
        }
        
        if(Yii::$app->getRequest()->isAjax)
        {
            return $this->renderAjax('update', [
                'model' => $model,
                'modelUser' => $modelUser,
                'rol' => $rol,
                'company' => $company,
            ]);
        }
        else
        {
            return $this->render('update', [
                'model' => $model,
                'modelUser' => $modelUser,
                'rol' => $rol,
                'company' => $company,
            ]);
        }
    }

    /**
     * Deletes an existing Account model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $modelToken = Token::find()->where("user_id = $model->user_id")->one();
        $modelUser = User::findOne($model->user_id);
        
        $deleteAccount = $model->delete();
        if($modelToken != NULL){
            $deleteToken = $modelToken->delete();
        }
        $deleteUser = $modelUser->delete();
        if($deleteAccount && $deleteUser){return $this->redirect(['index']);}else{return false;}
    }

    /**
     * Finds the Account model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Account the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Account::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
