<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/18
 * Time: 16:28
 */

namespace backend\components;


use creocoder\nestedsets\NestedSetsBehavior;

class MenuQuery extends \yii\db\ActiveQuery
{
      public function behaviors() {
            return [
                NestedSetsBehavior::className(),
            ];
      }
}