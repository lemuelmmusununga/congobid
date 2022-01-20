<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $dir;?>">
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?> | <?php echo $appConfigurations['name']; ?></title>
	<link rel="alternate" type="application/rss+xml" href="/auctions/index.rss" title="<?php __('Live Auctions');?>">
	<link rel="shortcut icon" type="image/x-icon" href="/img/faveicon.png" />
 <meta name="viewport" content="width=device-width,initial-scale=1">    
	<?php
		if(!empty($meta_description)) :
			echo $html->meta('description', $meta_description);
		endif;
		if(!empty($meta_keywords)) :
			echo $html->meta('keywords', $meta_keywords);
		endif;
		if($_GET['theme']=='black'){
			echo $html->css('style12_black');
		}else{
		echo $html->css('style21'); 
		}
		echo $html->css('animate');
		 
		//echo $javascript->link('jquery/jquery');
		//echo $javascript->link('jquery/ui');
	?>
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="<?php echo $this->webroot ?>auctionjs.php"></script>
	<?php

		echo $scripts_for_layout;
	?>
	 

 
<script type="text/javascript">
	var page_name = '<?php echo $this->params['action']; ?>'; 
	var uname = ''; 
	var uid = <?php echo (int) $session->read('Auth.User.id'); ?>; 
	</script> 

	<script type="text/javascript">
	<!--
	// page_top_scroll
	$(function () {
        $('#link_to_top').click(function () {
            $(this).blur();

            $('html,body').animate({ scrollTop: 0 }, 'normal');
            return false;
        });
	});
	-->
	</script>

	<?php eval(AddonManager::hook('views_layouts_headbottom')); ?>
    
    

	<base href="<?php echo $appConfigurations['url']; ?>"> 

</head>
<body style="overflow-x:hidden;">
 
<div class="clock_poup">
<?php #echo $this->element('promotional_popup');?>
</div>


<script type="text/javascript">
$("body").click(function(){
        $(".clock_poup").fadeOut().removeClass('popubg');
    
});
</script>
<style>
.d-none{
	display:none;
}
</style>
<div class="fix_header fadeInDown animated">
<div id="header">
<div class="doc_width">
<div class="logo logo-white">
<a href="<?php echo $this->webroot; ?>"><img src="<?php echo $this->webroot;?>img/logo/logo.png"/></a>
</div> 

<div class="logo logo-black">
<a href="<?php echo $this->webroot; ?>"><img src="<?php echo $this->webroot;?>img/logo/logo-black.png"/></a>
</div> 



<form class="search_part d-none" method="post" action="/auctions/search">
<input class="search_bg" type="text" onclick="javascript:if(this.value == 'Search Auctions'){this.value='';}" name="data[Auction][search]" maxlength="40" value="<?php __('Search Auctions') ?>" id="UserUsername">
<span class="search_icon"><input type="image" src="<?php echo $this->webroot; ?>img/search_icon_black.png" value=""></span>
</form>

<span class="d-none top-account-link"><a href="<?php echo $this->webroot; ?>users"><img src="<?php echo $this->webroot;?>img/username_bg.png"/></a></span>

<div class="header_right"> 
<div class="login_menu">
<?php echo $this->element('menu_top');?>
</div>

 </div>
 
</div> 
</div>

<div class="main_menu mobile_none">
<div class="doc_width">
<?php echo $this->element('header_menu');?>
</div>
</div>


</div>





<?php if($this->params['action'] == 'home'){ 
echo $this->element('main_banner');    
      
}?>








<div id="container">
<?php if($this->params['action'] == 'home'){ 
echo $this->element('step');
   
}?>
<div id="maincontent">

		<?php
			if($session->check('Message.flash')){
				$session->flash();
			} elseif(isset($_COOKIE['reg_complete']) && $_COOKIE['reg_complete']) {
                echo "<div id=\"flashMessage\" class=\"success\">Thank you for registering. An email has been sent with a link to complete your registration. Please check your email inbox and click the confirmation link inside. Please check your SPAM folders if the email does not arrive within five minutes.</div>";
                setcookie ("reg_complete", "", time() - 3600);
            }

			if($session->check('Message.auth')){
				$session->flash('auth');
			}
		?>
		<?php echo $content_for_layout; ?>

	</div>
    
	
</div>

<br style="clear:both;" />

<div class="footerbg hide1"><?php   echo $this->element('footer');?></div>
<?php echo $cakeDebug; ?>


<div class="alert-outer">
 

</div>


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-3MREWDXJH3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-3MREWDXJH3');
</script>
  <script type="text/javascript" src="/css/slide/wow.js"></script>
 
</body>
</html>