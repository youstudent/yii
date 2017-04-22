<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="index.html"><img src="<?=Yii::getAlias('@web')?>/images/logo.png" alt="京西商城"></a></h2>
        <div class="flow fr flow2">
            <ul>
                <li>1.我的购物车</li>
                <li class="cur">2.填写核对订单信息</li>
                <li>3.成功提交订单</li>
            </ul>
        </div>
    </div>
</div>
<!-- 页面头部 end -->

<div style="clear:both;"></div>

<!-- 主体部分 start -->
<div class="fillin w990 bc mt15">
    <div class="fillin_hd">
        <h2>填写并核对订单信息</h2>
    </div>
    <div class="fillin_bd">
        <!-- 收货人信息  start-->
        <?php $form = \yii\widgets\ActiveForm::begin()?>
        <div class="address">
            <h3>收货人信息 <a href="javascript:;" id="address_modify"></a></h3>
            <div class="address_info">
                <?php foreach($address as $addres):?>
                <p><input type="radio" value="<?=$addres->id?>" name="address_id"/><?=$addres->consignee.'&nbsp&nbsp'.$addres->tel.'&nbsp&nbsp'.$addres->province.'&nbsp&nbsp'.$addres->city.'&nbsp&nbsp'.$addres->area?></p>
                <?php endforeach;?>
            </div>
        <!-- 配送方式 start -->
        <div class="delivery">
            <h3>送货方式 <a href="javascript:;" id="delivery_modify">[修改]</a></h3>
            <div class="delivery_info">
                <p>默认 京东快递</p>
                <p>送货时间不限</p>
            </div>

            <div class="delivery_select none">
                <table>
                    <thead>
                    <tr>
                        <th class="col1">送货方式</th>
                        <th class="col2">运费</th>
                        <th class="col3">运费标准</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (\frontend\models\Order::$deliveres as $k=>$delivere):?>
                    <tr class="cur">
                        <td>
                            <input type="radio" name="delivery" value="<?=$k?>" checked="checked" / ><?=$delivere[0]?>
                            <select name="" id="">
                                <option value="">时间不限</option>
                                <option value="">工作日，周一到周五</option>
                                <option value="">周六日及公众假期</option>
                            </select>
                        </td>
                        <td><?=$delivere[1]?></td>
                        <td><?=$delivere[2]?></td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
                <a href="" class="confirm_btn"><span>确认送货方式</span></a>
            </div>
        </div>
        <!-- 配送方式 end -->

        <!-- 支付方式  start-->
        <div class="pay">
            <h3>支付方式 <a href="javascript:;" id="pay_modify">[修改]</a></h3>
            <div class="pay_info">
                <p>默认 微信支付</p>
            </div>

            <div class="pay_select none">
                <table>
                    <?php foreach (\frontend\models\Order::$pays as $k =>$pay):?>
                    <tr class="cur">
                        <td class="col1"><input type="radio" value="<?=$k?>" name="pay" checked/><?=$pay[0]?></td>
                        <td class="col2"><?=$pay[1]?></td>
                    </tr>
                    <?php endforeach;?>
                </table>
                <a href="" class="confirm_btn"><span>确认支付方式</span></a>
            </div>
        </div>
        <!-- 支付方式  end-->
        <!-- 商品清单 start -->
        <div class="goods">
            <h3>商品清单</h3>
            <table>
                <thead>
                <tr>
                    <th class="col1">商品</th>
                    <th class="col3">价格</th>
                    <th class="col4">数量</th>
                    <th class="col5">小计</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($models as $model):?>
                <tr>
                    <input type="hidden" name="goods_id" value="<?=$model['id']?>">
                    <td class="col1"><a href=""><?=\yii\helpers\Html::img($model['logo'])?></a>  <strong><a href=""><?=$model['name']?></a></strong></td>
                    <td class="col3"><?=$model['shop_price']?></td>
                    <td class="col4"><?=$model['num']?></td>
                    <td class="col5"><span><?=$model['shop_price']*$model['num']?></span></td>
                </tr>
                <?php endforeach;?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <ul>
                            <li>
                                <span><?=$mun?>件商品，总商品金额：</span>
                                <em><?=$total?></em>
                            </li>
                            <li>
                                <span>运费：</span>
                                <em>￥10.00</em>
                            </li>
                            <li>
                                <span>应付总额：</span>
                                <em><?=$total?></em>
                            </li>
                        </ul>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- 商品清单 end -->

    </div>

    <div class="fillin_ft">
        <?php echo \yii\helpers\Html::submitButton('')?>
        <p>应付总额：<strong><?=$total?></strong></p>
        <?php $form = \yii\widgets\ActiveForm::end()?>
    </div>
</div>
<!-- 主体部分 end -->

<div style="clear:both;"></div>
