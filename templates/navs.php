
	<div class="container" id="nav-menu"> <!--container-fluid-->
		
		<nav class="nav" id="navs">
			<a href="trang-chu.html" class=" nav-link <?php echo isset($_GET['cid']) || isset($_GET['nid'])?"":"active";?>"><span class="glyphicon glyphicon-home" aria-hidden="true" style="font-size: 1.2em;padding-bottom: 0px"></span></a>
			<?php
				$sql = "SELECT * FROM category";
				$stmt = $conn->prepare($sql);
				$stmt->execute();
				$cates = $stmt->fetchAll(PDO::FETCH_OBJ);
				if($stmt->rowCount()==0)
				{
					echo "<p>Chưa có chuyên mục nào</p>";
				}
				else{
					foreach ($cates as $cate) {
					$cate_khongdau = strtolower(unicode_convert($cate->cate_name));

					//kiem tra xem co ton tai nid khong
					if(isset($_GET['nid']) && filter_var($_GET['nid'],FILTER_VALIDATE_INT) && $_GET['nid'] > 0){
						//tim cate co nid do
						$nid = $_GET['nid'];
						$sql = "SELECT c.cate_id FROM tintuc t INNER JOIN category c USING(cate_id) WHERE news_id = $nid";
						$stmt = $conn->prepare($sql);
						$stmt->execute();
						$catex = $stmt->fetch(PDO::FETCH_OBJ);
						$cate_idx = $catex->cate_id;
					}

					if((isset($_GET['cid']) && $_GET['cid'] == $cate->cate_id )|| (isset($cate_idx) && $cate_idx ==  $cate->cate_id)){
						$active = "active";
					}else{
						$active = ""; 
					}

					
					echo "<a class='nav-link ".$active."' href='danh-muc/".$cate->cate_id."/".$cate_khongdau.".html'>$cate->cate_name</a>";
					}
				}
			?>
		</nav>
	</div>