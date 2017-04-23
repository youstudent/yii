<table class="table table-bordered table-hover" >
    <tr>
        <th>用户名</th>
        <th>电话号码</th>
        <th>邮箱</th>
        <th>注册时间</th>
    </tr>
    <tr>
        <td><?=$member->username?></td>
        <td><?=$member->tel?></td>
        <td><?=$member->email?></td>
        <td><?=date('Y-m-d H:i:s',$member->add_time)?></td>
    </tr>
</table>
<?php
echo \yii\bootstrap\Html::a('解除绑定',['wechat/jie'],['class'=>'btn btn-info btn-block']);?>