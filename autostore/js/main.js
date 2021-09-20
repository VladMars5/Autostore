function mobileCheck(){
	var winWidth=$(window).width();
	if (winWidth<=768) {
		$("#sidebar").after($("#body .pagination:first"))
	} else {
		$(".products-wrap").before($("#body .pagination:first"))
	}
}

$(document).ready(function() {
		loadcart();
		$("input[type=checkbox]").crfi();
		$("select").crfs();
		// $(".last-products .products").bxSlider({
		// 		pager: false,
		// 		minSlides: 1,
		// 		maxSlides: 5,
		// 		slideWidth: 235,
		// 		slideMargin: 0
		// });

		$(".tabs .nav a").click(function() {
			var container = $(this).parentsUntil(".tabs").parent();
			if (!$(this).parent().hasClass("active")) {
				container.find(".nav .active").removeClass("active")
				$(this).parent().addClass("active")
				container.find(".tab-content").hide()
				$($(this).attr("href")).show();
			};
			return false;
		});
		console.log('333');
		$("#price-range").slider({
			range: true,
			min: 0,
			max: 300000,
			values: [ 10000, 200000 ],
			slide: function( event, ui ) {
				$(".ui-slider-handle:first").html("<span>" + ui.values[ 0 ] + " ₽</span>");
				$(".ui-slider-handle:last").html("<span>" + ui.values[ 1 ] + " ₽</span>");
			}
		});
		console.log('444');
		$(".ui-slider-handle:first").html("<span>" + $( "#price-range" ).slider( "values", 0 ) + " ₽</span>");
		$(".ui-slider-handle:last").html("<span>" + $( "#price-range" ).slider( "values", 1 ) + " ₽</span>");
		$("#menu .trigger").click(function() {
			$(this).toggleClass("active").next().toggleClass("active")
		});

		mobileCheck();
		$(window).resize(function() {
			mobileCheck();
		});

			if(~location.href.indexOf("products.php?sort=dateup") || ~location.href.indexOf("products.php?sort=datedown"))
			{
				$('input[name="dark"][id="dark3"]').prop('checked',true);
			}
			if(~location.href.indexOf("products.php?sort=populardown")||~location.href.indexOf("products.php?sort=popularup"))
			{
				$('input[name="dark"][id="dark1"]').prop('checked',true);
			}

			if(~location.href.indexOf("products.php?sort=pricedown") || ~location.href.indexOf("products.php?sort=priceup"))
			{
				$('input[name="dark"][id="dark2"]').prop('checked',true);
			}
			if(~location.href.indexOf("categ=0"))
			{
				$('input[name="dark1"][id="dark0"]').prop('checked',true);
			}
			if(~location.href.indexOf("categ=1"))
			{
				$('input[name="dark1"][id="dark1"]').prop('checked',true);
			}
			if(~location.href.indexOf("categ=2"))
			{
				$('input[name="dark1"][id="dark2"]').prop('checked',true);
			}
			if(~location.href.indexOf("categ=3"))
			{
				$('input[name="dark1"][id="dark3"]').prop('checked',true);
			}
			if(~location.href.indexOf("categ=4"))
			{
				$('input[name="dark1"][id="dark4"]').prop('checked',true);
			}
			if(~location.href.indexOf("categ=5"))
			{
				$('input[name="dark1"][id="dark5"]').prop('checked',true);
			}
			if(location.href=="http://jewellerystore/products.php")
			{
				$('input[name="dark1"][id="dark0"]').prop('checked',true);
			}

			function isValidEmailAddress(emailAddress){
				var pattern= new RegExp( /^[\w]{1}[\w-\.]*@[\w-]+\.[a-z]{2,4}$/i);
		return pattern.test(emailAddress);

			}
			function isValidAddress(Address){
				var pattern=new RegExp(/г+\.[А-Яа-я\s-]+[\s,]+[ул|пер|пр|б-р]+\.[А-Яа-я\s-]+[\s,]+[дом|д]+\.[0-9\/]+[\s,]+кв+\.[0-9]/);
		return pattern.test(Address);
			}
			function isValidPhone(Phone){
				var pattern= new RegExp( /^(\+7|8)(\(\d{3}\)|\d{3})\d{7}$/);
		return pattern.test(Phone);
			}
			function isValidFio(Fio){
				var pattern=new RegExp(/^[А-Яа-я\s]+$/);
		return pattern.test(Fio);
			}

			$('#confirm-button-next').click(function(e){
				var order_fio=$("#order_fio").val();
				var order_email=$("#order_email").val();
				var order_phone=$("#order_phone").val();
				var order_address=$("#order_address").val();
				if(!$(".order_payment").is(":checked")){
					$(".label_payment").css("color","#E07B7B");
					send_order_payment='0';
				}
				else{
					$(".label_payment").css("color","black");
					send_order_payment='1';
				}
				if(order_fio==""||order_fio.length>50||isValidFio(order_fio)==false){
					$("#order_fio").css("borderColor","#FDB6B6");
					send_order_fio='0';
				}
				else{$("#order_fio").css("borderColor","#DBDBDB");send_order_fio='1';}

				if(order_email==""||isValidEmailAddress(order_email)==false){
					$("#order_email").css("borderColor","#FDB6B6");
					send_order_email='0';
				}
				else{$("#order_email").css("borderColor","#DBDBDB");send_order_email='1';}
				if(order_phone==""||order_phone.length>50||isValidPhone(order_phone)==false){
					$("#order_phone").css("borderColor","#FDB6B6");
					send_order_phone='0';
				}
				else{$("#order_phone").css("borderColor","#DBDBDB");send_order_phone='1';}
				if(order_address==""||isValidAddress(order_address)==false){
					$("#order_address").css("borderColor","#FDB6B6");
					send_order_address='0';
				}
				else{$("#order_address").css("borderColor","#DBDBDB");send_order_address='1';}
				if(send_order_payment==1 && send_order_email==1 && send_order_phone==1 && send_order_address==1 && send_order_fio==1 ){
					return true;
				}
				e.preventDefault();

			});


			$('.ico-del').click(function() {
					var tid=$(this).attr("tid");

					$.ajax({
							type:"POST",
							url:"/include/deletefromcart.php",
							data:"id="+tid,
							dataType: "html",
							cache:false,
							success:function(data) {
									window.location.reload();
									if(data=="0") {
											alert("В наличии нет такого количества данного товара")
									}
									else {
											loadcart();
									}
							}
					});
			});
			$('.btn-add').click(function() {
					var tid=$(this).attr("tid");

					$.ajax({
							type:"POST",
							url:"/include/addtocart.php",
							data:"id="+tid,
							dataType: "html",
							cache:false,
							success:function(data) {
									if(data=="0") {
											alert("В наличии нет такого количества данного товара")
									}
									else {
											loadcart();
									}
							}
					});
			});
			function loadcart(){
					$.ajax({
							type:"POST",
							url:"/include/loadcart.php",

							dataType: "html",
							cache:false,
							success:function(data){
									if(data=="0") {
											$(".cart>a").html('<span class="ico-products"></span>Корзина пустая');
									}
									else {
											$(".cart>a").html(data);
									}
							}
					});
				};
				function thousandSeparator (str) {
					var parts = (str + '').split('.'),
						main = parts[0],
						len = main.length,
						output = '',
						i = len - 1;

					while(i >= 0) {
						output = main.charAt(i) + output;
						if ((len - i) % 3 === 0 && i > 0) {
							output = ' ' + output;
						}
						--i;
					}

					if (parts.length > 1) {
						output += '.' + parts[1];
					}
					return output;
				};
			$('.count-minus').click(function(){
				var iid=$(this).attr("iid");
				$.ajax({
					type:"POST",
					url:"/include/count-minus.php",
					data:"id="+iid,
					dataType:"html",
					cache:false,
					success:function(data){
						$("#input-id"+iid).val(data);
						loadcart();
						var priceproduct=$("#tovar"+iid+">p").attr("price");
						result_total=Number(priceproduct)*Number(data);
						$("#tovar"+iid+" > p").html(thousandSeparator(result_total)+" ₽");
						$("#tovar"+iid+"> h5 > .span-count").html(data);
						itog_price();
					}
				})
			});
			function itog_price(){
				$.ajax({
					type:"POST",
					url:"/include/itog_price.php",
					dataType:"html",
					cache:false,
					success:function(data){
						$(".itog-price > strong").html(data);
					}
				});
			};
			$('.count-plus').click(function(){
				var iid=$(this).attr("iid");
				$.ajax({
					type:"POST",
					url:"/include/count-plus.php",
					data:"id="+iid,
					dataType:"html",
					cache:false,
					success:function(data){
						if(data=="0")
						{alert("В наличии нет такого количества данного товара"); }
						else{
						$("#input-id"+iid).val(data);
						loadcart();
						var priceproduct=$("#tovar"+iid+">p").attr("price");
						result_total=Number(priceproduct)*Number(data);
						$("#tovar"+iid+" > p").html(thousandSeparator(result_total)+" ₽");
						$("#tovar"+iid+"> h5 > .span-count").html(data);
						itog_price();
						}
					}
				});
			});
			$('.count-input').keypress(function(e){
				if(e.keyCode==13){
					var iid=$(this).attr("iid");
					var incount=$("#input-id"+iid).val();
				$.ajax({
					type:"POST",
					url:"/include/count-input.php",
					data:"id="+iid+"&count="+incount,
					dataType:"html",
					cache:false,
					success:function(data){
						if(data!=incount){alert("В наличии нет такого количества данного товара");
						$("#input-id"+iid).val(data);
						loadcart();
						var priceproduct=$("#tovar"+iid+">p").attr("price");
						result_total=Number(priceproduct)*Number(data);
						$("#tovar"+iid+" > p").html(thousandSeparator(result_total)+" ₽");
						$("#tovar"+iid+"> h5 > .span-count").html(data);
						itog_price();
						 }
						else{
						$("#input-id"+iid).val(data);
						loadcart();
						var priceproduct=$("#tovar"+iid+">p").attr("price");
						result_total=Number(priceproduct)*Number(data);
						$("#tovar"+iid+" > p").html(thousandSeparator(result_total)+" ₽");
						$("#tovar"+iid+"> h5 > .span-count").html(data);
						itog_price();
						}
					}
				});
				};
			});
			$("#genpass").on('click',function(){

				$.ajax({
					type:"POST",
					url:"/functions/genpass.php",
					dataType:"html",
					cache:false,
					success:function(data){
						$('#reg_pass').val(data);
					}
				});
			});
			$('.top-auth').on('click',
				function(){

					$("#block-top-auth").toggle();}

			);
			$('#button-pass-show-hide').click(function() {
				var statuspass =$('#button-pass-show-hide').attr("class");

				if(statuspass == "pass-show") {
					$('#button-pass-show-hide').attr("class","pass-hide");
						var $input = $("#auth_pass");
						var change ="text";
						var rep = $("<input placeholder='Пароль' type='" + change + "' />")
							.attr("id",$input.attr("id"))
							.attr("name",$input.attr("name"))
							.attr('class',$input.attr('class'))
							.val($input.val())
							.insertBefore($input);
						$input.remove();
						$input = rep;
				} else {
					$('#button-pass-show-hide').attr("class","pass-show");
						var $input = $("#auth_pass");
						var change ="password";
						var rep = $("<input placeholder='Пароль' type='" + change + "' />")
							.attr("id",$input.attr("id"))
							.attr("name",$input.attr("name"))
							.attr('class',$input.attr('class'))
							.val($input.val())
							.insertBefore($input);
						$input.remove();
						$input = rep;
				}
			});
			$("#button-auth").click(function(){
				var auth_login=$("#auth_login").val();
				var auth_pass=$("#auth_pass").val();
				if(auth_login==""|| auth_login.length>30){
					$("#auth_login").css("borderColor","#FDB6B6");
					send_login='no';
				}
				else{
					$("#auth_login").css("borderColor","#DBDBDB");
					send_login='yes';

				}
				if(auth_pass==""|| auth_pass.length>15){
					$("#auth_pass").css("borderColor","#FDB6B6");
					send_pass='no';
				}
				else{
					$("#auth_pass").css("borderColor","#DBDBDB");
					send_pass='yes';
				}
				if($(".checkmark").css("backgroundColor")=='rgb(33, 150, 243)'){
					auth_rememberme='yes';


				}
				else{ auth_rememberme='no';

				}
		if(send_login=='yes'&& send_pass=='yes'){
		$.ajax({
			type:"POST",
			url:"/include/auth.php",
			data:"login="+auth_login+"&pass="+auth_pass+"&rememberme="+auth_rememberme,
			dataType:"html",
			cache:false,
			success:function(data){
				if(data=='yes_auth'){
				location.reload();
			}
			else{
				$("#message-auth").slideDown(400);
			}
		}
		});
		}
			});
			$('#remindpass').click(function(){
				$('#input-email-pass').fadeOut(200,function(){
					$('#block-remind').fadeIn(300);
				});

			});
			$('#prev-auth').click(function(){
				$('#block-remind').fadeOut(200,function(){
					$('#input-email-pass').fadeIn(300);
				});

			});
			$('#button-remind').click(function(){
				var recall_email=$("#remind-email").val();
				if(recall_email==""||isValidEmailAddress(recall_email)==false){
					$("#remind-email").css("borderColor","#FDB6B6");

				}
				else{
					$("#remind-email").css("borderColor","#DBDBDB");
					$.ajax({
						type:"POST",
						url:"/include/remind-pass.php",
						data:"email="+recall_email,
						dataType:"html",
						cache:false,
						success:function(data){
							if(data=='yes'){
								$('#message-remind').attr("class","message-remind-success").html("На ваш e-mail выслан пароль.").slideDown(400);
								setTimeout("$('#message-remind').html('').hide(),$('#block-remind').hide(),$('#input-email-pass').show()",3000);
							}
							else{
								$('#message-remind').attr("class","message-remind-error").html(data).slideDown(400);
							}
						}
					});
				}
			});
			$('#auth-user-info').on('click',
				function(){

					$("#block-user").toggle();}

			);
			$('#logout').click(function(){
				$.ajax({
					type:"POST",
					url:"/include/logout.php",
					dataType:"html",
					cache:false,
					success:function(data){
						if(data=='logout'){
							location.reload();
						}
					}
				});
			});
			var field = $('#list').find('option');

		// собственно поиск
		$('#searchInput').bind('keyup', function() {
		  var q = new RegExp($(this).val(), 'ig');

		  for (var i = 0, l = field.length; i < l; i += 1) {
		      var option = $(field[i]),
		          parent = option.parent();

		      if ($(field[i]).text().match(q)) {
		          if (parent.is('span')) {
		              option.show();
		              parent.replaceWith(option);
		          }
		      } else {
		          if (option.is('option') && (!parent.is('span'))) {
		              option.wrap('<span>').hide();
		          }
		      }
		  }
		});



});
