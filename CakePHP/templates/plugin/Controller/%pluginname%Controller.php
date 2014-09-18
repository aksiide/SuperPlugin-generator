<?php

class %pluginname%Controller extends %pluginname%AppController {
	private $bLive = true;
	public $name = "%pluginname%";
	public $uses = array(
		'%pluginname%.MyModel',
	);

     /**
      * function index
      * url: http://yoururl/%pluginshortname%
      *
      * @return
      **/
	public function index()
	{
		$options = array();
		$this->set( 'sYourConfig', Configure::read( 'yourconfig' ) );
	}

     /**
      * function example
      * url: http://yoururl/%pluginshortname%/example
      *
      * @return
      **/
	public function example()
    {
		$options = array();
		$this->set( 'sMyVariable', 'This is sMyVariable' );
	}

     /**
      * function dbexample
      * url: http://yoururl/%pluginshortname%/dbexample
      *
      * @return
      **/
	public function dbexample()
    {
		$laData= array();
		$laData = $this->MyModel->find( 'all',
			array(
				'conditions' => array('User !=' => '') //--> WHERE `User` != ''
			)
		);
		$this->set( 'aData', $laData );
	}


}

