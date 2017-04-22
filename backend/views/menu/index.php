<h3>菜单管理</h3>
<?=\yii\bootstrap\Html::a('添加',['menu/add'])?>
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>上级分类</th>
        <th>Url(路由)</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->name?></td>
        <td><?=$model->parent_id?></td>
        <td><?=$model->url?></td>
        <td>
            <?=\yii\bootstrap\Html::a('编辑',['menu/edit','id'=>$model->id])?>
            <?=\yii\bootstrap\Html::a('删除',['menu/del','id'=>$model->id],['data' =>['confirm' => '你确定要删除会员吗？']])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>