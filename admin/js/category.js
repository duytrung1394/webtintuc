$(document).ready(function(){
	//ẩn div popup-background
	$("#popup-background").hide();
	//bắt sự kiện click để hiện popup
	$("#add-category").click(function(){
		$("#popup-background h3").html("Thêm chuyên mục");
		// $(".submit").attr("id","add-ajax"); //nếu nhấp vào Thêm thì thêm id= add-ạjax cho nút submit
		// $(".submit").attr("value","Thêm");
		//cách viết gọn
		$(".submit").attr({
			id:"add-ajax",
			value : "Thêm"
		})
		$("#popup-background").fadeIn();
	});

	$("#close, #cancel-add-cate").click(function(){
		$("#popup-background").fadeOut("fast",function(){
			$("#cate_name").val("");
			$("#cate_name").next(".errors").fadeOut();

		});
	});
	//dùng hàm delegate để bắt sự kiện click class edit trong một khung thẻ nào đó cặp thẻ có id=#table
	//duyệt qua mọi thẻ khi ta click vào ở trong cặp table để tìm ra class .edit-ajax
	$("#table").delegate(".edit-ajax","click",function(){

		$("#popup-background h3").html("Chỉnh sửa chuyên mục");
		// $(".submit").attr("id","edit-ajax"); //nếu nhấp vào chỉnh sử thì thêm id= edit-ạjax cho nút submit
		// $(".submit").attr("value","Chỉnh sửa");
		cate_id = $(this).attr("data-cateid");
		$(".submit").attr({
			id:"edit-ajax",
			value : "Chỉnh sửa",
			//data-cateid: cate_id
		});
		//lấy cate_id qua thuộc tính edit-ajax
		ajax("get-name",cate_id);
		$("#popup-background").fadeIn();
	});
	

	// vì id == add-ajax mới được thêm vào ở phía trên, nên sự kiên click k hoạt đông $("#add-ajax").click(function() 

	$(".submit").click(function(){
		//lấy giá trị ở cacsc thẻ
		c = $("#cate_name").val();
		//kiểm tra xem đã nhập dữ liệu chưa
		var errors= false;
		//validate
		if(c==""){
			$("#cate_name").next(".errors").html("Bạn chưa nhập tên danh mục");
			$("#cate_name").next(".errors").fadeIn();
			errors= true;
		}
		if(errors==true){
			//dừng xử lý
			return false;
		}else{

			//truyền dư liệu qua ajax để xử lí
			action=$(this).attr("id"); // lấy id của thẻ submit. id này mới được thêm ở khi click vào thẻ a class.edit-ajax
			//nếu action == add-ajax thì cho thi thực hiên chay hàm ajax action thêm chuyên mục
			// id=$(this).attr("data-cateid");// lấy giá trị id cảu data-cateid
			if(action=="add-ajax"){
				ajax("add-ajax");
			}// ngược lại edit-ajax...........
			else if(action=="edit-ajax"){
				ajax("edit-ajax",cate_id);//cate_id là giá trị lấy được ở trên khi lick edit-ajax
			}
			return false;
		}
	});
	
	$("#cate_name").keyup(function(){
		$(this).next(".errors").fadeOut();
	});


	$("#table").delegate(".del-ajax","click",function(){
	
		var varConfirm= confirm("Bạn có muốn xóa nó không?");
		if(varConfirm==true){
		id= $(this).attr("data-cateid");
		ajax("del-ajax",id);
		}
		return false;

	});
	//viết hàm ajax để rút gọn các file xử lí
	function ajax(action,id){
		if(action=="add-ajax"){
			//nếu action == adđ-ajax thì lấy giá trị của cate nam cho vào data
			cate_name = $("#cate_name").val();
			data="action="+action+"&cate_name="+cate_name;
		}else if(action=="del-ajax"){
			//nếu action -- del-ajax thì lấy giá trị cate_id cho vào data để truyền sang file xử lí
			data="action="+action+"&cate_id="+id;
		}else if(action=="get-name"){
			data="action="+action+"&cate_id="+id;
		}
		else if(action=="edit-ajax"){
			cate_name= $("#cate_name").val();
			data="action="+action+"&cate_name="+cate_name+"&cate_id="+id;
		}
			$.ajax({
			url: "js/xuly_category.php",
			type: "post",
			data: data,
			dataType: "json", //truyền dữ liệu bằng json: làm dữ liệu trả về kq tách riêng ra (3 xã hôi)
			async: true,
			success:function(kq){
				if(action=="add-ajax"){
					//nếu action là add-ajax thì hiện thị cate mới vào dòng cuối
					stt= $("#content-x table tr:last td:first").text();
					stt++;
					$("#content-x table").append(
					
					"<tr><td>"+stt+"</td><td>"+kq.cate_name+"</td><td><a href='javascript:void(0)'  class='edit-ajax' data-cateid="+kq.cate_id+"><span class='icon-edit' >Sửa</a></td><td><a href='javascript:void(0)' class='del-ajax' data-cateid="+kq.cate_id+"><span class='icon-delete' >Xóa</a></td></tr>"
					);	
					$("#cate_name").val("");
					$("#popup-background").fadeOut();
				}else if(action=="del-ajax"){
					//nếu action== del- thì ẩn dòng bị xóa đi
					$("a[data-cateid='"+kq.cate_id+"']").closest("tr").fadeOut("fast");
				}else if(action=="get-name"){
					 $("#cate_name").val(kq.cate_name);
				 }else if(action=="edit-ajax"){
				 	// $("#cate_name_x"+id).html(kq);//bên xuly echo cate_name// cách này chỉ đúng với trường hợp 1 cột dữ liệu được thay đổi
				 	//cách viết khác//nếu có nhiều cột thay đổi cũng có thể dễ dàng chỉnh sửa
				 	 $("#popup-background").fadeOut("fast",function(){
				 	 	$("a[data-cateid='"+kq.cate_id+"']").closest("tr").find("td:eq(1)").html(kq.cate_name);
				 	 	$("#cate_name").val("");
				 	});
				 	//kq.cate_id ==>cach viêt lấy cate_id qua json
				 	
				 }
			}
		});
		}
});