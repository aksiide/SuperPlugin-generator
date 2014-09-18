<?php

App::uses( 'AppModel', 'Model' );

class MyModel extends AppModel {
	public $name = 'MyModel';  //note: TablenameSetting
	public $useTable = 'user'; //note: table name
	public $primaryKey = 'User';
	public $useDbConfig = '%dbconfig%'; //note: db config --> see 'app/Config/database.php'

	public function __construct() {
  	parent::__construct();
  }

}


