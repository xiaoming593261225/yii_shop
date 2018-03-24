<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "mulu".
 *
 * @property int $id 主键
 * @property string $name mingc
 * @property string $ico 图标
 * @property string $url 地址
 * @property int $parent_id 父类ID
 */
class Mulu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'name' => 'mingc',
            'ico' => '图标',
            'url' => '地址',
            'parent_id' => '父类ID',
        ];
    }
    public static function listName(){
          $listArr=[];
//            得到一级目录
          $listmulu = self::find()->where(['parent_id'=>0])->all();
            foreach ($listmulu as $list){
                  $newlist = [];
                  $newlist['label']=$list->name;
                  $newlist['icon']=$list->ico;
                  $newlist['url']=$list->url;

//                  通过一级找二级
                  $erlist=self::find()->where(['parent_id'=>$list->id])->all();
                  foreach ($erlist as $value){
                        $newer = [];
                        $newer['label']=$value->name;
                        $newer['icon']=$value->ico;
                        $newer['url']=$value->url;
//                        追加
                        $newlist['items'][]=$newer;
                  }
//                  var_dump($newlist);
                  $listArr[]=$newlist;
            }

            return $listArr;
    }
}
