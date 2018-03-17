<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'sort');
echo $form->field($model,'status')->inline()->radioList(['在线','下线'],['value'=>0]);
echo $form->field($model,'intro')->textarea();
//echo $form->field($model,'code')->widget(yii\captcha\Captcha::className());
echo $form->field($model,'is_help');
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
$form = \yii\bootstrap\ActiveForm::end();