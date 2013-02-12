function locUpdate()
{
	$('.loc_update').unbind();
	var pg=$('#page_name').val();
	var data= $('#location_data').serialize();
		$.post("ajax_content/"+pg,data,function(response){
			$('#provider').html(response);
			initBlocks(pg);
	});
}

function curUpdate()
{
	$('.cur_update').unbind();
	var pg=$('#page_name').val();
	var data= $('#currency_data').serialize();
		$.post("ajax_content/"+pg,data,function(response)
		{
			$('#provider').html(response);
			initBlocks(pg);
	});
}

function insUpdate()
{
	$('.ins_update').unbind();
	var pg=$('#page_name').val();
	var data= $('#instance_price_data').serialize();
		$.post("ajax_content/"+pg,data,function(response)
		{
			$('#provider').html(response);
			initBlocks(pg);
	});
}

function atrUpdate()
{
	$('.atr_update').unbind();
	var pg=$('#page_name').val();
	var data= $('#pro_attr_data').serialize();
		$.post("ajax_content/"+pg,data,function(response)
		{
			$('#provider').html(response);
			initBlocks(pg); elasticHostTab();
	});
}

function licUpdate()
{
	$('.lic_update').unbind();
	var pg=$('#page_name').val();
	var data= $('#pro_soft_data').serialize();
		$.post("ajax_content/"+pg,data,function(response)
		{
			$('#provider').html(response);
			initBlocks(pg);
	});
}

function licUpdate()
{
	$('.lic_update').unbind();
	var pg=$('#page_name').val();
	var data= $('#pro_soft_data').serialize();
		$.post("ajax_content/"+pg,data,function(response)
		{
			$('#provider').html(response);
			initBlocks(pg);
	});
}

function licUpdate()
{
	$('.lic_update').unbind();
	var pg=$('#page_name').val();
	var data= $('#pro_soft_data').serialize();
		$.post("ajax_content/"+pg,data,function(response)
		{
			$('#provider').html(response);
			initBlocks(pg);
	});
}

function loc_cur_update()
{
	$('.loc_cur_update').unbind();
	var pg=$('#page_name').val();
	var data= $('#loc_currency').serialize();
		$.post("ajax_content/"+pg,data,function(response)
		{
			$('#provider').html(response);
			initBlocks(pg);
	});
}

function max_pow_update()
{
	$('.max_pow_update').unbind();
	var pg=$('#page_name').val();
	var data= $('#max_pow_data').serialize();
		$.post("ajax_content/"+pg,data,function(response)
		{
			$('#provider').html(response);
			initBlocks(pg);
	});
}