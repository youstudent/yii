<?php
/*  @var $this yii\web\View */
?>
<!-- 登录主体部分start -->
<div class="login w990 bc mt10 regist">
    <div class="login_hd">
        <h2>用户注册</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <?php
            $form = \yii\widgets\ActiveForm::begin();
            echo '<ul>';
            $button =  '<input type="button" id="get_captcha" value="获取验证码" style="height: 25px;padding:3px 8px">';

            echo $form->field($model,'username',
                [
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
                    //'template'=>"{label}\n{input}$button\n{hint}\n{error}",//输出模板
                ]
            )->textInput(['class'=>'txt','placeholder'=>'您的帐户名和登陆名']);
            echo $form->field($model,'password',
                [
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
                    //'template'=>"{label}\n{input}$button\n{hint}\n{error}",//输出模板
                ]
            )->passwordInput(['class'=>'txt','placeholder'=>'建议使用两种字符组合','maxlength'=>16]);

            echo $form->field($model,'passwords',
                [
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
                    //'template'=>"{label}\n{input}$button\n{hint}\n{error}",//输出模板
                ]
            )->passwordInput(['class'=>'txt','placeholder'=>'请再次确认密码','maxlength'=>16]);

            echo $form->field($model,'email',
                [
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
                ]
            )->textInput(['class'=>'txt','placeholder'=>'邮箱必须合法']);

            echo $form->field($model,'tel',
                [
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
                ]
            )->textInput(['class'=>'txt','placeholder'=>'建议常使用手机','maxlength'=>11]);

            echo $form->field($model,'duanxin',
                [
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                   'errorOptions'=>['tag'=>'p'],//错误信息的标签
                    'template'=>"{label}\n{input}&nbsp&nbsp$button\n{hint}\n{error}",//输出模板
                ]
            )->textInput(['class'=>'txt','placeholder'=>'请输入手机验证码
']);
            echo $form->field($model,'code',
                [
                    'options'=>['tag'=>'li','class'=>'checkcode'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p','style'=>'margin-left:60px;margin-top:10px'],//错误信息的标签
                ]
            )->widget(yii\captcha\Captcha::className(),[
               'template'=>"{input}{image}"
           ]);

            echo  $form->field($model,'checkbox',[
                'options'=>['tag'=>'li','class'=>'chb'],
            ])->checkbox().'我已阅读并同意《用户注册协议》';

            echo '<li><label for="">&nbsp;</label>'.\yii\helpers\Html::submitButton('',['class'=>'login_btn']).'</li>';
            echo '</ul>';
            \yii\widgets\ActiveForm::end();

            ?>


        </div>

        <div class="mobile fl">
            <h3>手机快速注册</h3>
            <p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
            <p><strong>1069099988</strong></p>
        </div>

    </div>
</div>
<!-- 登录主体部分end -->
<?php
//定义路由路径
$url = \yii\helpers\Url::to(['member/code']);
$Token = Yii::$app->request->csrfToken;
$js=<<<EOT
        $('#get_captcha').click(function(){
            var tel = $('#member-tel').val();
            $.post('{$url}',{tel:tel,'_csrf-frontend':'{$Token}'},function(data){
                  console.log(data);
            
            });
            $('#captcha').prop('disabled',false);
            var time=30;
            var interval = setInterval(function(){
                time--;
                if(time<=0){
                    clearInterval(interval);
                    var html = '获取验证码';
                    $('#get_captcha').prop('disabled',false);
                } else{
                    var html = time + ' 秒后再次获取';
                    $('#get_captcha').prop('disabled',true);
                }
    
                $('#get_captcha').val(html);
            },1000);
        })
        
       
  



EOT;
$this->registerJs($js);
?>



