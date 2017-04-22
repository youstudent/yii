<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'url');
echo $form->field($model,'description')->textarea();
echo $form->field($model,'parent_id')->dropDownList(\backend\models\Menu::parent());
echo \yii\bootstrap\Html::submitButton('添加');
\yii\bootstrap\ActiveForm::end();