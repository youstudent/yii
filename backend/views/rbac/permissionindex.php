<H3>权限管理表</H3>
<?=\yii\bootstrap\Html::a('添加权限(路由)',['permission-add'],['class'=>'btn btn-info'])?>
<table class="table table-bordered table-hover">
    <tr>
        <th>权限(路由)</th>
        <th>描述</th>
        <th>操作</th>
    </tr>
    <?php foreach($permissions as $permission):?>
    <tr>
        <td><?=$permission->name?></td>
        <td><?=$permission->description?></td>
        <td>
            <?=\yii\bootstrap\Html::a('删除',['rbac/permission-del','name'=>$permission->name],['class'=>'btn btn-danger','data'=>['confirm'=>'确认要删除吗??']])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
