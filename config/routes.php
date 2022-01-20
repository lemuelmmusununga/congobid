<?php
	Router::connect('/', array('controller' => 'auctions', 'action' => 'home'));
	
	/* Admin Stuff */
	Router::connect('/admin', array('controller' => 'dashboards', 'action' => 'index', 'admin' => true));
	Router::connect('/admin/stats', array('controller' => 'dashboards', 'action' => 'stats', 'admin' => true));
	Router::connect('/admin/users/login', array('controller' => 'users', 'action' => 'login', 'admin' => false));
	Router::connect('/admin/users/logout', array('controller' => 'users', 'action' => 'logout', 'admin' => false));
	
	/* Pages Routing */
	Router::connect('/page/*', array('controller' => 'pages', 'action' => 'view'));
	Router::connect('/search/*', array('controller' => 'pages', 'action' => 'search'));
	Router::connect('/contact', array('controller' => 'pages', 'action' => 'contact'));
	Router::connect('/suggestion', array('controller' => 'pages', 'action' => 'suggestion')); 
	Router::connect('/store', array('controller' => 'pages', 'action' => 'store'));
	
	
	/* Offline mode */
	Router::connect('/offline', array('controller' => 'settings', 'action' => 'offline'));
	
	/* New daemon urls */
	Router::connect('/dcleaner', array('controller' => 'daemons', 'action' => 'cleaner'));
	Router::connect('/dwinner', array('controller' => 'daemons', 'action' => 'winner'));
	Router::connect('/404testpage4525d2fdc', array('controller' => 'auctions', 'action' => 'home'));
	
	/* Router for rss */
	Router::parseExtensions('rss');
	
	Router::connect('/auctions/:id', array('controller' => 'auctions', 'action' => 'view'), array('id'=>'.*-.*','pass'=>array('id')));
	Router::connect('/categories', array('controller' => 'categories', 'action' => 'index'));
	Router::connect('/categories/*', array('controller' => 'categories', 'action' => 'view'), array('id'=>'.*-.*','pass'=>array('id')));

	
	eval(AddonManager::hook('config_routes'));
?>