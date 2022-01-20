<?php
function get($name = null, $auction_id = null, $cache = true) {
	global $config;
	global $db;

	if($cache == true) {
		$setting = cacheRead('cake_'.$name);

		if(!empty($setting)) {
			return $setting;
		} else {
			$setting = mysqli_fetch_array(mysqli_query($db,"SELECT value FROM settings WHERE name = '$name'"), MYSQLI_ASSOC);
			if(!empty($setting)) {
				return $setting['value'];
			} else {
				return false;
			}
		}
	}

	// then this is a dynamic setting that we are getting
	if($config['App']['bidIncrements'] == 'single') {
		$settings = mysqli_fetch_array(mysqli_query($db,"SELECT * FROM setting_increments"), MYSQLI_ASSOC);
	} elseif($config['App']['bidIncrements'] == 'dynamic') {
		$auction = mysqli_fetch_array(mysqli_query($db,"SELECT price FROM auctions where id = ".$auction_id), MYSQLI_ASSOC);
		$price = $auction['price'];
		$settings = mysqli_fetch_array(mysqli_query($db,"SELECT * FROM setting_increments where lower_price <= $price AND upper_price > $price and `product_id`=0"), MYSQLI_ASSOC);

		if(empty($settings)) {
			// lets check to see if the price is in the upper region
			$settings = mysqli_fetch_array(mysqli_query($db,"SELECT * FROM setting_increments where lower_price <= $price AND upper_price = '0.00'  and `product_id`=0"), MYSQLI_ASSOC);
		}

		if(empty($settings)) {
			// lets check to see if the price is in the lower region
			$settings = mysqli_fetch_array(mysqli_query($db,"SELECT * FROM setting_increments where lower_price = '0.00' AND upper_price > $price  and `product_id`=0"), MYSQLI_ASSOC);
		}

		if(empty($settings)) {
			// finally if it fits none of them for some strange reason
			$settings = mysqli_fetch_array(mysqli_query($db,"SELECT * FROM setting_increments"), MYSQLI_ASSOC);
		}
	} elseif($config['App']['bidIncrements'] == 'product') {
		$auction = mysqli_fetch_array(mysqli_query($db,"SELECT product_id FROM auctions where id = ".$auction_id), MYSQLI_ASSOC);
		$settings = mysqli_fetch_array(mysqli_query($db,"SELECT * FROM setting_increments WHERE product_id = ".$auction['product_id']), MYSQLI_ASSOC);
	}

	return $settings[$name];
}

function is_live_server(){
	$host = $_SERVER['HTTP_HOST'];
	$host1 = str_replace('www.','', $host);
	  
	if($host1 == 'congobid.com'){  
		return true;
	}else{  
		return false;
	}
}function is_test_server(){
	$host = $_SERVER['HTTP_HOST'];
	$host1 = str_replace('www.','', $host);
	 
	if($host1 !== 'congobid.com'){  
		return false;
	}else{  
		return true;
	}
}

function checkCanClose($id,  $timeCheck = true) {
	
	global $config;global $db;
	
	$skip_leader_check=false;
	$skip_bidbutlers=false;

	 
	$auction = mysqli_fetch_array(mysqli_query($db,"SELECT a.id, a.end_time, a.max_end_time, a.max_end, a.peak_only, a.price, a.minimum_price,
	 a.reverse, a.free, a.autobids, a.leader_id, a.autobid_on,a.ab_winning, p.autobid_limit, a.random FROM auctions a, products p WHERE a.deleted=0 AND a.id = $id AND a.product_id = p.id"), MYSQLI_ASSOC);
	echo '<br /> checkCanClose fucntion ' ; 
 
	$autobid_enabled = true;
 	if ($config['App']['autobids'] === 0 || $auction['autobid_on'] == 0 ) {
		$autobid_enabled = false;  
	}
	if (get('real_can_win')) {
		return true;  
	} 
	 
	if($timeCheck == true) {
		// lets check to see if the end_max_time is on, and if so we HAVE to close the auction
		if(!empty($auction['max_end'])) {
			if(strtotime($auction['max_end_time']) < time()) {
				logIt($auction['id'].' hit max_end_time');
				echo '<br /> 11' ; return true; 
			}
		}

		// lets check if it has actually expired
		if(strtotime($auction['end_time']) > time()) {
			logIt($auction['id'].' expired');
			//echo '<br /> 22' ;return false;
		}
	}

	  
	if ($autobid_enabled) {  
		// lets adjust the autobid limit
		//$auction['autobid_limit'] = adjustAutobidLimit($auction['id'], $auction['autobid_limit'], $auction['random']);
		
		if($auction['ab_winning'] == 0){  
			echo '<br /> ab_not_winning so bid again' ; return false; 
		}
		 
			/*if($auction['autobid_limit'] > 0   ) {
				if($auction['autobids'] <= $auction['autobid_limit']  || ($auction['price'] < $auction['minimum_price']) ) { 
					logIt($auction['id'].' can still autobid');
					echo '<br /> 66' ;return false;
				}
			} */

			  	if( $auction['price'] < $auction['minimum_price']  ) { 
 					echo '<br /> 66' ;return false;
				}
			  
		 
		 
	} 
	
	
	if(0) {
	    //bid butlers can't extend an auction that's hit zero 
	    if (!($auction['reverse'] && $auction['price']<=0)) {

		    // finally lets check that there are no bid butlers left to be placed
		    if($config['App']['bidButlerType'] == 'simple') {
			    $sql = mysqli_query($db,"SELECT id, user_id FROM bidbutlers WHERE bids > 0 AND auction_id = ".$auction['id']." AND user_id != ".$latest_bid['user_id']);
		    } else {
			    if ($auction['reverse']) {
				    //reverse auction lacks max price check
				    $sql = mysqli_query($db,"SELECT id, user_id FROM bidbutlers WHERE bids > 0 AND minimum_price >= '".$auction['price']."' AND auction_id = ".$auction['id']." AND user_id != ".$latest_bid['user_id']);
			    } else {
				    $sql = mysqli_query($db,"SELECT id, user_id FROM bidbutlers WHERE bids > 0 AND minimum_price <= '".$auction['price']."' AND maximum_price > '".$auction['price']."' AND auction_id = ".$auction['id']." AND user_id != ".$latest_bid['user_id']);
			    }
		    }

		    $totalRows = mysqli_num_rows($sql);
		    logIt($auction['id'].'; '.$totalRows.' bidbutlers waiting, not closing yet');
		    if($totalRows > 0) {
			    //if($config['App']['bidButlerType'] == 'advanced') {
			    //	return false;
			    //} else {
				    // go through each of them and make sure that they have bids left in their account
				    while($bidbutler = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
					    if(!empty($config['App']['limits']['active'])) {
						    $limits_exceeded = limitsCanBid($auction['id'], $bidbutler['user_id'], $auction['product_id'], false);
						    if($limits_exceeded == false) {
							    //this bidbutler has limits exceeded, don't let it block auction close
							    logIt($auction['id'].' '.$data['user_id'].' - bid butler invalid, limits exceeded');
								echo '<br /> 99' ; continue;
						    }
					    }

					    if(balance($bidbutler['user_id']) > 0) {
						    logIt('bidbutler '.$bidbutler['id'].' has bids left');
						    echo '<br /> 10 10' ;return false;
					    }
				    }
			    //}
		    }
	    } else {
		    logIt($auction['id']. " reverse auction hit 0");
			echo '<br /> 11 11 ' ; return true;
	    }
	}
	
	return true;
}

function lastBid($auction_id = null) {
	global $db;
	 
	$res=mysqli_query($db,"SELECT 	id,  
					debit, 
					description, 
					user_id, 
					created 
					FROM bids
					WHERE auction_id = $auction_id AND unblk=0 AND blk=0 
					ORDER BY id DESC
					LIMIT 1");
	$lastBid = mysqli_fetch_array($res, MYSQLI_ASSOC);
	mysqli_free_result($res);
								
	$bid = array();

	if(!empty($lastBid)) {
		//*** Performance is better to do a simple query here than to do a JOIN in the query above
		$res=mysqli_query($db,"SELECT 	autobidder,
						username
						FROM users
						WHERE id='".$lastBid['user_id']."'");
		$user=mysqli_fetch_array($res, MYSQLI_ASSOC);
		mysqli_free_result($res);
		
		
		$bid = array(
			'debit'       => $lastBid['debit'],
			'created'     => $lastBid['created'],
			'username'    => $user['username'],
			'description' => $lastBid['description'],
			'user_id'     => $lastBid['user_id'],
			'autobidder'  => $user['autobidder']
		);
	}
	return $bid;
}

function check($auction_id, $end_time, $data, $smartAutobids = false) {
	// lets check to see if there are no bids in the que already
	$autobid = mysqli_fetch_array(mysqli_query($db,"SELECT * FROM autobids WHERE auction_id = $auction_id"), MYSQLI_ASSOC);

	if(!empty($autobid)) {
		if($autobid['end_time'] == $end_time) {
			if($autobid['deploy'] <= date('Y-m-d H:i:s')) {
				// lets place the bid!
				placeAutobid($auction_id, $data, $smartAutobids, time() - $end_time);
				mysqli_query($db,"DELETE FROM autobids WHERE auction_id = $auction_id");

				$auction = mysqli_fetch_array(mysqli_query($db,"SELECT end_time FROM auctions WHERE id = $auction_id"), MYSQLI_ASSOC);
				$end_time = $auction['end_time'];
			} else {
				return false;
			}
		} else {
			mysqli_query($db,"DELETE FROM autobids WHERE auction_id = $auction_id");
		}
	}

	$str_end_time = strtotime($end_time);
	$timeDifference = $str_end_time - time();
	$randomTime = rand(3, $timeDifference);
	$deploy = date('Y-m-d H:i:s', $str_end_time - $randomTime);

	mysqli_query($db,"INSERT INTO autobids (deploy, end_time, auction_id) VALUES ('$deploy', '$end_time', '$auction_id')");

	return $data;
}

function placeAutobid($id) {
	
	global $config;global $db;
	
	if ($config['App']['autobids']==false) {
		return null;	
	}
	echo '<br /> place autobid functio 1n  : '.$id ;
	
	logIt("Autobidding $id");
	
	$data['auction_id']	= $id;

	$bid = lastBid($id);

	if(!empty($bid)) {
		$bidder = $bid['user_id'];
 
		if(empty($user)) {
 			$user = mysqli_fetch_array(mysqli_query($db,"SELECT id FROM users WHERE aid = $id AND active = 1 AND autobidder = 1 AND id != $bidder ORDER BY modified asc"), MYSQLI_ASSOC);
			$data['user_id']	= $user['id'];
		}
	} else {
		$user = mysqli_fetch_array(mysqli_query($db,"SELECT id FROM users WHERE aid = $id AND active = 1 AND autobidder = 1 ORDER BY modified asc"), MYSQLI_ASSOC);
		$data['user_id']	= $user['id'];
	}

	if(empty($user)) {
		$user = mysqli_fetch_array(mysqli_query($db,"SELECT id FROM users WHERE active = 1 AND autobidder = 1 AND id != $bidder ORDER BY modified asc"), MYSQLI_ASSOC);
	    $data['user_id']	= $user['id'];
   }

	if(!empty($user)) { 
		// lets check to see if its a nail bitter
		$auction = mysqli_fetch_array(mysqli_query($db,"SELECT nail_bitter FROM auctions WHERE id = $id"), MYSQLI_ASSOC);

		$message = __('Single Bid', true);

		// Bid the auction
		$auction = bid($data, true, $message);

		 
	} else {
		logIt("Autobid broke on $id :/");
		return null;
	}
}

function bid($data = array(), $autobid = false, $bid_description = null) {  

	global $config;global $db; global $msgarr; 
	 
	$canBid = true;
	$message = '';
	$flash = '';

	if(empty($data['user_id'])) {
		$message = $msgarr[$config['App']['language']]['not_login'];

		$canBid = false; if($autobid){ echo '<br /> error: no user_ID  '; } 
		$data['user_id'] = 0;
	}

	if($autobid){ echo '<br /> in bid () '; }
	
 
	
	// Get the auctions
	$auction_id = $data['auction_id'];
	$uid = $data['user_id'];
 
	$columns = array("a.id", "a.product_id", "a.start_time", "a.end_time", "a.bid_debit","a.time_inc","a.price_inc","a.price", "a.peak_only",
	 "a.closed", "a.minimum_price", "a.autobids","a.real_bids_in_row", "a.max_end", "a.max_end_time", "a.penny", "a.free",
	  "a.reverse", "a.beginner", "a.block_bids","a.unblock_bids", "p.buy_now","p.minimum_price as pmp", "p.rrp"
	);
	$joins = array();
 
	$auction = mysqli_fetch_array(mysqli_query($db,"SELECT ".implode(",", $columns)." FROM auctions a LEFT JOIN products p ON (a.product_id=p.id) ".implode(" ", $joins)." WHERE a.deleted=0 AND a.id = $auction_id"), MYSQLI_ASSOC);
	$user = mysqli_fetch_array(mysqli_query($db,"SELECT sid, sid_exp FROM users  WHERE id =  ". $data['user_id'] ), MYSQLI_ASSOC);
 	if($user['sid']  > 0){
		$sid = $user['sid'];
	}if($user['sid_exp'] < date('Y-m-d')){
		$sid = 0;
	}
	
	if (!$auction) logIt(mysqli_error()); 

	if( isset( $_SESSION['user_'.$data['user_id']] ) && $autobid == false){
		$diff_last_bid = round(microtime(true) * 1000) - $_SESSION['user_'.$data['user_id']];
		if($diff_last_bid <= 100){
			$message = 'bidding too fast';
 			$canBid = false;
		}
	}

	if( $auction['unblock_bids'] > 0 ) {
		$t = time();
		$auc_blk = mysqli_fetch_array(mysqli_query($db,"SELECT ab.id, u.first_name FROM auction_block ab
														LEFT JOIN users u on ab.user_id = u.id
														 WHERE ab.auction_id = $auction_id  "), MYSQLI_ASSOC);
		
		if($auc_blk['id'] > 0 ){
			$usr_blk = mysqli_fetch_array(mysqli_query($db,"SELECT id FROM user_unblock WHERE auction_id = $auction_id AND user_id = $uid   "), MYSQLI_ASSOC);
			if(!$usr_blk['id']   ){
				$message = sprintf($msgarr[$config['App']['language']]['auction_blocked'], $auc_blk['first_name'], $auction['unblock_bids']    )    ;	
				$message1 =  'auction_blocked' ;
				$canBid = false;
			}

		}
	}

 	
	if(!empty($auction)) { 
	 
		// check to see if this is a free auction
		if(!empty($auction['free'])) {
			$data['bid_debit'] = 0;
		}
		if( $auction['bid_debit'] > 0 ) {
			$data['bid_debit'] = $auction['bid_debit'];
		}

		 
		$data['time_increment'] = $auction['time_inc'];
 		 
		$data['price_increment'] = '0.01';
		if( $auction['price_inc'] > 0 ) {
			$data['price_increment'] = $auction['price_inc'];
			
		}
		$tl = strtotime($auction['end_time']) - time();
		
		 
		if($auction['price'] >= $auction['pmp']){
			$canBid = false;
			$message = 'Min price Reached already.';
		}
		
		
		// pusher Check if the auction has ended - this only applies to NON autobidders
		if((!empty($auction['closed']) || strtotime($auction['end_time']) <= (time()-1) ) && $autobid == false && !@$data['bid_butler'] && empty($auction['unique'])) {
			$message = $msgarr[$config['App']['language']]['auction_closed'];
			if($autobid){ echo '<br /> error: auction_closed  '; } 
 			$canBid = false;
		}
		
		// Don't let reverse auctions drop below 0.00
		if ($auction['reverse']==1 && $auction['price']<=0) {
			$message = $msgarr[$config['App']['language']]['auction_closed'];
			if($autobid){ echo '<br /> error: auction_closed  '; } 
			$canBid = false;
		}

		// Check if the auction has been not started yet
		 if(!empty($auction['start_time'])) {
			if(strtotime($auction['start_time']) > time()){
				$message =  $msgarr[$config['App']['language']]['auction_not_started'];
				if($autobid){ echo '<br /> error: auction_not_started  '; } 
 				$canBid = false;
			}
		} 

		 
		$balance = $data['bid_debit'];
		if($tl < 35 && $autobid == false){
			$balance = balance($data['user_id']);
		}
		       
	 
		if( is_live_server() ){
		 	//$latest_bid = lastBid($data['auction_id']);
		 
			/*if (!empty($latest_bid) && !isset($data['ignore_latest_bid']) && $latest_bid['user_id'] == $data['user_id']) {
				$message = $msgarr[$config['App']['language']]['already_leading'];
				$message1 = 'already_leading' ;
				logIt($auction['id'] . ' ' . $data['user_id'] . ' - cantBid: alreadylatest');
				//$canBid = false; // ajay remove my comment 
			}   */
	}
		
		$ab_winning = ($autobid) ? 1 : 0 ; 
		 
		if($autobid == false) {   
			$rrp = $auction['rrp'];
			if(is_live_server() ){ 
				if( $rrp > $config['App']['subscription_pack_rrp'][$sid]   ){ 
						if($rrp <= $config['App']['subscription_pack_rrp'][$sid+1] ){ $new_sid = $sid+1; }
						else if($rrp <= $config['App']['subscription_pack_rrp'][$sid+2] ){ $new_sid = $sid+2; }
						else if($rrp <= $config['App']['subscription_pack_rrp'][$sid+3] ){ $new_sid = $sid+3; }
						else if($rrp <= $config['App']['subscription_pack_rrp'][$sid+4] ){ $new_sid = $sid+4; }
						else if($rrp <= $config['App']['subscription_pack_rrp'][$sid+5] ){ $new_sid = $sid+5; }
					
						$message = sprintf($msgarr[$config['App']['language']]['upgrade_plan'], $config['App']['subscription_pack'][$new_sid]) ;
						if($autobid){ echo '<br /> error: upgrade_plan  '; }  
						
					$canBid = false;
				}
			}
			 
		}else{
			 //$message = $msgarr[$config['App']['language']]['buy_plan'];
			 //$canBid = false;
		}


		  
		if($canBid == true) { 		if($autobid){ echo '<br /> can bid  () '; }  
			 
			if($balance >= $data['bid_debit']) {
				 
				 
				// lets make sure the auction time is not less than now
				if(strtotime($auction['end_time']) < (time()+$data['time_increment'])) {
					$auction['end_time'] = date('Y-m-d H:i:s', time() + $data['time_increment']);
				} 
 
				 
				
				// lets extend the minimum price if its an auto bidder
				if($autobid == true) {
 
					$auction['minimum_price'] += 0.01;
					  
					$auction['autobids'] += 1;
					$auction['real_bids_in_row'] = 0;
				} else {
					$auction['real_bids_in_row'] += 1;
					$auction['autobids'] = 0;
				}

				// Formatting user bid transaction
				$bid['user_id']    = $data['user_id'];
				$bid['auction_id'] = $auction['id'];
				$bid['credit']     = 0;
				$bid['debit'] = $data['bid_debit'];
                  
                                
				$bid['description'] = __('Single Bid', true);
 
				$auction['leader_id'] = $data['user_id'];
 
				$new_price_inc = 0; // is_test_server
				if($auction['price_inc'] == 0){
					$a = $auction['pmp']; // product min price
					$tl1 = $tl/60;
					//$b = mysqli_fetch_array(mysqli_query($db,"SELECT COUNT(id) total FROM last5bidders WHERE auction_id = ".$auction['id']), MYSQLI_ASSOC);
					$y = mysqli_fetch_array(mysqli_query($db,"SELECT COUNT(id) total FROM last5bids WHERE auction_id = ".$auction['id']), MYSQLI_ASSOC);
					
					if(  $y > 0){
						$new_price_inc =  number_format(    ( $a / ( 2 * $tl *  $y['total'])   ),8 ) ;
						$formula = 'a/b*y / tl';
					}else{
						$new_price_inc =  number_format( ($a/ (2* $tl1) ),8) ;
						$formula = 'a/  tl';
					} 
					

					// if($new_price_inc < $auction['price_inc'] ) { $data['price_increment'] = $new_price_inc; } 

					if($new_price_inc > 0 ) { $data['price_increment'] = $new_price_inc; }  
				}
				
				$auction['price'] 	+= $data['price_increment'];
				
				if( $auction['price'] >= $auction['minimum_price'] && $auction['minimum_price'] > 0 ){
					$auction['price'] 	= $auction['minimum_price'];
				}
				 /* echo '<br /> a : '. $a ;
				  echo '<br /> tl : '. $tl1 ;
				 echo '<br /> b : '. $b['total'] ; 
				 echo '<br /> y : '. $y['total'] ; 
				echo '<br /> x =  : '. $new_price_inc ; 
				echo '<br /> formula =  : '. $formula ;  */  
				 
				if(!$new_price_inc) { $new_price_inc  = $auction['price_inc']; }   
				 if($new_price_inc == 'inf') $new_price_inc = '1.2011';
			$success = mysqli_query($db,"UPDATE auctions SET ab_winning = '".$ab_winning ."', end_time = '".$auction['end_time']."', price = '".$auction['price']."', minimum_price = '".$auction['minimum_price']."', 
			autobids = ".$auction['autobids'].",real_bids_in_row = ".$auction['real_bids_in_row'].", price_inc_new = ".$new_price_inc .", leader_id = ".$auction['leader_id'].", modified = '".date('Y-m-d H:i:s')."' WHERE id = ".$auction['id']);
 
                                
				if ($success) {
					if($tl > 40){ 
						$bid['debit'] = 0;  
					}
					$fields='`user_id`, `auction_id`, `description`, `bid_val` , `credit`, `debit`, `created`, `modified`';
					$values="'{$bid['user_id']}', '{$bid['auction_id']}', '{$bid['description']}','{$auction['price']}' ,'{$bid['credit']}', '{$bid['debit']}', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."'";

				 
					mysqli_query($db,"INSERT INTO bids ($fields) VALUES ($values)");
					
					// delete from table where id < (select max(id) from table)-N
					//$date5min = date('Y-m-d H:i:s', strtotime('-5 minutes')); // in cronjob file 
					//mysqli_query($db,"DELETE FROM last5bidders WHERE created <  '".date('Y-m-d H:i:s')."'  ");  //in cronjob file 
					mysqli_query($db,"DELETE FROM last5bidders WHERE user_id = '{$bid['user_id']}' AND auction_id = '{$bid['auction_id']}' ");
					
					mysqli_query($db,"INSERT INTO last5bidders SET user_id = '{$bid['user_id']}', 
																	auction_id = '{$bid['auction_id']}',
																	created = '".date('Y-m-d H:i:s')."' 
																	   ");
					mysqli_query($db,"INSERT INTO last5bids SET user_id = '{$bid['user_id']}', 
																	auction_id = '{$bid['auction_id']}',
																	debit = 1,
																	created = '".date('Y-m-d H:i:s')."' 
																	   ");
                    if($autobid == false){
						mysqli_query($db,"INSERT INTO user_auction_bids SET user_id = '{$bid['user_id']}', auction_id = '{$bid['auction_id']}',	total_bids = 1 ");	
						mysqli_query($db,"UPDATE user_auction_bids SET total_bids = total_bids + 1 WHERE auction_id = '{$bid['auction_id']}' AND user_id = '{$bid['user_id']}'  ");	
					}                    
					 

					if($autobid == true) {
						mysqli_query($db,"UPDATE users SET modified = '".date('Y-m-d H:i:s')."' WHERE id = ".$data['user_id']);
					}else{
						$user = mysqli_fetch_array(mysqli_query($db,"SELECT rewards_points,bid_balance,bd_cnt_bb_bids FROM users WHERE id = ".$data['user_id']), MYSQLI_ASSOC);
						$user['bid_balance'] -= $bid['debit'];
						$user['bd_cnt_bb_bids'] += 1; // $bid['debit']
						if($user['bd_cnt_bb_bids'] >= 10 && $tl > 30 ){ 
							$user['bd_cnt_bb_bids'] = 0;
							$user['rewards_points'] += 1; 
							mysqli_query($db,"UPDATE users SET rewards_points = '".$user['rewards_points']."',bd_cnt_bb_bids = '".$user['bd_cnt_bb_bids']."', bid_balance = '".$user['bid_balance']."', modified = '".date('Y-m-d H:i:s')."' WHERE id = ".$data['user_id']);
 
						}else{
							unset($user['rewards_points']);
							mysqli_query($db,"UPDATE users SET bd_cnt_bb_bids = '".$user['bd_cnt_bb_bids']."', bid_balance = '".$user['bid_balance']."', modified = '".date('Y-m-d H:i:s')."' WHERE id = ".$data['user_id']);

						} 
					}


					// this is normally in afterSave but need this here
					clearCache($auction['id'], $data['user_id']);

					$message = $msgarr[$config['App']['language']]['bid_placed'];
					$message1 = 'bid_placed';
					$un = mysqli_fetch_array(mysqli_query($db,"SELECT username,first_name FROM users WHERE id = '". $bid['user_id'] ."' "), MYSQLI_ASSOC);
					$usr_auc_bid = mysqli_fetch_array(mysqli_query($db,"SELECT total_bids  FROM user_auction_bids WHERE auction_id = '". $auction['id'] ."' AND user_id = '". $bid['user_id'] ."' "), MYSQLI_ASSOC);
			
					 
					
					
					$datap['id'] = $auction['id']; 
					$datap['p'] = $auction['price'];
					//$datap['pi'] = $data['price_increment']. ':'. $new_price_inc;
					$datap['pi'] =   $new_price_inc;
					if( 0 ){
						$datap['pi'] = $auction['price_inc']  ;
					}
					$datap['u'] = ($un['first_name']) ? $un['first_name'] : $un['username']  ;
 					$datap['s'] = strtotime($auction['end_time']) - time();
					$datap['cs'] = 0;
					
					$datap['BU'] = ($un['first_name']) ? $un['first_name'] : $un['username']  ;
					$datap['BC'] = date('Y-m-d H:i:s');
					$datap['BB'] = $usr_auc_bid['total_bids'];
					$datap['BU'] = $datap['BU'].'( '.$usr_auc_bid['total_bids'].')' ; 
					$datap['u'] = $datap['u'].'( '.$usr_auc_bid['total_bids'].')' ; 

					if( $autobid == false){ $_SESSION['user_'.$bid['user_id']] = round(microtime(true) * 1000); } 
					
					push($datap);
					$min_price = $auction['minimum_price'] - $data['price_increment'] ; // added because last bid also adding new row in bids table highest user bid 
					if( $auction['price'] >= $min_price ){
						if(!$autobid){
							if($auction['autobid_on'] == 1 ){ placeAutobid($auction['id']); }
							closeAuction($auction, 1);
						}
					}
					
					
					
				} else {
					logIt($auction['id'].' '.$data['user_id'].' - cantBid: unknown bid error: '.mysqli_error());
					$message = $msgarr[$config['App']['language']]['bid_problem'];
 				} 

				 

				$auction['Auction']['success'] = true;
				$auction['Bid']['description'] = $bid['description'];
				$auction['Bid']['user_id'] = $bid['user_id'];

 				$result['Bid'] = $bid;
			} else {
				$message = $msgarr[$config['App']['language']]['no_bids'];
				$message1 =  'no_bids' ;
				$message2 =  $balance ;
				logIt($auction['id'].' '.$data['user_id'].' - cantBid: account bids depleted');
			}
		}else{
			if($autobid){ echo '<br /> can NOT  bid  () '. $message; }  
		} 

		$result['Auction']['id']      = $auction['id'];
		$result['Auction']['bd']      = $bid['debit'];
		$result['Auction']['reward_points']      = (int) $user['rewards_points'];
		$result['Auction']['bd1']      = 1 ; // $data['bid_debit'] 
		$result['Auction']['element'] = 'auction_'.$auction['id'];
		$result['Auction']['new_sid'] = $new_sid;
		$result['Auction']['pack_name'] = $config['App']['subscription_pack'][$new_sid];
		$result['Auction']['bids'] = $config['App']['subscription_pack_price'][$new_sid] - $config['App']['subscription_pack_price'][$sid];
		if($new_sid > 0){
			$message .=  sprintf($msgarr[$config['App']['language']]['upgrade_plan3'], $result['Auction']['bids']); 
		}
		$result['Auction']['message'] = $message;
		$result['Auction']['message1'] = $message1;
		$result['Auction']['message2'] = $message2;
 
		if($autobid){ echo '<pre>result ';print_r($result);echo '</pre>';   }  
		if($autobid){ echo '<pre>data ';print_r($data);echo '</pre>';   }  
		return $result;
	} else {
		return false;
	}
}

function fixDoubleBids($auction_id = null) {
	$bidHistories = mysqli_query($db,"SELECT * FROM bids WHERE credit = 0 AND auction_id = ".$auction_id." ORDER BY id DESC LIMIT 2");
	$totalBids    = mysqli_num_rows($bidHistories);

	if($totalBids > 0) {
		$user_id = 0;
		while($bid = mysqli_fetch_array($bidHistories, MYSQLI_ASSOC)) {
			if(empty($user_id)) {
				// this is the first bid checking
				$user_id = $bid['user_id'];
			} else {
				// lets compare this to the second bid
				if($bid['user_id'] == $user_id) {
					logIt('Triggering fixDoubleBids() on auctionid: '.$auction_id);
					mysqli_query($db,"DELETE FROM bids WHERE {$bid['id']} = id");
					clearCache($auction_id, $bid['user_id']);
				}
			}
		}
	}
}

function balance($user_id) {
	global $config;global $db;  
	$user = mysqli_fetch_array(mysqli_query($db,"SELECT bid_balance FROM users WHERE id = $user_id"), MYSQLI_ASSOC);
	
	return $user['bid_balance'];
	   
}

function bidPlaced($auction_id = null, $user_id = null, $message = 'Single Bid') {
	$smartbid = mysqli_fetch_array(mysqli_query($db,"SELECT * FROM smartbids WHERE auction_id = $auction_id AND user_id = $user_id"), MYSQLI_ASSOC);

	if(empty($smartbid)) {
		mysqli_query($db,"INSERT INTO smartbids (auction_id, user_id, message) VALUES ('$auction_id', '$user_id', '$message')");
	} elseif(rand(1, 10) == 10) {
		// lets delete a bidder every so often
		mysqli_query($db,"DELETE FROM smartbids WHERE id = ".$smartbid['id']);
	}
}

function limitsCanBid($auction_id = null, $user_id = null, $product_id = null, $autobidder = false) {
	global $config;

	if($autobidder == true) {
		return true;
	}

	$expiry_date = date('Y-m-d H:i:s', time() - ($config['App']['limits']['expiry'] * 24 * 60 * 60));

	$sql = mysqli_query($db,"SELECT 	`leader_id`
						FROM `auctions`
						WHERE `leader_id` = '$user_id'
						   AND end_time > '$expiry_date'");
	$total   = mysqli_num_rows($sql);

	if($total >= $config['App']['limits']['limit']) {
		return false;
	}

	// now lets check the individual product
	$sql = mysqli_query($db,"SELECT 	`leader_id` 
						FROM auctions a, 
						   products p, 
						   limits l 
						WHERE a.product_id = $product_id 
						   AND a.leader_id = $user_id 
						   AND end_time > '$expiry_date' 
						   AND p.id = a.product_id 
						   AND l.id = p.limit_id");
	$productTotal   = mysqli_num_rows($sql);

	$limit = mysqli_fetch_array(mysqli_query($db,"SELECT 	l.limit, 
									l.id 
									FROM limits l,
									   products p 
									WHERE l.id = p.limit_id 
									   AND p.id = $product_id"), MYSQLI_ASSOC);

	if(empty($limit['limit'])) {
		return true;
	}

	if($productTotal >= $limit['limit']) {
		return false;
	} else {
		return true;
	}
}

function refundBidButlers($auction_id = null, $price = null) {
	/*if(!empty($price)) {
		$conditions = "auction_id = $auction_id AND bids > 0 AND maximum_price < '$price'";
	} else {
		$conditions = "auction_id = $auction_id AND bids > 0";
	}

	$sql = mysqli_query($db,"SELECT * FROM bidbutlers WHERE $conditions");
	$totalRows   = mysqli_num_rows($sql);

	if($totalRows > 0) {
		while($bidbutler = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
			$bid['user_id'] 	= $bidbutler['user_id'];
			$bid['description'] = __('Bid Butler Refunded Bids', true);
			$bid['credit']      = $bidbutler['bids'];

			mysqli_query($db,"INSERT INTO bids (user_id, description, credit, created, modified) VALUES ('".$bid['user_id']."', '".$bid['description']."', '".$bid['credit']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");

			mysqli_query($db,"UPDATE bidbutlers SET bids = 0, modified = '".date('Y-m-d H:i:s')."' WHERE id = ".$bidbutler['id']);
		}
	}*/
}

function closeAuction($auction = array(), $max_bid_wnr=0) { 	 
	global $config;
	global $db;
	
	// it is OK to close this auction
	mysqli_query($db,"UPDATE auctions SET closed = 1, end_time = '".date('Y-m-d H:i:s')."', modified = '".date('Y-m-d H:i:s')."' WHERE id = ".$auction['id']);

	// now sleep the auction for a quarter of a second to give it time for any final bids to process
	usleep(250000);

	 
	if( $max_bid_wnr  ){
		$bid = mysqli_fetch_array(mysqli_query($db,"SELECT user_id FROM user_auction_bids WHERE auction_id = '". $auction['id'] ."' ORDER BY total_bids DESC LIMIT 1 "), MYSQLI_ASSOC);
		if( $bid['user_id'] != $auction['leader_id'] ){ 
			//$bid_val = $auction['price'] + $auction['price_inc'] ; 
			$bid_val = $auction['minimum_price'] ; 
			mysqli_query($db,"INSERT INTO bids SET user_id = '{$bid['user_id']}', 
											   description = 'Max bids placed.',
											   auction_id = '{$auction['id']}',
											   bid_val = '{$bid_val}',
											   created = '".date('Y-m-d H:i:s')."' 
		   ");
			mysqli_query($db,"UPDATE auctions SET  price = '". $auction['minimum_price'] ."'  WHERE id = ".$auction['id']);
		}

	}else{
		$bid = lastBid($auction['id']); 
	}
	  

		
	$un = mysqli_fetch_array(mysqli_query($db,"SELECT first_name FROM users WHERE id = '". $bid['user_id'] ."' "), MYSQLI_ASSOC);
	 mysqli_query($db,"UPDATE users SET sid = 0  WHERE id = '". $bid['user_id'] ."' ") ;
		
	 

	 $datap['id'] = $auction['id'];
	$datap['p'] = $auction['price'];
	$datap['closed'] = 1;
	$datap['u'] = $un['first_name'];
	$datap['s'] = 0;
	$datap['cs'] = 1;
	push($datap);
	
	 
		
		 
	
	
	if(!empty($bid)) {
		if($bid['autobidder'] == 0 && $auction['price']>0) {
			// add the auction_id into auction_emails for sending
			mysqli_query($db,"INSERT INTO auction_emails (auction_id) VALUES ('".$auction['id']."')");
		}
		 
		mysqli_query($db,"UPDATE auctions SET winner_id = ".$bid['user_id'].",leader_id = ".$bid['user_id'].", status_id = 1, modified = '".date('Y-m-d H:i:s')."' WHERE id = ".$auction['id']);
	 
	}

	clearCache($auction['id']);

	// lets remove any autobids from the system
	mysqli_query($db,"DELETE FROM autobids WHERE auction_id = ".$auction['id']);

	// and lets do the same for any smartbids
	if($config['App']['smartAutobids'] == true) {
		mysqli_query($db,"DELETE FROM smartbids WHERE auction_id = ".$auction['id']);
	}

	// and lets see if the credit system is on and add credits to the users that didn't win
	if(!empty($config['App']['credits']['active'])) {
		$losersSql = mysqli_query($db,"SELECT 	DISTINCT b.user_id 
							FROM bids b, users u 
							WHERE b.auction_id = ".$auction['id']." 
							   AND u.autobidder = 0 
							   AND u.id != '".$auction['winner_id']."' 
							   AND b.debit > 0 AND u.id = b.user_id");
		$totalLosers   = mysqli_num_rows($losersSql);
		if($totalLosers > 0) {
			while($loser = mysqli_fetch_array($losersSql, MYSQLI_ASSOC)) {
				$bidsSql = mysqli_query($db,"SELECT 	id 
								FROM bids 
								WHERE auction_id = ".$auction['id']." 
								   AND debit > 0 
								   AND user_id = ".$loser['user_id']);
				
				$numberOfBids   = mysqli_num_rows($bidsSql);
				if($numberOfBids > 0) {
					$credit['user_id'] = $loser['user_id'];
					$credit['auction_id'] = $auction['id'];
					$credit['credit'] = $numberOfBids * $config['App']['credits']['value'];

					mysqli_query($db,"INSERT INTO credits (user_id, auction_id, credit, created, modified) VALUES ('".$credit['user_id']."', '".$credit['auction_id']."', '".$credit['credit']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
				}
			}
		}
	}

	// now lets refund any bid credits not used before returning the data IF advanced mode is on
	if($config['App']['bidButlerType'] == 'advanced') {
		logIt("RefundBidButlers auction ".$auction['id']." without price");
		refundBidButlers($auction['id']);
	}

	// now check if we need to relist this auction
	if(!empty($auction['autolist'])) {
		$product = mysqli_fetch_array(mysqli_query($db,"SELECT stock, stock_number FROM products WHERE id = ".$auction['product_id']), MYSQLI_ASSOC);
		if(!empty($product['stock'])) {
			if($product['stock_number'] > 0) {
				if($bid['autobidder'] == 0) {
				// lets make the stock number smaller
					$product['stock_number'] -= 1;
					mysqli_query($db,"UPDATE products SET stock_number = ".$product['stock_number'].", modified = '".date('Y-m-d H:i:s')."' WHERE id = ".$product['id']);
				}

				autoRelist($auction);
			}
		} else {
			autoRelist($auction);
		}
	}
}

//*** Called by bidbutler cronjob, tests if it's OK to invoke a bid butler
function canBidButler($bidbutler) {
	global $config;
	
	if ($bidbutler['reverse']) {
		//reverse auctions work differently
		if ($bidbutler['price'] <= $bidbutler['minimum_price'] ||
				   $config['App']['bidButlerType'] == 'simple' ||
				   $bidbutler['fixed'] == 1) {
			logIt($bidbutler['auction_id']. '; canBidButler: true');
			return true;
		}
				   
	} else {
		//standard auction
		
		if ($bidbutler['price'] >= $bidbutler['minimum_price'] &&
			   ($bidbutler['price'] < $bidbutler['maximum_price']) ||
			   $config['App']['bidButlerType'] == 'simple' ||
			   $bidbutler['fixed'] == 1) {
			logIt($bidbutler['auction_id']. '; canBidButler: true');
			return true;
		}
	}
}

function autorelist($auction = array()) {
	// make sure this isn't a duplicate spawn for some reason
	#$productSql = mysqli_query($db,"SELECT id FROM auctions WHERE deleted = 0 AND closed = 0 AND active = 1 AND parent_id = ".$auction['id']);
	$productSql = mysqli_query($db,"SELECT id FROM auctions WHERE deleted = 0 AND closed = 0 AND active = 1 AND product_id = ".$auction['id']);
	if(mysqli_num_rows($productSql) == 0) {
		// check for a delayed start time
		$delayed_start = get('autolist_delay_time');

		if(!empty($delayed_start)) {
			$auction['start_time'] = date('Y-m-d H:i:s', time() + $delayed_start * 60);
			$auction['end_time'] = date('Y-m-d H:i:s', time() + (get('autolist_expire_time') + $delayed_start) * 60);
		} else {
			$auction['start_time'] = date('Y-m-d H:i:s');
			$auction['end_time'] = date('Y-m-d H:i:s', time() + get('autolist_expire_time') * 60);
		}

		//is this a max end auction?
		if ($auction['max_end']) {
			//yep, give the spawned auction a max_end_date span comparible to the original's
			$max_duration=strtotime($auction['max_end_time']) - strtotime($auction['start_time']);
			$auction['max_end_time']=date('Y-m-d H:i:s', strtotime('+'.$max_duration.' second'));
			
		}
		
		if($auction['max_end_time'] < $auction['end_time']) {
			$auction['max_end_time'] = $auction['end_time'];
		}
		

		$product = mysqli_fetch_array(mysqli_query($db,"SELECT start_price, minimum_price FROM products WHERE id = ".$auction['product_id']), MYSQLI_ASSOC);

		$auction['price'] 			= $product['start_price'];
		$auction['minimum_price'] 	= $product['minimum_price'];

		mysqli_query($db,"INSERT INTO auctions (	parent_id,
										product_id, 
										start_time, 
										end_time, 
										max_end, 
										max_end_time, 
										price, 
										autolist, 
										featured, 
										peak_only, 
										nail_bitter, 
										penny, 
										free, 
										hidden_reserve,
										beginner,
										reverse,
										minimum_price, 
										active, 
										bid_debit, 
										created, 
										modified) 
								VALUES (	'".$auction['id']."',
										'".$auction['product_id']."', 
										'".$auction['start_time']."', 
										'".$auction['end_time']."', 
										'".$auction['max_end']."', 
										'".$auction['max_end_time']."', 
										'".$auction['price']."', 
										'".$auction['autolist']."', 
										'".$auction['featured']."', 
										'".$auction['peak_only']."', 
										'".$auction['nail_bitter']."',
										'".$auction['penny']."', 
										'".$auction['free']."', 
										'".$auction['hidden_reserve']."', 
										'".$auction['beginner']."', 
										'".$auction['reverse']."', 
										'".$auction['minimum_price']."', 
										'".$auction['active']."', 
										'".$auction['bid_debit']."', 
										'".date('Y-m-d H:i:s')."', 
										'".date('Y-m-d H:i:s')."')");
										
		$config=Configure::read('Twitter');							
		if ($config['enabled']===true) {
			 $auction=getAuctionById($auction['id']);
			 
		}
	}
}

function clearCache($auction_id = null, $user_id = null) {
	eval(AddonManager::hook('daemons_functions_clearcache_top'));
	if(!empty($auction_id)) {
		cacheDelete('cake_auction_view_'.$auction_id);
		cacheDelete('cake_auction_'.$auction_id);
		cacheDelete('cake_daemons_extend_auctions');
		cacheDelete('cake_last_bid_'.$auction_id);
	}

	if(!empty($user_id)) {
		cacheDelete('cake_bids_balance_'.$user_id);
	}
}

function getAuctionById($auction_id) {
	eval(AddonManager::hook('daemons_functions_getauctionbyid_top'));
	$res=mysqli_query($db,"SELECT * FROM `auctions` WHERE `id`='".$auction_id."'");
	if (mysqli_num_rows($res)==0) return false;
	$auction['Auction']=mysqli_fetch_array($res,MYSQLI_ASSOC);
	mysqli_free_result($res);
	
	$res=mysqli_query($db,"SELECT * FROM `products` WHERE `id`='".$auction['Auction']['product_id']."'");
	$auction['Product']=mysqli_fetch_array($res,MYSQLI_ASSOC);
	mysqli_free_result($res);
	
	return $auction;	
	
}

function adjustAutobidLimit($auction_id, $autobid_limit, $random) {
	eval(AddonManager::hook('daemons_functions_adjustautobidlimit_top'));
	if($random == '0.00') {
		// lets create a ranom digit
		$digit = rand(0, 100);
		$random = $digit / 100 + 1;
		mysqli_query($db,"UPDATE auctions SET random = '$random' WHERE id = $auction_id");
	}
	return (ceil($autobid_limit * $random));
}

function logIt($msg, $which=false) {
	eval(AddonManager::hook('daemons_functions_logit_top'));

	if (!defined('LOG_FILE') or !LOG_FILE) return false;
	
	$pf=fopen(LOG_FILE, 'a');
	if(!array_key_exists('type', $_GET))
	{
		$_GET['type'] = 'unk ';
	}
	fwrite($pf, date('Y-m-d H:i:s').' '.strtoupper($_GET['type']).': '.$msg."\n");
	fclose($pf);
}

function push($data)
{                                                                            
	 			
	//API Url
	
	$url = 'http://localhost:3000/push/'; 
	if( is_live_server() ){ 
		$url = 'https://localhost:3001/push/'; 
	}
	 
	//Initiate cURL.
	$ch = curl_init($url);

	//Tell cURL that we want to send a POST request.
	curl_setopt($ch, CURLOPT_POST, 1);

	//Attach our encoded JSON string to the POST fields.
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	 
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

	//Execute the request
	$result = curl_exec($ch);
	 
	return $result;
	
}

 
?>