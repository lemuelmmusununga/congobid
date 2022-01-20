<style>
.crumb{display:none;}
</style>



<?php

$ca = $this->params['action'];
$cc = $this->params['controller'];

if($cc == 'users' && $ca == 'index'){
	$class1 = 'act';
}

if($cc == 'users' && $ca == 'edit'){
	$class2 = 'act';
}

if($cc == 'users' && $ca == 'changepassword'){
	$class3 = 'act';
}

if($cc == 'addresses' && $ca == 'index'){
	$class4 = 'act';
}

if($cc == 'packages' && $ca == 'index'){
	$class5 = 'act';
}

if($cc == 'watchlists' && $ca == 'index'){
	$class6 = 'act';
}

if($cc == 'bidbutlers' && $ca == 'index'){
	$class7 = 'act';
}

if($cc == 'auctions' && $ca == 'won'){
	$class8 = 'act';
}

if($cc == 'bids' && $ca == 'index'){
	$class9 = 'act';
}

if($cc == 'accounts' && $ca == 'index'){
	$class10 = 'act';
}

if($cc == 'referrals' && $ca == 'index'){
	$class11 = 'act';
}
if($cc == 'invites' && $ca == 'index'){
	$class12 = 'act';
}

if($cc == 'users' && $ca == 'cancel'){
	$class13 = 'act';
}




?>

<a  onclick="document.getElementById('leftuser').classList.toggle('closed');" class="left-nav-btn" href="javascript:void(0)">&nbsp;</a>

<div id="leftuser" class="leftblock_inner slide_login_user closed">
<ul>

		<li><a class="<?php echo $class1?>" href="/users"><?php __('Dash Board');?></a></li>
		<li><a class="<?php echo $class2?>" href="/users/edit"><?php __('Edit Profile');?></a></li>
		<li><a class="<?php echo $class3?>" href="/users/changepassword"><?php __('Change Password');?></a></li>
		<li><a class="<?php echo $class4?>" href="/addresses"><?php __('My Addresses');?></a></li>


		<li><a class="<?php echo $class5?>" href="/packages"><?php __('Purchase Bids');?></a></li>
		<li><a class="<?php echo $class6?>" href="/watchlists"><?php __('My Watchlist');?></a></li>
		<li><a class="<?php echo $class7?>" href="/bidbutlers"><?php __('My Bid Butlers');?></a></li>
		<li><a class="<?php echo $class8?>" href="/auctions/won"><?php __('Won Auctions');?></a></li>



		<li><a class="<?php echo $class9?>" href="/bids"><?php __('My Bids');?></a></li>
		<li><a class="<?php echo $class10?>" href="/accounts"><?php __('My Account');?></a></li>
				


		<li><a class="<?php echo $class11?>" href="/referrals"><?php __('Referrals');?></a></li>
		<li><a class="<?php echo $class12?>" href="/invites"><?php __('Invite My Friends');?></a></li>
		<li><a class="<?php echo $class13?>" href="/users/cancel"><?php __('Cancel My Account');?></a></li>
</ul>
</div>