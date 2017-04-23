<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username')->textInput(['placeholder'=>'用户名或邮箱']);
echo $form->field($model,'password')->passwordInput(['placeholder'=>'密码']);
echo \yii\bootstrap\Html::submitButton('登陆并绑定',['class'=>'btn btn-info']);
echo '&nbsp &nbsp &nbsp';
\yii\bootstrap\ActiveForm::end();