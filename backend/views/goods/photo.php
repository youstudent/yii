<h3>商品相册</h3>
<p><?php
$id=$_GET['id'];
echo \yii\bootstrap\Html::a('添加',['goods/photo','id'=>$id],['class'=>'btn btn-info'])?>
 &nbsp;&nbsp;&nbsp;<?php echo \yii\bootstrap\Html::a('返回商品列表',['goods/index'],['class'=>'btn btn-info']);?></p>
   <?php foreach($model as $model):?>
       <div style="float: left;padding-right: 100px ">
       <?=\yii\bootstrap\Html::img('@web/'.$model->path,['width'=>200,'height'=>200])?>
       <p><?=\yii\bootstrap\Html::a('删除',['goods/photodel','id'=>$model->id,'ids'=>$model->goods_id],['class'=>'btn btn-danger','data' =>['confirm' => '你确定要删除相册吗？',]])?></p></div>
   <?php endforeach;?>


