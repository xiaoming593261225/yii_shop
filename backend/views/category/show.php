<?php
/* @var $this yii\web\View */
?>
<h1>商品的分类</h1>
<!--<a href="--><?//=\yii\helpers\Url::to(['category/add'])?><!--" class="btn btn-primary">添加</a>-->
<table class="table table-bordered">
    <tr>
        <td>
              <?= \leandrogehlen\treegrid\TreeGrid::widget([
                  'dataProvider' => $dataProvider,
                  'keyColumnName' => 'id',
                  'parentColumnName' => 'parent_id',
                  'parentRootValue' => '0', //first parentId value
                  'pluginOptions' => [
                      'initialState' => 'collapsed',
                  ],
                  'columns' => [
                      'name',
                      'id',
                      'parent_id',
                      'intro',
                      ['class' => 'yii\grid\ActionColumn']
                  ]
              ]); ?>
        </td>
    </tr>

</table>
