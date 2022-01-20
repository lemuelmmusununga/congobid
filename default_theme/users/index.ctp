<style>
.main_model_rank .model_inner{
	top:3%;
}
.darkorange_bg a {
	/*background-color:#ee710c; */
}


</style>
<?php 
$pid = $this->params['pass'][0];
if($pid == 1){
	/* require_once ('/var/www/html/database.php');
	$sqlQuery = "SELECT * FROM tbl_posts WHERE id < '" .$lastId . "' ORDER BY id ASC LIMIT 4";
	$result = mysqli_query($db, $sqlQuery); */
}

 
?>

<div class="box clearfix my-account">
<div class="step_titel">
<div class="doc_width">
<h1><?php echo sprintf(__('My %s', true), $appConfigurations['name']); ?></h1>

</div>

</div>
<div class="main_content">

 <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
 
 
 <div class="doc_width text-center">
 
<div class="row d-flex mar_b_20">

	 <div class="simple_box padd_25 blue_bg radius">
		<p class="simple_box_title"><?php __('You currently have') ;?> </p>
		<p class="box_p"><?php echo sprintf(__('%s bids and %s bonus bids.', true), '<strong>'.(int) $user_info['User']['bid_balance'].'</strong>', '<strong>'.(int) $user_info['User']['rewards_points'].'</strong>');?></p>
		<p>
		<a class="btn_new  left-animated  btn-blue" href="/packages"><?php __('Purchase some bids');?></a>
		<a class="btn_new  left-animated  btn-blue" href="/pages/bids"><?php __('Transfer bids');?></a>	
		<a class="btn_new  left-animated  btn-blue" href="/pages/convert_bids"><?php __('Convert bonus bids');?></a>	
	 </div>
	
	<div class="simple_box padd_25 orange_bg radius">
		<p class="simple_box_title"><?php __('You currently have unpaid');?></p>
		<p class="box_p"><?php echo sprintf(__('%s auction.', true), '<strong>'.$unpaidAuctions.'</strong>');?></p>
		<p>
		<a class="btn_new  left-animated  btn-blue" href="/auctions/won">
		<?php __('View your won auctions');?></a></p>

		<div class="unpaid_bought">
			<?php if($bin_unpaidAuctions > 0){ ?>
			<?php echo sprintf(__('You currently have %s Unpaid Bought Products..', true), '<strong>'.$bin_unpaidAuctions.'</strong>');?>
				<a  href="/auctions/bin"><?php __('View');?></a>
			<?php }?>
		</div>
	</div>

	<div class="simple_box padd_25 green_bg radius">
			<p class="simple_box_title"><?php __('User Registration Information');?></p>
			<p class="box_p"><strong><?php echo $session->read('Auth.User.first_name'). ' '. $session->read('Auth.User.last_name') ; ?> </strong> <?php //__('Username');?>
			</p>
			<p>
			<a class="btn_new  left-animated  btn-blue" href="/users/edit"><?php __('View User Details');?></a></p>
	</div>
</div>
 
 
 
 
 
<div class="row d-flex mar_b_20">
 <div class="simple_box padd_25 darkorange_bg radius">
	<?php 
		$plan_text = 'None';
		if($user['User']['sid'] > 0){
			$plan_text = ' plan '. $appConfigurations['subscription_pack'][$user['User']['sid']] ;
			$now = time(); // or your date as well
			$your_date = strtotime($user['User']['sid_exp']);
			$datediff =  $your_date - $now;
			$exp_days =  round($datediff / (60 * 60 * 24));

		}if($user['User']['sid_exp'] < date('Y-m-d')){
			$user['User']['sid'] = 0 ; $exp_days =  '--';
		}
	?>
		<p class="simple_box_title"><?php __('Your Subscription Details');?></p>
		<p class="box_p"><?php __('Current Plan:');?> <strong> <?php echo __($plan_text); ?>   </strong> 
		<p class="box_p"><?php __('Days remaining:');?> <strong> <?php echo $exp_days; ?>   </strong> 
		</p>
		<p>
			<?php foreach($appConfigurations['subscription_pack'] as $key=>$val){ if($key == 0){ continue;} ?>
			
				<?php if($user['User']['sid'] < $key){
						$plan_price = $appConfigurations['subscription_pack_price'][$key] - $appConfigurations['subscription_pack_price'][$user['User']['sid']];
						 
					?>
					<a rel="<?php echo $key; ?>" rel1="<?php echo $val; ?>" class="btn_new plan_btn  left-animated  btn-blue" href="javascript:void(0);">
					
					
  <?php echo sprintf(__("pay %s bids and Upgrade to Plan %s so you will able to bid products value up to %s", true), $plan_price, $val, $number->currency($appConfigurations['subscription_pack_rrp'][$key]) ); ?>
</a>
 
 
 			
 		
				
				
				</p><?php } ?>
		
				<?php } ?>
</div>



</div>

 







</div>
<br style="clear: both;">
 
 
		<div class="doc_width shadow_bg">			
		<div class="inner_heading text-center"><h1><?php __('Things to do');?></h1></div>
			<div id="rightcol">
			<div class="rightcol_inner">
			
				
		
				
				
				
				
				
				<ul class="to-do">
				<?php if(!empty($userAddress)) : ?>
					<?php foreach($userAddress as $name => $address) : ?>
						<?php if(empty($address)) : ?>
							<?php $count = 1; ?>
							<li><a class="btn_new  animated-btn animated-1" href="/addresses/add/<?php echo $name; ?>"><?php __('Add a');?> <?php echo $name; ?> <?php __('Address');?></a></li>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
				
				<?php if($bidBalance == 0) : ?>
					<?php $count = 1; ?>
					<li><a class="btn_new  animated-btn animated-1" href="/packages"><?php __('Purchase some bids');?></a></li>
				<?php endif; ?>
				
				<?php if($unpaidAuctions > 0) : ?>
					<?php $count = 1; ?>
					<li><a class="btn_new  animated-btn animated-1" href="/auctions/won"><?php __('Pay for an Auction');?></a></li>
				<?php endif; ?>
				
				<?php if(empty($count)) : ?>
					<li><?php __('You have no things to do at the moment.');?></li>
				<?php endif; ?>
				<?php if (Configure::read('Settings.daily_reward_enable')){ ?>	
				<li>
				<a href="javascript:void(0);" class="btn_new  btn_new_orange   animated-btn animated-1 click_rank"><?php __('Daily Login Bonus');?>
		<?php if($user['User']['lgn_cnt'] > 0 &&  $user['User']['lgn_rwd_gvn'] == 0 ) { ?> 
		
		<i class="fa fa-bell faa-ring animated" style="font-size: 17px;margin-left: 10px;"></i>
		
		<?php }?>
				</a>
				</li>
				<?php } ?>
				</ul>
				
                   
                
			</div>                
			</div>
        
    </div> 
    </div>
    </div>
            
			
		
		<div class="main_model_rank">
		<div class="model_inner">
		<h1><?php __('Daily Login Bonus');?></h1>
		<div class="padd_25">
		<h3><?php __('Login in every day to get bigger rewards');?>  </h3>
		
		<div class="row">
		<ul>
		<li class="login_rwd lday_1  toolt">		
		<font class="tooltiptext">   
		<?php echo $arr1[1];?>  
		</font>
	
		
		
		<p><?php __('Day');?> 1</p>
		<p class="day_reward day_1"><?php __('Locked');?></p>
		</li>
		
		<li class="login_rwd lday_2 toolt">
		<font class="tooltiptext">   
		<?php echo $arr1[2];?>  
		</font>
		<p><?php __('Day');?> 2</p>
		<p class="day_reward day_2"><?php __('Locked');?></p>
		</li>	
		
		<li class="login_rwd lday_3 toolt">
		<font class="tooltiptext">   
		<?php echo $arr1[3];?>  
		</font>
		<p><?php __('Day');?> 3</p>
		<p class="day_reward day_3"><?php __('Locked');?></p>
		</li>
		</ul>
		</div>
		
		<div class="row">
		<ul>
		<li class="login_rwd lday_4 toolt">
		<font class="tooltiptext">   
		<?php echo $arr1[4];?>  
		</font>
		<p><?php __('Day');?> 4</p>
		<p class="day_reward day_4"><?php __('Locked');?></p> 
		</li>
		
		<li class="login_rwd lday_5 toolt">
		<font class="tooltiptext">   
		<?php echo $arr1[5];?>  
		</font>
		<p><?php __('Day');?> 5</p>
		<p class="day_reward day_5"><?php __('Locked');?></p>
		</li>	
		
		<li class="login_rwd lday_6 toolt">
		<font class="tooltiptext">   
		<?php echo $arr1[6];?>  
		</font>
		<p><?php __('Day');?> 6</p>
		<p class="day_reward day_6"><?php __('Locked');?></p>
		</li>
		</ul>
		</div>
		
		
		<div class="row main_model_rank_btm">
		<ul>
		<li class="login_rwd lday_7 toolt">
		<font class="tooltiptext">   
		<?php echo $arr1[7];?>  
		</font>
		<p><?php __('Day');?> 7 - <?php __('the big reward');?></p>
		<p class="day_reward day_7"><?php __('Locked');?></p>
		</li>
		</ul>
		
		
		<p>
		<a class="close" href="javascript:void(0);"><img src="/img/close_btn.png" alt="" /></a>
		</p>
		
		
		
		</div>
		
		
		
		</div>
		
		</div>
		</div>
		 
<script>
$('.click_rank').click(function(){	
	$('.main_model_rank').show();
	
});
$('.close').click(function(){
 $('.main_model_rank').fadeOut('slow');
});

$('.plan_btn').click(function(){
 var cnf_txt = '<?php __("Are you Sure? you want to signup for Plan ");?>'; 
 var pid = parseInt($(this).attr('rel')); 
 var p_name = $(this).attr('rel1'); 
 if( confirm(cnf_txt  + p_name + '?') ){
	window.location.href = '/pages/update_plan/' + pid ;
 }
});
<?php

if($user['User']['lgn_cnt'] == 0 || $user['User']['lgn_rwd_gvn'] == 1 ){ ?>
	$('.day_reward').html('Locked');
	  
<?php }else{?>
	$(<?php echo $cls; ?>).html('<p class="getreward">Get Reward</p>');	
	$(<?php echo $cls2; ?>).removeClass('Locked').addClass('get_reward');	 
	console.log('<?php echo $cls2_del. ': get_reward  '  ; ?>'); 
	$('.day_reward').click(function(){
		window.location.href = '/pages/login_reward';
	});
<?php }?>
<?php
 $completed_loop = $user['User']['lgn_cnt']-1;
 if($user['User']['lgn_rwd_gvn']) { $completed_loop = $user['User']['lgn_cnt']; } 
 $k = 0;
 while( $k < $completed_loop ){ $k++; $cls1 = " '.day_$k' "; $cls11 = " '.lday_$k' ";  ?>
	$(<?php echo $cls1; ?>).html('<p class="completed">Completed</p>');
	$(<?php echo $cls11; ?>).removeClass('Locked').addClass('completed');
	console.log('<?php echo $k. ': completed  '  ; ?>'); 	
<?php    }?>


</script>			
