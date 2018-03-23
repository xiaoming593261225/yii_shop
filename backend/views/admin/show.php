<h1>管理员列表</h1>

<p>
<table class="table table-bordered">
    <tr>
        <th>编号</th>
        <th>名称</th>
        <th>添加时间</th>
        <th>登录时间</th>
        <th>状态</th>
        <th>图片</th>
        <th>ip</th>
        <th>操作</th>
    </tr>
   <?php foreach ($values as $value):?>
    <tr>
        <td><?=$value->id?></td>
        <td><?=$value->username?></td>
        <td><?=date('Y-m-d',$value->created_at)?></td>
        <td><?=date('Y-m-d',$value->login_time)?></td>
        <td><?=\backend\models\Admin::$status[$value->status]?></td>
        <td>

              <?php
              $imgLog=strpos($value->log,"ttp://")==false?"/".$value->log:$value->log;
              echo \yii\bootstrap\Html::img($imgLog,['height'=>30]);
              ?>
        </td>
        <td><?=long2ip($value->login_ip)?></td>
        <td>
            <a href="<?=\yii\helpers\Url::to(['edit','id'=>$value->id])?>" class="btn btn-primary">编辑</a>
            <a href="<?=\yii\helpers\Url::to(['del','id'=>$value->id])?>" class="btn btn-danger">删除</a>
        </td>
    </tr>
    <?php endforeach;?>
</table>
</p>
