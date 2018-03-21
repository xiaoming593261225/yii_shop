<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($category,'name');
echo $form->field($category,'parent_id');

echo \liyuze\ztree\ZTree::widget([
    'setting' => '{
			data: {
				simpleData: {
					enable: true,
					pIdKey: "parent_id",
				}
			},
			callback: {
				onClick: onClick
			}
		}',
    'nodes' => $cateJson,
]);

echo $form->field($category,'intro')->textInput();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
$form = \yii\bootstrap\ActiveForm::end();


//定义jS代码块
$js=<<<JS
//得到ztree对象
var treeObj = $.fn.zTree.getZTreeObj("w1");
// 找到节点当前对象
var node = treeObj.getNodeByParam("id", "$category->parent_id", null);
// zTree对象加上节点对象
treeObj.selectNode(node);
//选中当前节点
$('#category-parent_id').val($category->parent_id);
treeObj.expandAll(true);
//展开方法
JS;
//追加
$this->registerJs($js);



?>
<script>
    function onClick(e,treeId, treeNode) {
        var parent=$("#category-parent_id");
        parent.val(treeNode.id);
//        console.debug(treeNode.id);
//        var zTree = $.fn.zTree.getZTreeObj("treeDemo");
//        zTree.expandNode(treeNode);
    }
</script>
