	

<?php 
//Ham phan trang
function phantrang($pageShow,$displayItem,$totalPage,$start)
{
	if($totalPage > 1){
		//==========lấy đường dẫn hiên tại//// không thể dùng cho nhiều ?cid=11?page=13

		//$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]";

		//-------Tìm actual link bị hạn chế nếu 100 page rở lên---------

		// $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		// 	if(isset($_GET['page'])){
		// 		if((int)($_GET['page'])>=10){
		// 			$actual_link = substr($actual_link,0,-8);
		// 		}
		// 		else{
		// 			$actual_link = substr($actual_link,0,-7);
		// 	}
		// } 
		
		//=================ACTUAL_LINK cải tiến=========================
		$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			if(isset($_GET['page'])){
				$i=strlen($_GET['page'])-1;//strlen đếm độ dài chuỗi
				if(($_GET['page'])>=(10**$i)){
						$actual_link = substr($actual_link,0,(-7-$i));	
				}
		}

		$currentPage= $start/$displayItem + 1;

			//page đầu, page trước
				$first="";
				$prew="";
				if($currentPage>1){
					$first= "<a href='$actual_link?page=1'>First</a>";
					$prew= "<a href='$actual_link?page=".($currentPage-1)."'><</a>";
				}
			//page tiếp theo, page cuối
				$next="";
				$last="";
				if($currentPage<$totalPage){
					$last= "<a href='$actual_link?page=$totalPage'>Last</a>";
					$next= "<a href='$actual_link?page=".($currentPage+1)."'>></a>";
				}	
					//nếu tổng số page> số page hiện thị
					if($totalPage>$pageShow){
						//page đầu tiên, và page cuối  hiên thị,
						if($currentPage==1){
							$startPage=1;
							$endPage=$pageShow;
						}else if($currentPage==$totalPage){
								$endPage=$totalPage;
								$startPage=$totalPage - $pageShow + 1;
						}else{
							$startPage  = $currentPage - ($pageShow-1)/2;
							$endPage = $currentPage + ($pageShow-1)/2;
							//nếu start page<1 thì startpage=1, end= endpage +1
							if($startPage<1){
								$startPage=1;
								$endPage=$endPage+1;
							}
							//nếu endPage>totalPage thì startpage=start-1; $endpage=totalpage;
							if($endPage>$totalPage){
								$startPage=$startPage-1;
								$endPage=$totalPage;
							}
						}
					}// end if(tông page> page show)
					else{
						$startPage = 1 ;
						$endPage= $totalPage;
					}
					// ListPage
					$listPage="";
					//nếu page là hiên tại thì thêm class active
					for($i=$startPage;$i<=$endPage;$i++){
						if($i==$currentPage){
							$listPage.="<a href='$actual_link?page=$i' class='active'>$i</a>";
						}else{
							$listPage.="<a href='$actual_link?page=$i'>$i</a>";
						}
					}
					//hiện thị
		echo "<div class='center'>";
		echo "<div class='pagination'>".$first.$prew.$listPage.$next.$last."</div>";
		echo "</div>";
 	}
}
?>