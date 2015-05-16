<?php if(!defined("DIR")){ exit(); }
class pager extends connection{

	function __construct(){
		
	}
	
	public function action($c,$sql,$exe_array,$path,$itemsPerPage){
		$out = array();
		$conn = $this->conn($c);
		try{
			$query = $conn->prepare($sql);
			$query->execute($exe_array);
			$nr = count($query->fetchAll());
		}catch(Exception $e){
			$nr = 0;
		}
		if($nr)
		{
			// get current page
			if(isset($_GET['pn'])){	
				$pn = preg_replace('#[^0-9]#i','',$_GET['pn']);
			}
			else{
				$pn = 1;
			}
			// last page
			$lastPage = ceil($nr / $itemsPerPage);
			if($pn < 1){
				$pn = 1;
			}
			else if($pn > $lastPage){
				$pn = $lastPage;	
			}	
			// generate other pages
			$centerPages = '';
			$sub1 = $pn-1; // 0
			$sub2 = $pn-2; // -1
			$add1 = $pn+1; // 2
			$add2 = $pn+2; // 3	
			// some logic to show pager
			if($pn==1){
				$centerPages .= '<span class="page active">'.$pn.'</span>';
				$centerPages .= '<a href="'.$path.$add1.'" class="page gradient">'.$add1.'</a>';
			}
			else if($pn == $lastPage){
				$centerPages .= '<a href="'.$path.$sub1.'" class="page gradient">'.$sub1.'</a>';
				$centerPages .= '<span class="page active">'.$pn.'</span>';
			}
			else if($pn > 2 && $pn < ($lastPage-1)){
				$centerPages .= '<a href="'.$path.$sub2.'" class="page gradient">'.$sub2.'</a>';
				$centerPages .= '<a href="'.$path.$sub1.'" class="page gradient">'.$sub1.'</a>';
				$centerPages .= '<span class="page active">'.$pn.'</span>';
				$centerPages .= '<a href="'.$path.$add1.'" class="page gradient">'.$add1.'</a>';
				$centerPages .= '<a href="'.$path.$add2.'" class="page gradient">'.$add2.'</a>';
			}
			else if($pn > 1 && $pn < $lastPage){
				$centerPages .= '<a href="'.$path.$sub1.'" class="page gradient">'.$sub1.'</a>';
				$centerPages .= '<span class="page active">'.$pn.'</span>';
				$centerPages .= '<a href="'.$path.$add1.'" class="page gradient">'.$add1.'</a>';
			}
			$limit = 'LIMIT '.($pn-1)*$itemsPerPage.','.$itemsPerPage;
			if($nr > 0)
			{
				$out[0] = $sql." $limit";
			}
			$paginationDisplay = '<div class="pagination">';
			if($lastPage != 1){
				$paginationDisplay1 = '<a href="javascript:;" class="page gradient">Page: <strong>'.$pn.'</strong> All: '.$lastPage.' </a>';
			}
			if($pn != 1){
				$previous = $pn-1;
				$paginationDisplay .= '<a href="'.$path.'1" class="page gradient">'.htmlentities("<<").'</a>';
				$paginationDisplay .= '<a href="'.$path.$previous.'" class="page gradient">'.htmlentities("<").'</a>';
			}
			$paginationDisplay .= $centerPages;
			if($pn != $lastPage){
				$nextPage = $pn+1;
				$paginationDisplay .= '<a href="'.$path.$nextPage.'" class="page gradient">'.htmlentities(">").'</a>';
				$paginationDisplay .= '<a href="'.$path.$lastPage.'" class="page gradient">'.htmlentities(">>").'</a>';
			}
			$outputList = $paginationDisplay."</div>";
			if($nr <= $itemsPerPage)
			{
				$outputList = "";
			}
			$n=1;
			$out[1]=$outputList;
			$out[2]=$nr;
		}
		return $out;
	}

	function __destruct(){
		
	}
}

?>