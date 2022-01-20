<p><?php echo sprintf(__('Hi %s', true), $data['User']['first_name']);?>,</p>

<p><?php echo sprintf(__('You recently requested to reset your password for your  %s account.', true), $appConfigurations['name']);?>.</p>

<p><?php __('Your new login details are:');?>:<br />
<?php __('Username');?>: <?php echo $data['User']['username'];?><br />
<?php __('Password');?>: <?php echo $data['User']['before_password'];?>
</p>

<p>If you did not request a password reset, please ignore this email, or reply to let us know. You can now login <a href="<?php echo $appConfigurations['url'];?>/users/login"> here </a></p>

<p><?php __('Please change your password immediately after logging back in.');?></p>

<p><?php __('Thank You');?><br/>
<?php echo $appConfigurations['name'];?></p>
 