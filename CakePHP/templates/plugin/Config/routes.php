<?php
Router::connect('/%pluginshortname%',
	array('plugin'=>'%pluginshortname%', 'controller' => '%pluginshortname%', 'action' => 'index'));

Router::connect('/%pluginshortname%/:action',
	array('plugin'=>'%pluginshortname%', 'controller' => '%pluginshortname%', 'action' => ':action'));
		
Router::connect('/%pluginshortname%/read/:code',
	array('plugin'=>'%pluginshortname%', 'controller' => '%pluginshortname%', 'action' => 'read'));

