<?php
//error_reporting( 0);
require_once "includes/libplugin.php";
require_once "includes/libs.php";

global $sDir;


/**
 * class CakePHP
 *
 * @package
 */
class CakePHP extends AksiIDEPlugin {
	private static $instance;

	public function init() {
		//$this->rPluginInfo['name']." is running... ";
    $this->rPluginInfo[ 'name'] = 'CodeIgniter Plugin';
    $this->rPluginInfo[ 'version'] = '0.0.1 (beta)';
    $this->rPluginInfo[ 'vendor'] = 'AksiIDE.com';

    // create plugin menu
    $this->AddFunction( 'CodeIgniter|&Controller Generator', array( 'name'=>'Handler', 'cmd'=>'ControllerGen'));
    $this->AddFunction( 'CodeIgniter|&Model Generator', array( 'name'=>'Handler', 'cmd'=>'ModelGen'));
    $this->AddFunction( 'CodeIgniter|M&odules Generator', array( 'name'=>'Handler', 'cmd'=>'ModulesGen'));

    return json_encode( $this->rPluginInfo);
	}
	public function variable_list( $args = array()) {
  	global $aParameter;
    $lsCommand = $aParameter['cmd'];
    // add variable
    switch ($lsCommand) {
    	case 'ControllerGen' :
		    $this->AddVariable( 'Controller Name', array( 'name'=>'controller_name', 'type'=>'edit', 'value'=>''));
		    $this->AddVariable( 'Extends Name', array( 'name'=>'extends_name', 'type'=>'edit', 'value'=>'MX_Controller'));
		    $this->AddVariable( 'Directory Target', array( 'name'=>'directory', 'type'=>'dir', 'value'=>'%dir%'));
        break;
    	case 'ModelGen' :
		    $this->AddVariable( 'Model Name', array( 'name'=>'model_name', 'type'=>'edit', 'value'=>''));
		    $this->AddVariable( 'Directory Target', array( 'name'=>'directory', 'type'=>'dir', 'value'=>'%dir%'));
        break;
    	case 'ModulesGen' :
		    $this->AddVariable( 'Module Name', array( 'name'=>'module_name', 'type'=>'edit', 'value'=>''));
		    $this->AddVariable( 'Table Name', array( 'name'=>'table_name', 'type'=>'edit', 'value'=>'your_table_name'));
		    $this->AddVariable( 'Primary Key', array( 'name'=>'primary_key', 'type'=>'edit', 'value'=>'id'));
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

  public function ControllerGen(){
  	global $aParameter;
    $laResult[ 'err'] = 1;
    if ( ($aParameter[ 'controller_name'] == '') or ( $aParameter[ 'directory'] == '')){
      $laResult[ 'msg'] = 'Invalid parameter !';
      return json_encode( $laResult);
    }
    if ( !is_dir( $aParameter[ 'directory'])) {
      $laResult[ 'msg'] = 'Invalid Directory !';
      return json_encode( $laResult);
    }
    $lsClassName = ucwords( $aParameter[ 'controller_name']);
    $lsClassName = str_replace( ' ', '', $lsClassName);
    $aParameter[ 'class_name'] = $lsClassName;
    $lsModelName = $aParameter[ 'controller_name'];
    $lsModelName = str_replace( ' ', '', $lsModelName);
    $aParameter[ 'controller_name'] = $lsModelName;

    $lsDirSource = __DIR__ . '/templates/controller/';
    _GeneratePluginFiles( $lsModelName, $lsDirSource, $aParameter[ 'directory']);

    $lsFileName = $aParameter[ 'directory'] . '/' .  $lsModelName . ".php";
  	$laResult[ 'err'] = 0;
    $laResult[ 'msg'] = "Controller '$lsModelName' Created.";
    $laResult[ 'command'] = 'fileopen';
    $laResult[ 'parameter'] = $lsFileName;
    return json_encode( $laResult);
  }

  public function ModelGen(){
  	global $aParameter;
    $laResult[ 'err'] = 1;
    if ( ($aParameter[ 'model_name'] == '') or ( $aParameter[ 'directory'] == '')){
      $laResult[ 'msg'] = 'Invalid parameter !';
      return json_encode( $laResult);
    }
    if ( !is_dir( $aParameter[ 'directory'])) {
      $laResult[ 'msg'] = 'Invalid Directory !';
      return json_encode( $laResult);
    }
    $lsClassName = ucwords( $aParameter[ 'model_name']);
    $lsClassName = str_replace( ' ', '', $lsClassName);
    $aParameter[ 'class_name'] = $lsClassName;
    $lsModelName = $aParameter[ 'model_name'];
    $lsModelName = str_replace( ' ', '', $lsModelName);
    $aParameter[ 'model_name'] = $lsModelName;

    $lsDirSource = __DIR__ . '/templates/model/';
    _GeneratePluginFiles( $lsModelName, $lsDirSource, $aParameter[ 'directory']);

    $lsFileName = $aParameter[ 'directory'] . '/' .  $lsModelName . "_model.php";
  	$laResult[ 'err'] = 0;
    $laResult[ 'msg'] = "Model '$lsModelName' Created.";
    $laResult[ 'command'] = 'fileopen';
    $laResult[ 'parameter'] = $lsFileName;
    return json_encode( $laResult);
  }


}//-- class CakePHP


/**
 * function _GeneratePluginFiles
 *
 * @params $psPluginName
 * @params $psDirSource
 * @params $psDirTarget
 * @return
 */
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


$PlugIn = new CakePHP(0);
echo $PlugIn->$sFunctionName( );

/*
D:\garapan\AksiIDE\bin\AksiIDE\app\plugins\php\CakePHP\index.php
Handler
pluginname=namapluginok
dbconfig=default
directory=C:%5Chome%5Ccoba%5Cpublic_html%5Ccakephp-2.4.0%5Capp%5CPlugin%5Cjadi
cmd=GeneratePlugin

index.php Handler pluginname=namapluginok dbconfig=default directory=C:%5Chome%5Ccoba%5Cpublic_html%5Ccakephp-2.4.0%5Capp%5CPlugin%5Cjadi cmd=GeneratePlugin
*/

