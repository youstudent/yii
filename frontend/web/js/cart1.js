/*
@功能：购物车页面js
@作者：diamondwang
@时间：2013年11月14日
*/

//计算总价格
function total(){
    var total = 0;
    $(".col5 span").each(function(){
        total += parseFloat($(this).text());
    });
    $("#total").text(total.toFixed(2));
}


$(function(){
	
	//减少
	$(".reduce_num").click(function(){
		var amount = $(this).parent().find(".amount");
		if (parseInt($(amount).val()) <= 1){
			alert("商品数量最少为1");
		} else{
            var amount = $(this).parent().find(".amount");
            var num = parseInt(amount.val()) - 1;
            var tr = $(this).closest("tr");
            var goods_id = tr.attr('goods_id');
			$.post('/cart/ajax?filter=edit',{goods_id:goods_id,num:num},function (data) {
				if (data == "success"){
                    $(amount).val(num);
                    //小计
                    var subtotal = parseFloat(tr.find(".col3 span").text()) * parseInt($(amount).val());
                    tr.find(".col5 span").text(subtotal.toFixed(2));
                    //总计金额
                    var total = 0;
                    $(".col5 span").each(function(){
                        total += parseFloat($(this).text());
                    });

                    $("#total").text(total.toFixed(2));
                    total();
				}else {
					console.log(data);
				}
            })
		}

	});

	//增加
	$(".add_num").click(function(){

        var amount = $(this).parent().find(".amount");
        var num = parseInt(amount.val()) + 1;
        var tr = $(this).closest("tr");
        var goods_id = tr.attr('goods_id');

		$.post('/cart/ajax?filter=edit',{goods_id:goods_id,num:num},function(data){
              if (data =='success'){

              	  $(amount).val(num);
                  //小计
                  var subtotal = parseFloat(tr.find(".col3 span").text()) * parseInt($(amount).val());
                  tr.find(".col5 span").text(subtotal.toFixed(2));
                  //总计金额
                  var total = 0;
                  $(".col5 span").each(function(){
                      total += parseFloat($(this).text());
                  });

                  $("#total").text(total.toFixed(2));
                  total();

			  }else {
              	  console.log(data);
			  }

		});



	});

	//直接输入
	$(".amount").blur(function(){
		if (parseInt($(this).val()) < 1){
			alert("商品数量最少为1");
			$(this).val(1);
		}
		//小计
		var subtotal = parseFloat($(this).parent().parent().find(".col3 span").text()) * parseInt($(this).val());
		$(this).parent().parent().find(".col5 span").text(subtotal.toFixed(2));
		//总计金额
		var total = 0;
		$(".col5 span").each(function(){
			total += parseFloat($(this).text());
		});

		$("#total").text(total.toFixed(2));
         total();
	});

	//删除商品
	$(".btn_del").click(function(){
		if (confirm('确认删除该商品吗?')){
			var tr = $(this).closest("tr");
			var goods_id = tr.attr('goods_id');
			console.log(goods_id);
            //发送ajax请求
            $.post('/cart/ajax?filter=del',{goods_id:goods_id},function(data){
				if (data == 'success'){
					tr.remove();
                    total();
				}
            })
		}

    });

});