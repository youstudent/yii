<?php
echo \yii\bootstrap\Html::a('返回列表页面',['goods/index'],['class'=>'btn btn-info']);
?>
<h3>回收站中心</h3>
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>商品名</th>
        <th>品牌LOGO</th>
        <th>所属分类</th>
        <th>品牌</th>
        <th>市场价格</th>
        <th>本店价格</th>
        <th>库存</th>
        <th>是否上架</th>
        <th>状态</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->name?></td>
            <td><?=\yii\bootstrap\Html::img($model->logo,['width'=>30,'height'=>30])?></td>
            <td><?=$model->goods_category_id?></td>
            <td><?=$model->brand_id?></td>
            <td><?=$model->market_price?></td>
            <td><?=$model->shop_price?></td>
            <td><?=$model->stock?></td>
            <td><?=\backend\models\Goods::$sale_option[$model->in_on_sale]?></td>
            <td><?=\backend\models\Goods::$status_option[$model->status]?></td>
            <td><?=date('Y-m-d',$model->inputtime)?></td>
            <td>
                <?=\yii\bootstrap\Html::a('恢复',['goods/binedit','id'=>$model->id],['class'=>'btn btn-info'])?>
                <?=\yii\bootstrap\Html::a('永久删除',['goods/bindel','id'=>$model->id],['class'=>'btn btn-danger','data' =>['confirm' => '删除后数据不可恢复!是否删除？',]])?>
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