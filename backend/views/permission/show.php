<?php
/* @var $this yii\web\View */
?>
<h1>权限列表</h1>

<p>
    <a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-primary">添加</a>
    <table class="table-bordered table">
    <tr>
        <th>名称</th>
        <th>描述</th>
<!--        <th>122</th>-->
        <th>操作</th>
    </tr>
    <?php foreach ($model as $value):?>
        <tr>
            <td><?=strpos($value->name,'/')!==false?"------":""?><?=$value->name?></td>
            <td><?=$value->description?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','name'=>$value->name])?>" class="btn btn-primary">编辑</a>
                <a href="<?=\yii\helpers\Url::to(['del','name'=>$value->name])?>" class="btn btn-danger">删除</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>
</p>
