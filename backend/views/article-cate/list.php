<h1>文章分类列表的显示</h1>
<a href="<?=\yii\helpers\Url::to(['add'])?>"class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span></a>
<table class="table-bordered table">
      <tr>
            <th>编号</th>
            <th>分类的名称</th>
            <th>分类的排序</th>
            <th>分类的状态</th>
            <th>分类的简介</th>
            <th>分类的友情</th>
            <th>操作</th>
      </tr>
      <?php foreach ($values as $value):?>
            <tr>
                  <th><?=$value->id?></th>
                  <th><?=$value->name?></th>
                  <th><?=$value->sort?></th>
                  <th><?php
                        if($value->status){
                              echo \yii\bootstrap\Html::a("",["","id"=>$value->id],["class"=>"glyphicon glyphicon-ok btn btn-info"]);
                        }else{
                              echo \yii\bootstrap\Html::a("",["","id"=>$value->id],["class"=>"glyphicon glyphicon-remove btn btn-danger"]);
                        }
                        ?></th>
                  <th><?=$value->intro?></th>
                  <th><?=$value->is_help?></th>
                  <th>
                      <a href="<?=\yii\helpers\Url::to(['edit','id'=>$value->id])?>" class="btn btn-info"><span class="glyphicon glyphicon-pencil"></span></a>
                        <a href="<?=\yii\helpers\Url::to(['del','id'=>$value->id])?>" class="btn btn-primary"><span class="glyphicon glyphicon-trash"></span></a>
                  </th>
            </tr>
      <?php endforeach;?>
</table>
<?=\yii\widgets\LinkPager::widget([
    'pagination' => $page
]);