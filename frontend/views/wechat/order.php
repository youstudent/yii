<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>姓名</th>
        <th>城市</th>
        <th>电话</th>
        <th>价格</th>
        <th>订单号</th>
        <th>下单时间</th>
    </tr>
    <?php foreach($orders as $order):?>
    <tr>
        <td><?=$order->id?></td>
        <td><?=$order->name?></td>
        <td><?=$order->province_name.$order->city_name.$order->area_name?></td>
        <td><?=$order->tel?></td>
        <td><?=$order->price?></td>
        <td><?=$order->trade_no?></td>
        <td><?=date('Y-m-d H:i:s',$order->create_time)?></td>
    </tr>
    <?php endforeach;?>
</table>