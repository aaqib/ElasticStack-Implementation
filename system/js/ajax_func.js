function getData(url,pm,d,chked,chk) {

	//checking if we have action available
	if(url.indexOf('act=') != -1)
	{
		 var n = $("input:checked").length;
		 if(n == 0)
		 {
			alert('Please select at least one record!');
			return;
		 }
		 else
		 {
			var sAlert	= "Are you sure you want to change the status of selected record?";
			if(url.indexOf('_del') != -1)
				sAlert	= "Are you sure you want to delete selected records?";
			if(!confirm(sAlert))
				return;
		 }
	}

	document.getElementById(d).innerHTML='<div id="loading"><div class="load-box"><div class="load-anim"></div></div></div>';
	var xmlHttp;
	try {
		// Firefox, Opera 8.0+, Safari
		 xmlHttp=new XMLHttpRequest();
  	}catch (e){
	  // Internet Explorer
	  try{
	    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      }catch (e){
	    try{
	      xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    	}catch (e){
	      alert("Your browser does not support AJAX!");
    	  return false;
	    }
     }
  }
  
  xmlHttp.onreadystatechange=function(){
	
    if(xmlHttp.readyState==4){      
		//document.getElementById('loading').style.display='none';
		document.getElementById(d).innerHTML=xmlHttp.responseText;
		
		try{
			//search on enter button
			fnSearch();

			//Event Binding For Ajax Light box Content
			$(document).ready(function()
			{
				$("a.zoom").fancybox(
				{
					'zoomSpeedIn' : 350, 'zoomSpeedOut' : 300, 'overlayOpacity' : 0.6, 'overlayColor' : '#000000'
				});
			});
		}	
		catch(e){};
    }
  }

 //alert(url+pm);
/*  var lnk = url+pm;
  var ar = lnk.split('&');
  var lmt = ar[3].split('=');
  lmt = lmt[1];
  document.getElementById('limit').value=lmt;*/
 //alert(document.getElementById('limit').value);
  
  if(pm.indexOf('&details=') == -1) //condition applied for details text box
	pm = pm.toLowerCase();
  
  url+=pm;
  
  if(chked == "checked" || chked == "checked_inner"){
	  //alert(chked);
	  var values = getValues(chk, chked);
	  document.getElementById(chked).value = values;
	  //alert( values);
	  url+="&"+chked+"="+values.substring(0,(values.length)-1);
  }else if(chked != undefined){
	  //alert(chked+ chk);
	  var values = getValues(chked, chk);
	  document.getElementById(chk).value = "";
	 // alert(values.length);
	  url+="&"+chked+"="+values.substring(0,(values.length)-1);
  }
  //alert(url);
  xmlHttp.open("GET",url,true);
  xmlHttp.send(null);  
}

function getValues(chk,chked){
  var ar =  document.getElementsByName(chk);
  var values='';
  
  if(chked == "checked"){
		var class2 = "srch-tabrowbg2";
		var prefix = 'row_';
	}else{
		var class1= "inr-tabrowbg1";
		var prefix = 'inner_';
	}
	
   //alert( 'sssssss');
  for(var i=0; i<ar.length; i++){
	 if(ar[i].checked == true){
		 document.getElementById(prefix+ar[i].value).style.className="srch-tabrowbg2";
		 
		 values += ar[i].value+",";
		 //alert( values);
	 }
  }
  values += document.getElementById(chked).value;
 // alert(document.getElementById("checked").value);
 // alert(values);
  values = unique(values);
  return values;
}

function unique(arrayName){
    var newArray=new Array();
	
	arrayName = arrayName.split(",");
	//alert("ddd"+arrayName);
    label:for(var i=0; i<arrayName.length;i++ ){  
	
       for(var j=0; j<newArray.length;j++ ){
          if(newArray[j]==arrayName[i]) 
            continue label;
       }
       newArray[newArray.length] = arrayName[i];
    }
	return newArray.join(",");
}

function removeByElement(arrayName,arrayElement){
	//alert(arrayName+arrayElement);
 for(var i=0; i<arrayName.length;i++ ){ 
 	//alert(arrayName[i]+"---"+arrayElement);
     if(arrayName[i]==arrayElement)
        arrayName.splice(i,1); 
  }
  return arrayName.join(",");
}
  
function getChecked(id,v,chked){
	var values = document.getElementById(chked).value;
	
	
	if(chked == "checked"){
		var class1= "srch-tabrowbg1";
		var class2 = "srch-tabrowbg2";
		var prefix = 'row_';
	}else{
		var class1= "inr-tabrowbg1";
		var class2 = "srch-tabrowbg2";
		var prefix = 'inner_';
	}
	if(v==true){
		document.getElementById(prefix+id).setAttribute("class", class2);//style.className="srch-tabrowbg2";
		values+=id+",";
	}else{
		values = removeByElement(values.split(","),id);
		document.getElementById(prefix+id).setAttribute("class", class1);//.style.className="srch-tabrowbg1";
	}
	document.getElementById(chked).value = values;
	//var c = document.getElementById("row_"+id).style.className;
	//alert(id+v+c);
}

function getCheckedOrders(id,v,chked,v1){
	var values = document.getElementById(chked).value;
	
	if(chked == "checked"){
		var class1= "srch-tabrowbg1";
		var class2 = "srch-tabrowbg2";
		var prefix = 'row_';
	}else{
		var class1= "inr-tabrowbg1";
		var class2 = "srch-tabrowbg2";
		var prefix = 'inner_';
	}
	
	 var ar =  document.getElementsByName("check_inner");
	 for(var i=0; i<ar.length; i++){
		 //alert(ar[i].value+"ds"+v1);
		 if(v==true && ar[i].value==v1 || v==true && ar[i].checked==true){
			 ar[i].checked=true;
		 }else if(v==false && v1==ar[i].value){
			 ar[i].checked=false;
		 }
	 }
	  
	if(v==true){
		document.getElementById(prefix+id).setAttribute("class", class2);//style.className="srch-tabrowbg2";
		values+=id+",";
	}else{
		values = removeByElement(values.split(","),id);
		document.getElementById(prefix+id).setAttribute("class", class1);//.style.className="srch-tabrowbg1";
	}
	document.getElementById(chked).value = values;
	//var c = document.getElementById("row_"+id).style.className;
	//alert(id+v+c);
}
function getBGClass(name){
   var arr =  document.getElementsByName(name);

   for(var i=0; i<arr.length; i++){
	 if(arr[i].checked == true){
		 arr[i].checked;
	 }
  }
 // alert(str+arr);
}

function getCheckedAll(v,name,chked){
	var values=document.getElementById(chked).value;
	
	if(chked == "checked"){
		var class1= "srch-tabrowbg1";
		var class2 = "srch-tabrowbg2";
		var prefix = 'row_';
	}else{
		var class1= "inr-tabrowbg1";
		var class2 = "srch-tabrowbg2";
		var prefix = 'inner_';
	}
//   alert(v+name+chked);
   var arr =  document.getElementsByName(name);

   for(var i=0; i<arr.length; i++){
	 if(v == true){
		 arr[i].checked=true;
		 values += arr[i].value+",";
		 document.getElementById(prefix+arr[i].value).setAttribute("class", class2);
	 }else{
		 arr[i].checked="";
		 values = removeByElement(values.split(","),arr[i].value);
		 document.getElementById(prefix+arr[i].value).setAttribute("class", class1);
	 }
  }
  document.getElementById(chked).value = values;  
  //  alert(val+"aaa"+values);
}

function showDiv(d){
	//alert(d);
	var dis = document.getElementById(d).style.display;
	//alert(dis);
	if(dis == '' || dis == 'none'){
		fadeslide.toggle(d);
	}
}

function getSimpleData(url,pm,d,h) {

	var xmlHttp;

	try {
		// Firefox, Opera 8.0+, Safari
		 xmlHttp=new XMLHttpRequest();
  	}catch (e){
	  // Internet Explorer
	  try{
	    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      }catch (e){
	    try{
	      xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    	}catch (e){
	      alert("Your browser does not support AJAX!");
    	  return false;
	    }
     }
  }
 	
  xmlHttp.onreadystatechange=function(){
	
    if(xmlHttp.readyState==4){      
		document.getElementById(d).innerHTML=xmlHttp.responseText;
    }
  }
  
  if(h)
	document.getElementById(h).style.display = 'none';

  pm = pm.toLowerCase();
  url+=pm;
  
//  alert(url);
  xmlHttp.open("POST",url,true);
  xmlHttp.send(null);  
}
function changeClass(id,current,newclass){
	var tmplink = document.getElementById('tmplink').value;
	
	if(tmplink != id){
		document.getElementById(id).setAttribute('class', newclass);
		document.getElementById(tmplink).setAttribute('class', current);
		
		document.getElementById('tmplink').value=id;
	}
}

function getPrivCheckedAll(v,name,chked){
	
	if(v == true || v==false){
		var arr =  document.getElementsByName('privs[]');
		for(var i=0; i<arr.length; i++){
			if(v == true){ arr[i].checked=true;	}else{ arr[i].checked="";}
		}
		var arr =  document.getElementsByName('addons[]');
		for(var i=0; i<arr.length; i++){
			if(v == true){ arr[i].checked=true;	}else{ arr[i].checked="";}
		}
		var arr =  document.getElementsByName('cms[]');
		for(var i=0; i<arr.length; i++){
			if(v == true){ arr[i].checked=true;	}else{ arr[i].checked="";}
		}
		var arr =  document.getElementsByName('customers[]');
		for(var i=0; i<arr.length; i++){
			if(v == true){ arr[i].checked=true;	}else{ arr[i].checked="";}
		}
		var arr =  document.getElementsByName('support[]');
		for(var i=0; i<arr.length; i++){
			if(v == true){ arr[i].checked=true;	}else{ arr[i].checked="";}
		}
		var arr =  document.getElementsByName('setup[]');
		for(var i=0; i<arr.length; i++){
			if(v == true){ arr[i].checked=true;	}else{ arr[i].checked="";}
		}
		var arr =  document.getElementsByName('util[]');
		for(var i=0; i<arr.length; i++){
			if(v == true){ arr[i].checked=true;	}else{ arr[i].checked="";}
		}
	}
}

function getChartWidth(default_width,percent){
	var default_resolution=1024;
	var resolution = screen.width;
	
	if(resolution> default_resolution){
		var width=((resolution-default_resolution)/100*percent);
		return parseInt(width+default_width);
	}
	return default_width;	
}