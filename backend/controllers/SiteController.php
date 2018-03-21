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
          $request = \Yii::$app->request;
          if($request->isPost){
                $model->load($request->post());
//                var_dump($model->username);exit;
                $admin = Admin::find()->where(['username'=>$model->username])->one();
//                判断用户是否存在  存在再次去验证密码
                if ($admin) {
                      $pwd = Admin::find()->where(['password'=>$model->password])->one();
                      if($pwd){
                            \Yii::$app->session->setFlash("success","登录成功");
                            return $this->redirect(['goods/show']);
                      }else{
//                            Yii::$app->session->setFlash('danger','密码不正确');
                            return $this->redirect(['site/login']);
                      }
                }else{
//                      Yii::$app->session->setFlash('danger','用户名不存在');
                      return $this->redirect(['site/login']);
                }
          }
            return $this->render('login', [
                'model' => $model,
            ]);
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
