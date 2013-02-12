var nav={

//Specify full URL to down and right arrow images (23 is padding-right added to top level LIs with drop downs):
arrowimages: {right:['rightarrowclass', 'images/right.gif']},

transition: {overtime:160, outtime:120}, //duration of slide in/ out animation, in milliseconds
shadow: {enable:false, offsetx:5, offsety:5},

///////Stop configuring beyond here///////////////////////////

detectwebkit: navigator.userAgent.toLowerCase().indexOf("applewebkit")!=-1, //detect WebKit browsers (Safari, Chrome etc)
detectie6: document.all && !window.XMLHttpRequest,

getajaxmenu:function($, setting){ //function to fetch external page containing the panel DIVs
	var $menucontainer=$('#'+setting.contentsource[0]) //reference empty div on page that will hold menu
	$menucontainer.html("Loading Menu...")
	$.ajax({
		url: setting.contentsource[1], //path to external menu file
		async: true,
		error:function(ajaxrequest){
			$menucontainer.html('Error fetching content. Server Response: '+ajaxrequest.responseText)
		},
		success:function(content){
			$menucontainer.html(content)
			nav.buildmenu($, setting)
		}
	})
},


buildmenu:function($, setting){

	try
	{
		var smoothmenu=nav

		var $mainmenu=$("#"+setting.mainmenuid+">ul") //reference main menu UL

		$mainmenu.parent().get(0).className=setting.classname || "nav"
		var $headers=$mainmenu.find("ul").parent()
		$headers.hover(
			function(e){
				$(this).children('a:eq(0)').addClass('selected')
			},
			function(e){
				$(this).children('a:eq(0)').removeClass('selected')
			}
		)
		$headers.each(function(i){ //loop through each LI header
			var $curobj=$(this).css({zIndex: 100-i}) //reference current LI header
			var $subul=$(this).find('ul:eq(0)').css({display:'block'})
			this._dimensions={w:this.offsetWidth, h:this.offsetHeight, subulw:$subul.outerWidth(), subulh:$subul.outerHeight()}
			this.istopheader=$curobj.parents("ul").length==1? true : false //is top level header?
			$subul.css({top:this.istopheader && setting.orientation!='v'? this._dimensions.h+"px" : 0})

	if (smoothmenu.shadow.enable){
				this._shadowoffset={x:(this.istopheader?$subul.offset().left+smoothmenu.shadow.offsetx : this._dimensions.w), y:(this.istopheader? $subul.offset().top+smoothmenu.shadow.offsety : $curobj.position().top)} //store this shadow's offsets
				if (this.istopheader)
					$parentshadow=$(document.body)
				else{
					var $parentLi=$curobj.parents("li:eq(0)")
					$parentshadow=$parentLi.get(0).$shadow
				}
				this.$shadow=$('<div class="ddshadow'+(this.istopheader? ' toplevelshadow' : '')+'"></div>').prependTo($parentshadow).css({left:this._shadowoffset.x+'px', top:this._shadowoffset.y+'px'})  //insert shadow DIV and set it to parent node for the next shadow div
			}
			$curobj.hover(
				function(e){
					var $targetul=$(this).children("ul:eq(0)")
					this._offsets={left:$(this).offset().left, top:$(this).offset().top}
					var menuleft=this.istopheader && setting.orientation!='v'? 0 : this._dimensions.w
					menuleft=(this._offsets.left+menuleft+this._dimensions.subulw>$(window).width())? (this.istopheader && setting.orientation!='v'? -this._dimensions.subulw+this._dimensions.w : -this._dimensions.w) : menuleft //calculate this sub menu's offsets from its parent
					if ($targetul.queue().length<=1){ //if 1 or less queued animations
						$targetul.css({left:menuleft+"px", width:this._dimensions.subulw+'px'}).animate({height:'show',opacity:'show'}, nav.transition.overtime)
						if (smoothmenu.shadow.enable){
							var shadowleft=this.istopheader? $targetul.offset().left+nav.shadow.offsetx : menuleft
							var shadowtop=this.istopheader?$targetul.offset().top+smoothmenu.shadow.offsety : this._shadowoffset.y
							if (!this.istopheader && nav.detectwebkit){ //in WebKit browsers, restore shadow's opacity to full
								this.$shadow.css({opacity:1})
							}
							this.$shadow.css({overflow:'', width:this._dimensions.subulw+'px', left:shadowleft+'px', top:shadowtop+'px'}).animate({height:this._dimensions.subulh+'px'}, nav.transition.overtime)
						}
					}
				},
				function(e){
					var $targetul=$(this).children("ul:eq(0)")
					$targetul.animate({height:'hide', opacity:'hide'}, nav.transition.outtime)
					if (smoothmenu.shadow.enable){
						if (nav.detectwebkit){ //in WebKit browsers, set first child shadow's opacity to 0, as "overflow:hidden" doesn't work in them
							this.$shadow.children('div:eq(0)').css({opacity:100})
						}
						this.$shadow.css({overflow:'hidden'}).animate({height:0}, nav.transition.outtime)
					}
				}
			) //end hover
		}) //end $headers.each()
		$mainmenu.find("ul").css({display:'none', visibility:'visible'})
	} catch(e) {}	
},

init:function(setting){
	if (typeof setting.customtheme=="object" && setting.customtheme.length==2){ //override default menu colors (default/hover) with custom set?
		var mainmenuid='#'+setting.mainmenuid
		var mainselector=(setting.orientation=="v")? mainmenuid : mainmenuid+', '+mainmenuid
		document.write('<style type="text/css">\n'
			+mainselector+' ul li ul li a {background:'+setting.customtheme[0]+';}\n'
			+mainmenuid+' ul li ul li a:hover {background:'+setting.customtheme[1]+';}\n'
		+'</style>')
	}
	this.shadow.enable=(document.all && !window.XMLHttpRequest)? false : this.shadow.enable //in IE6, always disable shadow
	jQuery(document).ready(function($){ //ajax menu?
		if (typeof setting.contentsource=="object"){ //if external ajax menu
			nav.getajaxmenu($, setting)
		}
		else{ //else if markup menu
			nav.buildmenu($, setting)
		}
	})
}

} //end nav variable
//Settings
nav.init({
	mainmenuid: "nav", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'navleft', //class added to menu's outer DIV
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})