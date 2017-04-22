
<!-- 头部 end-->

<div style="clear:both;"></div>

<!-- 页面主体 start -->
<div class="main w1210 bc mt10">
    <div class="crumb w1210">
        <h2><strong>我的XX </strong><span>> 我的订单</span></h2>
    </div>

    <!-- 左侧导航菜单 start -->
    <div class="menu fl">
        <h3>我的XX</h3>
        <div class="menu_wrap">
            <dl>
                <dt>订单中心 <b></b></dt>
                <dd><b>.</b><a href="">我的订单</a></dd>
                <dd><b>.</b><a href="">我的关注</a></dd>
                <dd><b>.</b><a href="">浏览历史</a></dd>
                <dd><b>.</b><a href="">我的团购</a></dd>
            </dl>

            <dl>
                <dt>账户中心 <b></b></dt>
                <dd class="cur"><b>.</b><a href="">账户信息</a></dd>
                <dd><b>.</b><a href="">账户余额</a></dd>
                <dd><b>.</b><a href="">消费记录</a></dd>
                <dd><b>.</b><a href="">我的积分</a></dd>
                <dd><b>.</b><a href="">收货地址</a></dd>
            </dl>

            <dl>
                <dt>订单中心 <b></b></dt>
                <dd><b>.</b><a href="">返修/退换货</a></dd>
                <dd><b>.</b><a href="">取消订单记录</a></dd>
                <dd><b>.</b><a href="">我的投诉</a></dd>
            </dl>
        </div>
    </div>
    <!-- 左侧导航菜单 end -->

    <!-- 右侧内容区域 start -->
    <div class="content fl ml10">
        <div class="address_hd">
            <h3>收货地址薄</h3>
            <?php foreach ($res as $re):?>
            <dl class="last"> <!-- 最后一个dl 加类last -->
                <dt><?=$re->id.'.&nbsp'.$re->consignee.'&nbsp'.$re->province.'&nbsp'.$re->city.'&nbsp'.$re->area.'&nbsp'.$re->tel?></dt>
                <dd>
                    <a href="">修改</a>
                    <a href="del?id=<?=$re->id?>">删除</a>
                    <a href="check?id=<?=$re->id?>"><?=$re->check==1?'默认地址':'设置默认地址'?></a>
                </dd>
            </dl>
            <?php endforeach;?>

        </div>

        <div class="address_bd mt10">
            <h4>新增收货地址</h4>
            <form action="index" name="address_form" method="post">
                <?php
                $form = \yii\widgets\ActiveForm::begin();
                  echo '<ul>';
                  echo $form->field($model,'consignee',[
                      'options'=>['tag'=>'li'],//包裹整个输入框的标签
                     'errorOptions'=>['tag'=>'p','style'=>'margin-left:70px;margin-top:6px'],//错误信息的标签
                  ])->textInput(['class'=>'txt']);

                 echo  '<label for=""><span>*</span>所在地:</label>
                      <select name="province" id="cmbProvince"></select>
                      <select name="city" id="cmbCity"></select>
                      <select name="area" id="cmbArea"></select>';

//                echo '<label for=""><span>*</span>所在地：</label>
//								<select name="provice" id="cmbProvince">
//								</select>
//                               <select name="city" id="cmbCity">
//								</select>
//								<select name="area" id="cmbArea">
//								</select>';
                echo '<br>';
                echo '<br>';
                echo $form->field($model,'detailed_address',[
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p','style'=>'margin-left:70px;margin-top:6px'],//错误信息的标签
                ])->textInput(['class'=>'txt address']);

                echo $form->field($model,'tel',[
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p','style'=>'margin-left:70px;margin-top:6px'],//错误信息的标签
                ])->textInput(['class'=>'txt']);
                echo $form->field($model,'check',[
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
                ])->checkbox(['class'=>'check']);
                echo \yii\helpers\Html::submitButton('保存',['style'=>'margin-left:20px']);
                $form = \yii\widgets\ActiveForm::end();
                  echo '</ul>';
                 ?>
            </form>
        </div>

    </div>
    <!-- 右侧内容区域 end -->
</div>
<!-- 页面主体 end-->

<div style="clear:both;"></div>
<!-- 底部导航 start -->
<div class="bottomnav w1210 bc mt10">
<?=\frontend\widgets\ArticleCategoryWidgets::widget()?>
</div>
<!-- 底部导航 end -->
<script type="text/javascript">
    addressInit('cmbProvince', 'cmbCity', 'cmbArea', '四川', '自贡市', '富顺县');
</script>
