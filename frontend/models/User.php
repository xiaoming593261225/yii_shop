<?php

namespace frontend\models;

use Symfony\Component\CssSelector\Tests\Parser\ReaderTest;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $phone 电话号码
 * @property int $login_time 登录时间
 * @property int $login_ip 登录ip
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
      public function behaviors()
      {
            return [
                [

                    'class' => TimestampBehavior::className(),
                    'attributes' => [
                        self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                        self::EVENT_BEFORE_UPDATE => ['updated_at'],
                    ],
                      // if you're using datetime instead of UNIX timestamp:
                      // 'value' => new Expression('NOW()'),
                ],
            ];
      }
      public $password; //密码
      public $rePassword; // 验证二次密码
      public $checkCode; //验证码
      public $captcha;//短信验证码
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','password','rePassword','email','phone'],'required'],
              ['rePassword','compare','compareAttribute' => 'password'],
            [['phone'],'match','pattern'=>'/(13|14|15|17|18|19)[0-9]{9}/','message'=>'请输入正确的手机'],
            [['email'],'match','pattern'=>'/\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}/','message'=>'邮箱格式错误'],
              [['checkCode'],'captcha','captchaAction' => 'user/code'],
            [['captcha'],'validateCaptcha']//自定义规则
        ];
    }
//    手机号的自定规则方法
      public function validateCaptcha($attribute, $params)
      {
            $codeOld=\Yii::$app->session->get("tel_".$this->phone);
//            exit($codeOld);
            //2.判断输入8code是否正确
           if($this->captcha==$codeOld){

           }else{
                 $this->addError($attribute, '验证码错误');
           }
      }
    /**
     *
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'auth_key' => 'Auth Key',
            'password_hash' => '密码',
            'password_reset_token' => 'Password Reset Token',
            'email' => '邮箱',
            'status' => 'Status',
              'password'=>'密码',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'phone' => '电话号码',
              'rePassword'=>'密码',
            'login_time' => '登录时间',
            'login_ip' => '登录ip',
              'checkCode'=>'验证码'
        ];
    }

      /**
       * Finds an identity by the given ID.
       * @param string|int $id the ID to be looked for
       * @return IdentityInterface the identity object that matches the given ID.
       * Null should be returned if such an identity cannot be found
       * or the identity is not in an active state (disabled, deleted, etc.)
       */
      public static function findIdentity($id)
      {
            return self::findOne($id);
      }

      /**
       * Finds an identity by the given token.
       * @param mixed $token the token to be looked for
       * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
       * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
       * @return IdentityInterface the identity object that matches the given token.
       * Null should be returned if such an identity cannot be found
       * or the identity is not in an active state (disabled, deleted, etc.)
       */
      public static function findIdentityByAccessToken($token, $type = null)
      {
            // TODO: Implement findIdentityByAccessToken() method.
      }

      /**
       * Returns an ID that can uniquely identify a user identity.
       * @return string|int an ID that uniquely identifies a user identity.
       */
      public function getId()
      {
           return $this->id;
      }

      /**
       * Returns a key that can be used to check the validity of a given identity ID.
       *
       * The key should be unique for each individual user, and should be persistent
       * so that it can be used to check the validity of the user identity.
       *
       * The space of such keys should be big enough to defeat potential identity attacks.
       *
       * This is required if [[User::enableAutoLogin]] is enabled.
       * @return string a key that is used to check the validity of a given identity ID.
       * @see validateAuthKey()
       */
      public function getAuthKey()
      {
            return $this->auth_key;
            // TODO: Implement getAuthKey() method.
      }

      /**
       * Validates the given auth key.
       *
       * This is required if [[User::enableAutoLogin]] is enabled.
       * @param string $authKey the given auth key
       * @return bool whether the given auth key is valid.
       * @see getAuthKey()
       */
      public function validateAuthKey($authKey)
      {
            return $this->auth_key===$authKey;
            // TODO: Implement validateAuthKey() method.
      }
}
