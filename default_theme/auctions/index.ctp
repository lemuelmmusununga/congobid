
<div class="step_titel">
<div class="doc_width"><h1><?php __('Live Auctions'); ?></h1></div>
</div>
<div class="doc_width">
   

    <?php if(!empty($auctions)) : ?>
    <?php echo $this->element('auctions'); ?> <?php echo $this->element('pagination'); ?>
    <?php else: ?>
    <div class="align-center off_message">
      <p>
        <?php __('There are no live auctions at the moment.');?>
      </p>
    </div>
    <?php endif; ?>
    <br class="clear_l">
    <div class="crumb_bar">
      <?php
			$html->addCrumb(__('Live Auctions', true), '/auctions');
			echo $this->element('crumb_auction');
			?>
    </div>

  
</div>

