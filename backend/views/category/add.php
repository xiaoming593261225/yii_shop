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

echo $form->field($category,'intro')->widget('kucha\ueditor\UEditor',[]);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
$form = \yii\bootstrap\ActiveForm::end();
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
