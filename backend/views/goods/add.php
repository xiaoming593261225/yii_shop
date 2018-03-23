<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($goods,'name');
echo $form->field($goods,'sn');
echo $form->field($goods,'logo')->widget(\manks\FileInput::className(),[]);
echo $form->field($goods,'logimg')->widget(\manks\FileInput::className(),
    [
        'clientOptions' => [
            'pick' => [
                'multiple' => true,
            ],
              // 'server' => Url::to('upload/u2'),
              // 'accept' => [
              // 	'extensions' => 'png',
              // ],
        ]
]);
//echo $form->field($goods,'logimg')->fileInput();
echo $form->field($goods,'goods_category_id')->dropDownList($category,['prompt'=>"请选择..."]);
echo $form->field($goods,'brand_id')->dropDownList($brand,['prompt'=>"请选择..."]);
echo $form->field($intro,'content')->widget(kucha\ueditor\UEditor::className());
echo  $form->field($goods,'market_price');
echo  $form->field($goods,'shop_price');
echo $form->field($goods,'stock');
echo $form->field($goods,'is_on_sale')->inline()->radioList(['下架','上架'],['value'=>1]);
echo $form->field($goods,'sort');
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
$form = \yii\bootstrap\ActiveForm::end();