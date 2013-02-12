//This Variables Using For Child Images
var totChild, befChild, delChild = new Array;

function planImageEvent()
{
	totChild = $("#tot_child").val();
	$('.frm-mixbtn2').click(function()
	{
		totChild = parseInt(totChild)-1;  
		$("#tot_child").val(totChild);
		delChild.push($(this).attr('title'));
		$('#child_row_'+$(this).attr('title')+'').remove();
	})
	$('#child_btn').click(function(){    $('#child_btn').unbind();   planAddChildImage();    })
}

function planAddChildImage()
{
	totChild = $("#tot_child").val();   $('.frm-mixbtn2').unbind();   totChild = parseInt(totChild)+1;   $("#tot_child").val(totChild);
	if (delChild.length != 0)
	{
		for(var i=0; i<=delChild.length; i++)
		{
			var chkNum = parseInt(delChild[i])-1;
			var chkDiv = $('#child_row_'+chkNum+'').size();
			if(chkDiv == 1){    totChild=delChild[i];  delChild.splice(i, 1);  i=delChild.length;    }
		}
	}
	befChild = parseInt(totChild)-1;
	
	$('#child_row_'+befChild+'').after('<div class="child_fld2" id="child_row_'+totChild+'"><label>Friendly Name '+totChild+':</label><input class="inr-edit-fld3" type="text" name="user_name" value="" /><input type="file" name="child_img[]" /><a href="javascript:void(0);" class="frm-mixbtn2" title="'+totChild+'">Remove</a></div>');
	$('.frm-mixbtn2').click(function()
	{   
		totChild = parseInt(totChild)-1;
		$("#tot_child").val(totChild);
		delChild.push($(this).attr('title'));
		$('#child_row_'+$(this).attr('title')+'').remove();
	})
	$('#child_btn').click(function(){   $('#child_btn').unbind();   planAddChildImage();  })
}








//Plan Suggestion Check Function
function planSuggCheck()
{
	//Defining All Default Variables
	var totSugPlan=$("#tot_sug_plan").val(), sugPlanDiv='#sug_plan-1', i, sugPlanSel=0;
	
	//Creating List of IDS For Suggestion Plans
	for(i=2; i<=totSugPlan; i++){   sugPlanDiv += ', #sug_plan-'+i+'';   }
	
	//Check Box Click Function
	$(sugPlanDiv).click(function()
	{   
		//Calculating Selected Suggestion Plans
		if($(this).attr('checked') == true){   sugPlanSel=parseInt(sugPlanSel)+1;  }
		else{   sugPlanSel = parseInt(sugPlanSel)-1;   }
		
		//Controlling Suggestion Plans
		if(sugPlanSel == 2)
		{
			//Check Active DIV
			for(i=1; i<=totSugPlan; i++)
			{   
				if($('#sug_plan-'+i+'').attr('checked') == false){   $('#sug_plan-'+i+'').attr('disabled', 'disabled');   }
			}
		}
		else
		{
			$(sugPlanDiv).removeAttr('disabled');
		}
	})
}