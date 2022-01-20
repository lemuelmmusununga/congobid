
<?php if($session->check('Auth.User')):?>
<li><a class="top_bidbal" href="javascript:void(0)"> <?php __('BIDS') ?>  <label> <?php echo $bidBalance ;?></label> </a></li>
<li><a style="font-family:novecentonormal;cursor:auto;" href="javascript:void(0)"><?php __('Welcome') ?>, <strong><?php echo $session->read('Auth.User.username'); ?></strong></a></li>
<li style="position:relative;"><a  class="plus_icon" href="javascript:void(0)"><img src="<?php echo $this->webroot;?>img/plusicon.png"/></a>

<div class="slide_mayaccount">
<a href="<?php echo $this->webroot; ?>users"><?php __('My Account') ?> </a>
<a  href="<?php echo $this->webroot; ?>auctions/logout"><?php __('Logout') ?> </a>

</div>

</li>




<?php else:?>

<div class="fb_element" style="display:none!important;">
<span><?php echo $this->element('fb_element');?></span>
<span><?php if(1 || $_GET['google_login'] == 1 ){ echo $this->element('google_login'); } ?></span>
</div>



<li><a href="/users/login"> <?php __('Login') ?></a></li> <li class="add_padding"><?php __('or') ?> </li>  <li> <a href="/users/register"><?php __('Register') ?> </a></li>
 <?php endif;?>






<li style="display:none!important;" class="add_padding add_bor <?php if($_COOKIE['lang'] == 'eng'){ echo 'on_lang'; } ?> "><a  href="<?php echo $this->webroot; ?>?lang=eng">EN</a> 
<li style="display:none!important;" class="add_padding <?php if($_COOKIE['lang'] == 'spa'){ echo 'on_lang'; } ?>"><a  href="<?php echo $this->webroot; ?>?lang=spa">ES</a>




<style>

.top_bidbal{background:#ff9100;color:#fff;cursor:auto;font-size:16px;padding:6px 14px;border-radius:18px;margin-right:40px;}
a:hover.top_bidbal{ color:#fff;}
.login_menu li{display:inline-block;}
.login_menu .slide_mayaccount a{width:100%;float:left;color:#fff;padding-top:8px;font-size:14px;}
.login_menu .slide_mayaccount a:hover{color:#ff9100;}
.fb_element{float:right;margin-top:-12px;}
.fb_element span{display:inline-block;}
</style>



<script type="text/javascript">
$('.plus_icon').hover(function(){
	$('.slide_mayaccount').slideToggle();
	
})

</script>

<script type="text/javascript">
$('.plus_icon').click(function(){
	$('.slide_mayaccount').slideToggle();
	
})

</script>