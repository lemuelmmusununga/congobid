<div class="doc_width">
<div id="footer">
<div class="footer_inner">
<div class="footerlink">



<ul>
<li><a href="<?php echo $this->webroot?>page/faq"><?php __('faq');?></a></li>
<li><a href="<?php echo $this->webroot?>page/privacy"><?php __('privacy');?></a></li>
<li><a href="<?php echo $this->webroot?>page/terms"><?php __('terms & conditions');?></a></li>
<li><a href="<?php echo $this->webroot?>contact"><?php __('contact us');?></a></li>
<li><a href="<?php echo $this->webroot?>news"><?php __('news');?></a></li>
<?php 
$wheel_live = Configure::read('Settings.spin_wheel');
if($wheel_live == 1){ ?>  
	<li style="display:none!important;"><a href="<?php echo $this->webroot?>pages/wheel"><?php __('Spin Wheel');?></a></li>
<?php } ?>

</ul>





<ul class="social">
<h1 style="text-transform:uppercase;"><strong><?php __('Follow Us');?></strong></h1>
<li class="social_icon f_icon"><a href="<?php echo Configure::read('Settings.fb_footer_link'); ?>">&nbsp;</a></li>
<li class="social_icon t_icon"><a href="<?php echo Configure::read('Settings.twitter_footer_link'); ?>">&nbsp;</a></li>
<li class="social_icon g_icon"><a href="<?php echo Configure::read('Settings.instagram_footer_link'); ?>">&nbsp;</a></li>
</ul>




<ul class="last_ul">
<a href="<?php echo $this->webroot; ?>invites">
<img src="<?php echo $this->webroot; ?>img/invite_img_<?php echo $appConfigurations['language']; ?>.png"/></a>
</ul>








</div>



</div>
</div>
</div> <!-- google code start fb_footer_link  twitter_footer_link  instagram_footer_link -->
<?php echo Configure::read('Settings.google_analytic_code'); ?>

<!-- google code end -->
