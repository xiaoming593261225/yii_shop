<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'title');
echo $form->field($model,'sort');
echo $form->field($model,'cate_id')->dropDownList($cateArr);
echo $form->field($model,'status')->inline()->radioList(['下线','上线'],['value'=>'0']);
echo $form->field($model,'intro')->textarea();
echo $form->field($content,'content')->widget('kucha\ueditor\UEditor',[]);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
$form = \yii\bootstrap\ActiveForm::end();