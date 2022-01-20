<style>
.shadow_bg{width:1360px!important}
</style>
 <div class="box clearfix">
 <div class="step_titel">
 
<div class="doc_width"><h1> <?php __('Referrals');?></h1>
<?php
				$html->addCrumb('Referrals', '/referrals');
				echo $this->element('crumb_user');
				?>
</div>
 
</div>
<div class="main_content">
 
 <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
		<div class="doc_width shadow_bg">						
			<div id="rightcol">
			<div class="rightcol_inner">            
				
                
                <div class="mange_space">                
				<p><?php echo sprintf(__('Earn %s free bids on the first bid package that any of your referrals purchase.', true), '<strong>'.$setting.'%</strong>');?></p>
				
				<p><?php __('Ask the new user to enter in your username or email address in the \'Referrer\' box when they register, or simply ask them to vist the following link:');?>
				<?php echo $appConfigurations['url']; ?>/users/register/<?php echo $session->read('Auth.User.username'); ?>
				</p>
				
				<p>
				<?php echo sprintf(__('Promoting your referral link through social media is the easiest way to obtain referrals.', true), '<a href="/invites">
				<?php __("clicking here");?></a>');?></p>
				
				<h2><?php __('Pending Referrals');?></h2>
				
				<p><?php __('Pending referrals are users whom you have referred, that have not purchased bids yet.');?><br /><br />
				<a class="btn_new  animated-btn animated-1 small_btn" href="/referrals/pending"><?php __('Click here to view your pending referrals');?></a></p>
				
				<h2><?php __('Confirmed Referrals');?></h2>
				
				
				<?php if(!empty($referrals)) : ?>
				
					<p><?php __('You have referred and received free bids for signing up the following users.');?></p>
				
					<?php echo $this->element('pagination'); ?>
				<div class="table-responsive">
					<table class="results" cellpadding="0" cellspacing="0">
						<tr>
							<th><?php echo $paginator->sort('User.username');?></th>
							<th><?php echo $paginator->sort('User.first_name');?></th>
							<th><?php echo $paginator->sort('User.last_name');?></th>
							<th><?php echo $paginator->sort('Date Joined', 'Referral.created');?></th>
							<th><?php echo $paginator->sort('Date Bids Given', 'Referral.modified');?></th>
						</tr>
						<?php
						$i = 0;
						foreach ($referrals as $referral):
							$class = null;
							if ($i++ % 2 == 0) {
								$class = ' class="altrow"';
							}
						?>
						<tr<?php echo $class;?>>
							<td>
								<?php echo $referral['User']['username']; ?>
							</td>
							<td>
								<?php echo $referral['User']['first_name']; ?>
							</td>
							<td>
								<?php echo $referral['User']['last_name']; ?>
							</td>
							<td>
								<?php echo $time->niceShort($referral['Referral']['created']); ?>
							</td>
							<td>
								<?php echo $time->niceShort($referral['Referral']['modified']); ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</table>
					</div>
				
					<?php echo $this->element('pagination'); ?>
				
				<?php else:?>
					<p><?php __('You have not referred any members yet.');?></p>
				<?php endif;?>
                </div>
				
				<img class="refrel_img" src="/img/refer_img.jpg" alt="">
                </div>
			</div>
    </div> 
    </div>
    </div>
