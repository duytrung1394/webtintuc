$(document).ready(function(){
	
	function move_center(div){
	//căn giữa chiều rộng
	window_width=$(window).width();
	obj_width=$(div).width();
	$(div).css('left',(window_width / 2) - (obj_width/2));
	//căn giữa chiều cao
	// window_height=$(window).height();
	// obj_height=$(div).height();
	// $(div).css('left',(window_height/2)-(obj_height/2));
	}
	move_center('#popup-center');
	move_center('#popup-center-x');
})