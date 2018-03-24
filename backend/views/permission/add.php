<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput(['style'=>'width:300px;']);
echo $form->field($model,'description')->textarea(['rows' => '12','clos'=>'5']);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
$form = \yii\bootstrap\ActiveForm::end();
