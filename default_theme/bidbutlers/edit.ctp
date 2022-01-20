<style>
fieldset div.submit {
    margin: 5px 0px 0px 209px !important;
}
.actions{margin-left: 210px;}
fieldset .text label, fieldset.contact .text label, fieldset.contact .select label, fieldset.contact .textarea label{
width:auto
}
</style>
<div class="box clearfix input_line input_only_line">
 <div class="step_titel">
<div class="doc_width"><h1> <?php __('Edit BidBuddies');?></h1></div>
</div>
<div class="main_content">
 <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
		<div class="doc_width shadow_bg">			
			
			<div id="rightcol">
			<div class="rightcol_inner">   
<?php __('Edit My Bid Butler for Auction:');?> <a  href="/auctions/view/<?php echo $bidbutler['Auction']['id']; ?>"><?php echo $bidbutler['Auction']['Product']['title']; ?></a>			
				<fieldset>
				<?php echo $form->create('Bidbutler', array('action' => 'edit/'.$bidbutler['Auction']['id']));?>
				

				<?php if(Configure::read('App.bidButlerType') == 'simple') : ?>
					<p><?php __('Please Note: Your bids will be used when the counter reaches 30 seconds.');?></p>
				<?php endif; ?>

				<?php
					echo $form->input('id');
					if(Configure::read('App.bidButlerType') !== 'simple') :
						echo $form->input('minimum_price', array('label' => 'Minimum Price *'));
						echo $form->input('maximum_price', array('label' => 'Maximum Price *'));
					endif;
					if(Configure::read('App.bidButlerType') !== 'advanced') :
						echo $form->input('bids', array('label' => 'Number of Bids to use *'));
					endif;
				?>
				<?php echo $form->end(__('Save Changes', true));?>
			</fieldset>

			<div class="actions">
				<ul>
					<li><?php echo $html->link(__('<< Back to my bid butlers', true), array('action' => 'index'));?></li>
				</ul>
			</div>
                </div>
			</div>
    </div> 
    </div>
    </div>















