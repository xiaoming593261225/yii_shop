<h1>文章列表的显示</h1>
<!--<a href="--><?//=\yii\helpers\Url::to(['add'])?><!--" class="btn btn-info"><span class="glyphicon glyphicon-plus btn"></span></a>-->
<!--<a href="--><?//=\yii\helpers\Url::to(['article-cate/show'])?><!--" class="btn btn-info"><span class="glyphicon glyphicon-plus btn"></span>文章分类列表</a>-->
<table class="table table-bordered">
      <tr>
            <th>编号</th>
            <th>标题</th>
            <th>分类ID</th>
            <th>状态</th>
            <th>排序</th>
            <th>简介</th>
            <th>创建时间</th>
            <th>操作</th>
      </tr>
    <?php foreach ($values as $value):?>
        <tr>
            <td><?=$value->id?></td>
            <td><?=$value->title?></td>
            <td><?=$value->cate->name?></td>
            <td><?php
                  if($value->status){
                      echo \yii\bootstrap\Html::a("",["","id"=>$value->id],["class"=>"glyphicon glyphicon-ok btn btn-info"]);
                  }else{
                        echo \yii\bootstrap\Html::a("",["","id"=>$value->id],["class"=>"glyphicon glyphicon-remove btn btn-danger"]);
                  }

                  ?></td>
            <td><?=$value->sort?></td>
            <td><?=$value->intro?></td>
            <td><?=date("Y-m-d H:i:s",$value->created_at)?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$value->id])?>" class="btn btn-info"><span class="glyphicon glyphicon-pencil"></span></a>
                <a href="<?=\yii\helpers\Url::to(['del','id'=>$value->id])?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?=\yii\widgets\LinkPager::widget([
    'pagination' => $page
]);