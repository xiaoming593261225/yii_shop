<?php
namespace backend\controllers;

use backend\models\Admin;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','captcha'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        $request = Yii::$app->request;
        if($request->isPost){
              $model->load($request->post());
              if($model->validate()){
                  $admin = Admin::findOne(['username'=>$model->username,'status'=>1]);
                  if($admin){
                        if(Yii::$app->security->validatePassword($model->password,$admin->password_hash)){
                              Yii::$app->user->login($admin,1);
                              return $this->redirect(['/goods/show']);
                        }else{

                        }
                  }else{
                        $model->addError('username','用户名不存在或禁用');
                  }
              }else{
                    var_dump($model->errors);exit;
              }
        }
            return $this->render('login', [ 'model' => $model,
            ]);
    }
    public function actionAdd(){
          $admin = new Admin();
          return $this->render('add',compact('admin'));
    }
    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
