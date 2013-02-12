function getData(url,pm,d,arr) {

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

  //alert(url+pm);
/*  var lnk = url+pm;
  var ar = lnk.split('&');
  var lmt = ar[3].split('=');
  lmt = lmt[1];
  document.getElementById('limit').value=lmt;*/
 //alert(document.getElementById('limit').value);
  
  pm = pm.toLowerCase();
  url+=pm;
  
  if(arr == "checked"){
	 // alert("checked");
	  var values = getValues();
	  document.getElementById("checked").value = values;
	  //alert( values);
	  url+="&"+arr+"="+values.substring(0,(values.length)-1);
  }else if(arr != undefined){
	  //alert("check");
	  var values = getValues();
	  document.getElementById("checked").value = "";
	 // alert(values.length);
	  url+="&check="+values.substring(0,(values.length)-1);
  }
  //alert(url);
  xmlHttp.open("GET",url,true);
  xmlHttp.send(null);  
}

function getValues(){
  var ar =  document.getElementsByName("check");
  var values='';
   //alert( 'sssssss');
  for(var i=0; i<ar.length; i++){
	 if(ar[i].checked == true){
		 document.getElementById("row_"+ar[i].value).style.className="srch-tabrowbg2";
		 
		 values += ar[i].value+",";
		 //alert( values);
	 }
  }
  values += document.getElementById("checked").value;
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
  
function getChecked(id,v){
	var values = document.getElementById("checked").value;
	
	if(v==true){
		document.getElementById("row_"+id).setAttribute("class", "srch-tabrowbg2");//style.className="srch-tabrowbg2";
		values+=id+",";
	}else{
		values = removeByElement(values.split(","),id);
		document.getElementById("row_"+id).setAttribute("class", "srch-tabrowbg1");//.style.className="srch-tabrowbg1";
	}
	document.getElementById("checked").value = values;
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

function getCheckedAll(v,name){
	var values=document.getElementById("checked").value;
	
   //alert(v+name);
   var arr =  document.getElementsByName(name);

   for(var i=0; i<arr.length; i++){
	 if(v == true){
		 arr[i].checked=true;
		 values += arr[i].value+",";
		 document.getElementById("row_"+arr[i].value).setAttribute("class", "srch-tabrowbg2");
	 }else{
		 arr[i].checked="";
		 values = removeByElement(values.split(","),arr[i].value);
		 document.getElementById("row_"+arr[i].value).setAttribute("class", "srch-tabrowbg1");
	 }
  }
  document.getElementById("checked").value = values;  
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