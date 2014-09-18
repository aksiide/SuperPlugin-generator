<?php
/**
 * Project Name: %project_name%
 * File: %controller_name%.php
 *
 * @author     ______________________
 * @copyright
 * @Generated date %date%
 * @package    %class_name%
 *
 * @generator  AksiIDE, http://www.aksiide.com
 *
 */


if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * class %class_name%
 *
 * @package
 */
class %class_name% extends %extends_name% {

	/**
   * function __construct
   */
	public function __construct() {
  	parent::__construct();
		$this->load->model('%controller_name%_model');
  }

	/**
   * function index
   */
	public function index() {

		$this->load->view('welcome_message');
	}


}


