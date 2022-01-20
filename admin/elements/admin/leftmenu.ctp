<script src="<?php echo $appConfigurations['url']?>/admin/css/jquery_002.js" language="javascript"></script>
<script src="<?php echo $appConfigurations['url']?>/admin/css/ddaccordion.js" language="javascript"></script>
<style>

.left_panel_top_co {
	margin:0px;
	padding:0px;
	height:47px;
	background:url(<?php echo $appConfigurations['url']?>/admin/img/left_panel_top.gif) no-repeat top left;
}
.left_panel_bottom_co {
	float:left;
	margin:0px;
	padding:0px;
	width:100%;
	height:15px;
	background:url(<?php echo $appConfigurations['url']?>/admin/img/left_panel_bottom_co.gif) no-repeat top left;
}
.urbangreymenu{
	width: 244px;
	padding:0px;
	background:url(<?php echo $appConfigurations['url']?>/admin/img/left_panel_middle_bg.gif) repeat-y top left;
}

.urbangreymenu .headerbar{
	font-size: 15px;
	color: #000;
	padding:15px 0px 0px 51px;
	cursor:pointer;
	font-weight:normal;
	margin:0px;
}
.urbangreymenu .headerbar a{
	text-decoration: underline;
	color: white;
	display: block;
	font-weight:normal;
}

.urbangreymenu ul{
	list-style-type: none;
	margin: 0px 3px;
	padding: 0px 0px 8px 0px;
	margin-bottom: 0; 
	font-weight:normal;
	background:#fff;
}

.urbangreymenu ul li{
	padding:0px;
	font-weight:normal;
	border-bottom:1px solid #dcdcdc;
	padding:3px 0px;
}

.urbangreymenu ul li a{
	font: normal 12px Arial;
	color: #555555;
	display: block;
	padding: 5px 0px 0px 28px;
	line-height: 20px;
	text-decoration: none;
	font-weight:normal;
	background-color: #fff;
	font-size:13px;
	background-image: url(<?php echo $appConfigurations['url']?>/admin/img/submenu_bg.gif);
	background-repeat: no-repeat;
	background-position: 15px 13px;
}

.urbangreymenu ul li a:visited{
	color: #555555;
}

.urbangreymenu ul li a:hover{
	color: #035383;
	font-weight:normal;
	background-image: url(<?php echo $appConfigurations['url']?>/admin/img/submenuhover_bg.gif);
	background-repeat: no-repeat;
	background-position: 15px 13px;
}

.urbangreymenu ul li a.active{ 
	color: #035383;
	font-weight:normal;
	background-image: url(<?php echo $appConfigurations['url']?>/admin/img/submenuhover_bg.gif);
	background-repeat: no-repeat;
	background-position: 15px 13px;
}

.left_section_management {
	background-position:1px top;
	background-repeat:no-repeat;
	height:50px;
}



.text_box_search {
    margin: 10px 0 3px 14px;
    font-size: 12px;
    padding:3px 22px 3px 6px;
    width:186px;
    height:22px;
	border:1px solid #ccc;
    border-radius: 5px;
    float:left;
}

.left_panel_top_co .left_menu_search {
    background:url(<?php echo $appConfigurations['url']?>/admin/img/search_icon.jpg) no-repeat 0px 2px ;
    float:left;
    margin:15px 0 0 -22px;
    padding:0;
    opacity:0.5;
}


</style>

<script type="text/javascript">
Cufon.replace('td.heading');
Cufon.replace('h3.headerbar');
Cufon.replace('td.header_nav_text');

window.onload = function() {
    	var x = readCookie('showLeftMenu');
	searchClass ="middle_left_content";
	node = "";
	tag = "td";
	
    var classElements = new Array();
	
	var els = document.getElementsByTagName(tag);
	var elsLen = els.length;
	var pattern = new RegExp("(^|\\s)"+searchClass+"(\\s|$)");
	for (i = 0, j = 0; i < elsLen; i++) {
		if ( pattern.test(els[i].className) ) {
			// This code is used to change the image and showing/hiding leftmenu.
			if(x == 'yes') {
				els[i].style.display = "block";		// Hide menu
				document.getElementById("menuShowHide").src="/admin/img/icon_hide_panel.jpg";
			} else if(x == 'no') {
				els[i].style.display = "none";		// show menu				   
				document.getElementById("menuShowHide").src="/admin/img/icon_show_panel.jpg";
			}
			j++;
		}
	}
}

// This function is used to show/hide the left menu.
function hidemenu() {
	searchClass ="middle_left_content";
	node = "";
	tag = "td";
	
	var theImg = document.getElementById("menuShowHide").src;	
	
	var imgNam = theImg.split("/");
	var imglen = imgNam.length-1;
	var val = imgNam[imglen];
	var x = readCookie('showLeftMenu');
	
		// This code is used to change the image and setting the cookie value.
	//alert('Val=>'+val);
	if (val == 'icon_hide_panel.jpg') {
		//alert("if");
        document.getElementById("menuShowHide").src="<?php echo $appConfigurations['url']?>/admin/img/icon_show_panel.jpg";
                	setCookie("showLeftMenu", "no", 1);
            } else {    	
        document.getElementById("menuShowHide").src="<?php echo $appConfigurations['url']?>/admin/img/icon_hide_panel.jpg";
                	setCookie("showLeftMenu", "yes", 1);
            }
    	var classElements = new Array();
	if ( node == null )
		node = document;
	
	var els = document.getElementsByTagName(tag);
	var elsLen = els.length;
	var pattern = new RegExp("(^|\\s)"+searchClass+"(\\s|$)");
	for (i = 0, j = 0; i < elsLen; i++) {
		if ( pattern.test(els[i].className) ) {			
			// check if the cookie is set to yes then hide menu. Code for image.			
			if (val == 'icon_hide_panel.jpg' || x == 'yes') {
				els[i].style.display = "none";		// Hide menu
			} else if (val == 'icon_show_panel.jpg' || x == 'no') {
				els[i].style.display = "block";		// show menu
			}
			j++;
		}
	}
	
	
                graph1.replot( { resetAxes:true } );
            graph2.replot( { resetAxes:true } );
    }

// This function is used to set the cookie.
function setCookie(name, value, days) {
    document.cookie= name + "=" + escape(value);
    if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

// This function is used to read the cookie.
function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

// This function is used to erase the cookie.
function eraseCookie(name) {
	createCookie(name,"",-1);
}

jQuery.expr[':'].Contains = function(a, i, m) { 
  return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0; 
};
function change_menu(str, e) {
    $(".left_section_management").css("display","");
    if(str=="") {
        $('.text_box_search').val('').focus();
        $('#menu_clear').hide();
        $('#menu_search').show();
        $(".submenu li").css("display","");
        ddaccordion.expandone('headerbar',$("#selected_section").val());
        return;
    }
    $('#menu_clear').show();
    $('#menu_search').hide();
    $(".submenu li").css("display","none");
    $(".submenu li:Contains('"+str+"')").css("display","");
    var items;
    $(".left_section_management").each(function(){
        if(parseInt($(this).find(".headerbar:Contains('"+str+"')").length) > 0) {
            $(this).next("ul").find("li").css("display","");
        }
        else {
            items = $(this).next("ul").find("li")
            .filter(function() {
               return !($(this).css('visibility') == 'hidden' || $(this).css('display') == 'none');
            }).length;
            if(items==0) { 
                $(this).css("display","none");
                $(this).next("ul").css("display","none");
            }
        }
    });
    //var firstmenu = parseInt($('.left_section_management:visible:eq(0)').next("ul").attr('contentindex'));
    var firstmenu = parseInt($('.left_section_management')
    .filter(function() {
               return !($(this).css('visibility') == 'hidden' || $(this).css('display') == 'none');
            })
    .next("ul").attr('contentindex'));
    ddaccordion.expandone('headerbar',firstmenu);
    if (e.keyCode == 13) {
        var url = $('.left_section_management')
        .filter(function() {
           return !($(this).css('visibility') == 'hidden' || $(this).css('display') == 'none');
        }).next("ul").find("li")
            .filter(function() {
               return !($(this).css('visibility') == 'hidden' || $(this).css('display') == 'none');
            })
            .find("a").attr("href");
        if(url!=undefined)
        document.location.href=url;
    }
    if (e.keyCode == 27) {
        change_menu('');
    }
}

/*
 * ~ START: FULL SCREEN FUNCTION
 */
function launchFullscreen(element) {
	if (!$('body').hasClass("full-screen")) {
		$('body').addClass("full-screen");
		if (element.requestFullscreen) {
			element.requestFullscreen();
		} else if (element.mozRequestFullScreen) {
			element.mozRequestFullScreen();
		} else if (element.webkitRequestFullscreen) {
			element.webkitRequestFullscreen();
		} else if (element.msRequestFullscreen) {
			element.msRequestFullscreen();
		}
	} else {
		$('body').removeClass("full-screen");
		if (document.exitFullscreen) {
			document.exitFullscreen();
		} else if (document.mozCancelFullScreen) {
			document.mozCancelFullScreen();
		} else if (document.webkitExitFullscreen) {
			document.webkitExitFullscreen();
		}
	}
}

/*
 * ~ END: FULL SCREEN FUNCTION
 */
</script>



<img  style="cursor:pointer;" src="<?php echo $appConfigurations['url']?>/admin/img/icon_hide_panel.jpg" id="menuShowHide" class="hide_show_leftpanel noprint" onclick="hidemenu();" accesskey="a" border="0">
	   <table class="leftmenu" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr>
              <td style="display: block;" class="middle_left_content">
              <div class="urbangreymenu noprint">
              
                  <div class="left_panel_top_co">
                   <form name="search" action="https://members.phppennyauction.com/index.php" method="POST" target="_blank">
                      <input  class="text_box_search" placeholder="Search" title="Search." type="text" ccesskey="s" onkeyup="change_menu(this.value, event)">
                    
                    <img src="<?php echo $appConfigurations['url']?>/admin/img/search_icon.jpg" class="left_menu_search" id="menu_search" height="17px">
                    <img src="<?php echo $appConfigurations['url']?>/admin/img/admin_icon_delete.gif" class="left_menu_search" style="display:none;cursor:pointer;" id="menu_clear" onclick="change_menu('');" height="17px"> 
                    
                      </form>
                    
                    </div>
                    
                    
                  <div class="left_section_management" style="background-image:url(<?php echo $appConfigurations['url']?>/admin/img/report_icon.gif);">
                  <h3 class="headerbar" headerindex="0h">Auction Management</h3>
                  </div>                 
                  <ul style="display: none;" contentindex="0c" class="submenu">
                  <li><a href="<?php echo $this->webroot;?>admin/products/index">Products Index</a></li>
				  <li><a href="<?php echo $this->webroot;?>admin/products/add">Add New Product</a></li>                  
				  <li><a href="<?php echo $this->webroot;?>admin/auctions/live">Auctions Index</a></li>                  
				  <li><a href="<?php echo $this->webroot;?>admin/auctions/comingsoon">Future Auctions</a></li>                  
				  <li><a href="<?php echo $this->webroot;?>admin/auctions/won">Won Auctions</a></li>                  
				  <li style="display:none;"><a href="<?php echo $this->webroot;?>admin/storeorders">Store Orders</a></li>                                    
                  <li><a href="<?php echo $this->webroot;?>admin/bids/index">Bids Placed</a></li>                  
                  </ul>
                  
                  <div class="left_section_management" style="background-image:url(<?php echo $appConfigurations['url']?>/admin/img/quote_icon.gif);">
                  <h3 class="headerbar" headerindex="1h">Content Management</h3>
                  </div>                  
                  <ul style="display: none;" contentindex="1c" class="submenu">
                  <li><a href="<?php echo $this->webroot;?>admin/pages/index">Pages</a></li>
                  <li><a href="<?php echo $this->webroot;?>admin/news/index">News articles</a></li>
                  <li><a href="<?php echo $this->webroot;?>admin/categories/index">Categories</a></li>
                  <li><a href="<?php echo $this->webroot;?>admin/departments/index">Departments</a></li>
				
                  </ul>
                   
                  <div class="left_section_management" style="background-image:url(<?php echo $appConfigurations['url']?>/admin/img/user_icon.gif);">
                  <h3 class="headerbar" headerindex="2h">Members</h3>
                  </div>
                  <ul style="display: none;" contentindex="2c" class="submenu">
                  <li><a href="<?php echo $this->webroot;?>admin/users/index" >Users</a></li>
                  <li><a href="<?php echo $this->webroot;?>admin/referrals/index" >Referrals</a></li>
                  <li><a href="<?php echo $this->webroot;?>admin/users/autobidders/index">Autobidders</a></li>
                  </ul>
                  
                  
                  <div class="left_section_management" style="background-image:url(<?php echo $appConfigurations['url']?>/admin/img/content_management_icon.gif);">
                  <h3 class="headerbar" headerindex="3h">News Letters</h3>
                  </div>
                  <ul style="display: none;" contentindex="3c" class="submenu">
                    <li> <a href="<?php echo $this->webroot;?>admin/newsletters/index">News Letters</a></li>
                  </ul>
                  
                  
                  <div class="left_section_management" style="background-image:url(<?php echo $appConfigurations['url']?>/admin/img/printer_icon.gif);">
                    <h3 class="headerbar" headerindex="4h">Site Setting</h3>
                  </div>
                  <ul style="display: none;" contentindex="4c" class="submenu">

                 <li><a href="<?php echo $this->webroot;?>admin/settings/index">General Settings</a></li>
                 <li><a href="<?php echo $this->webroot;?>admin/packages/index">Packages</a></li>
                 <li><a href="<?php echo $this->webroot;?>admin/coupons/index">Coupons</a></li>
				 <li><a href="<?php echo $this->webroot;?>admin/countries/index">Countries</a></li>
			    <li><a href="<?php echo $this->webroot;?>admin/statuses/index">Statuses</a></li>
                <li><a href="<?php echo $this->webroot;?>admin/sources/index">Sources</a></li>                
               <li><a href="<?php echo $this->webroot;?>admin/dashboards/clear_cache">Clear cache</a></li>
			   </ul>
				 <div class="left_panel_bottom_co"></div>
                 
                </div>
                
                <script type="text/javascript">
ddaccordion.init(     {
	headerclass: "headerbar", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false
	defaultexpanded: [0], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", "selected"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["", "", ""], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "normal", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
			ddaccordion.collapseall('headerbar');
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
	    
		//do nothing
	}
});
</script>
                </td>
              
            </tr>
          </tbody>
        </table>





    
          <SCRIPT type="text/javascript">
//	var parentAccordion = new TINY.accordion.slider("parentAccordion");
//	parentAccordion.init("acc", "h3", 0, 0);

var index=$('h3.acc-selected').attr('tabindex');
index=parseInt(index);
//alert(index + " is selected!"); 
	var nestedAccordion = new TINY.accordion.slider("nestedAccordion");
	nestedAccordion.init("acc", "h3", 1, index, "acc-selected");


</SCRIPT>