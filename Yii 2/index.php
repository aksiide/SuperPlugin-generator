<?php
//error_reporting( 0);
require_once "includes/libplugin.php";
require_once "includes/libs.php";

global $sDir;

/**
 * Panada
 * @param  ___
 * @return ___
 */

class Panada extends AksiIDEPlugin {
	private static $instance;

	public function init() {
		//$this->rPluginInfo['name']." is running... ";
    $this->rPluginInfo[ 'name'] = 'Yii2 Plugin';
    $this->rPluginInfo[ 'version'] = '0.0.1 (beta)';
    $this->rPluginInfo[ 'vendor'] = 'AksiIDE.com';

    // create plugin menu
    $this->AddFunction( 'Yii2|&App Generator', array( 'name'=>'Handler', 'cmd'=>'GenerateApp'));

    return json_encode( $this->rPluginInfo);
	}
	public function variable_list( $args = array()) {
  	global $aParameter;
    $lsCommand = $aParameter['cmd'];
    // add variable
    switch ($lsCommand) {
    	case 'GenerateApp' :
		    $this->AddVariable( 'Application Name', array( 'name'=>'app_name', 'type'=>'edit', 'value'=>''));
		    $this->AddVariable( 'Database Host', array( 'name'=>'db_host', 'type'=>'edit', 'value'=>'localhost'));
		    $this->AddVariable( 'Database Username', array( 'name'=>'db_username', 'type'=>'edit', 'value'=>'root'));
		    $this->AddVariable( 'Database Password', array( 'name'=>'db_password', 'type'=>'edit', 'value'=>'root'));
		    $this->AddVariable( 'Database Name', array( 'name'=>'db_name', 'type'=>'edit', 'value'=>'panada'));
		    $this->AddVariable( 'Directory Target', array( 'name'=>'directory', 'type'=>'dir', 'value'=>'%dir%'));
        break;
    }

  	$laResult[ 'err'] = 0;
  	$laResult[ 'variable'] = $this->rVariable;
    return json_encode( $laResult);
	}

  public function Handler(){
  	global $aParameter;
    $lsCommand = $aParameter['cmd'];
    return $this->$lsCommand();
  }

  public function test(){
  	global $aParameter;
    $lsParameter = print_r( $aParameter, true);
  	$laResult[ 'err'] = 0;
    $laResult[ 'msg'] = "This is test";
    return json_encode( $laResult);
  }

  public function GenerateApp(){
  	global $aParameter;
    $laResult[ 'err'] = 1;
    if ( ($aParameter[ 'app_name'] == '') or ( $aParameter[ 'directory'] == '')){
      $laResult[ 'msg'] = 'Invalid parameter !';
      return json_encode( $laResult);
    }
    if ( !is_dir( $aParameter[ 'directory'])) {
      $laResult[ 'msg'] = 'Invalid Directory !';
      return json_encode( $laResult);
    }

    $lsAppName = ucwords( $aParameter[ 'app_name']);
    //$lsAppName = str_replace( ' ', '', $lsAppName);
    $aParameter[ 'app_name'] = $lsAppName;
    $aParameter[ 'app_shortname'] = str_replace( ' ', '', strtolower( $lsAppName));
    $lsDir = $aParameter[ 'directory'];
    $lsDirTarget = $lsDir . '/' . $aParameter[ 'app_shortname'];

    _CreateDirectory( $lsDirTarget, false);
    $lsDirSource = __DIR__ . '/templates/app/';
    _GeneratePluginFiles( $lsAppName, $lsDirSource, $lsDirTarget);

  	$laResult[ 'err'] = 0;
    $lsMsg = "DONE !"
    	. "\n\nApplication '".$lsAppName."' has been generated"
      . "\n\n";
    $laResult[ 'msg'] = $lsMsg;
    //-- open index file
    $lsFileName = $lsDirTarget . "/index.php";
    //-- open project file
    $lsFileName = $lsDirTarget . "/$lsAppName.aprj";
    $laResult[ 'command'] = 'fileopen';
    $laResult[ 'parameter'] = $lsFileName;
    return json_encode( $laResult);
  }

}

function _GeneratePluginFiles( $psPluginName, $psDirSource, $psDirTarget){
	$lsPluginShortname = strtolower( $psPluginName);
  $laFiles = scandir( $psDirSource);
	foreach ($laFiles as $lsFileName) {
		if ( $lsFileName == "." ) continue;
		if ( $lsFileName == ".." ) continue;

		$laTargetDir = explode( "/", $psDirSource);
		$lsTargetDir = "";
		for ($liI = 1; $liI < count( $laTargetDir); $liI++) {
			$lsTargetDir .= $laTargetDir[ $liI] . "/";
		}
		$lsTargetDir = "$psDirTarget/$lsFileName";

		$lsType = filetype( "$psDirSource/$lsFileName");
		if ( $lsType == "dir"){
    	//$lsTargetDir = str_replace("%plugin.name%", $psPluginName, $lsTargetDir);
    	//$lsTargetDir = str_replace("%plugin.shortname%", $lsPluginShortname, $lsTargetDir);
      $lsTargetDir = _ConvertFileName( $lsTargetDir);
			_CreateDirectory( $lsTargetDir);
      $lsDir = $psDirSource . $lsFileName . '/';
			_GeneratePluginFiles( $psPluginName, $lsDir, $lsTargetDir);
		}else{ //-- copy dari templates
			$lsSourceFile = "$psDirSource/$lsFileName";
			$laSource = _ReadFile( $lsSourceFile);
      $lsSource = $laSource['content'];

			$lsTargetFile = str_replace( "_____", $lsPluginShortname, $lsTargetDir);
      $lsTargetFile = _ConvertFileName( $lsTargetFile);
      $lsSource = _ConvertContent( $lsSource, _ConvertFileName( $lsFileName));
			_SaveFile( $lsTargetFile, $lsSource);

		}//-- if ( $lsType == "dir")

  }//-- foreach ($laFiles as $lsFileName) {

}


$PlugIn = new Panada(0);
echo $PlugIn->$sFunctionName( );

