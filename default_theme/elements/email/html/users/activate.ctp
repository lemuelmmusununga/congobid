<p><?php echo sprintf(__('Hi %s', true), $data['User']['first_name']);?>,</p>

<p> Welcome to PokeBidder! In order to activate your account and receive your free bids, click the link below:</p>

<p>
    <a href="<?php echo $data['User']['activate_link'];?>" title="Activate">
        <?php echo $data['User']['activate_link'];?>
    </a>
</p>

 
<p><?php __('Good Luck');?><br/>
<?php echo $appConfigurations['name'];?></p>

<p><?php __('If you received this email by mistake, please contact the administrator here: '.$appConfigurations['url'].'/contact ');?></p>
