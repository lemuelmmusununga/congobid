<style>
.homepage_admin_box{min-height:270px;}
.btm_padd{ padding-bottom:2px;margin-bottom:0px;}
.add_height{min-height:236px;}
table tr.altrow td{padding:0px }
table tr td{ padding:7px 8px 7px 8px!important;}
.search_text{display:none;}
.search_view{border:none;}
.homepage_admin_box{margin-bottom:0px;}
</style>
<?php
$html->addCrumb(__('Dashboard', true), '/admin');
echo $this->element('admin/crumb');
require_once $_SERVER['DOCUMENT_ROOT'].'/database.php';
$live_auction_cost = mysqli_query($db," SELECT a.id, p.rrp FROM auctions a  LEFT JOIN products p ON a.product_id = p.id where closed = 0 AND a.end_time > '".date('Y-m-d H:i:s')."'   " );

?>
<?php if (isset($_GET['is_home'])): ?>
	 
<?PHP else: ?>



	<blockquote><p><strong>Welcome to the Admin Panel dashboard</strong>. From here you can administer every aspect of your website. You may wish to start by <?php echo sprintf(__('%s an auction', true), $html->link(__('creating', true), array('controller' => 'auctions', 'action'=>'index')));?> or <?php echo sprintf(__('%s.', true), $html->link(__('checking your site settings', true), array('controller' => 'settings', 'action'=>'index')));?></p></blockquote>

	 


<table class="maintable" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  
    <td class="divider">
    <div class="homepage_admin_box homepage_admin_box2 order_box">
	<h1><img src="<?php echo $appConfigurations['url']?>/admin/img/recent1_icon.png" class="absmiddle" alt="" />&nbsp; <?php __('Recent Transaction');?></h1>
    <div class="spacediv">
	<table cellspacing="0" cellpadding="0" border="0" style="width:100%;">
  	<tbody>
	<?php 
	//$accounts = mysql_query("SELECT a.id,a.order_id,a.price, u.username,u.email, a.created FROM accounts a LEFT JOIN users u ON a.user_id = u.id ORDER BY a.id DESC LIMIT 3");
	while(0 && $account = mysql_fetch_array($accounts, MYSQL_ASSOC) ){
	?>
    <tr>
      <td width="20%" valign="middle" height="45" class="ord_1"><a href="#">Order #<?php echo  $account['order_id'];  ?></a></td>
      <td width="30%"><?php echo  date('Y-m-d', strtotime($account['created']));  ?><br>
        <b> <?php echo  $account['price'];  ?></b></td>
      <td width="50%"><?php echo  $account['username'];  ?><br>
        <?php echo  $account['email'];  ?></td>
    </tr>
	<?php } ?>
    
        
	        
        
      </tbody>
    </table>
	<div class="search_view">
<div class="search_text">
  <input type="text" placeholder="Order Number" id="order_num">
  <input type="button" id="search_order" value="">
</div>
<div class="view"> <a href="/admin/accounts">View All Orders &gt;&gt;</a> </div>
</div>
	 </div>
	</div>
    </td>
    
    <td class="divider">
    <div class="homepage_admin_box homepage_admin_box2 order_box">
	<h1><img src="<?php echo $appConfigurations['url']?>/admin/img/onlineuserslarge.png" alt="" class="absmiddle" />&nbsp; <?php __('New Customers');?></h1>
    <div class="spacediv">
	<table cellspacing="0" cellpadding="0" border="0" style="width:100%;">
  <tbody>
  <?php 
	//$users = mysql_query("SELECT u.id,u.first_name,u.last_name, u.username, u.email, u.created FROM users u WHERE u.autobidder = 0  ORDER BY u.id DESC LIMIT 3");
	while( 0 &&  $user = mysql_fetch_array($users, MYSQL_ASSOC) ){
	?>
    <tr>
      <td valign="middle" height="45"><span><a href="user_view_details.php?userid=7"><?php echo $user['first_name']. ' '. $user['last_name'] ;  ?></a></span><br>
       <?php echo $user['email']  ;  ?></td>
      <td> <?php echo $user['username']  ;  ?><br>
         <?php echo  date('Y-m-d', strtotime($user['created']));  ?></td>
    </tr>
	<?php } ?>
         
    
        
        
      </tbody>
    </table>
    <div class="search_view">
<div class="search_text">
  <input type="text" placeholder="Order Number" id="order_num">
  <input type="button" id="search_order" value="">
</div>
<div class="view"> <a href="/admin/users">View All customers &gt;&gt;</a> </div>
</div>
		
	</div>
	</div>
    </td>
    
    <td class="divider">
    <div class="homepage_admin_box homepage_admin_box2 order_box">
	<h1><img src="<?php echo $appConfigurations['url']?>/admin/img/quote1_icon.png" class="absmiddle" alt="" />&nbsp; Recent Won auction</h1>
    <div class="spacediv">
	<table cellspacing="0" cellpadding="0" border="0" style="width:100%;">
  <tbody>
  <?php 
	/*$auctions = mysql_query("SELECT a.id,a.price, u.username,u.email, a.end_time , p.title 
							FROM auctions a 
							LEFT JOIN users u ON a.winner_id = u.id 
							LEFT JOIN products p ON a.product_id = p.id 
							WHERE a.winner_id > 0 AND a.closed = 1 ORDER BY a.end_time DESC LIMIT 3");*/
	while(0 &&  $auction = mysql_fetch_array($auctions, MYSQL_ASSOC) ){
	?>
    <tr>
      <td valign="middle" height="45">Title: <a href="/auctions/view/<?php echo $auction['id'];  ?>"><?php echo $auction['title'];  ?></a><br>
       Winner: <?php echo $auction['username'];  ?></td>
      <td><span> <?php echo  date('Y-m-d', strtotime($auction['end_time']));  ?></span></td>
    </tr>
	<?php } ?>
          
   </tbody>
</table>

<div class="search_view">
<div class="search_text">
  <input type="text" placeholder="Order Number" id="order_num">
  <input type="button" id="search_order" value="">
</div>
<div class="view"> <a href="/admin/auctions/won">View All Won Auctions &gt;&gt;</a> </div>
</div>

    </div>
	</div>
    </td>
    
  </tr>
</table>








<table class="maintable" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="divider">
    <div class="homepage_admin_box add_height">
			<h1 class="title2"><img src="<?php echo $appConfigurations['url']?>/admin/img/onlineuserslarge2.png" class="absmiddle" alt="" />&nbsp; <?php __('Online Users');?></h1>
                <div class="spacediv">
			<p>
				<?php echo sprintf(__('There are %d online user(s) at the moment. </br>', true), number_format($onlineUsers));?> (<?php echo $html->link(__('View who\'s online', true), array('controller' => 'users', 'action'=>'online')); ?>)
			</p>


			<h2 class="btm_padd"><?php __('Users');?></h2>
			<p><?php echo sprintf(__('%s the users who are registered on the site.', true), $html->link(__('Manage', true), array('controller' => 'users', 'action'=>'index')));?></p>


			<h2 class="btm_padd"><?php __('Auctions');?></h2>
			<p><?php echo sprintf(__('%s and control your auctions.', true), $html->link(__('Manage', true), array('controller' => 'auctions', 'action'=>'index')));?></p>
			
			<?php 

			if (Configure::read('Settings.autobidders')) { ?>
				<p><?php echo __('Warning: Autobidders are <strong>enabled</strong>.'); ?>
					<?php echo $html->link(__('Change', true), '/admin/settings/edit/autobidders'); ?>
					</p>	
			<?php }else{ ?>
				<p><?php /*__('Autobidders are <strong>disabled</strong>'); */?></p>
			<?php }?>
			<?php
			if (isset($warn_version)) {
				?>
				<p><?php echo __('Warning: Your database version is incorrect. Please upgrade your database or contact support for assistance.') ?></p>
				<?php
			}
			?>
				
			<?php eval(AddonManager::hook('views_dashboards_adminindex_box1')); ?>
            </div>
	</div>
    </td>
    
    <td class="divider">
    <div class="homepage_admin_box homepage_admin_box2 order_box add_height">
	<h1 class="title2"><img src="<?php echo $appConfigurations['url']?>/admin/img/doller_negiran.png" alt="" class="absmiddle" />&nbsp; <?php __('Quick sales Overview');?></h1> 
    <div class="spacediv">
	<table cellspacing="0" cellpadding="0" border="0" style="width:100%;">
  <tbody>
      <?php
		$last_auc = mysqli_fetch_array(mysqli_query($db,"SELECT end_time FROM auctions where closed = 1 ORDER BY id DESC "), MYSQLI_ASSOC);
		$totla_income = mysqli_fetch_array(mysqli_query($db,"SELECT SUM(price) as total FROM accounts where id > 0 "), MYSQLI_ASSOC);
     
		   
      ?>
    <tr>
      <td valign="middle" ><span><?php __('Total :');?></span> </td>
      <td><?php echo $number->currency($totla_income['total'] * 0.01 , $appConfigurations['currency']); ?></td>
    </tr> <tr>
      <td valign="middle" ><span><?php __('Today:');?></span> </td>
      <td><?php echo $number->currency($dailyIncome * 0.01 , $appConfigurations['currency']); ?></td>
    </tr>
    
      <tr>
      <td valign="middle" ><span><?php __('Todays Bids');?></span> </td>
      <td><?php echo  $dailyIncome  ?></td>
     </tr>
       
      <tr>
      <td valign="middle" ><span><?php __('last closed auction time:');?></span> </td>
      <td>
      <?php 
          while($res = mysqli_fetch_array($live_auction_cost,MYSQLI_ASSOC) ){
            $id = $res['id'];
            $price = $res['rrp'];
            $total_price +=  $price;
            echo "<br /> id: $id, Price: $price";
          }

          echo '<br /><br /> Total: '. $total_price ;
          echo '<br /> Real user can win: '  ;
          echo ( ($dailyIncome * 0.01) >= $total_price   ) ? 'Yes' : 'no' ;
      ?>
      </td>  
     </tr>       
     
              
      </tbody>
    </table>
	</div>
	</div>
    </td>
    
<td class="divider">

    <div class="homepage_admin_box homepage_admin_box2 order_box add_height">
	<h1 class="title2"><img src="<?php echo $appConfigurations['url']?>/admin/img/shoppingbasketlarge2.png" class="absmiddle" alt="" />&nbsp; <?php __('Latest Bids');?></h1>
    <div class="spacediv">
    
	<table cellspacing="0" cellpadding="0" border="0" style="width:100%;">
	<?php if(!empty($bids)):?>    
  	<tbody>
    
    
    
    <tr>
			<th><?php __('Username');?></th>
			<th><?php __('Auction');?></th>
			<th><?php __('Bid Placed');?></th>
		</tr>
<?php
		$i = 0;
		foreach ($bids as $bid):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>        
    
    
   <tr<?php echo $class;?>>
      <td width="20%" valign="middle"  class="ord_1"><?php echo $html->link($bid['User']['username'], array('controller' => 'users', 'action' => 'view', $bid['User']['id'])); ?></td>
      
      <td width="30%">
					<?php echo $html->link( $text->truncate($bid['Auction']['Product']['title'],18), array('admin' => false, 'controller' => 'auctions', 'action' => 'view', $bid['Auction']['id']), array('target' => '_blank')); ?>
                    
                    
                     
                    
				</td>
                
      <td width="50%">
	   <?php echo $time->niceShort($bid['Bid']['created']); ?>
	   </td>  
       </tr>
    
    	<?php
		endforeach;
		?>
        
        
        
        <tr>
        <td colspan="3" style="border:none;">
        
        <div class="view" style="padding:0px 8px 5px 0px"><?php echo $html->link(__('View all bids &gt;&gt;', true), array('controller' => 'bids', 'action' => 'index')); ?></div>
	<?php else:?>
		<p class="sapcepadd"><?php __('There have not been any bids placed on the site yet.');?></p>
	<?php endif;?>
        
        </td>
        </tr>
    
      </tbody>
     
      
     
    </table>  
     
		
	
	<?PHP endif; ?> 	
	 </div>
	</div>
 
    </td>    
    
</tr>
</table>
    
