<?php
%header% 

class %module_name%_Form_Handler_Admin_Main extends Zikula_Form_AbstractHandler {
	public function __construct($args)
	{
			$this->args = $args;
	}

	public function initialize(Zikula_Form_View $view) {
		if (!SecurityUtil::checkPermission('%module_name%:page:', '::', ACCESS_EDIT)) {
				throw new Zikula_Exception_Forbidden(LogUtil::getErrorMsgPermission());
		}

		PageUtil::setVar('title', $this->__('Page list and content structure'));
		$csssrc = ThemeUtil::getModuleStylesheet('admin', 'admin.css');
		PageUtil::addVar('stylesheet', $csssrc);

		$this->view->assign('enableVersioning', $this->getVar('enableVersioning'));
		return true;
	}

	public function handleCommand(Zikula_Form_View $view, &$args)  {
		require_once DataUtil::formatForOS( "modules/%module_name%/config.app.php");
		if (!$view->isValid()) {
				return false;
		}
    $lsURL = ModUtil::url('%module_name%', 'admin','main');
		$laData = $view->getValues();
    $laData = $_REQUEST;
    //$laData = $_FILES;


    if ($args['commandName'] == 'cancel') {
    	return $view->redirect( $lsURL);
    }
    if ($args['commandName'] != 'save') {
    	return $view->redirect( $lsURL);
    }

		$now = DateUtil::getDatetime();
		$lsUserName = UserUtil::getVar('uname');
		$liUID = UserUtil::getVar('uid');

    // proses form
	
    LogUtil::registerStatus($this->__('Terima kasih. Album telah ditambahkan.'));
    $lsURL = ModUtil::url('%module_name%', 'admin','main', array( "variabel" => "nilai" ));
		return $view->redirect( $lsURL);	
	}
}
