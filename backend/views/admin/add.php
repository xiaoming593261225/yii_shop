<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($admin,'username');
echo $form->field($admin,'password_hash');
echo $form->field($admin,'log')->widget(\manks\FileInput::className(),[]);
//echo $form->field($admin,'log')->fileInput();
echo $form->field($admin,'status')->inline()->radioList(['禁用','激活'],['value'=>1]);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
$form = \yii\bootstrap\ActiveForm::end();