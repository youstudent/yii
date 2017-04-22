<?php
echo \yii\bootstrap\Html::a('添加',['category/add'],['class'=>'btn btn-info'])
?>
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>简介</th>
        <th>状态</th>
        <th>排序</th>
        <th>是否帮助</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->name?></td>
        <td><?=$model->intro?></td>
        <td><?=\backend\models\Category::$status_options[$model->status]?></td>
        <td><?=$model->sort?></td>
        <td><?=\backend\models\Category::$help[$model->is_help]?></td>
        <td>
            <?=\yii\bootstrap\Html::a('编辑',['category/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
            <?=\yii\bootstrap\Html::a('删除',['category/del','id'=>$model->id],['class'=>'btn btn-info','data' =>['confirm' => '你确定要删除分类吗？',]])?>
        </td>
    </tr>
     <?php endforeach;?>
</table>

