<?php
/**
 * Project Name: %project_name%
 * File: %handler_name%.php
 *
 * @author     ______________________
 * @copyright
 * @Generated %date%
 * @package %module_name%
 * @generator  AksiIDE, http://www.aksiide.com
 *
 **/



/**
 * Form handler for create and edit.
 */
class %module_name%_Handler_%handler_name% extends Zikula_Form_AbstractHandler{
	/**
	 * User id.
	 * When set this handler is in edit mode.
	 * @var integer
	 */
	private $_id;

	private $_user;

	/**
	 * Setup form.
	 * @param Zikula_Form_View $view Current Zikula_Form_View instance.
	 * @return boolean
	 */
	public function initialize(Zikula_Form_View $view){
		if (!SecurityUtil::checkPermission('%module_name%::', '::', ACCESS_ADD) ) {
    	throw new Zikula_Exception_Forbidden(LogUtil::getErrorMsgPermission());
    	//return LogUtil::registerPermissionError();
    }
		$lsVariable1   = FormUtil::getPassedValue('variable1', isset($args['variable1']) ? $args['variable1'] : null, 'GETPOST', FILTER_SANITIZE_STRING);

    $view->assign( $_REQUEST);
    $view->assign( "variable1", $lsVariable1);
		return true;
	}

	/**
	 * Handle form submission.
	 *
	 * @param Zikula_Form_View $view  Current Zikula_Form_View instance.
	 * @param array            &$args Args.
	 *
	 * @return boolean
	 */

	public function handleCommand(Zikula_Form_View $view, &$args){
		// check for valid form
		if (!$view->isValid()) {
				//return false;
		}
    $psURL = FormUtil::getPassedValue('the_url', '', 'GETPOST', FILTER_SANITIZE_STRING);
    $lsURL = ModUtil::url('%module_name%', 'user','main');

    if (!($this->request->isPost())) {
    	return $view->redirect( $lsURL);
    }
    if ($args['commandName'] == 'cancel') {
    	return $view->redirect( $lsURL);
    }

    if ($args['commandName'] != 'save') {
    	return $view->redirect( $lsURL);
    }
		$now = DateUtil::getDatetime();
		$lsUserName = UserUtil::getVar( 'uname');
		$liUID = UserUtil::getVar( 'uid');

		$laData = $view->getValues();

    // get form value
    $psName = $this->getFormValue( 'name', 'default value');

    // your code


		//echo "--$psURL <pre>";print_r( $_REQUEST);die;

    //$this->setVars($data); --> simpan ke registry module
    LogUtil::registerStatus($this->__('Done! Data saved.'));

		return $view->redirect( $psURL);
	}


	//usage: if result is boolean --> $varname = (bool)$this->getFormValue('YesNo', false);
  private function getFormValue($key, $default){
  	//return isset($this->formValues[$key]) ? $this->formValues[$key] : $default;
    return FormUtil::getPassedValue( $key, $default, 'GETPOST', FILTER_SANITIZE_STRING);
  }


}

