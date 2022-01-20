 <div class="box clearfix">
 <div class="step_titel">
 
<div class="doc_width"><h1> <?php __('Referrals');?></h1></div>
 
</div>
<div class="main_content">
 
 
		<div class="main_content_middle">			
			<div id="leftcol">
				<?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
			</div>
			<div id="rightcol">
			<div class="rightcol_inner">            
				<?php
				$html->addCrumb('Referrals', '/referrals');
				echo $this->element('crumb_user');
				?>
                
                <div class="mange_space">                
				<p><?php echo sprintf(__('Earn %s free bids each time you refer a user who signs up and purchases some bids.', true), '<strong>'.$setting.'</strong>');?></p>
				
				<p><?php __('Ask the new user to enter in your username or email address in the \'Refer\' box when they register, or simply ask them to vist the following link:');?>
				<div>
				<?php echo $appConfigurations['url']; ?>/users/register/<?php echo $session->read('Auth.User.username'); ?>
				</p>
				
				<p><?php echo sprintf(__('You can also invite members from various social network websites and popular free email services by %s.', true), '<a href="/invites">
				<?php __("clicking here");?></a>');?></p>
				
				<h2><?php __('Pending Referrals');?></h2>
				
				<p><?php __('Pending referrals are users who you have referred who have not purchased any bids yet.');?><br />
				<a href="/referrals/pending"><?php __('Click here to view your pending referrals');?></a></p>
				
				<h2><?php __('Confirmed Referrals');?></h2>
				
				
				<?php if(!empty($referrals)) : ?>
				
					<p><?php __('You have referred and received free bids for signing up the following users.');?></p>
				
					<?php echo $this->element('pagination'); ?>
				
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
				
					<?php echo $this->element('pagination'); ?>
				
				<?php else:?>
					<p><?php __('You have not referred any members yet.');?></p>
				<?php endif;?>
                </div>
                </div>
			</div>
    </div> 
    </div>
    </div>
