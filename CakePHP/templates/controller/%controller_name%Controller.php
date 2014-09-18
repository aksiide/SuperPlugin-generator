<?php
/**
 * File: %controller_name%Controller.php
 *
 * @package    %plugin_name%
 * @author     ______________________
 * @copyright
 * @Generated date 22-10-2013 15:46
 * @generator  AksiIDE, http://www.aksiide.com
 * @url http://www.aksiide.com
 *
 */

/**
 * class %controller_name%Controller
 *
 * @package %plugin_name%
 */
class %controller_name%Controller extends %plugin_name%AppController
{
	public $name = '%controller_name%';
	public $uses = array( );
	public $components = array( );
	public $paginate = array(
		'limit' => 10,
		'order' => array(
			'news_date' => 'desc',
		),
	);


    /**
     * function beforeFilter
     *
     */
    function beforeFilter( )
    {
        parent::beforeFilter( );

        /* your code */
    }

    /**
     * function index
     *
     */
    public function index( )
    {
        $content = 'This is index content';
        $this->set( 'content', $content );
    }

  /* */
}


