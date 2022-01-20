<style>
.title h3 a{color:#000;}
li.on_lang a{ color:#7c7c7c;}
.howit_step .step .label{left:0px;}



</style>

<?php
$class1=$class2=$class3=$class4=$class5=$class6=$class7=$class8=$class9=$class10=$class11=''; 
$ca = $this->params['action'];
$cc = $this->params['controller'];


if($cc == 'auctions' && $ca == 'home'){
	$class1 = 'act';
}
if($cc == 'auctions' && $ca == 'index'){
	$class1 = 'act';
}

if($cc == 'auctions' && $ca == 'winners'){
	$class2 = 'act';
}
if($cc == 'auctions' && $ca == 'closed'){
	$class2 = 'act';
}


if($this->params['url']['url'] == 'page/how-it-works'){
	$class4 = 'act';
	
}
if($cc == 'packages' && $ca == 'index'){
	$class5 = 'act';
}

if($cc == 'categories' && $ca == 'index'){
	$class6 = 'act';
}

if($cc == 'users' && $ca == 'login'){
	$class7 = 'act';
}
if($cc == 'users' && $ca == 'register'){
	$class8 = 'act';
}

if($cc == 'users' && $ca == 'index'){
	$class9 = 'act';
}

if($cc == 'auctions' && $ca == 'seat'){
	$class10 = 'act';
}
if($cc == 'auctions' && $ca == 'penny'){
	$class11 = 'act';
}


?>



<div class="tasktop_non top_lang">
 <li  class="<?php if($_COOKIE['lang'] == 'eng'){ echo 'on_lang'; } ?> ">
<a title="English"  href="<?php //echo $this->webroot; ?>?lang=eng"> <img src="<?php echo $this->webroot;?>img/flag_eng.png" title="English" alt="English"/>ENG</a> 
</li>
<li  class="<?php if($_COOKIE['lang'] == 'fre'){ echo 'on_lang'; } ?>">
<a title="french"  href="<?php //echo $this->webroot; ?>?lang=fre">
<img src="<?php echo $this->webroot;?>img/flag_fre.png" title="french" alt="french"/>
FRE</a>
</li>
</div>




<a  onclick="document.getElementById('navigation').classList.toggle('closed');" class="nav-btn" href="javascript:void(0)">&nbsp;</a>
<ul id="navigation" class="slide_login closed">


<?php if($session->check('Auth.User')):?>

<li class="tasktop_non welcome_name"><a style="font-weight: bold;cursor: inherit;" href="javascript:void:0px"><?php __('Welcome') ?>, <?php echo $session->read('Auth.User.username'); ?></a></li>
<li class="tasktop_non current-plan"><a href="javascript:void(0);"><font class="bid-balance">
	<?php __('Current Plan');?>:</font> 
	<strong><?php echo $appConfigurations['subscription_pack'][$user_info['User']['sid']]  ;?></strong>
</a></li>
<li class="tasktop_non" style="color:#fff;font-size:19px;">
	<?php __('Balance');?> <?php echo sprintf(__('%s', true), '<strong class="top_bidbal bid-balance" style="color:#ff9100;">'.(int) $user_info['User']['bid_balance'].'</strong>');?>
	<?php __('Bonus bids');?> <?php echo sprintf(__('%s', true), '<strong class="top_bidbal bbid-balance" style="color:#ff9100;">'.(int) $user_info['User']['rewards_points'].'</strong>');?>
</li> 



<li class="tasktop_non"><a class="<?php echo $class9?>"  href="<?php echo $this->webroot; ?>users"><?php __('My Account');?></a></li>
<li class="tasktop_non"><a  href="<?php echo $this->webroot; ?>auctions/logout"><?php __('Logout');?></a></li>

<?php else:?>
<li class="tasktop_non"><a   href="<?php echo $this->webroot; ?>users/login"><?php __('Login');?></a></li>      
<li class="tasktop_non"><a   href="<?php echo $this->webroot; ?>users/register"><?php __('Register');?></a></li>  
<?php endif;?>


   



<li><a  href="<?php echo $this->webroot; ?>auctions" ><?php __('Live Auctions');?></a></li>
 
<li><a  href="<?php echo $this->webroot; ?>auctions/closed"><?php __('Closed Auctions');?></a>
</li>
  
        

<li><a  href="<?php echo $this->webroot; ?>packages" class="<?php echo $class5?>"><?php __('Bid Packages');?></a></li>  
 <li><a  href="<?php echo $this->webroot; ?>watchlists" class="<?php echo $class5?>"><?php __('My Watchlist');?></a></li>  
<li><a  href="<?php echo $this->webroot; ?>page/frequently-asked-questions" ><?php __('Faq');?></a></li>
  


 

     
</ul>







<style>
li.myaccount .slide_mayaccount {
	border-radius: 0px 0px 6px 6px;
	/*opacity:0;*/
	visibility:hidden;
	display:none;
	position:absolute;
	right:0;
	z-index:1000;
	text-align:left;
	top:100px;
}

li.myaccount:hover  .slide_mayaccount {
	/*opacity:1;*/
	visibility:visible;
	top:51px;
	display:block;
}



.top_bidbal{
	color: #fff !important;cursor:auto;font-size:16px;padding:0px 8px;margin-right:0;
	background:linear-gradient(-90deg, #317D09, #5FC529);
	border-radius: 50px;
	padding: 2px 8px;
}
a:hover.top_bidbal{ color:#fff;}
.login_menu li{display:inline-block;}
font-size:14px;}
.fb_element{float:right;margin-top:-12px;}
.fb_element span{display:inline-block;}
select.lang{
	background: #25272a;
	color: #fff;
	padding: 5px;
	border: 1px solid #fff;
	font-size: 12px;
}
</style>


<script>
 $('.plus_icon').click(function(){
		$('.slide_mayaccount_auction').toggle();
});
 $('.plus_icon_how').click(function(){
		$('.slide_mayaccount_how').toggle();
});
$(document).on("scroll", function(){
		if
      ($(document).scrollTop() > 50){
		  $(".fix_header").addClass("fixed");
		  $("body").addClass("fixed_body");
		}
		else
		{
			$(".fix_header").removeClass("fixed");
			$("body").removeClass("fixed_body");
		}
	});
	
	


$('.welcome_user').click(function(){
	$('.slide_mayaccount_top').toggle();
});

	

 
$('html').click(function() { /*console.log('html click #slide_mayaccount_top hide');*/
	$('#slide_mayaccount_top').hide();
	$('.slide_mayaccount_auction').hide();
	$('.slide_mayaccount_how').hide();
});
$('.header_right').click(function(e){ /*console.log('header_right click  not hide');*/
	e.stopPropagation();
});
$( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {  
        $('#slide_mayaccount_top').hide();
    }
});
 
</script>

 
 
  <script>
  new WOW().init();
 </script>

