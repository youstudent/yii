<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username')->textInput(['placeholder'=>'用户名或邮箱']);
echo $form->field($model,'password')->passwordInput(['placeholder'=>'密码']);
echo $form->field($model,'code')->widget(\yii\captcha\Captcha::className(),[
    'template'=>'<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-2">{image}</div></div>'
]);
echo $form->field($model,'remember')->checkbox();
echo \yii\bootstrap\Html::submitButton('登陆',['class'=>'btn btn-info']);
echo '&nbsp &nbsp &nbsp';
\yii\bootstrap\ActiveForm::end();