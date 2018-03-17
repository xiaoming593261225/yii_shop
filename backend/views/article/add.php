<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'title');
echo $form->field($model,'sort');
echo $form->field($model,'cate_id')->dropDownList($cateArr);
echo $form->field($model,'status')->inline()->radioList(['上线','下线'],['value'=>'0']);
echo $form->field($model,'intro')->textarea();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
$form = \yii\bootstrap\ActiveForm::end();