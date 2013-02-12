<?php  
//$path = $path = $_GET['path'];
$path = "../../"; $pth=$path;
require_once("../../system/include/config.php");
require_once(INC."paging.php");
require_once(INC."functions.php");
require_once(INC."mail.php");

mysql_query("SET NAMES 'utf8'");
$path = $_GET['path'];
$list = $_GET['list'];
$parm = $_GET['parm'];
$sort = $_GET['sort'];
$page_no = $_GET['page_no'];

/*echo $list = $_GET['list'];
echo $parm = $_GET['parm'];
echo $sort = $_GET['sort'];
echo $page_no = $_GET['page_no'];*/


if(isset($_GET['limit'])){ $limit = $_GET['limit'];}else $limit=5;
if(isset($_GET['checked'])){ $checked = explode(",", $_GET['checked']);}
if(isset($_GET['check'])){ 
	$check = explode(",",$_GET['check']);
	$act = $_GET['act'];
	
	foreach($check as $id){
		if($act == "seract_1"){
			$q = getActionQuery($act,$id);
		}else{ 
			$q = getActionQuery($act,$id);
			mysql_query($q);
		}
	}
}

$arr = getFields($list);
$sortMenu = array();

foreach($arr as $k=>$v){
	if($v != ""){
		$sortMenu[$k] = $v;
		$str .= $v.", ";
	}else{
		if($list == "invoices")$str .= "i.date, ";
	}
}

$str = substr($str, 0, strlen($str)-2);

if($parm == "" && $list=="invoices" || $parm == "search here.." && $list=="invoices")
{	
	$q = "SELECT $str , i.symbol FROM invoice i INNER JOIN users u USING(id_users) LIMIT 5";
	$rec_chk = "1";
}
else
{
	if($sort == "0"){   $sort = $arr['ID'];   }
	$q = "SELECT $str ".getQuery($list, $parm)." order by ".$sort;
	
	$PAGING=new PAGING($q, $limit);
	$q=$PAGING->sql;
	$records = $PAGING->getRecords();
}
?>
<div class="searchbg1"><div class="searchbg2"><div class="searchcontbox">
<div class="search-titbox"><h1>Search Result</h1><a  href="javascript:fadeslide.toggle('searchbox')">Close</a></div>
<div class="search-recbox"><div>
<?php  if($parm == "" || $parm == "search here.."){
	echo "5 Records Found - [ Page 1 of 1 ]";
}else{
	echo $PAGING->showPageLocation();
}

$limitList = getPageLimitList();?> </div>

<div class="search-reclistbox">
<select class="search-reclist1" name="select2" onchange="javascript:getData('<?=$path;?>search.php?list=', '<?=$list?>&parm=<?=$parm?>&sort=<?=$sort?>&limit='+this.value+'&page_no=<?=$page_no?>&path=<?=$path;?>', 'searchbox', 'checked','check');">

<?php  foreach($limitList as $k=>$v){
	if($limit == $k){
		echo "<option selected='selected' value='$k'>$v</option>";
	}else{
		echo "<option value='$k'>$v</option>";
	}
}?>
</select>
<select class="search-reclist1" onchange="javascript:getData('<?=$path;?>search.php?list=', '<?=$list?>&parm=<?=$parm?>&sort='+this.value+'&limit=<?=$limit?>&page_no=<?=$page_no?>&path=<?=$path;?>', 'searchbox', 'checked', 'check');">
<option value="0" selected="selected">Sort By</option>
<?php 
foreach($sortMenu as $k=>$v){
	if($sort == $v){
		echo "<option value='$v' selected='selected'>$k</option>";
	}else{
		echo "<option value='$v'>$k</option>";
	}
}
?>
</select>

<?php if($parm != "" && $parm != "search here.."){ echo $PAGING->showPages($path.'search.php', 'parm='.$parm."&list=".$list."&sort=".$sort."&limit=".$limit."&path=".$path, "searchbox","checked", "check"); }?>
</div></div>

<div class="search-resulbox">
<table class="srch-tab" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="srch-tabrow1"><input class="srch-tabchk" type="checkbox" name="checkbox" onclick="javascript:getCheckedAll(this.checked,'check','checked');" /></td>
<?php 
$i=0;
foreach($arr as $k=>$v){
	$i++;	
	if($sort == $v){
		echo "<td class='srch-tabrow1'><a class='sort' href='javascript:void(0);' onclick='javascript:getData(\"".$path."search.php?list=\", \"$list&parm=$parm&sort=$v&limit=$limit&page_no=$page_no&path=$path\", \"searchbox\", \"checked\",\"check\");'>$k</a></td>";
	}else if($sort == '0' && $i==1){
		echo "<td class='srch-tabrow1'><a class='sort' href='javascript:void(0);' onclick='javascript:getData(\"".$path."search.php?list=\", \"$list&parm=$parm&sort=$v&limit=$limit&page_no=$page_no&path=$path\", \"searchbox\", \"checked\",\"check\");'>$k</a></td>";
	}else if($v==""){
		echo "<td class='srch-tabrow1'>$k</td>";
	}else{
		echo "<td class='srch-tabrow1'><a href='javascript:void(0);' onclick='javascript:getData(\"".$path."search.php?list=\", \"$list&parm=$parm&sort=$v&limit=$limit&page_no=$page_no&path=$path\", \"searchbox\", \"checked\",\"check\");'>$k</a></td>";
	}
}
?>
</tr>
<?php 

$sql = mysql_query($q);

//if($checked!="") foreach($checked as $k=>$v){ echo $v."==";}
if($records>0 || $rec_chk==1){
 $fields = mysql_num_fields($sql);
$count2=0;
while($row = mysql_fetch_array($sql)){ $count2++;
	if(strstr($_SERVER['HTTP_REFERER'],"admin/home.php")){ $pth="";}
  	if($list == "invoices")
	{
		$row[3] = getDueDate($row[3]);
		$row[4] = getGateway($row[4]);
		if($row['5']>0){ $row[5]="<a class='inr-tablnk1' href='".$pth."modules/account/invi_detail.php?id=".base64_encode($row[5])."'>".$row['5']."</a>";}else{ $row[5]="<b>New</b>";}
		
		$row[6] = $row[8].$row[6];
		$row[7] = getStatus($row[7]);
		$fields = 8;
	}
	else if($list == "customers")
	{
		//Fetching User Services
		$ser_act = getServices($row[0],"service_status='1' AND","0");
		$ser_pen = getServices($row[0],"service_status='0' AND","0");
		$ser_viw = getServices($row[0],"","1");
		$ser_exp = getServices($row[0],"service_status='E' AND","0");
		$row[1] = '<b>'.$row[1].'</b>';
		$row[4] = '( <b class="srch-hltxt3">'.$ser_act.'</b> / <b class="srch-hltxt2">'.$ser_pen.'</b> / <b class="srch-hltxt1">'.$ser_viw.'</b> / <b class="srch-hltxt4">'.$ser_exp.'</b> )';
		$row[5] = '<a class="inr-tablnk2" href="'.$pth.'modules/client/personal_det.php?id='.base64_encode($row[0]).'">Personal</a> | <a class="inr-tablnk1" href="'.$pth.'modules/service/service_client.php?id='.base64_encode($row[0]).'">Service</a> | <a class="inr-tablnk4" href="'.$pth.'modules/client/fund_hist_all.php?id='.base64_encode($row[0]).'">Fund History</a>';
		$fields = 6;
	}
	else if($list == "tickets")
	{
		$row[1] = '<a class="inr-tablnk1" href="'.$pth.'modules/support/tick_detail.php?id='.base64_encode($row[0]).'">'.$row[1].'</a>';
		$row[2] = date('d, M, Y | h:i a', strtotime($row[2]));
		$row[5] = getStatus($row['ticket_status_id']);
		$row[6] = getUrgency($row[6]);
		$fields = 7;
	}
	else if($list == "services")
	{
		//Fetching Remaining Fund of Current Service
		$ser_fund = getTotalSum2('pre_paid_funds', 'amount', "status='1' AND id_users=".$row['id_users']." AND service_id=".$row[0]."");
		
		//Fetching Management Per Hour Cost
		$cloud_cost = getFieldsData('config_management_cost', 'price', "id='".$row['id_cloud']."' AND currency='".$row[5]."'");

		$row[1] = '<a class="inr-tablnk1" href="'.$pth.'modules/service/service_det.php?id='.base64_encode($row[0]).'">'.$row[1].'</a>';
		if($row[4] == "1"){ $row[2]=date('d, M, Y | h:i a', strtotime($row[2])); }else{  $row[2]='--------'; }
		$row[4] = getStatus("seract_".$row[4]);
		$row[5] = $row['symbol'].' '.number_format($ser_fund,2);
		$row[6] = GetRoundData($ser_fund, $cloud_cost['price']).' Hour';
		$row[7] = '<a class="inr-tablnk1" href="'.$pth.'modules/service/service_logs.php?id='.base64_encode($row[0]).'">Notification Details</a> | <a class="inr-tablnk2" href="'.$pth.'modules/client/fund_hist_ser.php?id='.base64_encode($row[0]).'">Fund History</a>';
		$fields = 8;
	}
	if($checked!=""){ if(in_array($row[0], $checked)){ $chk = "checked='checked'"; $class="srch-tabrowbg2"; }else{ $class="srch-tabrowbg1"; $chk = "";}}
   
	echo '<tr id="row_'.$row[0].'" class="'.$class.'"><td class="srch-tabrow2"><input class="srch-tabchk" type="checkbox" name="check" '.$chk.' value="'.$row[0].'" onClick="javascript:getChecked(\''.$row[0].'\',this.checked,\'checked\');" /></td>';
	
	for($i=0; $i<$fields; $i++){ if($i==($fields-1)){ $class="srch-tabrow4"; }else{ $class="srch-tabrow3";}?>
		<td class="<?=$class;?>">&nbsp;<?=$row[$i];?></td>
<?php }
	echo '</tr>';
} 
	}else echo '<tr><td colspan="22" class="inr-tabrow10">No Record found</td></tr>';?>
<tr>
<td colspan="12" class="srch-tabrow5">
<b>With Selected:</b> 
<?php 
$links = getActionLinks($list);
$count = count($links);
$i=0;

foreach($links as $act=>$link){ $i++;
	if($i<$count){?>
		[ <a class="srch-tablnk<?=$i?>" href="javascript:void(0);" onclick="javascript:getData('<?=$path;?>search.php?act=<?=$act?>&list=', '<?=$list?>&parm=<?=$parm?>&sort=<?=$sort?>&limit=<?=$limit?>&page_no=<?=$page_no?>&path=<?=$path?>', 'searchbox', 'check', 'checked');"><?=$link?></a> ] -			
	<?php }else{?>
		[ <a class="srch-tablnk<?=$i?>" href="javascript:void(0);" onclick="javascript:getData('<?=$path;?>search.php?act=<?=$act?>&list=', '<?=$list?>&parm=<?=$parm?>&sort=<?=$sort?>&limit=<?=$limit?>&page_no=<?=$page_no?>&path=<?=$path?>', 'searchbox', 'check', 'checked');"><?=$link?></a> ]
<?php  }
}?>
</td>
</tr>
<?php if($records > $limit){?>
<?php echo $PAGING->showPaging($path.'search.php', 'parm='.$parm."&list=".$list."&sort=".$sort."&limit=".$limit."&path=".$path, "searchbox", "checked", "check");?>
<?php }?>
</table>
</div><br clear="all" /></div></div></div>