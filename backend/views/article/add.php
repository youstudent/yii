<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'article_category_id')->dropDownList(\backend\models\Article::getCategoryOption());
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\Article::$status_options);
echo $form->field($model,'sort');
echo $form->field($detail,'content')->textarea();
echo \yii\bootstrap\Html::submitButton('提交');
$form= \yii\bootstrap\ActiveForm::end();
