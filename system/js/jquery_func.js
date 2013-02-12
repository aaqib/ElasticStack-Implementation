//Default Variables for Generating Duplicate DIVs
var totDiv, befDiv, delDiv=new Array();

//Div Generator Click Events
function duplicatDivClickEvent(totDivID, dupDivID, addBtn, removeBtn, dupDivClass, dellArray, swapClass, change_name)
{
	//Remove Duplicate Div Event
	$('.'+removeBtn).click(function()
	{  
		//Deactivating All Events
		$('.'+removeBtn).unbind();  $('#'+addBtn+'').unbind(); 
		
		//Saving Deleted Data Id if Needed for Edit
		var data_id = $(this).attr('name');
		
		//Checking ID
		if(data_id != "")
		{
			//Saving ID in Deleted Item List
			var data_delete_list = $('#data_delete_list').val();
			data_delete_list += '|-|'+data_id;
			$('#data_delete_list').val(data_delete_list);
		}
		
		//Calling Duplicate DIV Deleting Function
		duplicatDivDelete(totDivID, dupDivID, addBtn, removeBtn, dupDivClass, $(this).attr('title'), dellArray, swapClass, change_name);  
	});

	//Add Duplicate Event
	$('#'+addBtn+'').click(function()
	{  
		//Deactivating All Events
		$('.'+removeBtn).unbind();  $('#'+addBtn+'').unbind(); 

		//Calling Duplicate Div Generator Function
		duplicatDivGenerator(totDivID, dupDivID, addBtn, removeBtn, dupDivClass, dellArray, swapClass, change_name);
	})
}

//Div Generator Onload Function
function duplicatDivOnload(totDivID, dupDivID, addBtn, removeBtn, dupDivClass, dellArray, swapClass, change_name)
{
	//Create Delete Div Array
	delDiv[dellArray] = new Array();
	
	//Div Generator Click Events
	duplicatDivClickEvent(totDivID, dupDivID, addBtn, removeBtn, dupDivClass, dellArray, swapClass, change_name);
}

//Duplicate Div Delete Function
function duplicatDivDelete(totDivID, dupDivID, addBtn, removeBtn, dupDivClass, divNum, dellArray, swapClass, change_name)
{
		totDiv = $('#'+totDivID+'').val();
		totDiv = parseInt(totDiv)-1;  
		$('#'+totDivID+'').val(totDiv);
		delDiv[dellArray].push(divNum);
		$('#'+dupDivID+'_'+divNum+'').remove();

		//Div Generator Click Events
		duplicatDivClickEvent(totDivID, dupDivID, addBtn, removeBtn, dupDivClass, dellArray, swapClass, change_name);
}

//Duplicate Div Generator Function
function duplicatDivGenerator(totDivID, dupDivID, addBtn, removeBtn, dupDivClass, dellArray, swapClass, change_name)
{
	//Assigning Values in Total Div Counter
	totDiv = $('#'+totDivID+'').val();    totDiv = parseInt(totDiv)+1;    $('#'+totDivID+'').val(totDiv);

	//Checking Deleted DIVs
	if (delDiv[dellArray].length > 0)
	{
		for(var i=0; i<=delDiv[dellArray].length;)
		{
			var chkNum = delDiv[dellArray][i];   chkNum = parseInt(chkNum)-1;
			var chkDiv = $('#'+dupDivID+'_'+chkNum+'').size();
			if(chkDiv == 1)
			{    
				totDiv=delDiv[dellArray][i];  
				delDiv[dellArray].splice(i, 1); 
				i=delDiv[dellArray].length;
			}
			i++;
		}
	}

	//Finding Prevous Div
	befDiv = parseInt(totDiv)-1;

	var DivClassName = dupDivClass;

	//Saving Html Data Into String
	var html_data =$('#'+dupDivID+'_1').html();

	//Condition For Swapping Class
	if((swapClass == 1) & ($('#'+dupDivID+'_'+befDiv+'').attr('class') == 'pro_set2')){    DivClassName = 'pro_set3';    }

	//Updating Name Value For Key
	if(change_name == 1)
	{
		var name_val = parseInt(totDiv)-1;
  		var dataUpdater = html_data.split('0[]');
		dataUpdater = dataUpdater.join(name_val+'[]');
		html_data = dataUpdater;
		//alert(html_data);
	}
		
	//Placing Content Into Duplicate Div
	$('#'+dupDivID+'_'+befDiv+'').after('<div class="'+DivClassName+'" id="'+dupDivID+'_'+totDiv+'">'+html_data+'</div>');

	//Adding Remove Button
	$('#'+dupDivID+'_'+totDiv+'').append('<a href="javascript:void(0);" class="'+removeBtn+'" title="'+totDiv+'">Remove</a>');

	//Assigning Unique Number In Fields
	$('#'+dupDivID+'_'+totDiv+' .dup_num').html(totDiv);

	//Div Generator Click Events 
	duplicatDivClickEvent(totDivID, dupDivID, addBtn, removeBtn, dupDivClass, dellArray, swapClass, change_name); 
}

//Plan Suggestion Check Function
function planSuggCheck(limit)
{
	//Defining All Default Variables
	var totSugPlan=$("#tot_sug_plan").val(), sugPlanDiv='#sug_plan-1', i, sugPlanSel=$("#tot_sug").val();

	//Creating List of IDS For Suggestion Plans
	for(i=2; i<=totSugPlan; i++){   sugPlanDiv += ', #sug_plan-'+i+'';   }

	//Check Box Click Function
	$(sugPlanDiv).click(function()
	{   
		//Calculating Selected Suggestion Plans
		if($(this).attr('checked') == true){   sugPlanSel=parseInt(sugPlanSel)+1;  }
		else{   sugPlanSel = parseInt(sugPlanSel)-1;   }

		//Controlling Suggestion Plans
		if(sugPlanSel == limit)
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
	
	//Controlling Suggestion Plans
	if(sugPlanSel == 2)
	{
		//Check Active DIV
		for(i=1; i<=totSugPlan; i++)
		{   
			if($('#sug_plan-'+i+'').attr('checked') == false){   $('#sug_plan-'+i+'').attr('disabled', 'disabled');   }
		}
	}
	
}

//------------------------Akram----------------------------------------

function initBlocks(provider)
{
	//alert(provider);
	if(provider == 'provider_set_1.php')
	{
		duplicatDivOnload('tot_div1', 'dup_div1', 'add_dup_btn1', 'frm-mixbtn2', 'child_fld2', '0', '0'); 
		duplicatDivOnload('tot_div2', 'dup_div2', 'add_dup_btn2', 'frm-mixbtn4', 'pro-ser_box2', '1', '0');
	}
	else if(provider == 'provider_set_2.php')
	{
		duplicatDivOnload('tot_div1', 'dup_div1', 'add_dup_btn1', 'frm-mixbtn2', 'child_fld2', '0', '0'); 
		duplicatDivOnload('tot_div2', 'dup_div2', 'add_dup_btn2', 'frm-mixbtn2-2', 'child_fld2', '1', '0'); 
		elasticHostTab();
	}
	$(function()
	{
		$('#provider .loc_update').bind('click', locUpdate);
		$('#provider .cur_update').bind('click', curUpdate);
		$('#provider .ins_update').bind('click', insUpdate);
		$('#provider .atr_update').bind('click', atrUpdate);
		$('#provider .lic_update').bind('click', licUpdate);
		$('#provider .loc_cur_update').bind('click', loc_cur_update);
		$('#provider .max_pow_update').bind('click', max_pow_update);
	});	
}

//------------------------------------------------------------------

//Provider Setting Onload Function
function providerSetLoader(provider)
{
	//Display Preloader
	$('#provider').html('<div id="loading"><div class="load-box"><div class="load-anim"></div></div></div>');

	//Sending Preloader	Number
	var data = 'provider='+provider;
	
	//Loading Provider Data
	$.post('ajax_content/'+provider, data, function(response)
	{
		//Placing Response to DIV
		$('#provider').html(response);

		//Calling Onload Function
		initBlocks(provider);
	})
}

//Configuration Page Click Function
function configCheck()
{
	//Check Box Click Function
	$('#exd_locs').click(function()
	{
		//Calculating Selected Suggestion Plans
		if($(this).attr('checked') == true){   
			$('.exd_loc_check').removeAttr('disabled');  
		}else{   
			$('.exd_loc_check').removeAttr('checked').attr('disabled', 'disabled');
		}
	})
}

//Elastic Host Tab Function
function elasticHostTab()
{
	var activeTab = $('#current_tab').val();
	var tab_id = '#tab1';
	for(var i=2; i<$('#tot_tab').val(); i++){    tab_id += ', #tab'+i;    }
	$(''+tab_id+'').click(function()
	{
		var currTab = $(this).attr('title');
		if(activeTab != currTab)
		{
			$($('#tab'+activeTab+'').parent()).removeClass();
			if(currTab == '1'){  $($(this).parent()).addClass('act1');   }else{   $($(this).parent()).addClass('act2');   } 
			$('#tab_cont-'+activeTab+'').css('display','none');
			$('#tab_cont-'+currTab+'').fadeIn('fast');
			activeTab = currTab;
			$('#current_tab').val(currTab);
		}
	});
}

//Ajax Form Submission Event
function ajaxForm(n, btn, form, ldr, script, error_box, div, response_div, name, param, callback, function_num, function_param)
{
	var check = confirm('Are you Sure?');
	if(check == true)
	{
		//Hidding Error Box
		jQuery(error_box).slideUp(50);

		//Deactivating Form Buttons
		jQuery(btn).unbind();
		
		//Unbinding Light Box Event 
		lightBoxEventUnbind();
		
		//Deactivating Form Objects
		jQuery(ldr).slideDown(50);

		//Saving Form Data
		var data = jQuery(''+form+n+'').serialize();
		
		//Sending Ajax Requests
		jQuery.post(''+script+'',data,function(response)
		{
			//Updating Div Data If Required
			if(name != ""){  getData(name, param, response_div);  }
	
			//Placing Error Data
			jQuery(error_box).html(response);
			
			//Buttons Click Event
			jQuery(btn).click(function()
			{  
				var btn = jQuery(this).attr("id").split("-");
				ajaxForm(btn[1], btn, form, ldr, script, error_box, div, response_div, name, param);
			});
	
			//Hidding Deactivator Box
			jQuery(ldr).slideUp(50, function()
			{
				jQuery(error_box).slideDown('fast', function()
				{    
					//Light Box Event Binding
					if(div != ""){  lightBoxEventBind(div);  }
					
					//On Response Callback Function Define Here
					if(callback == 'yes')
					{ 
						switch(true)
						{
							case function_num == '1': initBlocks(''+function_param+''); break; 	
						}
					}
				});
			});
		});
	}
}

//Light Box Loader
function lightBoxLoader()
{
	//Placing All Light Box Data Into Body
	jQuery('body').append('<div id="light-box"><a id="light-close" href="javascript:void(0);">Close</a><div class="light-c1">&nbsp;</div><br clear="all" /><div id="light-data"></div><br clear="all" /><div class="light-c2">&nbsp;</div></div><div id="light-bg">&nbsp;</div>');

	//Setting Light Box Background Heigh For IE
	if ((jQuery.browser.msie) & (parseInt(jQuery.browser.version) == 6))
	{
		jQuery('#light-bg').css('height',''+document.body.offsetHeight+'px');
	}
	//Setting Light Box Background Tranparancy Setting For IE
	jQuery('#light-bg').css({'filter' : 'alpha(opacity=70)'});
}

//Light Box Display Function
function lightBoxShow(div)
{
	//Light Box Event Binding
	lightBoxEventBind(div);
	
	//Loading Content Into Light Box Container
	jQuery('#light-data').html(jQuery(div).html());

	//Cleaning Temprory Container
	jQuery(div).html('');

	//Light Box Set Display Position Function
	lightBoxSetPosition();

	//Displaying Light
	jQuery('#light-bg, #light-box').fadeIn('fast');	
}

//Light Box Loader
function lightBoxHide(div)
{
	//Unbinding Light Box Event 
	lightBoxEventUnbind();
	
	//Hidding Light Box Background
	jQuery('#light-bg').fadeOut('fast');

	//Hidding Cleaning Light Box Data Container
	jQuery('#light-box').fadeOut('fast', function()
	{  
		//Hidding Error Box
		jQuery('.error_box').css('display', 'none');
	
		//Loading Content Into Temprary Box
		jQuery(div).html(jQuery('#light-data').html());

		//Cleaning Light Box Container
		jQuery('#light-data').html('');
	});
}

//Light Box Set Display Position Function
function lightBoxSetPosition()
{
	//Setting Calculating Current Windows Position
	var topPos = jQuery(document).scrollTop() + ((jQuery(window).height() - (jQuery('#light-box').height()))* 0.5);
	var leftPos = jQuery(document).scrollLeft() + ((jQuery(window).width() - (jQuery('#light-box').width()))* 0.5);
	
	//Comparing Calculated Position to Document Position
	topPos	= Math.max(jQuery(document).scrollTop()+20, topPos);
	leftPos	= Math.max(jQuery(document).scrollLeft()+20, leftPos);
	
	//Applying Position to Light Box Container
	jQuery('#light-box').css('top',''+topPos+'px');
	jQuery('#light-box').css('left',''+leftPos+'px');
}

//Light Box Event Binding
function lightBoxEventBind(div)
{
	//Lightbox Closing On Click Event
	jQuery('#light-close, #light-bg').click(function(){   lightBoxHide(div);  });

	//Lightbox Closing On Keyprss Event
	jQuery(document).unbind('keydown.fb').bind('keydown.fb', function(e){   if(e.keyCode == 27){ lightBoxHide(div); }   });
}

//Light Box Event Unbinding
function lightBoxEventUnbind()
{
	//Unbinding Click Event
	jQuery('#light-close, #light-bg').unbind();
	
	//Unbinding Keyboard Event
	jQuery(document).unbind('keydown.fb');
}

//Add Fund Function 
function fundAdd(curr, tax_apply, setup_fee, status)
{
	jQuery('#tax_apply').html(tax_apply+' %');
	jQuery('#fund_curr').html(curr);
	
	//Display Setup Fee Against Pending Service
	if((setup_fee != 0) && (status == 0))
	{
		jQuery('#fund_setup_fee').html('* One Time Setup Apply Against This Service: <b>'+setup_fee+' '+curr+'</b>');
	}
	else
	{
		jQuery('#fund_setup_fee').html('');
	}
	
	jQuery('#ammount').change(function()
	{
		var val = jQuery('#service').val().split("_");
		if ((!isNaN(jQuery('#ammount').val())) & (jQuery('#ammount').val() != "") & (jQuery('#service').val() != "0"))
		{
			var hour= jQuery('#ammount').val()/val[1];
			var hour= Math.floor(hour);
			jQuery('#fund_hour').html(hour+' Hours');
			jQuery('#fund_note').css('display','block');
		}
		else
		{
			jQuery('#fund_note').css('display','none');
		}
	});
}

function FundHist(p, type, t1, t2, limit, name, page)
{
	//Onload FundHistory Function
	FundHistLoad(p, type, '', '', limit, name, page)
	
	//Set Active Type
	var act_type = type;

	//Type Click Event
	jQuery('#hist_type_1, #hist_type_2, #hist_type_3').click(function()
	{  
		var curr = jQuery(this).val(), date_1='', date_2='';
		if(curr != act_type)
		{
			if((jQuery('#from').val() != "") && (jQuery('#to').val() != ""))
			{
				date_1=jQuery('#from').val();
				date_2=jQuery('#to').val();
			}
			//Activatin Current Selected Type
			act_type = curr;
			
			//Loading Fund History
			FundHistLoad(p, act_type, date_1, date_2, limit, name, page)
		}
	})
	
	//Date Click Event
	jQuery('#hist_date').click(function()
	{  
		//Getting Date
		var date_1 = jQuery('#from').val(), date_2 = jQuery('#to').val();
		
		//Validatin Date
		if(date_1 == "")
		{
			alert(t1);
		}
		else if(date_2 == "")
		{
			alert(t2);
		}
		else if((date_1 != "") && (date_2 != ""))
		{
			//Loading Fund History
			FundHistLoad(p, act_type, date_1, date_2, limit, name, page)
		}
	})
}

function FundHistLoad(p, type, date_1, date_2, limit, name, page)
{
	//Loading FundHistory Data
	getData(''+p+'ajax_content/'+name+'.php','?sort=0&path='+p+'ajax_content/'+name+'.php&page='+page+'&limit='+limit+'&pm_type='+type+'&date_from='+date_1+'&date_to='+date_2+'&order=desc', 'results');
}

//Service Forms Event Function 
function serviceFormEvent(param, div, btn, ldr, data_div, data, error_box)
{
	//Display Lighbox
	lightBoxShow(div);

	//Data Placing into Div
	jQuery(data_div).val(data);

	//Unbinding Button Event
	jQuery(btn).unbind();

	//Form Submit Click Event
	jQuery(btn).click(function()
	{
		var num = btn.split("-");
		ajaxForm(num[1], btn, '#ser_form-', ldr, 'ajax_content/service_forms.php', error_box, div, 'results', 'ajax_content/service.php', param)
	});
}

function sec_event()
{
	//Setting Service Detail
	jQuery('#service_det').html('Please Wait....');
	
	//Saving Form Data
	var data = jQuery('#service_data').serialize();
	//alert(data);
	
	//Sending Ajax Requests
	jQuery.post("ajax_content/service_credentials.php",data,function(response)
	{
		//alert(response);
		var chk_res = response.search('Wrong');
		if((chk_res != -1))
		{
			//Display Error Message
			jQuery('#service_det').html(response);
		}
		else
		{
			//Display Credentials
			jQuery('#service_det').html(response);

			//Hide Form
			jQuery('#service_form').css('display','none');
		}		
	});
}

function serverDataUpdate(p, id)
{
	//Saving Form Data
	var data = jQuery('#ser_data').serialize();
	
	//Sending Data to Script
	getData(p, '?path='+p+'&page='+id+'&'+data+'', 'results', 'checked_inner','check_inner')
}

//Service Forms Event Function 
function providerFormEvent(div, btn, ldr, error_box)
{
	//Display Lighbox
	lightBoxShow(div);

	//Unbinding Button Event
	jQuery(btn).unbind();

	//Form Submit Click Event
	jQuery(btn).click(function()
	{
		var num = btn.split("-");
		ajaxForm(num[1], btn, '#set_form-', ldr, 'ajax_content/provider_forms.php', error_box, div, 'provider', 'ajax_content/provider_set_2.php', '', 'yes', '1', 'provider_set_2.php')
	});
}


//Chart Event | Onload Event Binder
function chartEvents()
{
	//Top Tab Click Function
	jQuery('#tab1, #tab2, #tab3').click(function()
	{
		var type = jQuery(this).attr('name');
		var id = jQuery(this).attr('id');
		
		if(id == 'tab1')
		{   
			jQuery('.act2').removeClass('act2'); jQuery(jQuery(this).parent()).addClass('act1');
		}
		else
		{
			jQuery('.act1').removeClass('act1'); jQuery('.act2').removeClass('act2');  jQuery(jQuery(this).parent()).addClass('act2');
		}
		jQuery('#ch_type').val(type);
		chartUpdate();
	});
	
	//View By Day, etc Function
	jQuery('#date1, #date2, #date3').click(function()
	{  
		jQuery('.band-rep-act').removeClass();
		jQuery(this).addClass('band-rep-act');
		jQuery('#ch_date').val(jQuery(this).attr("name"));
		chartUpdate();
	})
	
	//Server Config
	jQuery('#conf-server').change(function()
	{  
		jQuery('#ch_server').val(jQuery(this).val());
		chartUpdate();
	})
	
	//Chart Update Function
	chartUpdate();
}

//Chart Update Function
function chartUpdate()
{
	jQuery('#chart_report').html('<div id="loading"></div>');
	
	var data = jQuery('#chart_detail').serialize();
	jQuery.post("ajax_content/chart_data.php",data,function(response)
	{   
		jQuery('#chart_report').html(response);
	})
}

//Tax Report | Updator
function taxReportUpdate()
{
	//Setting Service Detail
	jQuery('#results').html('<div id="loading"><div class="load-box"><div class="load-anim"></div></div></div>');
	
	//Saving Form Data
	var data = jQuery('#tax_report_data').serialize();
	
	//Sending Ajax Requests
	jQuery.get("ajax_content/tax_report.php",data,function(response)
	{
		jQuery('#results').html(response);
	});
}

//Page Select all Handler
function pageSelectHandler(bind_class, check_class_name, attr_num, attr_val, sep_num, sep_val)
{
	//alert(bind_class+' | '+check_class_name+' | '+attr_num+' | '+attr_val+' | '+sep_num+' | '+sep_val);

	//Check Box Click Function
	$(''+bind_class+'').click(function()
	{
		//Get Number
		var num = $(this).attr(attr_num);
		if(sep_num != ""){    num=num.split(sep_num);  num=num[1];     }

		//Get Value
		var val = $(this).attr(attr_val);
		if(sep_val != ""){    val=val.split(sep_val);  val=val[1];     }
		
		//Select all Checks
		if(val == "1")
		{
			$(''+check_class_name+num+'').attr('checked', 'checked');
		}
		
		//Deselect all Checks
		else if(val == "0")
		{
			$(''+check_class_name+num+'').removeAttr('checked');
		}
	})
}

//Mail all Invoices
function fnProcessInvoices(sMsg, sURL, sParam, sURL2, sParam2, sResult, sStatus)
{
	if(window.confirm(sMsg))
	{
		$(sResult).html('<div id="loading"><div class="load-box"><div class="load-anim"></div></div></div>');
		jQuery.get(sURL, sParam, function(response)
		{
			jQuery.get(sURL2, sParam2, function(response2)
			{
				$(sResult).html(response2);
				$(sStatus).html(response);
			});
		});
	}		
}

//Search on enter button
function fnSearch()
{
	//submitting form on enter key
	$('#search').keypress(function(e){
		if(e.which == 13){
			$('#btn_search').click();
		}
	});
}

var iTimer;
//Traffic Stats Show details
function fnShowTrafficDetails()
{
	//$('.tbl_details').hide('slow');
	$('.ico_toogle_expand').click(function() {
		var oID = $(this).attr('id').split('-');
		$('#tbl-'+oID[1]).slideDown();
		$(this).hide();
		$('#toogle_collapse-'+oID[1]).show();
	});
	$('.ico_toogle_collapse').click(function() {
		var oID = $(this).attr('id').split('-');
		$('#tbl-'+oID[1]).slideUp();
		$(this).hide();
		$('#toogle_expand-'+oID[1]).show();
	});
	
	if ($(".ico_toogle_expand").length == 0){
		iTimer = setTimeout('fnShowTrafficDetails()', 1000)
	}	
	else
		clearTimeout(iTimer);
}

function scrollPanel(sElementID, sContainerID, sFooterID) 
{
    var win = $(window),
      sidebar = $(sElementID),
      sidebarTop = sidebar.offset().top,
	  sidebarWidth	= sidebar.width(),
      sidebarHeight = sidebar.height(),
      footerPos = $(sFooterID).offset().top,
	  position = $(sContainerID).offset().left;
	  
    if (sidebarHeight < $(sContainerID).height()) {
        win.scroll(function () {
            var scrollTop = win.scrollTop();
            if (scrollTop + 60 > sidebarTop) {
                if (scrollTop + sidebarHeight < footerPos - 60) {
                    sidebar.addClass('scrolled').removeClass('fixedbottom');
					//sidebar.css('left', position - sidebarWidth);
                } else {
                    sidebar.removeClass('scrolled').addClass('fixedbottom');
					//sidebar.css('left', position - sidebarWidth);
				}
            } else {
                sidebar.removeClass('scrolled');
				//sidebar.css('left', position - sidebarWidth);
            }
        });
    }
}

function fnCalculateQuote()
{
	var oForm	= document.frm_quote;
	var oElems	= oForm.elements;
	var iTotal	= 0;
	for(var i=0; i<oElems.length; i++)
	{
		if( (oElems[i].type == 'select-one' && oElems[i].value != '' && oElems[i].id != 'tax' && oElems[i].id != 'discount') || (oElems[i].type == 'checkbox' && oElems[i].checked) )
		{
			oVal	= oElems[i].value.split('|-|');
			iTotal	+= parseFloat(oVal[2]);
		}	
	}
	fnAssignQuoteValues(iTotal);
	$('#total_amount_db').val(iTotal);
	$('#tax').change();
	$('#discount').change();
}

function fnAssignQuoteValues(iTotal)
{
	$('#total_amount').val(iTotal.toFixed(2));
	$('#float-amount').html(iTotal.toFixed(2));
}

function fnCalculateQuoteTaxDiscount(iTotalAmount, iApplyTax)
{
	//Calculatin Tax Ammount
	iTaxAmount 	= iApplyTax * iTotalAmount;
	iTaxAmount 	= iTaxAmount / 100;
	return iTaxAmount.toFixed(2);
}