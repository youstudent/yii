<H3>商品列表</H3>
<?php
$form = \yii\bootstrap\ActiveForm::begin(
        ['method'=>'get',
        'options'=>['class'=>'form-inline'],
        'action'=>\yii\helpers\Url::to(['goods/index']),
        ]
);
echo $form->field($search,'name')->textInput(['placeholder'=>'商品名'])->label(false).'&nbsp &nbsp &nbsp';
echo $form->field($search,'sn')->textInput(['placeholder'=>'货号'])->label(false).'&nbsp &nbsp &nbsp';
echo $form->field($search,'minprice')->textInput(['placeholder'=>'最小价格'])->label(false).'&nbsp &nbsp &nbsp';
echo $form->field($search,'maxprice')->textInput(['placeholder'=>'最大价格'])->label(false).'&nbsp &nbsp &nbsp';
echo \yii\bootstrap\Html::submitButton('查询',['class'=>'btn bnt-info','style'=>'margin-bottom:11px;']);
\yii\bootstrap\ActiveForm::end();
echo \yii\bootstrap\Html::a('添加',['goods/add'],['class'=>'btn btn-info']);
echo \yii\bootstrap\Html::a('回收站',['goods/bin'],['class'=>'btn btn-danger']);
?>
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
        <td><?=$model->category->name?></td>
        <td><?=$model->brand->name?></td>
        <td><?=$model->market_price?></td>
        <td><?=$model->shop_price?></td>
        <td><?=$model->stock?></td>
        <td><?=\backend\models\Goods::$sale_option[$model->in_on_sale]?></td>
        <td><?=\backend\models\Goods::$status_option[$model->status]?></td>
        <td><?=date('Y-m-d',$model->inputtime)?></td>
        <td>
            <?=\yii\bootstrap\Html::a('修改',['goods/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
            <?=\yii\bootstrap\Html::a('删除',['goods/del','id'=>$model->id],['class'=>'btn btn-danger'])?>
            <?=\yii\bootstrap\Html::a('相册查看',['goods/photolist','id'=>$model->id],['class'=>'btn btn-danger'])?>
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
