<?php
/* @var $this yii\web\View */
//asdsfafws
?>
<h1>品牌的展示</h1>
<a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn-primary btn"><span class="glyphicon glyphicon-plus"></span></span></a>
<table class="table table-bordered">
    <tr>
        <th>编号</th>
        <th>名称</th>
        <th>排序</th>
        <th>图像</th>
        <th>状态</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
      <?php foreach ($brand as $value):?>
          <tr>
              <td><?=$value->id?></td>
              <td><?=$value->name?></td>
              <td><?=$value->sort?></td>
              <td><img src="/<?=$value->log?>" height="30"></td>
              <td><?=\backend\models\Brand::$status[$value->status]?></td>
              <td><?=$value->intro?></td>
              <td>
                  <a href="<?=\yii\helpers\Url::to(['edit','id'=>$value->id])?>" class="glyphicon glyphicon-pencil btn btn-primary"></a>
                  <a href="<?=\yii\helpers\Url::to(['del','id'=>$value->id])?>" class="glyphicon glyphicon-trash btn btn-danger"></a>
              </td>
          </tr>
      <?php endforeach;?>
</table>
<?=\yii\widgets\LinkPager::widget([
        'pagination' => $page
]);
?>
