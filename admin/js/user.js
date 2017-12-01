$(document).ready(function(){

	$("#popup-background").hide();
	//bắt sự kiện khi lick vào 
	$(".edit-user").click(function(){
		//hiện thị popup
		user_id= $(this).attr("data-userid");
		//thêm userid= vào class submit-edit

		ajax("get-info",user_id);
		//ajax("get-level",user_id);
		 $("#popup-background").fadeIn();

	});
	
	$("#cancel-edit-user").click(function(){
		$("#popup-background").fadeOut("fast",function(){
			$("#txtuser_name").val("");
			$("#txtuser_name").next(".errors").fadeOut();
		});
	});
	//bat event khi nhan nut submit-edit
	$("#sb-edit").click(function(){
		var errors = false;
		u = $("#txtuser_name").val();
		if (u=="") {
			$("#txtuser_name").next(".errors").fadeIn();
			errors= true;
		}
		
		if(errors==true){
			return false;
		}else{
			ajax("edit-user",user_id);
			return false;
		}
	});
	//bắt sự kiện del-user
	$(".del-user").click(function(){
		//lấy user_id
		var varConfirm= confirm("Bạn có muốn xóa nó không?");
		if(varConfirm==true){
			id= $(this).attr("data-userid");
			ajax("del-user",id);
		}
		return false;
		
	});
	$("#txtuser_name").keyup(function(){
		$(this).next(".errors").fadeOut();
	})
	function ajax(action,id){
		if(action=="get-info"){
			data="action="+action+"&user_id="+id;
		}
		else if(action=="edit-user"){
			level= $("#chucvu").val();
			user_name = $("#txtuser_name").val();
			data="action="+action+"&user_id="+id+"&user_name="+user_name+"&level="+level;
		}
		else if(action=="del-user"){
		 	data="action="+action+"&user_id="+id;
		 }

		$.ajax({
			url:"js/xuly_user.php",
			type: "post",
			data: data,
			dataType: "json",
			async: true,
			success:function(kq){
				if(action=="get-info"){
					$("#txtuser_name").val(kq.user_name);

					$("#chucvu").html("<option value='1'>Người dùng</option><option value='2'>Mod</option><option value='4' >Admin</option>");

					//nếu thẻ option có value = kq.level thì thêm thuộc tính selected
					$("option[value='"+kq.level+"']").attr("selected","selected");
				}
				else if(action=="edit-user"){
						$("a[data-userid='"+kq.user_id+"']").closest("tr").find("td:eq(1)").html(kq.user_name);
						$("#popup-background").fadeOut();
				 	 	$("#txtuser_name").val("");
				 	 	switch (kq.level){
				 	 		case "1":
				 	 			$("a[data-userid='"+kq.user_id+"']").closest("tr").find("td:eq(3)").html("Người dùng");
				 	 		break;
				 	 		case "2":
				 	 			$("a[data-userid='"+kq.user_id+"']").closest("tr").find("td:eq(3)").html("Mod");
				 	 		break;
				 	 		case "4":
				 	 			$("a[data-userid='"+kq.user_id+"']").closest("tr").find("td:eq(3)").html("Admin");
				 	 		break;
				 	 		default:
				 	 			$("a[data-userid='"+kq.user_id+"']").closest("tr").find("td:eq(3)").html("Khách");
				 	 		break;
				 	 	}
				}
					else if(action=="del-user"){
						 $("a[data-userid='"+kq.user_id+"']").closest("tr").fadeOut("fast");
				 }
			
			}
		
		});
	}

});