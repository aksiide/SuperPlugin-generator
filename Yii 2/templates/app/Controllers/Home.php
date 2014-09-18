<?php
namespace Controllers;
use Resources;


/**
 * class Home
 *
 * @package
 */
class Home extends Resources\Controller {

	private $sMyName = 'AksiIDE';

	public function __construct( ) {
		parent::__construct( );
		$this->session = new Resources\Session;
		$this->request = new Resources\Request;
	}


/**
 * function index
 *
 * @return
 */
	public function index( ) {
		$data['sAppName'] = '%app_name%';
		$data['sBaseURL'] = $this->uri->baseUri;
		$this->output( 'home', $data );
	}
}


