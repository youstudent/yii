<h3>角色管理表</h3>
<?php
echo \yii\bootstrap\Html::a('添加角色',['rbac/role-add'],['class'=>'btn btn-info'])
?>
<table class="table table-bordered table-hover">
    <tr>
        <th>角色名</th>
        <th>描述</th>
        <th>操作</th>
    </tr>
    <?php foreach($roles as $role):?>
    <tr>
        <td><?=$role->name?></td>
        <td><?=$role->description?></td>
        <td>
            <?=\yii\bootstrap\Html::a('修改',['rbac/role-edit','name'=>$role->name],['class'=>'btn btn-info'])?>
            <?=\yii\bootstrap\Html::a('删除',['rbac/role-del','name'=>$role->name],['class'=>'btn btn-info','data'=>['confirm'=>'确认删除吗??']])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>