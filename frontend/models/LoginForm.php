<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/27
 * Time: 13:56
 */

namespace frontend\models;


use yii\base\Model;

class LoginForm extends Model
{
      public $username;
      public $password;
      public $reMessage;
      public $checkcode;

      public function rules()
      {
            return [
                [['username','password','checkcode'],'required'],
                  [['reMessage'],'safe'],
                [['checkcode'],'captcha','captchaAction' => 'user/code'],
            ];
      }

      public function attributeLabels()
      {
            return [
                'username'=>'用户名',
                'password'=>'密码',
                  'checkcode'=>'验证码',
            ];
      }
}