<?php
/* @var $this yii\web\View */
?>
<h1>角色列表</h1>

<p>
    <a href="<?=\yii\helpers\Url::to('add')?>" class="btn btn-primary">添加</a>
   <table class="table table-bordered">
    <tr>
        <th>名称</th>
        <th>描述</th>
        <th>权限</th>
        <th>操作</th>
    </tr>
    <?php foreach ($model as $value):?>
        <tr>
            <td><?=$value->name?></td>
            <td><?=$value->description?></td>
            <td>
                <?php
                $auth = Yii::$app->authManager;
//                通过角色找到对应的所有权限
                $pers = $auth->getPermissionsByRole($value->name);
//        var_dump($pers);
                $text="";
                foreach ($pers as $per){
                    $text.=$per->description."-----";
                }
                echo $text;
                ?>

            </td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','name'=>$value->name])?>" class="btn btn-primary">编辑</a>
                <a href="<?=\yii\helpers\Url::to(['del','name'=>$value->name])?>" class="btn btn-danger">删除</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>
</p>
