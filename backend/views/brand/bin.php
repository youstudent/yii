<?php
echo \yii\bootstrap\Html::a('首页',['brand/index'],['class'=>'btn btn-info'])
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
        <td><?=\yii\bootstrap\Html::img('@web/'.$model->logo,['width'=>30,'height'=>30])?></td>
        <td><?=\backend\models\Brand::$status_options[$model->status]?></td>
        <td>
            <?=\yii\bootstrap\Html::a('恢复数据',['brand/binregain','id'=>$model->id],['class'=>'btn btn-danger'])?>
            <?=\yii\bootstrap\Html::a('删除数据',['brand/bindel','id'=>$model->id],['class'=>'btn btn-danger','data' =>['confirm' => '删除后不可恢复!是否删除？',]])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?=\yii\widgets\LinkPager::widget([
     'pagination'=>$pager,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页'])
?>