$(document).ready(function (){

	//bắt sự kiên nhấn submit
	$('.btn-submit-reply').click(function (){
		
		var com_id = $(this).attr('data-comid');
		var rep_mess = $('.reply-mess'+com_id).val();
		var error =false;
		if(rep_mess == "")
		{
			$('.error-reply'+com_id).html('Bạn phải nhập nội dung');
			$('.error-reply'+com_id).fadeIn();
			error = true;
		}else if(rep_mess.length < 4 || rep_mess.length > 500)
		{
			$('.error-reply'+com_id).html('Bạn phải nhập trả lời có từ 4 đến 500 kí tự');
			$('.error-reply'+com_id).fadeIn();
			error = true;
		}
		if(error == true)
		{
			return false;
		}else{
			$.ajax({
				url: "proccess/xuly_reply.php",
				type: "post",
				data: "com_id="+com_id+"&rep_mess="+rep_mess,
				async: true,
				success:function(kq)
				{	
					// if($(".list-reply"+com_id+" .reply-x").length == 0)
					// {
						
					// 	$(".list-reply"+com_id).html(kq);
					// 	$('.reply_mess'+com_id).val("");
					// 	$('.error-reply'+com_id).fadeOut();
					// }else{
					// 	$(".list-reply"+com_id+" .reply-x:eq(0)").before(kq);
					// 	$('.reply_mess'+com_id).val("");
					// 	$('.error-reply'+com_id).fadeOut();
					// }
						$(".list-reply"+com_id).append(kq);
					 	$('.reply_mess'+com_id).val("");
					 	$('.error-reply'+com_id).fadeOut();
				}
			});
			return false;
		}
	});

	//xóa reply
	//bắt sự kiện click xóa
	$(".btn-del-reply").click(function (){
		var rep_id = $(this).attr("data-repid");

		var cf = confirm("Bạn có muốn xóa trả lời này?");
		if(cf == false)
		{
			return false;
		}else{
			
			$.ajax({
				url: "proccess/js/xuly_delreply.php",
				type: "post",
				data: "rep_id="+rep_id,
				async: true,
				success:function(kq)
				{	
					if(kq == "true"){
						$(".reply"+rep_id).fadeOut();
					}
					
				}
			});
		}
	});

	$('.btn-cancel-reply').click(function (){
		var com_id = $(this).attr('data-comid');
		$('.rep-post'+com_id).slideToggle();
		$('.reply-mess'+com_id).val("");
		$('.error-reply'+com_id).fadeOut();
	});
});