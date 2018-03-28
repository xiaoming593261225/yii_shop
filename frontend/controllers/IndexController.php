<?php

namespace frontend\controllers;

class IndexController extends \yii\web\Controller
{
    public function actionShow()
    {
        return $this->render('show');
    }
      public function actionList(){

          return $this->render('list');
      }
}
