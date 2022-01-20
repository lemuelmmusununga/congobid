<style>
.breadcrumb{margin:0 0 10px;}
.seat_auc{ border:1px solid #ccc; padding:10px;}
.seat_auc input{border:1px solid #ccc; padding:10px 25px;margin-left:10px;}


.seat_auc input.btn{  -moz-border-radius:4px;background:url(../../admin/img/menubg.gif) repeat-x left top;
  border-radius:4px;padding:8px 15px; color:#fff;font-size:16px;text-decoration:none;margin:10px 0 10px 94px;display:block;border:none;cursor:pointer;
}

</style>

<?php
$html->addCrumb('Manage Auctions', '/admin/auctions');
$html->addCrumb('Edit Auction', '/admin/'.$this->params['controller'].'/edit/'.$this->data['Auction']['id']);
echo $this->element('admin/crumb');


$sql = mysql_query("SELECT 	u.username, s.id FROM seats s
					LEFT JOIN users u ON s.user_id = u.id
					WHERE s.auction_id = '$id'
 ");
		$res_count   = mysql_num_rows($sql);
		
		

		
?>
<div class="seat_auc">
<form action="/admin/auctions/show_seat/<?php echo $id; ?>" method="post">
<strong>Username:</strong> <input type="text" name="data[Auction][username]">

<input  class="btn" type="submit" value="add user" name="submit">

</form>
</div>

<div class="auctions form">
<p><br /><br />Below is list of user who bought Seats<br /><br /></p>
<?php 
if($res_count > 0) {
			while($seats = mysql_fetch_array($sql, MYSQL_ASSOC)) {
					echo '<b>'.$seats['username'] .' </b>       <a href="/admin/auctions/show_seat/'.$id.'/'.$seats['id'].'">delete</a><br />';
			}
		}

?>

</div>