<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username');
echo $form->field($model,'password')->passwordInput();
echo $form->field($model,'email');
echo $form->field($model,'role')->checkboxList(\backend\models\Admin::getRole());
echo $form->field($model,'img_file')->fileInput();
echo $form->field($model,'code')->widget(\yii\captcha\Captcha::className(),[
    'template'=>'<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-2">{image}</div></div>'
]);
echo \yii\bootstrap\Html::submitButton('确认注册');
\yii\bootstrap\ActiveForm::end();