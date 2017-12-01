$(document).ready(function (){
	$('.login-btn').click(function (){
		
		$('#exampleModalLabel').html('Đăng nhập');
		$('.btn-submit').html('Đăng nhập');
		$('.btn-submit').attr("id","login-ajax");
	});

	$('.register-btn').click(function (){
		$('#exampleModalLabel').html('Đăng kí');
		$('.btn-submit').html('Đăng kí');
		$('.btn-submit').attr('id','register-ajax');
	});

	$('.btn-submit').click(function(){
		// $('#myLogin').delegate("#login-ajax","click", function(){ để có thể gọi #login-ajax ta phải dùng hàm live
		
		var uname = $('#inputUsername').val();
		var pass = $('#inputPassword').val();
		var error = false;
		if(/^[a-zA-Z0-9]{4,40}$/g.test(uname) === false)
		{	
			$('#inputUsername').next(".error").html("Tài khoản 4 đến 40 chữ cái, số");
			$('#inputUsername').next(".error").fadeIn();
			 $('.gly-user').fadeIn();
			error = true;
		}
		if(pass == "")
		{
			$('.gly-pass').fadeIn();
			error = true;
		}
		if(error === true)
		{
			return false;
		}else{
			var action = $(this).attr('id');
			if(action == 'login-ajax'){
				ajax(action, uname, pass);
			}else if(action == 'register-ajax')
			{
				ajax(action, uname, pass);
			}
			return false;
		}
	});

	function ajax(action,uname,pass){
		if(action == 'login-ajax'){
			var data = 'action='+action+'&uname='+uname+"&pass="+pass;
		}else if(action == 'register-ajax')
		{
			var data = 'action='+action+'&uname='+uname+"&pass="+pass;
		}
		$.ajax({
				url: "proccess/xuly-form-login.php",
				type: 'post',
				data: data,
				dataType: 'json',
				async: true,
				success:function(kq)
				{	
					if(action == 'login-ajax')
					{	
						if(kq.mess === true)
						{	
							window.location.reload();
						}else{

							$('#messages').html('Sai Username hoặc mật khẩu');
							$('#messages').fadeIn();
						}
					}else if(action == 'register-ajax'){
						if(kq.valid.success === true)
						{	
							$('#messages').removeClass('alert-danger');
							$('#messages').addClass('alert-success');
							$('#messages').html(kq.valid.messages);
							$('#messages').fadeIn();
							$('#inputUsername').val("");
							$('#inputPassword').val("");
						}else if(kq.valid.success === false){
							$('#messages').html(kq.valid.messages);
							$('#messages').fadeIn();
						}
					}
					
				}
		});
	}

	$('#inputUsername').keyup(function(){
		$(this).next(".error").fadeOut();
		$('.gly-user').fadeOut();	
		$('#messages').fadeOut();	
	});
	$('#inputPassword').keyup(function(){
		
		$('.gly-pass').fadeOut();
		$('#messages').fadeOut();
	});
	$('.close').click(function (){
		
		$('#inputUsername').val("");
		$('#inputPassword').val("");
		$('#inputUsername').next('.glyphicon').fadeOut();
		$('#inputPassword').next('.glyphicon').fadeOut();	
		$('#messages').fadeOut();
		
	});
});
