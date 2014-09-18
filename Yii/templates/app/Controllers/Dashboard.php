<?php
namespace Controllers;
use Resources;


/**
 * class Dashboard
 *
 * @package
 */
class Dashboard extends Resources\ Controller {

	public function __construct( ) {
		parent::__construct( );
		$this->session = new Resources\ Session;
	}


/**
 * function index
 *
 * @return
 */
	public function index( ) {
		$data['sVariabel1'] = 'variable 1';
		$data['sVariabel2'] = 'variable 2';
		$this->output( 'dashboard', $data);
	}

	public function hello( ) {
	}
}
