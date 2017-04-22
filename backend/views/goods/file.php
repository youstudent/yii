<h3>添加商品相册</h3><?=\yii\bootstrap\Html::a('不添加图片',['goods/index'],['class'=>'btn btn-primary'])?>
<?php
$form =\yii\bootstrap\ActiveForm::begin();
echo $form->field($gallery,'logo_file[]')->fileInput(['multiple'=>true]);
echo \yii\bootstrap\Html::submitButton('确认添加');
\yii\bootstrap\ActiveForm::end();
?>