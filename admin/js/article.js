$(document).ready(function(){
	$("#add-article").click(function(){
		//thêm class cho nut form
		$(".form h3").html("Thêm bài viết");
		$(".form").attr("id","addArticle");
		$("#submit-article").attr("value","Thêm");
		$("#operation").val("add");
		$("#hinhcu").hide();
		
		getData("getdata-add");		
		$("#popup-background").fadeIn();
	});
	//hiện popup khi click vào edit bài viết
	$("#table-article").delegate(".edit-article","click" ,function(){
		$(".form h3").html("Chỉnh sửa bài viết");
		$(".form").attr("id","editArticle");
		$("#submit-article").attr("value","Lưu lại");
		$("#operation").val("edit");
		//lấy data-newsid để chỉnh sửa
		news_id =$(this).attr("data-newsid");
		$("#news_id").val(news_id);
		getData("getdata-edit",news_id);
		$("#popup-background").fadeIn();

	});

	$("#table-article").delegate(".del-article","click" ,function(){

	 	//lấy id để delete
	 	if(confirm("Bạn có muốn xóa tin tức này không?")==true){
	 		id = $(this).attr("data-newsid");
	 		getData("deldata",id);
	 	}
	 	return false;
	 });
	

	//gọi sự kiên submit form #addArticle // bắt buộc sử dụng live = delegate để bắt sự kiên load form submit, vì id= #addArticle mới được thêm vào qua lick add-artilce
	//sau nhiều lần thất bại thì Delegate rất là khả qua :(()) phải dùng đẻ có thể lấy được $POST['content']
	 $("#form-upload").delegate('.form','submit',function(){
	// $('.form').on('submit',function(){ FAIL

		//kiểm tra đã nhập dữ liệu chưa
		var errors= false;
		n= $("#news_title").val();
		m= $("#mota").val();
		c= CKEDITOR.instances.content.getData();
		//c= $("content").val();
		if(n ==""){
			$("#news_title").next(".errors").fadeIn();
			errors=true;
		}
		if(m==""){
			$("#mota").next(".errors").fadeIn();
			errors=true;
		}
		 if(c==""){
		 	// CKEDITOR.instances.content.next(".errors").fadeIn(); //sai
		 	$("#errors-content").fadeIn();
			errors=true;
		}
		if(errors==true){
			return false;
		}else{
			///Formdata sẽ truyền các giá trị có thể lấy được từ form,vd: $_POST[txtname]
		var form= $(this);
		var data = new FormData($(this)[0]);
		 	$.ajax({
			url: form.attr(' '), 	// Url to which the request is send
			type: form.attr('method'),  // Type of request to be send, called as method
			data: data,					// Data sent to server, a set of key/value pairs
			dataType: 'json',			//type data response
			cache: false,				// To unable request pages to be cached
			contentType: false,			// The content type used when sending data to the server.
			processData: false,			// To send DOMDocument or non processed data file it is set to false
			async: false,
			success:function(kq){
				var action = $(".form").attr("id");
				//neu action = "addArticle"
				if(action=="addArticle"){	
					if(kq.valid.success == false){
						$("#messages").html(kq.valid.messages);
						$("#messages").attr("class","warning");
					} else{
					var stt = $("#table-article tr:last-child td:first-child").text();
						stt++;
					var htmlData = "<tr><td>"+stt+"</td><td>"+kq.news_title+"</td><td>"+kq.mota+"</td><td>"+kq.cate_name+"</td><td>"+kq.user_name+"</td><td>"+kq.date+"</td><td><a href='javascript:void(0)'  class='edit-article' data-newsid="+kq.news_id+"><span class='icon-edit' >Sửa</a></td><td><a href='javascript:void(0)' class='del-article' data-newsid="+kq.news_id+"><span class='icon-delete' >Xóa</a></td></tr>";

						 if(stt==0){
						 		$("#table-article").html(htmlData);
						 	}else{
						 		$("#table-article").append(htmlData);
						 }
						 //set cac gia trị ở text về null khi add thành công
					 	$("#news_title").val("");
					 	$("#mota").val("");
					 	CKEDITOR.instances.content.setData("");
					 	$("#popup-background").fadeOut();
					}
				}	
					else if(action=="editArticle"){
						if(kq.valid.success == false){
							$("#messages").html(kq.valid.messages);
							$("#messages").attr("class","warning");
						}else{
							 $("#popup-background").fadeOut("fast",function(){
							 	//chọn thẻ tr ngoài cùng của thẻ a có data-newsid = news_id find cột thứ 2
						 	 	$("a[data-newsid='"+kq.news_id+"']").closest("tr").find("td:eq(1)").html(kq.news_title);
						 	 	$("a[data-newsid='"+kq.news_id+"']").closest("tr").find("td:eq(2)").html(kq.mota);
						 	 	$("a[data-newsid='"+kq.news_id+"']").closest("tr").find("td:eq(3)").html(kq.cate_name);
						 	 	$("#news_title").val("");
							 	$("#mota").val("");
							 	CKEDITOR.instances.content.setData("");
						 	});
						}
				}
			}
		});
		 return false;
	}
});


	function getData(action,id){
		if(action=='getdata-add'){
			data = "action="+action;
		}else if(action=='getdata-edit'){
			data ="action="+action+"&news_id="+id;
		}
		else if(action=='deldata'){
			data = "action="+action+"&news_id="+id;
		}
		
		$.ajax({
			url : "js/xuly_data.php",
			type: "post",
			data: data,
			dataType: "json",
			async:true,
			success:function(kq){
				if(action=="getdata-add"){
					var content= ""; 
					//dung for de lap qua tung gia tri jsonarrya( [{"usernid":"12","username":trung},{"usernid":"12","username":trung}...])
					for (var i = 0; i < kq.length; i++) {
						 content += "<option value='"+kq[i].cate_id+"'>"+kq[i].cate_name+"</option>";   
					}
					$("#chuyenmuc").html(content);
					$("#old-image").hide();
					$("#hinhcu").hide();
				}else if(action=="getdata-edit"){
					//lấy giá trị
					var content = "";
					for(var i=0; i < kq.cates.length; i++){
						// var cate = kq.cates[i];
						content += "<option value='"+kq.cates[i].cate_id+"'>"+kq.cates[i].cate_name+"</option>";
					}
					$("#chuyenmuc").html(content);
					tmpcate_id = kq.news[0].cate_id;
					$("#chuyenmuc option[value='"+tmpcate_id+"']").attr("selected","selected");
					//news[0] để lấy phần tử trong dãy {"news":[{"news_id":"127","news_title":"u00ecnh"}{"news_id":"...nếu có. nhưng mảng này chỉ có 1 array đầu nằm trong news"}]}
					// var src= "../upload/"+;
					
					$("#hinhcu").show();
					$("#old-image").html("<img src='../upload/"+kq.news[0].hinhanh+"' width='120px' height='80px' style='border-radius:3px;' />");
					$("#old-image").show();
					$("#news_title").val(kq.news[0].news_title);
					$("#mota").val(kq.news[0].mota);
					CKEDITOR.instances.content.setData(kq.news[0].content);
				}
				else if(action=="deldata"){
					$("a[data-newsid='"+kq.news_id+"']").closest("tr").fadeOut();
				}
			}
		});
	}

	//viet ham xoa cache
	$("#close").click(function(){
		$("#news_title").val("");
		CKEDITOR.instances.content.setData("");
		$("#mota").val("");
	})

});