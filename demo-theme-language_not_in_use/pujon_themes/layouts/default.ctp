<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $dir;?>">
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?> | <?php echo $appConfigurations['name']; ?></title>
	<link rel="alternate" type="application/rss+xml" href="/auctions/index.rss" title="<?php __('Live Auctions');?>">
	<link rel="shortcut icon" type="image/x-icon" href="/img/fav-icon.png" />
 <meta name="viewport" content="width=device-width,initial-scale=1">    
	<?php
		if(!empty($meta_description)) :
			echo $html->meta('description', $meta_description);
		endif;
		if(!empty($meta_keywords)) :
			echo $html->meta('keywords', $meta_keywords);
		endif;
		echo $html->css('style11');
		 
		echo $javascript->link('jquery/jquery');
		echo $javascript->link('jquery/ui');
	?>
	<script type="text/javascript" src="<?php echo $this->webroot ?>auctionjs.php"></script>
	<?php

		echo $scripts_for_layout;
	?>
	 
 
 
<script type="text/javascript">
	var page_name = 'home'; 
	var uname = ''; 
	var uid = ''; 
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
    
    

    

</head>
<body style="overflow-x:hidden;">
<!--[if lte IE 6]>
<?= $javascript->link('ie6/warning'); ?><script>window.onload=function(){e("<?= $this->webroot ?>/js/ie6/")}</script>
<![endif]-->
<div class="clock_poup">
<?php #echo $this->element('promotional_popup');?>
</div>


<script type="text/javascript">
$("body").click(function(){
        $(".clock_poup").fadeOut().removeClass('popubg');
    
});
</script>


 
<div class="fix_header">
<div id="header">
<div class="doc_width">
<div class="logo"><a href="<?php echo $this->webroot; ?>"><img src="<?php echo $this->webroot;?>img/logo/logo.png"/></a></div> 
<div class="header_right"> 	
<div class="login_menu">

	<?php echo $this->element('menu_top');?>

<?php if($session->check('Auth.User')):
 echo $this->element('status');
   endif;?>

</div>

 </div>
 
</div> 
</div>
<div class="main_menu">
<div class="doc_width">
<?php echo $this->element('header_menu');?>
</div>
</div>
</div>

<?php if($this->params['action'] == 'home'){  
   echo $this->element('home_banner'); 
} ?>

<br style="clear:both;" />
<?php 
if($this->params['action'] == 'home'){  
	echo $this->element('step');  
} 
?>


<div id="container">
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

<div class="footer_logo">
<div class="doc_width">
<p><img src="<?php echo $this->webroot; ?>img/payment_logo.jpg" alt="" width="auto" height="100%" /></p>
</div>
</div>

<div class="footerbg"><?php   echo $this->element('footer');?></div>
<?php echo $cakeDebug; ?>

 
</body>
</html>