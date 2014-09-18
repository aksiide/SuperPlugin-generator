<?php

App::uses( 'AppController', 'Controller' );

class %pluginname%AppController extends AppController
{
	public $ext = '.php';
	public $theme = false;
	public $layout = 'default';
	public $settings;

	function beforeFilter( ) {
		parent::beforeFilter( );
	}

	public function beforeRender() {
		parent::beforeRender();
	}

}

