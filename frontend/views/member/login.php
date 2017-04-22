<!-- 登录主体部分start -->
<div class="login w990 bc mt10">
    <div class="login_hd">
        <h2>用户登录</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <form action="" method="post">
                <?php
                $form = \yii\widgets\ActiveForm::begin();
                echo '<ul>';
                echo $form->field($model,'username',
                    [
                        'options'=>['tag'=>'li'],//包裹整个输入框的标签
                        'errorOptions'=>['tag'=>'p','style'=>'margin-left:70px;margin-top:6px'],//错误信息的标签
                        //'template'=>"{label}\n{input}\n{hint}\n{error}",//输出模板
                    ]
                )->textInput(['class'=>'txt','placeholder'=>'用户名']);
                echo $form->field($model,'password',
                    [
                        'options'=>['tag'=>'li'],//包裹整个输入框的标签
                        'errorOptions'=>['tag'=>'p','style'=>'margin-left:70px;margin-top:6px'],//错误信息的标签
                    ]
                )->passwordInput(['class'=>'txt','placeholder'=>'密码','maxlength'=>'16']);
                echo $form->field($model,'code',
                    [
                        'options'=>['tag'=>'li','class'=>'checkcode'],//包裹整个输入框的标签
                        'errorOptions'=>['tag'=>'p','style'=>'margin-left:60px;margin-top:10px'],//错误信息的标签
                    ]
                )->widget(yii\captcha\Captcha::className(),[
                    'template'=>"{input}{image}"
                ]);
                echo  $form->field($model,'rember',[
                        'options'=>['tag'=>'li','class'=>'chb'],
                    ])->checkbox().'记住我';
                echo '<li><label for="">&nbsp;</label>'.\yii\helpers\Html::submitButton('',['class'=>'login_btn']).'</li>';
                echo '</ul>';
                \yii\widgets\ActiveForm::end();

                ?>

            <div class="coagent mt15">
                <dl>
                    <dt>使用合作网站登录商城：</dt>
                    <dd class="qq"><a href=""><span></span>QQ</a></dd>
                    <dd class="weibo"><a href=""><span></span>新浪微博</a></dd>
                    <dd class="yi"><a href=""><span></span>网易</a></dd>
                    <dd class="renren"><a href=""><span></span>人人</a></dd>
                    <dd class="qihu"><a href=""><span></span>奇虎360</a></dd>
                    <dd class=""><a href=""><span></span>百度</a></dd>
                    <dd class="douban"><a href=""><span></span>豆瓣</a></dd>
                </dl>
            </div>
        </div>

        <div class="guide fl">
            <h3>还不是商城用户</h3>
            <p>现在免费注册成为商城用户，便能立刻享受便宜又放心的购物乐趣，心动不如行动，赶紧加入吧!</p>

            <a href="add" class="reg_btn">免费注册 >></a>
        </div>

    </div>
</div>
<!-- 登录主体部分end -->

<div style="clear:both;"></div>
<!-- 底部版权 start -->

</body>
</html>