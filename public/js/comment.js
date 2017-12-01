$(document).ready(function () {
	$('#submit-comment').click(function () {
		//lay newid, lay userid
		var news_id = $(this).attr('data-newsid');
		
		var com = $('#txtcomment').val();
		var error= false;

		if(com=="")
		{	
			$('.error-comment').html('Bạn chưa nhập bình luận');
			$('.error-comment').fadeIn();
			error = true;
		}else if(com.length < 4 || com.length > 500)
		{	
			$('.error-comment').html('Bình luận phải có độ dài từ 4 đến 500 kí tự');
			$('.error-comment').fadeIn();
			error = true;
		}
		if(error == true){
			return false;

		}else{
			$.ajax({
				url: 'proccess/xuly_comment.php',
				type: 'post',
				data: "com="+com+"&news_id="+news_id,
				async: "true",
				success:function(kq){
					if($("#list-comment .comment-x").length == 0)
					{
						$("#list-comment").html(kq);
						$('#txtcomment').val('');
					}else{
						$("#list-comment .comment-x:eq(0)").before(kq);
						$('#txtcomment').val('');
					}
				}
			});
			return false;
		}
		
	});
	//xoa comment 
	$(".btn-del-comment").click(function (){
		var com_id = $(this).attr('data-comid');
		var cf = confirm('Bạn muốn xóa bình luận này?');
		if(cf ==false){
			return false;
		}else{
			$.ajax({
				url: "proccess/xuly_delcomment.php",
				type: "post",
				data: "com_id="+com_id,
				async: true,
				success:function(kq)
				{
					if(kq == "true")
					{
						$(".comment"+com_id).fadeOut();
					}
				}
			});
			return false;
		}
	});


	$('#txtcomment').keyup(function (){
		$('.error-comment').fadeOut();
	});
	$('.btn-cancel-comment').click(function (){
		$('#txtcomment').val("");
	});
});