<?php 
$path = "../../../";
require_once("../../../system/include/config.php");
require_once(INC."paging.php");
require_once(INC."com_cms_funcs.php");

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
			if($act != "seract_1") mysql_query($q);
		}
	}
}

$arr = getFields('eh_image');

foreach($arr as $k=>$v){
	if($v != ""){
		$sortMenu[$k] = $v;
		$str .= $v.", ";
	}
}
$str	= substr($str, 0, strlen($str)-2);
$sort	= 'id_image';

$q = "SELECT $str FROM eh_image as i, eh_region as r where i.id_region = r.id_region ORDER BY ".$sort." ".$order;

$PAGING=new PAGING($q, $limit);
$q=$PAGING->sql;
?>

<div class="inr-recbox"><div><?=$PAGING->showPageLocation();?></div>
<div class="inr-reclistbox">
<select class="inr-reclist1" name="select2" onchange="javascript:getData('<?=$path;?>', '?sort=<?=$sort?>&limit='+this.value+'&page_no=<?=$page_no?>&path=<?=$path;?>&page=<?=$page?>&order=<?=$order;?>', 'results', 'checked_inner','check_inner');">
<?php  $limitList = getPageLimitList();

  foreach($limitList as $k=>$v){
	if($limit == $k){
		echo "<option selected='selected' value='$k'>$v</option>";
	}else{
		echo "<option value='$k'>$v</option>";
	}	
}?>
</select>
<select class="inr-reclist1" name="select2" onchange="javascript:getData('<?=$path;?>', '?sort='+this.value+'&limit=<?=$limit?>&page_no=<?=$page_no?>&path=<?=$path;?>&page=<?=$page?>&order=<?=$order;?>', 'results', 'checked_inner', 'check_inner');">
<?php foreach($sortMenu as $k=>$v){
	if($sort == $v){
		echo "<option value='$v' selected='selected'>$k</option>";
	}else{
		echo "<option value='$v'>$k</option>";
	}
}?>
</select>
<?=$PAGING->showPages($path, "&sort=".$sort."&limit=".$limit."&path=".$path."&page=".$page."&order=".$order, "results","checked_inner", "check_inner");?></div></div>

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
<?php  $sql = mysql_query($q);
$count2 = mysql_num_rows($sql);
if($count2 < 1){
echo '<tr><td colspan="22" class="inr-tabrow10">No Record found</td></tr>';

} else {
$count=0;
while($row = mysql_fetch_array($sql)){$count++;

if($checked!=""){ if(in_array($row[0], $checked)){ $chk = "checked='checked'"; $class="srch-tabrowbg2"; }else{ $class="inr-tabrowbg1"; $chk = "";}}?>
<tr class="<?=$class?>" id="inner_<?=$row[0];?>">
<td class="inr-tabrow2"><input class="inr-tabchk" type="checkbox" name="check_inner" <?=$chk?> onclick="javascript:getChecked('<?=$row[0];?>',this.checked,'checked_inner');" value="<?=$row[0];?>" /></td>
<td class="inr-tabrow3"><?=$row[0];?></td>
<td class="inr-tabrow3"><?=$row['1'];?></td>
<td class="inr-tabrow3"><?=$row['2'];?></td>
<td class="inr-tabrow3"><?=$row['3'];?></td>
<td class="inr-tabrow3"><?= getStatus('act_'.$row['4']); ?></td>
<td class="inr-tabrow4"><a class="inr-tablnk1" href="eh_image_add_edit.php?id=<?=base64_encode($row[0])?>">Edit Details</a></td>
</tr>

<?php  }?>
<tr>
<td colspan="9" class="inr-tabrow5"><b>With Selected:</b> 
<?php 
$links = getActionLinks('eh_image');
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
<?php echo $PAGING->showPaging($path, "sort=".$sort."&limit=".$limit."&path=".$path."&page=".$page."&order=".$order, "results", "checked_inner", "check_inner");?>
</table>
</div>