<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput(['disabled'=>""],['style'=>'width:300px;']);
echo $form->field($model,'description')->textarea(['rows' => '12','clos'=>'5']);
echo $form->field($model,'permissions')->inline()->checkboxList($persArr);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
$form = \yii\bootstrap\ActiveForm::end();
