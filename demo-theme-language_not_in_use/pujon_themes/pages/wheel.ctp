<SCRIPT type="text/javascript" src="<?php echo $appConfigurations['nml_url'];?>/css/divbox.js"></SCRIPT>

<style>
.left_part{
	width:628px;
	margin:0 auto;
}
</style>

<div class="box clearfix">
<div class="step_titel">
<div class="doc_width">
<h1><?= __('Spin The Wheel') ?></h1>
</div>


</div>




<div class="main_content">
<div class="main_content_middle">			
<p><?= __('NOTE: Once wheel is stoped you can reload page to see your updated balance OR') ?> <a href="/bids"><?= __('click here') ?></a><?= __('to see his histories') ?> </p>
   <div class="left_part">
            
            <br style="clear:both;">
            
            <?php if($session->check('Auth.User')):?>
			<div id="flashContent">
			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="627" height="591" id="wheel" align="middle">
				<param name="movie" value="https://www.weigrate.com/webroot/games/wheel/wheel.swf" />
				<param name="quality" value="transparent" />
				<param name="bgcolor" value="#000000" />
				<param name="play" value="true" />
				<param name="loop" value="true" />
				<param name="wmode" value="transparent" />
				<param name="scale" value="showall" />
				<param name="menu" value="true" />
				<param name="devicefont" value="false" />
				<param name="salign" value="" />
				<param name="allowScriptAccess" value="sameDomain" />
				<param name=FlashVars value="phpurl=https://www.pujon.co/webroot/games/wheel/" />
				<!--[if !IE]>-->
				<object type="application/x-shockwave-flash" data="https://www.pujon.co/webroot/games/wheel/wheel.swf" width="627" height="591">
					<param name="movie" value="https://www.pujon.co/webroot/games/wheel/wheel.swf" />
					<param name="quality" value="transparent" />
					<param name="bgcolor" value="#000000" />
					<param name="play" value="true" />
					<param name="loop" value="true" />
					<param name="wmode" value="transparent" />
					<param name="scale" value="showall" />
					<param name="menu" value="true" />
					<param name="devicefont" value="false" />
					<param name="salign" value="" />
					<param name="allowScriptAccess" value="sameDomain" />
					<param name="FlashVars" value="phpurl=https://www.pujon.co/webroot/games/wheel/" />
				<!--<![endif]-->
					<a href="https://www.adobe.com/go/getflash">
						<img src="https://www.adobe.com/matts/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
					</a>
				<!--[if !IE]>-->
				</object>
				<!--<![endif]-->
			</object>
		</div>
			<?php else:?>
            <span><a href="/users/login" class="popup" rel="box_id"><img style="width:97%;" src="<?php echo $this->webroot;?>img/spinwheel_bg.jpg"/></a></span>
            
              
            
            <?php endif;?>
            
            	 
            
            

            
            </div>
            
            
            
            
            
            
</div> 

</div>
</div>
