<?php 
/************************************************************************************************************************
 Developer: Muhammad Akram
 Company: Gaditek Solutions
 Last Updated: 07 April 2010

*************************************************************************************************************************/
class PAGING
{
	var $sql,$records,$pages;
	/*
	Variables that are passed via constructor parameters
	*/
	var $page_no,$total,$limit,$first,$previous,$next,$last,$start,$end;
	/*
	Variables that will be computed inside constructor
	*/
	function PAGING($sql,$records=15,$pages=9)
	{
		if($pages%2==0)
			$pages++;
		/*
		The pages should be odd not even
		*/
		$res=mysql_query($sql) or die($sql." - ".mysql_error());
		$total=mysql_num_rows($res);
		if($_GET["page_no"]==''){
			$page_no=1;
		}else{
			$page_no=isset($_GET["page_no"])?$_GET["page_no"]:1;
		}
		/*
		Checking the current page
		If there is no current page then the default is 1
		*/
		$limit=($page_no-1)*$records;
		$sql.=" limit $limit,$records";
		/*
		The starting limit of the query
		*/
		$first=1;
		$previous=$page_no>1?$page_no-1:1;
		$next=$page_no+1;
		$last=ceil($total/$records);
		if($next>$last)
			$next=$last;
		/*
		The first, previous, next and last page numbers have been calculated
		*/
		$start=$page_no;
		$end=$start+$pages-1;
		if($end>$last)
			$end=$last;
		/*
		The starting and ending page numbers for the paging
		*/
		if(($end-$start+1)<$pages)
		{
			$start-=$pages-($end-$start+1);
			if($start<1)
				$start=1;
		}
		if(($end-$start+1)==$pages)
		{
			$start=$page_no-floor($pages/2);
			$end=$page_no+floor($pages/2);
			while($start<$first)
			{
				$start++;
				$end++;
			}
			while($end>$last)
			{
				$start--;
				$end--;
			}
		}
		/*
		The above two IF statements are kinda optional
		These IF statements bring the current page in center
		*/
		$this->sql=$sql;
		$this->records=$records;
		$this->pages=$pages;
		$this->page_no=$page_no;
		$this->total=$total;
		$this->limit=$limit;
		$this->first=$first;
		$this->previous=$previous;
		$this->next=$next;
		$this->last=$last;
		$this->start=$start;
		$this->end=$end;
	}
	function show_paging($url,$params="")
	{
		$paging="";
		if($this->total>$this->records)
		{
			$page_no=$this->page_no;
			$first=$this->first;
			$previous=$this->previous;
			$next=$this->next;
			$last=$this->last;
			$start=$this->start;
			$end=$this->end;
			if($params=="")
				$params="?page_no=";
			else
				$params="?$params&page_no=";
			$paging.="<ul class='paging'>";
			$paging.="<li class='paging-current'>Page $page_no of $last</li>";
			if($page_no==$first)
				$paging.="<li class='paging-disabled'><a href='javascript:void(0)'>&lt;&lt;</a></li>";
			else
				$paging.="<li><a href='$url$params$first'>&lt;&lt;</a></li>";
			if($page_no==$previous)
				$paging.="<li class='paging-disabled'><a href='javascript:void(0)'>&lt;</a></li>";
			else
				$paging.="<li><a href='$url$params$previous'>&lt;</a></li>";
			for($p=$start;$p<=$end;$p++)
			{
				$paging.="<li";
				if($page_no==$p)
					$paging.=" class='paging-active'";
				$paging.="><a href='$url$params$p'>$p</a></li>";
			}
			if($page_no==$next)
				$paging.="<li class='paging-disabled'><a href='javascript:void(0)'>&gt;</a></li>";
			else
				$paging.="<li><a href='$url$params$next'>&gt;</a></li>";
			if($page_no==$last)
				$paging.="<li class='paging-disabled'><a href='javascript:void(0)'>&gt;&gt;</a></li>";
			else
				$paging.="<li><a href='$url$params$last'>&gt;&gt;</a></li>";
			$paging.="</ul>";
		}
		return $paging;
	}

	function showPageLocation()
	{
		$page_no=$this->page_no;
		$first=$this->first;
		$last=$this->last;
		$total=$this->total;
		
		$paging="";
		$paging.="$total Records Found - [ Page $page_no of $last ]";

		return $paging;
	}
	
	function showPaging($url,$params="",$div,$chked,$chk)
	{
			$paging="";
		if($this->total>$this->records)
		{
			$page_no=$this->page_no;
			$first=$this->first;
			$previous=$this->previous;
			$next=$this->next;
			$last=$this->last;
			$start=$this->start;
			$end=$this->end;
			if($params=="")
				$params="?page_no=";
			else
				$params="?$params&page_no=";

			if($page_no==$previous)
				$paging.="<tr><td colspan='9' class='inr-tabrow6'><a class='srch-tabnav1h' href='javascript:void(0);'>PREVIOUS PAGE</a>";
			else
				$paging.="<tr><td colspan='9' class='inr-tabrow6'><a class='srch-tabnav1' href='javascript:void(0);' onClick='javascript:getData(\"$url$params$previous\", \"\", \"$div\", \"$chked\", \"$chk\")'>PREVIOUS PAGE</a>";

			if($page_no==$next)
				$paging.="<a class='srch-tabnav2h' href='javascript:void(0);'>Next PAGE</a></td></tr>";
			else
				$paging.="<a class='srch-tabnav2' href='javascript:void(0);' onClick='javascript:getData(\"$url$params$next\", \"\", \"$div\", \"$chked\", \"$chk\")'>Next PAGE</a></td></tr>";
			
		}
		return $paging;
	}
	
	function getRecords(){
		return $this->total;
	}
	
	function showPages($url,$params="", $div,$chked,$chk)
	{
		$paging="";
		if($this->total>$this->records)
		{
			$page_no=$this->page_no;
			$first=$this->first;
			$previous=$this->previous;
			$next=$this->next;
			$last=$this->last;
			$start=$this->start;
			$end=$this->end;
			if($params=="")
				$params="?page_no=";
			else
				$params="?$params&page_no=";
				//<a class="srch-tabnav1h" href="#">PREVIOUS PAGE</a><a class="srch-tabnav2" href="#">NEXT PAGE</a>
			$paging.="<select name='page_no' class='search-reclist2' onchange='javascript:getData(\"$url$params\", this.value, \"$div\", \"$chked\", \"$chk\")'><option value='1' selected='selected'>Go Page</option>";
			//$paging.="<li class='paging-current'>Page $page_no of $last</li>";
				
			for($p=2;$p<=$last;$p++)
			{
				$paging.="<option";
				if($page_no==$p)
					$paging.=" selected='selected'";
				$paging.=" value='$p'>$p</li>";
			}

			$paging.="</select>";
		}
		return $paging;
	}	
}
?>