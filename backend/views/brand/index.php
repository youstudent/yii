<?php
echo \yii\bootstrap\Html::a('添加',['brand/add'],['class'=>'btn btn-info']);
echo \yii\bootstrap\Html::a('回收站',['brand/bin'],['class'=>'btn btn-danger']);
?>

<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>品牌图像</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->name?></td>
        <td><?=\yii\bootstrap\Html::img('@web'.$model->logo,['width'=>30,'height'=>30])?></td>
        <td><?=\backend\models\Brand::$status_options[$model->status]?></td>
        <td>
            <?=\yii\bootstrap\Html::a('编辑',['brand/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
            <?=\yii\bootstrap\Html::a('删除',['brand/del','id'=>$model->id],['class'=>'btn btn-danger'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?=\yii\widgets\LinkPager::widget([
     'pagination'=>$pager,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页'])
?>