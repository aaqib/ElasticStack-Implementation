<?php 
$path = "../../../";
require_once("../../../system/include/config.php");
require_once(INC."paging.php");
require_once(INC."com_cms_funcs.php");
require_once(INC."eh_funcs.php");

$path = $_GET['path'];
$sort = $_GET['sort'];
$page_no = $_GET['page_no'];
$limit = $_GET['limit'];
$page = $_GET['page'];
$order = $_GET['order'];

if(isset($_GET['checked_inner'])){ $checked = explode(",", $_GET['checked_inner']);}
if(isset($_GET['check_inner'])){ 
	$check = explode(",", $_GET['check_inner']);

	$act = $_GET['act'];

	if(isset($act)){
		foreach($check as $id){
			$q = getActionQuery($act,$id);
			//if($act != "seract_1") mysql_query($q);
		}
	}
}

$arr = getFields('eh_vlan');

/*foreach($arr as $k=>$v){
	if($v != ""){
		$sortMenu[$k] = $v;
		$str .= $v.", ";
	}
}
$str	= substr($str, 0, strlen($str)-2);
$sort	= 'id_region';*/

$resources	= eh_list_all_resources('vlan');
?>

<div class="inr-recbox">
<div class="inr-reclistbox">
</div></div>

<div class="inr-resulbox">
<table class="inr-tab" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="inr-tabrow1"><input class="inr-tabchk" type="checkbox" name="checkbox" onclick="javascript:getCheckedAll(this.checked,'check_inner','checked_inner');" value="" /></td>

<?php 
$i=0;
foreach($arr as $k=>$v){
	$i++;	
	if($order=="asc"){ $class="sort"; $order1="DESC";}else{ $class="sort1"; $order1="ASC";}
	if($sort == $v){
		echo "<td class='inr-tabrow1'><a class='$class' href='javascript:void(0);' onclick='javascript:getData(\"$path\", \"?sort=$v&limit=$limit&page_no=$page_no&path=$path&page=$page&order=$order1\", \"results\", \"checked_inner\",\"check_inner\");'>$k</a></td>";
	}else if($sort == '0' && $i==1){
		echo "<td class='inr-tabrow1'><a class='$class' href='javascript:getData(\"$path\", \"?sort=$v&limit=$limit&page_no=$page_no&path=$path&page=$page&order=$order1\", \"results\", \"checked_inner\",\"check_inner\");'>$k</a></td>";
	}else if($v==""){
		echo "<td class='inr-tabrow1'>$k</td>";
	}else{
		echo "<td class='inr-tabrow1'><a href='javascript:void(0);' onclick='javascript:getData(\"$path\", \"?sort=$v&limit=$limit&page_no=$page_no&path=$path&page=$page&order=$order\", \"results\", \"checked_inner\",\"check_inner\");'>$k</a></td>";
	}
}
?>
</tr>
<?php  
if(!$resources)
{
	echo '<tr><td colspan="22" class="inr-tabrow10">No Record found</td></tr>';
} 
else 
{
foreach($resources as $resource)
{
	$row[0]	= $resource;
	$result	= eh_get_resource_info('vlan', $resource);

	if($checked!=""){ if(in_array($row[0], $checked)){ $chk = "checked='checked'"; $class="srch-tabrowbg2"; }else{ $class="inr-tabrowbg1"; $chk = "";}}
?>
	<tr class="<?=$class?>" id="inner_<?=$row[0];?>">
	<td class="inr-tabrow2"><input class="inr-tabchk" type="checkbox" name="check_inner" <?=$chk?> onclick="javascript:getChecked('<?=$row[0];?>',this.checked,'checked_inner');" value="<?=$row[0];?>" /></td>
	<td class="inr-tabrow3"><?=$result['name'];?></td>
	<td class="inr-tabrow3"><?=$result['resource'];?></td>
	<td class="inr-tabrow4"><a class="inr-tablnk1" href="eh_vlan_add_edit.php?id=<?=$row[0]?>">Edit Details</a></td>
	</tr>
<?php 
}
?>
<tr>
<td colspan="9" class="inr-tabrow5"><b>With Selected:</b> 
<?php 
$links = getActionLinks('eh_vlan');
$count = count($links);
$i=0;

foreach($links as $act=>$link){ $i++;
	if($i<$count){?>
		[ <a class="srch-tablnk<?=$i?>" href="javascript:void(0);" onclick="javascript:getData('<?=$path;?>?act=<?=$act?>', '&sort=<?=$sort?>&limit=<?=$limit?>&page_no=<?=$page_no?>&path=<?=$path?>&page=<?=$page?>&order=<?=$order;?>', 'results', 'check_inner', 'checked_inner');"><?=$link?></a> ] -			
	<?php }else{?>
		[ <a class="srch-tablnk<?=$i?>" href="javascript:void(0);" onclick="javascript:getData('<?=$path;?>?act=<?=$act?>', '&sort=<?=$sort?>&limit=<?=$limit?>&page_no=<?=$page_no?>&path=<?=$path?>&page=<?=$page?>&order=<?=$order;?>', 'results', 'check_inner', 'checked_inner');"><?=$link?></a> ]
<?php  }
}?>
</td>
</tr>
<?php } ?>
</table>
</div>