<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="javascript" type="text/javascript">
//<![CDATA[
function clearText(thefield){
if (thefield.defaultValue==thefield.value)
thefield.value = ""
} 
//}}>
</script>
<?php echo $html->charset(); ?>
<title><?php echo $title_for_layout; ?> / Admin Panel [powered by Propennyauction]</title>
<?php
                echo $html->meta('icon');
                echo $html->css('admin/style');
                echo $html->css('tabmenu2');
        ?><!--[if lt IE 7]>
        <?php echo $html->css('admin-ie'); ?>
    <![endif]-->
<?php
        echo $javascript->link('jquery/jquery');
        echo $javascript->link('jquery/ui');
        echo $javascript->link('admin');
                echo $scripts_for_layout;
        ?>
        
        
<script src="<?php echo $appConfigurations['url']?>/admin/css/slide/animatedcollapse.js" language="javascript"></script>
<script src="<?php echo $appConfigurations['url']?>/admin/css/slide/highslide-with-html.js" language="javascript"></script>
<script language="javascript">
animatedcollapse.addAlldivs(10000);
</script>        
        
<script type="text/javascript">
//<![CDATA[
        sfHover = function() {
            var sfEls = document.getElementById("nav").getElementsByTagName("LI");
            for (var i=0; i<sfEls.length; i++) {
                sfEls[i].onmouseover=function() {
                    this.className+=" sfhover";
                }
                sfEls[i].onmouseout=function() {
                    this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
                }
            }
        }
        if (window.attachEvent) {
            window.attachEvent("onload", sfHover);
        }
//]]>
</script>












<style type="text/css">
/*<![CDATA[*/
 div.c5 {clear:both}
 iframe.c4 {border:none; overflow:hidden; width:100px; height:21px;}
 select.c3 {visibility: hidden !important;}
 option.c2 {visibility: hidden;}
 input.c1 {max-width:90px;}
/*]]>*/
</style>
</head>
<body>
<div id="wrapper"><?php # echo $this->element('admin/menu_top');?>
<div id="container">
<div id="header" class="clearfix container">
<div class="logo"><?php echo $html->link($html->image('admin/logo.png'), array('controller' => 'dashboards', 'action' => 'index', 'admin' => 'admin'), null, null , false);?></div>
<div class="adminpanel">Admin Panel</div>
  <div id="search">
  <form name="search" action="propennyauction.php" method="POST" target="_blank">
  
  <input name="searchquery" class="searchtext" type="text" style="max-width:90px;" value="[Enter keyword]" onFocus="clearText(this)">
  <input type="submit" name="Submit" value="Search" class="searchbuttonc">
  <select name="searchtype" class="searchselect" style="visibility: hidden;!important">
  <option value="all" selected style="visibility: hidden;">-- Support Site --</option></select>
  <input type="hidden" name="_m" value="core"><input type="hidden" name="_a" value="searchclient">
  
  </form>
  </div>
  <?php echo $this->element('admin/menu');?>
  </div>
<?php if($session->check('Message.flash')){
	$session->flash();}

if($session->check('Message.auth')){
$session->flash('auth');}?>

<div id="content_container">

<div id="left_side">
<?php echo $this->element('admin/leftmenu');?>
</div>

<div id="right_side"><?php echo $content_for_layout; ?></div>
<div class="col-left" id="footer"><a href="/" target="_blank">View Your Website</a> | <a href="http://propennyauction.com/" target="_blank">Support Center</a> | <a href="http://propennyauction.com/" target="_blank">Member Forums</a><br />
<?php 
include 'footer_copyright.php'; // avoid removing this.
?>

</div>
</div>
</div>
<?php echo $cakeDebug; ?></div>
</body>
</html>