<div class="block">
<h1><?php __('Purchase Bid Packs');?></h1>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th><?php __('Package');?></th>
    <th><?php __('Price');?> </th>
    <th><?php __('Saving');?></th>
  </tr>
  <?php 
	$sql = mysql_query("SELECT * FROM packages ");
	while($packages = mysql_fetch_array($sql, MYSQL_ASSOC)) {

  ?>
  <tr>
    <td style="width:90px;"><?php echo $packages['bids']; ?></td>
    <td style="width:95px;"><?php echo $number->currency($packages['price']  / $packages['bids'] ) ; ?></td>
    <td><?php echo $number->currency($packages['price']); ?></td>
  </tr>
  <?php } ?>
</table>

<div class="buybid"><a  href="/payment_gateways/paypal/package/<?php echo $packages['id'] ; ?>"><img src="<?php echo $this->webroot;?>img/buybid_btn.png"/></a></div>
</div>


<div class="block">
<h1><?php __('Letest Winners');?></h1>

<?php echo $this->element('latest_winner');?>


</div>


<div class="block">
<h1><?php __('Auction Types');?></h1>
<ul>
<li class="penny_icon"><?php __('Penny Auctions');?></li>
<li class="reserve_icon"><?php __('Reserve Auction');?></li>
<li class="nail_icon"><?php __('Nail Bitter Auction');?></li>
<li class="featured_icon"><?php __('Featured Auction');?> </li>
<li class="beginner_icon"><?php __('Beginner Auction');?></li>
<li class="peak_icon"><?php __('Peak Only Auction');?></li>
<li class="free_icon"><?php __('Free Auction');?></li>
</ul>
</div>
