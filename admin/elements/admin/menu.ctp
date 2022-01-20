<div id="header_menu">
<ul>
<li><a  href="<?php echo $this->webroot;?>admin/">Home</a></li>
<li><a  href="<?php echo $this->webroot;?>admin/products/index">Manage Auctions</a></li>
<li><a href="<?php echo $this->webroot;?>admin/pages/index">Manage Content</a></li>
<li><a href="<?php echo $this->webroot;?>admin/users">Manage Users</a></li>

<li><a href="<?php echo $this->webroot;?>admin/newsletters/index">Newsletters</a></li>
<li style=""><a  href="<?php echo $this->webroot;?>admin/settings">Settings</a></li>
<li style="background-image:none;"><a href="<?php echo $this->webroot;?>admin/accounts">Accounts</a></li>
<li class="username">Welcome <strong><?php echo $session->read('Auth.User.username'); ?></strong></li>
<li style="float:right;"><?php echo $html->link(__('Logout', true), array('controller' => 'users', 'action' => 'logout', 'admin' => false));?></li>

</ul>
</div>
  

        
    