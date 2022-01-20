<style>
.crumb{display:none1;}
.step_titel{margin-bottom:0px;}
/*.shadow_bg{width:750px;}*/
</style>




<?php
$class_1=$class_2=$class_3=$class_4=$class_5=$class_6=$class_7=$class_8=$class_9=$class_10=$class_11=$class_12=''; 
$ca = $this->params['action'];
$cc = $this->params['controller'];

if($cc == 'users' && $ca == 'index'){
	$class_1 = 'act';
}

if($cc == 'users' && $ca == 'edit'){
	$class_2 = 'act';
}

if($cc == 'users' && $ca == 'changepassword'){
	$class_3 = 'act';
}

if($cc == 'addresses' && $ca == 'index'){
	$class_4 = 'act';
}
if($cc == 'addresses' && $ca == 'add'){
	$class_4 = 'act';
}
if($cc == 'addresses' && $ca == 'edit'){
	$class_4 = 'act';
}
if($cc == 'auctions' && $ca == 'won'){
	$class_5 = 'act';
}
if($cc == 'auctions' && $ca == 'bin'){
	$class_6 = 'act';
}if($cc == 'auctions' && $ca == 'reward'){
	$class_13 = 'act';
}

if($cc == 'bids' && $ca == 'index'){
	$class_7 = 'act';
}
if($cc == 'bidbutlers' && $ca == 'index'){
	$class_8 = 'act';
}

if($cc == 'bidbutlers' && $ca == 'add'){
	$class_8 = 'act';
}
if($cc == 'bidbutlers' && $ca == 'edit'){
	$class_8 = 'act';
}
if($cc == 'watchlists' && $ca == 'index'){
	$class_9 = 'act';
}
if($cc == 'accounts' && $ca == 'index'){
	$class_10 = 'act';
}
if($cc == 'referrals' && $ca == 'index'){
	$class_11 = 'act';
}
if($cc == 'referrals' && $ca == 'pending'){
	$class_11 = 'act';
}

if($cc == 'invites' && $ca == 'index'){
	$class_12 = 'act';
}

?>

<div class="user_menu mar_b_20">
<div class="doc_width">



<a  onclick="document.getElementById('leftuser').classList.toggle('closed');" class="left-nav-btn" href="javascript:void(0)"></a>
<div id="leftuser" class="leftblock_inner slide_login_user closed">
<ul>

		<li><a class="<?php echo $class_1 ?>" href="<?php echo $this->webroot; ?>users"><?php __('Dashboard');?></a></li>
		<li><a class="<?php echo $class_2?>" href="<?php echo $this->webroot; ?>users/edit"><?php __('Edit Profile');?></a></li>
		<li><a class="<?php echo $class_3?>" href="<?php echo $this->webroot; ?>users/changepassword"><?php __('Change Password');?></a></li>
		<li><a class="<?php echo $class_4?>" href="<?php echo $this->webroot; ?>addresses"><?php __('My Address');?></a></li>


		<li><a class="<?php echo $class_5?>" href="<?php echo $this->webroot; ?>auctions/won"><?php __('Won Auctions');?></a></li>




		<li><a class="<?php echo $class_7?>" href="<?php echo $this->webroot; ?>bids"><?php __('My Bids');?></a></li>
		<li><a class="<?php echo $class_8?>" href="<?php echo $this->webroot; ?>bidbutlers"><?php __('My BidBuddies');?></a></li>
		<li><a class="<?php echo $class_9?>" href="<?php echo $this->webroot; ?>watchlists"><?php __('Watchlists');?></a></li>
		 <li><a class="<?php echo $class_10?>" href="<?php echo $this->webroot; ?>accounts"><?php __('My Congo Bid');?></a></li>
		<li><a class="<?php echo $class_11?>" href="<?php echo $this->webroot; ?>referrals"><?php __('Referrals');?></a></li>
		<li><a class="<?php echo $class_12?>" href="<?php echo $this->webroot; ?>invites"><?php __('Invite Friends');?></a></li>
		 
				
 
</ul>
</div>


</div>
</div>
<script>
setTimeout(function(){ 
$('#leftuser').addClass('add_ani');
}, 100);
</script>