<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'description');
echo $form->field($model,'permission_options')->checkboxList(\backend\models\RoleForm::getPermission());
echo \yii\bootstrap\Html::submitButton('添加');
\yii\bootstrap\ActiveForm::end();