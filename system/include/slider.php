	<?
	$select1='<select name="valueA" id="valueA">'; $select2='<select name="valueB" id="valueB">';
	
	if($report_type=='m'){
		for($i=1; $i<=12; $i++){
			$selected=""; if($i==1){ $current=getMonthName($mm); $c1=$current; $selected="selected='selected'";} if($mm==0){ $mm=12;}
			$select1.="<option $selected value='".getMonthName($mm)."'>".getMonthName($mm)."</option>";
			
			if($i==2){ $selected="selected='selected'";}
			if($mm==$c1-1){ $selected="selected='selected'";} if($mm==13){ $mm=1;}
			$select2.="<option $selected value='".getMonthName($mm)."'>".getMonthName($mm)."</option>"; $mm--;
		}
		
	}else if($report_type=='q'){ $mm=(int)$mm;
		for($i=1; $i<=4; $i++){
			if($mm<1){ $mm=12; $year=($yy-1); } $selected="";
			$qarter=getQuarter($mm); $qname=getQuarterName($qarter); 
			
			if($i==1){$current=$qarter; $selected="selected='selected'";}
			
			$select1.="<option $selected value='$qarter'>$qname $year</option>";
			
			if($qarter==$current-1){$selected="selected='selected'";}
			$select2.="<option $selected value='$qarter'>$qname $year</option>"; $mm-=3;
		} 
	}else if($report_type=='y'){ $mm=(int)$mm;
		for($i=1; $i<=4; $i++){	$selected="";
			if($i==1){$current=$yy; $selected="selected='selected'";}
			
			$select1.="<option $selected value='$yy'>$yy</option>";
			
			if($yy==$current-1){ $selected="selected='selected'";}
			$select2.="<option $selected value='$yy'>$yy</option>"; $yy--;
		} 
	}
	
	$select1.="</select>"; $select2.="</select>"; $slider=$select1.$select2;?>
