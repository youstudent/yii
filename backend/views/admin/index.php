<h1>会员管理列表</h1>
<?php
$form = \yii\bootstrap\ActiveForm::begin([
        'options'=>['class'=>'form-inline'],'method'=>'get'
]);
echo $form->field($search,'name');
echo \yii\bootstrap\Html::submitButton('查询',['class'=>'btn bnt-info','style'=>'margin-bottom:11px;']);
\yii\bootstrap\ActiveForm::end();
echo \yii\bootstrap\Html::a('添加用户',['admin/add'],['class'=>'btn btn-info']);
?>
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>用户</th>
        <th>邮箱</th>
        <th>头像</th>
        <th>注册时间</th>
        <th>最后登陆时间</th>
        <th>登陆IP</th>
        <th>操作</th>
    </tr>
    <?php foreach($model as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->username?></td>
        <td><?=$model->email?></td>
        <td><?=\yii\bootstrap\Html::img('@web/'.$model->img,['height'=>40,'width'=>88])?></td>
        <td><?=date('Y-m-d H:i:s',$model->add_time)?></td>
        <td><?=$model->last_login_time?date('Y-m-d H:i:s',$model->last_login_time):'未登陆过'?></td>
        <td><?=$model->last_login_ip?></td>
        <td>
            <?=\yii\bootstrap\Html::a('编辑会员',['admin/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
            <?=\yii\bootstrap\Html::a('删除会员',['admin/del','id'=>$model->id],['class'=>'btn btn-danger','data' =>['confirm' => '你确定要删除会员吗？',]])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?=\yii\widgets\LinkPager::widget([
    'pagination'=>$pager,
    'nextPageLabel'=>'下一页',
    'prevPageLabel' => '上一页',
    'firstPageLabel' => '首页',
    'lastPageLabel' => '尾页',
])?>
