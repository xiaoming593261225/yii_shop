<?php
/* @var $this yii\web\View */
?>
<h1>商品的显示</h1>
<!--<a href="--><?//=\yii\helpers\Url::to(['add'])?><!--" class="btn-primary btn">添加</a>-->
    <form class="form-inline pull-right">
        <div class="form-group">
            <input type="text" class="form-control" size="2" id="minPrice" placeholder="关键字" name="keyword">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" size="2" id="minPrice" placeholder="最小值" name="minPrice">
        </div>
        -
        <div class="form-group">
            <input type="text" class="form-control" size="2" id="maxPrice" placeholder="最大值" name="maxPrice">
        </div>
        <button type="submit" class="btn btn-default">查询</button>
    </form>
<table class="table table-bordered">
    <tr>
        <th>编号</th>
        <th>名称</th>
        <th>货号</th>
        <th>图像</th>
        <th>商品的分类</th>
        <th>品牌</th>
        <th>市场的价格</th>
        <th>本店的价格</th>
        <th>库存</th>
        <th>是否上架</th>
        <th>排序</th>
        <th>商品的录入时间</th>
        <th>操作</th>
    </tr>
    <?php foreach ($values as $value):?>
    <tr>
        <td><?=$value->id?></td>
        <td><?=$value->name?></td>
        <td><?=$value->sn?></td>
        <td><?php
              $imgLog=strpos($value->logo,"ttp://")==false?"/".$value->logo:$value->logo;
              echo \yii\bootstrap\Html::img($imgLog,['height'=>30]);
              ?></td>
        <td><?=$value->cate->name?></td>
        <td><?=$value->brand->name?></td>
        <td><?=$value->market_price?></td>
        <td><?=$value->shop_price?></td>
        <td><?=$value->stock?></td>
        <td>
              <?php
              if($value->is_on_sale){
                    echo \yii\bootstrap\Html::a("",["","id"=>$value->id],["class"=>"glyphicon glyphicon-ok btn btn-info"]);
              }else{
                    echo \yii\bootstrap\Html::a("",["","id"=>$value->id],["class"=>"glyphicon glyphicon-remove btn btn-danger"]);
              }
              ?>
        </td>
        <td><?=$value->sort?></td>
        <td><?=date("Y年m月d日")?></td>
        <td>
            <a href="<?=\yii\helpers\Url::to(['edit','id'=>$value->id])?>" class="btn btn-info">编辑</a>
            <a href="<?=\yii\helpers\Url::to(['del','id'=>$value->id])?>" class="btn btn-danger">删除</a>
        </td>
    </tr>
    <?php endforeach;?>
</table>

<?=\yii\widgets\LinkPager::widget([
    'pagination' => $page
]);