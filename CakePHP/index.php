<?php
//error_reporting( 0);
require_once "includes/libplugin.php";
require_once "includes/libs.php";

global $sDir;

/**
 * CakePHP
 * @param  ___
 * @return ___
 */

class CakePHP extends AksiIDEPlugin {
	private static $instance;

	public function init() {
		//$this->rPluginInfo['name']." is running... ";
    $this->rPluginInfo[ 'name'] = 'CakePHP Plugin';
    $this->rPluginInfo[ 'version'] = '0.0.1 (beta)';
    $this->rPluginInfo[ 'vendor'] = 'AksiIDE.com';

    // create plugin menu
    $this->AddFunction( 'CakePHP|&Controller Generator', array( 'name'=>'Handler', 'cmd'=>'GenerateController'));
    $this->AddFunction( 'CakePHP|&Model Generator', array( 'name'=>'Handler', 'cmd'=>'GenerateModel'));
    $this->AddFunction( 'CakePHP|&Plugin Generator', array( 'name'=>'Handler', 'cmd'=>'GeneratePlugin'));
    $this->AddFunction( 'CakePHP|C&omponent Generator', array( 'name'=>'Handler', 'cmd'=>'GenerateComponent'));
    //$this->AddFunction( 'CakePHP|Test', array( 'name'=>'Handler', 'cmd'=>'test'));

    return json_encode( $this->rPluginInfo);
	}
	public function variable_list( $args = array()) {
  	global $aParameter;
    $lsCommand = $aParameter['cmd'];
    // add variable
    switch ($lsCommand) {
    	case 'GenerateController' :
		    $this->AddVariable( 'Controller Name', array( 'name'=>'controller_name', 'type'=>'edit', 'value'=>''));
		    $this->AddVariable( 'Plugin Name', array( 'name'=>'plugin_name', 'type'=>'edit', 'value'=>''));
		    $this->AddVariable( 'Directory Target', array( 'name'=>'directory', 'type'=>'dir', 'value'=>'%dir%'));
        break;
    	case 'GeneratePlugin' :
		    $this->AddVariable( 'Plugin Name', array( 'name'=>'pluginname', 'type'=>'edit', 'value'=>''));
		    $this->AddVariable( 'Database Config', array( 'name'=>'dbconfig', 'type'=>'edit', 'value'=>'default'));
		    $this->AddVariable( 'Directory Target', array( 'name'=>'directory', 'type'=>'dir', 'value'=>'%dir%'));
        break;
    	case 'GenerateModel' :
		    $this->AddVariable( 'Model Name', array( 'name'=>'model_name', 'type'=>'edit', 'value'=>''));
		    $this->AddVariable( 'Table Name', array( 'name'=>'table_name', 'type'=>'edit', 'value'=>'your_table_name'));
		    $this->AddVariable( 'Primary Key', array( 'name'=>'primary_key', 'type'=>'edit', 'value'=>'id'));
		    $this->AddVariable( 'Directory Target', array( 'name'=>'directory', 'type'=>'dir', 'value'=>'%dir%'));
        break;
    	case 'GenerateComponent' :
		    $this->AddVariable( 'Component Name', array( 'name'=>'component_name', 'type'=>'edit', 'value'=>''));
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

  public function GenerateController(){
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
    $lsModelName = ucwords( $aParameter[ 'controller_name']);
    $lsModelName = str_replace( ' ', '', $lsModelName);
    $aParameter[ 'controller_name'] = $lsModelName;

    $lsDirSource = __DIR__ . '/templates/controller/';
    _GeneratePluginFiles( $lsModelName, $lsDirSource, $aParameter[ 'directory']);

    $lsFileName = $aParameter[ 'directory'] . '/' .  $lsModelName . "Controller.php";
  	$laResult[ 'err'] = 0;
    $laResult[ 'msg'] = "Controller '$lsModelName' Created.";
    $laResult[ 'command'] = 'fileopen';
    $laResult[ 'parameter'] = $lsFileName;
    return json_encode( $laResult);
  }

  public function GenerateModel(){
  	global $aParameter;
    $laResult[ 'err'] = 1;
    if ( ($aParameter[ 'model_name'] == '') or ($aParameter[ 'table_name'] == '') or ( $aParameter[ 'directory'] == '')){
      $laResult[ 'msg'] = 'Invalid parameter !';
      return json_encode( $laResult);
    }
    if ( !is_dir( $aParameter[ 'directory'])) {
      $laResult[ 'msg'] = 'Invalid Directory !';
      return json_encode( $laResult);
    }
    $lsModelName = ucwords( $aParameter[ 'model_name']);
    $lsModelName = str_replace( ' ', '', $lsModelName);
    $aParameter[ 'model_name'] = $lsModelName;

    $lsDirSource = __DIR__ . '/templates/model/';
    _GeneratePluginFiles( $lsModelName, $lsDirSource, $aParameter[ 'directory']);

    $lsFileName = $aParameter[ 'directory'] . '/' .  $lsModelName . ".php";
  	$laResult[ 'err'] = 0;
    $laResult[ 'msg'] = "Model '$lsModelName' Created.";
    $laResult[ 'command'] = 'fileopen';
    $laResult[ 'parameter'] = $lsFileName;
    return json_encode( $laResult);
  }

  public function GenerateComponent()
  {
  	global $aParameter;
    $laResult[ 'err'] = 1;
    if ( ($aParameter[ 'component_name'] == '') or ( $aParameter[ 'directory'] == '')){
      $laResult[ 'msg'] = 'Invalid parameter !';
      return json_encode( $laResult);
    }
    if ( !is_dir( $aParameter[ 'directory'])) {
      $laResult[ 'msg'] = 'Invalid Directory !';
      return json_encode( $laResult);
    }
    $component_name = ucwords( $aParameter[ 'component_name']);
    $component_name = str_replace( ' ', '', $component_name);
    $aParameter[ 'component_name'] = $component_name;

    $lsDirSource = __DIR__ . '/templates/component/';
    _GeneratePluginFiles( $component_name, $lsDirSource, $aParameter[ 'directory']);

    $lsFileName = $aParameter[ 'directory'] . '/' .  $component_name . "Component.php";
  	$laResult[ 'err'] = 0;
    $laResult[ 'msg'] = "Component '$component_name' Created.";
    $laResult[ 'command'] = 'fileopen';
    $laResult[ 'parameter'] = $lsFileName;
    return json_encode( $laResult);
  }





  public function GeneratePlugin(){
  	global $aParameter;
    $laResult[ 'err'] = 1;
    if ( ($aParameter[ 'pluginname'] == '') or ( $aParameter[ 'directory'] == '')){
      $laResult[ 'msg'] = 'Invalid parameter !';
      return json_encode( $laResult);
    }
    if ( !is_dir( $aParameter[ 'directory'])) {
      $laResult[ 'msg'] = 'Invalid Directory !';
      return json_encode( $laResult);
    }

    $lsPluginName = ucwords( $aParameter[ 'pluginname']);
    $lsPluginName = str_replace( ' ', '', $lsPluginName);
    $aParameter[ 'pluginname'] = $lsPluginName;
    $aParameter[ 'pluginshortname'] = strtolower( $lsPluginName);
    $lsDir = $aParameter[ 'directory'];
    $lsDirTarget = $lsDir . '/' . $lsPluginName;

    _CreateDirectory( $lsDirTarget);
    //chdir( $lsDirTarget);
    $lsDirSource = __DIR__ . '/templates/plugin/';
    _GeneratePluginFiles( $lsPluginName, $lsDirSource, $lsDirTarget);

    $aParameter[ 'pluginname'] = $lsPluginName;
    $aParameter[ 'pluginname'] = str_replace( ' ', '', $aParameter[ 'pluginname']);
    $lsParameter = print_r( $aParameter, true);
  	$laResult[ 'err'] = 0;
    $lsMsg = "DONE !"
    	. "\n\nPlugin '".$lsPluginName."' has been generated"
      . "\n\nmake sure you add line to file 'app/Config/bootstrap.php' whith this code: "
      . "\n\n    CakePlugin::load('$lsPluginName', array('routes'=>true,'bootstrap'=>true));"
      . "\n\n";
    $lsFileName = "$lsDirTarget/Controller/".$lsPluginName."Controller.php";
    $lsFileName = "$lsDirTarget/".$lsPluginName."-plugin.aprj";
    $laResult[ 'msg'] = $lsMsg;
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

