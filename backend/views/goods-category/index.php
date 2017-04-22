<?php
/* @var $this yii\web\View */
echo \yii\bootstrap\Html::a('添加',['goods-category/add'],['class'=>'btn btn-info']);
?>
<h1>商品分类</h1>
<table class="table table-bordered border-hover">
    <tr>
        <th>ID</th>
        <th>分类名称</th>
        <th>操作</th>
    </tr>
    <tbody id="category">
    <?php foreach($models as $model):?>
    <tr data_lft="<?=$model->lft?>" data_rgt="<?=$model->rgt?>"data_tree="<?=$model->tree?>">
        <td><?=$model->id?></td>
        <td><?=str_repeat('-',$model->depth),$model->name?>
        <span class="glyphicon glyphicon-plus expotion" style="float: right"></span>

        </td>
        <td>
            <?=\yii\bootstrap\Html::a('编辑',['goods-category/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
            <?=\yii\bootstrap\Html::a('删除',['goods-category/del','id'=>$model->id],['class'=>'btn btn-danger','data' =>['confirm' => '你确定要删除分类吗？',]])?>
        </td>
    </tr>
    <?php endforeach;?>
    </tbody>
</table>
<?=\yii\widgets\LinkPager::widget([
    'pagination'=>$pager,
    'nextPageLabel'=>'下一页',
    'prevPageLabel' => '上一页',
    'firstPageLabel' => '首页',
    'lastPageLabel' => '尾页',
])?>
<?php
$js = <<<EOT
      $(".expotion").click(function(){
          //图标的处理  如果图标不存在就创建  如果存在就删除   主要是设置 class的属性值
          $(this).toggleClass("glyphicon glyphicon-minus");
          $(this).toggleClass("glyphicon glyphicon-plus");
          //获取到当前点击的 tr
          var tr = $(this).closest("tr");
          //分别获取到 左值和有值
          var current_lft = tr.attr("data_lft");//左值
          var current_rgt = tr.attr("data_rgt");//有值
          var current_tree = tr.attr("data_tree");
         
          $("#category tr").each(function(){
            var lft = $(this).attr("data_lft");//分类的左值
            var rgt = $(this).attr("data_rgt");//分类的右值
            var tree = $(this).attr("data_tree");//分类的tree值
            if(parseInt(tree) == parseInt(current_tree) && parseInt(lft) > parseInt(current_lft) && parseInt(rgt) < parseInt(current_rgt)){
                //当前分类的子孙分类如果是显示就隐藏,隐藏就显示
                $(this).fadeToggle();
            }
        });
          
       // 1.根据 id获取到对象 想上查找到tr  获取里面的 左值和有值 以及树的值
       // 2.然后再循环所有的 tr    与点击的tr做对比  同一个分类 tree是相等的 并且 循环的左值要大于点击的左值 并且循环的右值要小于点击的右值
       // 3.如果条件满足就代表是所属的子分类
      })



EOT;
//注册js
$this->registerJs($js)

?>
