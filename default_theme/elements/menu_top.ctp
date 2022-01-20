
<?php
$class01=
$class02=
$class03=
$class04=
$class05=
$class06=
$class07=
$class08=
$class09=
$class10=
$class11=
$class12=
$class13=
$class14=
$class15=
$class16=
$class17=''; 
$ca = $this->params['action'];
$cc = $this->params['controller'];


if($cc == 'auctions' && $ca == 'home'){
	$class01 = 'act';
}
if($cc == 'auctions' && $ca == 'index'){
	$class01 = 'act';
}

if($cc == 'auctions' && $ca == 'winners'){
	$class01 = 'act';
}

if($cc == 'auctions' && $ca == 'closed'){
	$class01 = 'act';
}
if($this->params['url']['url'] == 'page/how-it-works'){
	$class02 = 'act';
	
}

if($this->params['url']['url'] == 'page/penny-auctions-guide'){
	$class02 = 'act';	
}

if($cc == 'packages' && $ca == 'index'){
	$class03 = 'act';
}

if($cc == 'categories' && $ca == 'index'){
	$class04 = 'act';
}

if($cc == 'users' && $ca == 'index'){
	$class05 = 'act';
}
if($cc == 'users' && $ca == 'edit'){
	$class06 = 'act';
}
if($cc == 'users' && $ca == 'changepassword'){
	$class07 = 'act';
}
if($cc == 'addresses' && $ca == 'index'){
	$class08 = 'act';
}
if($cc == 'addresses' && $ca == 'add'){
	$class08 = 'act';
}
if($cc == 'addresses' && $ca == 'edit'){
	$class08 = 'act';
}
if($cc == 'packages' && $ca == 'index'){
	$class09 = 'act';
}
if($cc == 'watchlists' && $ca == 'index'){
	$class10 = 'act';
}
if($cc == 'auctions' && $ca == 'won'){
	$class11 = 'act';
}
if($cc == 'bids' && $ca == 'index'){
	$class12 = 'act';
}
if($cc == 'invites' && $ca == 'index'){
	$class13 = 'act';
}

if($this->params['url']['url'] == 'pages/faq'){
	$class15 = 'act';
}
if($cc == 'news' && $ca == 'index'){
	$class15 = 'act';	
}
if($cc == 'contact' && $ca == 'index'){
	$class15 = 'act';	
}
if($this->params['url']['url'] == 'page/about-us'){
	$class15 = 'act';	
}
if($this->params['url']['url'] == 'pages/testimonial'){
	$class15 = 'act';
}




?>



<li class="myaccount1" style="position:relative;">
<a  class="<?php echo $class01?> tringle_img plus_icon" href="javascript:void(0)"> 
<?php __('All Auctions');?> 
<img class="logo-white" src="<?php echo $this->webroot;?>img/tringle_icon.png"/>
<img class="logo-black" src="<?php echo $this->webroot;?>img/tringle_icon_black.png"/>
</a>
<div class="slide_mayaccount slide_mayaccount_auction" style="display:none">
<a  href="<?php echo $this->webroot; ?>auctions" ><?php __('Live Auctions');?></a>
	<?php if($session->check('Auth.User')){ ?> <a  href="<?php echo $this->webroot; ?>watchlists/index" ><?php __('Mes Favoris');?></a><?php } ?>
 <a  href="<?php echo $this->webroot; ?>auctions/closed"><?php __('Closed Auctions');?></a>
</div>
</li>



<li><a  href="<?php echo $this->webroot; ?>packages" class="<?php echo $class03?>">
<?php __('Bid Packages');?></a></li> 

<li><a  href="<?php echo $this->webroot; ?>categories" class="hide <?php echo $class04?>">
<?php __('Plans');?></a></li> 



<li class="menu_last myaccount1" style="position:relative;">
<a class="<?php echo $class15?> tringle_img plus_icon_how"  href="javascript:void(0)">
<?php __('How CongoBid Works');?> 
<img class="logo-white" src="<?php echo $this->webroot;?>img/tringle_icon.png"/>
<img class="logo-black" src="<?php echo $this->webroot;?>img/tringle_icon_black.png"/>
</a>
<div class="slide_mayaccount slide_mayaccount_how" style="display:none">
 
<a  href="<?php echo $this->webroot; ?>page/how-it-works"><?php __('How It Works');?></a>
<a  href="<?php echo $this->webroot; ?>page/frequently-asked-questions" ><?php __("FAQ's");?></a>
<a  href="<?php echo $this->webroot; ?>contact" ><?php __('Contact Us');?></a>
</div>
</li> 


<li  class="language_top add_padding  <?php if($_COOKIE['lang'] == 'eng'){ echo 'on_lang'; } ?> ">
<a title="English"  href="<?php //echo $this->webroot; ?>?lang=eng"> <img src="<?php echo $this->webroot;?>img/flag_eng.png" title="English" alt="English"/>ENG</a> 
</li>

<li  class="language_top add_padding <?php if($_COOKIE['lang'] == 'fre'){ echo 'on_lang'; } ?>">
<a title="french"  href="<?php //echo $this->webroot; ?>?lang=fre">
<img src="<?php echo $this->webroot;?>img/flag_fre.png" title="french" alt="french"/>
FRE</a>
</li>



<style>
.welcomeuser p{margin: 0px;font-size: 12px;color: #333;}
.welcomeuser p strong{color:#000}
.account-link a{
	font-size: 11px;
	color: #f0710c;
	padding: 0px 10px 0px 0px;
	text-transform: none;
	text-decoration: underline;
}
.account-link a.logout_link{
	color:#ff0000;
}

.account-link a:hover{
	text-decoration:none
}
.timer_arrow #pricear{
	transform: rotate(360deg);
}
.timer_arrow{height: 0px;float: none;display: inline-block;top:9px;}
.top_lang li.on_lang a {opacity:0.5;}
.top_lang li a{font-size: 13px!important;color: #555;}
.top_lang a img{border:1px solid #ccc;position: relative;left: -4px;}
</style>



<?php if($session->check('Auth.User')):?>


<li class="welcomeuser" style="position:relative;">
<p class="user-name"><?php __('Hello') ?>, <strong><?php echo $session->read('Auth.User.username'); ?></strong> </p>
<p class="current-plan"><font class="bid-balance1"><?php __('Current Plan');?>:</font> <strong><?php echo $appConfigurations['subscription_pack'][$user_info['User']['sid']]  ;?></strong></p>
<p class="current-balance">
		<?php __('Bids');?> <strong class="bid-balance"><?php echo (int) $user_info['User']['bid_balance'] ;?></strong>
		<?php __('Bonus');?> <strong class="bbid-balance"><?php echo (int) $user_info['User']['rewards_points'] ;?></strong>
</p>
<p class="account-link">
<a  href="<?php echo $this->webroot; ?>users"><?php __('My Account');?></a>		
<a class="logout_link" href="<?php echo $this->webroot; ?>auctions/logout"><?php __('Logout');?></a>
</p>
</li>







 

<?php else:?>

<div class="fb_element" style="display:none!important;">
<span><?php echo $this->element('fb_element');?></span>
<span><?php if(1 || $_GET['google_login'] == 1 ){ echo $this->element('google_login'); } ?></span>
</div>




<div class="right_link">
<li>
<a class="btn_new  left-animated btn-blue blue_fill" href="<?php echo $this->webroot; ?>users/login">
<?php __('Login') ?></a>

<a class="btn_new   left-animated right-animated btn-blue" href="<?php echo $this->webroot; ?>users/register">
<?php __('Register') ?></a>
</li>
</div>

 <?php endif;?>






 

<style>
li.myaccount .slide_mayaccount {
	border-radius: 0px 0px 6px 6px;
	opacity:0;
	visibility:hidden;
	position:absolute;
	right:0;
	z-index:1000;
	text-align:left;
	top:100px;
	/*
	-webkit-transition:all 0.1s ease-in-out;
	-moz-transition:all 0.1s ease-in-out;
	-ms-transition:all 0.1s ease-in-out;
	-o-transition:all 0.1s ease-in-out;
	transition:all 0.1s ease-in-out;
	*/
}

li.myaccount:hover  .slide_mayaccount {
	opacity:1;
	visibility:visible;
	top:51px;
	/*
	-webkit-transition:all 0.1s ease-in-out;
	-moz-transition:all 0.1s ease-in-out;
	-ms-transition:all 0.1s ease-in-out;
	-o-transition:all 0.1s ease-in-out;
	transition:all 0.1s ease-in-out;
	*/
}




.top_bidbal{
	color: #fff !important;cursor:auto;font-size:16px;padding:0px 8px;margin-right:0;
	margin-left: 6px;
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
.login_menu li.top_bidbal strong{
	border:3px solid #ff9100;
	border-radius: 100px;
	padding: 8px 10px;
	right: -10px;
	position: relative;
	min-width: 50px;
	background: #fff;
	color: #ff9100;
}

.main_error .success:after{	
	background: url(../img/right_icon.png)  no-repeat;
	position:absolute;
	content: '';
	display: block;
	left: 15px;
	top: 25px;
	width: 39px;
	height: 29px;
	background-size: 24px;
}
.main_error .message:after{	
	background: url(../img/close_icon.png)  no-repeat;
	position:absolute;
	content: '';
	display: block;
	left: 15px;
	top: 23px;
	width: 30px;
	height: 30px;
	background-size: 20px;
}
</style>



<script>
 
$(".select_lang").click(function(){
   $('.main_model').show();
}); 

$(document).ready(function () {
    $(document).keydown(function(e){

        if(e.keyCode == 27) {
            $('.main_model').hide();
			$('.popup_model').hide();
			$('.main_model_rank').hide();
        }
    });
})

</script>


