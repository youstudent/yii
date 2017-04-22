<?php
use yii\web\JsExpression;
use xj\uploadify\Uploadify;
use yii\bootstrap\Html;
$form =\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'goods_category_id')->hiddenInput();
echo '<div>
            <ul id="treeDemo" class="ztree"></ul>
      </div>';
echo $form->field($model,'brand_id')->dropDownList(\backend\models\Goods::getBrandOption());
echo $form->field($model,'market_price');
echo $form->field($model,'shop_price');
echo $form->field($model,'stock');
echo $form->field($model,'in_on_sale',['inline'=>true])->radioList(\backend\models\Goods::$sale_option);
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\Goods::$status_option);
echo $form->field($model,'sort');
echo $form->field($content,'content')->widget('common\widgets\ueditor\Ueditor',[
    'options'=>[
        'initialFrameWidth' => 850,
        'initialFrameHeight' => 200,
    ]
]);
echo $form->field($model,'logo')->hiddenInput();
//Remove Events Auto Convert
echo Html::img($model->logo,['id'=>'img','width'=>50]);
//外部TAG
echo Html::fileInput('test', NULL, ['id' => 'test']);
echo Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
        'height' => 40,
        'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    console.log(data);
    if (data.error) {
        console.log(data.msg);
    } else {
       //console.log(data.fileUrl);
        $("#goods-logo").val(data.fileUrl);
        $("#img").attr("src",data.fileUrl);
    }
}
EOF
        ),
    ]
]);
echo \yii\bootstrap\Html::submitButton('添加');
\yii\bootstrap\ActiveForm::end();
//注册js文件
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
//注册js代码
$js = <<<EOT
     var zTreeObj;
    // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
    var setting = {
        data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "parent_id",
                rootPId: 0
            }
        },
        callback:{
            onClick:function(event, treeId, treeNode){
               $("#goods-goods_category_id").val(treeNode.id);
            }
        }
    };
    // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
    var zNodes = {$models};
    
       zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
       zTreeObj.expandAll(true);//展开所有节点
       zTreeObj.selectNode(zTreeObj.getNodeByParam("id", "{$model->goods_category_id}", null));//选中节点
 

EOT;
//注册js 事件
$this->registerJs($js);
?>
<link rel="stylesheet" href="/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">