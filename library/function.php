<?php 
	function cutString($str,$lenght,$ext = "...")
	{
		if(mb_strlen($str,'UTF-8') > $lenght)
		{
			$str = substr($str , 0, $lenght);
			$index = strripos($str , " ");
			return substr($str, 0, $index)." ". $ext ;
		}else{
			return $str;
		}
	
	}
	function formatTimetoDay($time)
	{
		$timestamp = strtotime($time);
		return date("d-m-Y",$timestamp);
	}

	function formatTimetoHours($time)
	{
		$timestamp = strtotime($time);
		return date('H:i:s d-m-Y',$timestamp);
	}
	//lấy tiêu đè theo tên tin
	function tieude(){
		global $conn;

		if(isset($_GET['cid']))
		{
			$cid = $_GET['cid'];
			$sql = "SELECT cate_name FROM category WHERE cate_id = :cid ";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(":cid",$cid,PDO::PARAM_INT);
			$stmt->execute();
			if($stmt->rowCount()>0)
			{
				$cates = $stmt->fetch(PDO::FETCH_OBJ);
				$tieude = $cates->cate_name;
			}else{
				$tieude = "Trang tin tức giải trí";
			}
		}else if(isset($_GET['nid']))
		{
			$nid = $_GET['nid'];
			$sql = "SELECT news_title FROM tintuc WHERE news_id = :nid";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(":nid",$nid,PDO::PARAM_INT);
			$stmt->execute();
			if($stmt->rowCount()>0)
			{
				$news = $stmt->fetch(PDO::FETCH_OBJ);
				$tieude = $news->news_title;
			}else{
				$tieude = "Trang tin tức giải trí";
			}

		}
		else{
			$tieude = "Trang tin tức giải trí";
		}

		return $tieude;
	}
	//lấy 3 tin với cate_id
	function get3New($cate_id)
	{	
		global $conn;
		$sql= "SELECT t.news_id,t.cate_id,t.news_title,t.hinhanh,t.mota,t.post_on,u.user_name ";
		$sql .= " FROM tintuc t " ;
		$sql .= " INNER JOIN users u ";
		$sql .= " USING(user_id) ";
		$sql .= " WHERE cate_id = $cate_id ";
		$sql .= " ORDER BY (t.news_id) DESC ";
		$sql .= " LIMIT 3 ";

		return  $conn->prepare($sql);
	}

	//lay tin tuc theo tung cate 
	function getNewsonCateid($cate_id,$start,$displayItem)
	{
		global $conn;

		$sql= "SELECT t.news_id,t.cate_id,t.news_title,t.hinhanh,t.mota,t.post_on,u.user_name ";
		$sql .= " FROM tintuc t " ;
		$sql .= " INNER JOIN users u ";
		$sql .= " USING(user_id) ";
		$sql .= " WHERE cate_id = :cate_id ";
		$sql .= " ORDER BY news_id DESC ";
		$sql .= " LIMIT :start,:displayItem ";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(":cate_id",$cate_id,PDO::PARAM_INT);
		$stmt->bindParam(":start",$start,PDO::PARAM_INT);
		$stmt->bindParam(":displayItem",$displayItem,PDO::PARAM_INT);
		

		return $stmt;
	}
	function getReplyonComid($com_id)
	{
		global $conn;
		$sql = "SELECT r.rep_id,r.rep_mess,r.rep_date,u.user_name,u.user_id FROM reply r ";
		$sql .= "INNER JOIN users u ";
		$sql .= "USING(user_id) ";
		$sql .= "WHERE r.com_id = $com_id";
		$stmt = $conn->prepare($sql);

		return $stmt;
	}

	 // ham chuyen ki tu co dau sang khong dau dùng cho địa chỉ
  	function unicode_convert($str)
  	{
        if(!$str) return false;

        $unicode = array(

            'a'=>array('á','à','ả','ã','ạ','ă','ắ','ặ','ằ','ẳ','ẵ','â','ấ','ầ','ẩ','ẫ','ậ'),

                'A'=>array('Á','À','Ả','Ã','Ạ','Ă','Ắ','Ặ','Ằ','Ẳ','Ẵ','Â','Ấ','Ầ','Ẩ','Ẫ','Ậ'),

                'd'=>array('đ'),

                'D'=>array('Đ'),

                'e'=>array('é','è','ẻ','ẽ','ẹ','ê','ế','ề','ể','ễ','ệ'),

                'E'=>array('É','È','Ẻ','Ẽ','Ẹ','Ê','Ế','Ề','Ể','Ễ','Ệ'),

                'i'=>array('í','ì','ỉ','ĩ','ị'),

                'I'=>array('Í','Ì','Ỉ','Ĩ','Ị'),

                'o'=>array('ó','ò','ỏ','õ','ọ','ô','ố','ồ','ổ','ỗ','ộ','ơ','ớ','ờ','ở','ỡ','ợ'),

                '0'=>array('Ó','Ò','Ỏ','Õ','Ọ','Ô','Ố','Ồ','Ổ','Ỗ','Ộ','Ơ','Ớ','Ờ','Ở','Ỡ','Ợ'),

                'u'=>array('ú','ù','ủ','ũ','ụ','ư','ứ','ừ','ử','ữ','ự'),

                'U'=>array('Ú','Ù','Ủ','Ũ','Ụ','Ư','Ứ','Ừ','Ử','Ữ','Ự'),

                'y'=>array('ý','ỳ','ỷ','ỹ','ỵ'),

                'Y'=>array('Ý','Ỳ','Ỷ','Ỹ','Ỵ'),

                 '-'=>array(' ','&quot;','.','?',':','!'),

                ''=>array('(',')',',',"'",'"')

            );

            foreach($unicode as $nonUnicode=>$uni){

              foreach($uni as $value)
                //str_replace thay thế một chuỗi trong cụm chuỗi mà ta chọn
                //str_replace ( mixed $search , mixed $replace , mixed $subject [, int &$count ] )
                  // search chuỗi cần thay thế.
                  // replace chuỗi thay thế.
                  // subject đối tượng thay thế.
                  // count Nếu chỉ định, biến này sẽ được lấp đầy với số lượng thay thế thực hiện.

              $str = str_replace($value,$nonUnicode,$str);

            }

      return $str;

  	}
  	// ham chuyen ki  tu có dấu sang không dấu cho REGEX
     function unicode_convert_for_regex($str)

    {
        if(!$str) return false;

        $unicode = array(

            'a'=>array('á','à','ả','ã','ạ','ă','ắ','ặ','ằ','ẳ','ẵ','â','ấ','ầ','ẩ','ẫ','ậ'),

                'A'=>array('Á','À','Ả','Ã','Ạ','Ă','Ắ','Ặ','Ằ','Ẳ','Ẵ','Â','Ấ','Ầ','Ẩ','Ẫ','Ậ'),

                'd'=>array('đ'),

                'D'=>array('Đ'),

                'e'=>array('é','è','ẻ','ẽ','ẹ','ê','ế','ề','ể','ễ','ệ'),

                'E'=>array('É','È','Ẻ','Ẽ','Ẹ','Ê','Ế','Ề','Ể','Ễ','Ệ'),

                'i'=>array('í','ì','ỉ','ĩ','ị'),

                'I'=>array('Í','Ì','Ỉ','Ĩ','Ị'),

                'o'=>array('ó','ò','ỏ','õ','ọ','ô','ố','ồ','ổ','ỗ','ộ','ơ','ớ','ờ','ở','ỡ','ợ'),

                '0'=>array('Ó','Ò','Ỏ','Õ','Ọ','Ô','Ố','Ồ','Ổ','Ỗ','Ộ','Ơ','Ớ','Ờ','Ở','Ỡ','Ợ'),

                'u'=>array('ú','ù','ủ','ũ','ụ','ư','ứ','ừ','ử','ữ','ự'),

                'U'=>array('Ú','Ù','Ủ','Ũ','Ụ','Ư','Ứ','Ừ','Ử','Ữ','Ự'),

                'y'=>array('ý','ỳ','ỷ','ỹ','ỵ'),

                'Y'=>array('Ý','Ỳ','Ỷ','Ỹ','Ỵ'),
            );

            foreach($unicode as $nonUnicode=>$uni){

              foreach($uni as $value)
                
              $str = str_replace($value,$nonUnicode,$str);

            }
      return $str;
    }

    

?>