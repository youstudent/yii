<?php
echo \yii\bootstrap\Html::a('添加文章',['article/add'],['class'=>'btn btn-info'])
?>
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>文章分类</th>
        <th>简介</th>
        <th>状态</th>
        <th>排序</th>
        <th>时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->name?></td>
        <td><?=$model->category->name?></td>
        <td><?=$model->intro?></td>
        <td><?=\backend\models\Article::$status_options[$model->status]?></td>
        <td><?=$model->sort?></td>
        <td><?=date('Y-m-d',$model->inputtime)?></td>
        <td>
            <?=\yii\bootstrap\Html::a('编辑',['article/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
            <?=\yii\bootstrap\Html::a('删除',['article/del','id'=>$model->id],['class'=>'btn btn-info','data' =>['confirm' => '你确定要删除文章吗？',]])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?=\yii\widgets\LinkPager::widget([
    'pagination'=>$pager,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页'

])?>