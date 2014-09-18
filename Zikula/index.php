<?php
//error_reporting( 0);
require_once "includes/libplugin.php";
require_once "includes/libs.php";


/**
 * ZikulaTableDef
 * @param  ___
 * @return ___
 */

class ZikulaTableDef extends AksiIDEPlugin {
	private static $instance;

	public function init() {
		//$this->rPluginInfo['name']." is running... ";
    $this->rPluginInfo[ 'name'] = 'Zikula - TableDef Generator';
    $this->rPluginInfo[ 'version'] = '0.0.1';
    $this->rPluginInfo[ 'vendor'] = 'LuriDarmawan @ KiOSS.com';

    // create plugin menu
    $this->AddFunction( 'Zikula|&Controller Generator', array( 'name'=>'Handler', 'cmd'=>'ControllerGenerator'));
    $this->AddFunction( 'Zikula|&DBObject/Model Generator', array( 'name'=>'Handler', 'cmd'=>'DBOjectGenerator'));
    $this->AddFunction( 'Zikula|&Handler Form Generator', array( 'name'=>'Handler', 'cmd'=>'HandlerFormGenerator'));
    $this->AddFunction( 'Zikula|&TableDef Generator', array( 'name'=>'Handler', 'cmd'=>'TableDefGenerator'));
    $this->AddFunction( 'Zikula|&Module Generator', array( 'name'=>'Handler', 'cmd'=>'ModuleGen'));

    return json_encode( $this->rPluginInfo);
	}
	public function variable_list( $args = array()) {
  	global $aParameter;
    $lsCommand = $aParameter['cmd'];
    // add variable
    switch ($lsCommand) {
    	case 'TableDefGenerator' :
		    $this->AddVariable( 'Module Name', array( 'name'=>'name', 'type'=>'edit', 'value'=>'%module.name%'));
    		$this->AddVariable( 'Database Type', array( 'name'=>'dbtype', 'type'=>'select', 'value'=>'0', 'options'=>'mysql|postgresql'));
		    $this->AddVariable( 'Hostname', array( 'name'=>'dbhostname', 'type'=>'edit', 'value'=>'%db.hostname%'));
    		$this->AddVariable( 'Username', array( 'name'=>'dbusername', 'type'=>'edit', 'value'=>'%db.username%'));
		    $this->AddVariable( 'Password', array( 'name'=>'dbpassword', 'type'=>'edit', 'value'=>'%db.password%'));
		    $this->AddVariable( 'Database Name', array( 'name'=>'dbname', 'type'=>'edit', 'value'=>'%db.name%'));
		    $this->AddVariable( 'Table Prefix', array( 'name'=>'dbtableprefix', 'type'=>'edit', 'value'=>'%db.tableprefix%'));
		    $this->AddVariable( 'Directory Target', array( 'name'=>'directory', 'type'=>'dir', 'value'=>'%project.dir%'));
      	break;
    	case 'ControllerGenerator' :
		    $this->AddVariable( 'Controller Name', array( 'name'=>'controller_name', 'type'=>'edit', 'value'=>''));
		    $this->AddVariable( 'Module Name', array( 'name'=>'module_name', 'type'=>'edit', 'value'=>'%module.name%'));
		    $this->AddVariable( 'Project Name', array( 'name'=>'project_name', 'type'=>'edit', 'value'=>'%project.name%'));
		    $this->AddVariable( 'Directory Target', array( 'name'=>'directory', 'type'=>'dir', 'value'=>'%dir%'));
      	break;
    	case 'HandlerFormGenerator' :
		    $this->AddVariable( 'Handler Name', array( 'name'=>'handler_name', 'type'=>'edit', 'value'=>''));
		    $this->AddVariable( 'Module Name', array( 'name'=>'module_name', 'type'=>'edit', 'value'=>'%module.name%'));
		    $this->AddVariable( 'Project Name', array( 'name'=>'project_name', 'type'=>'edit', 'value'=>'%project.name%'));
		    $this->AddVariable( 'Directory Target', array( 'name'=>'directory', 'type'=>'dir', 'value'=>'%dir%'));
      	break;
    	case 'DBOjectGenerator' :
		    $this->AddVariable( 'DBObject/Model Name', array( 'name'=>'model_name', 'type'=>'edit', 'value'=>''));
		    $this->AddVariable( 'Table Name', array( 'name'=>'table_name', 'type'=>'edit', 'value'=>''));
		    $this->AddVariable( 'Primary Key', array( 'name'=>'primary_key', 'type'=>'edit', 'value'=>'id'));
		    $this->AddVariable( 'Module Name', array( 'name'=>'module_name', 'type'=>'edit', 'value'=>'%module.name%'));
		    $this->AddVariable( 'Project Name', array( 'name'=>'project_name', 'type'=>'edit', 'value'=>'%project.name%'));
		    $this->AddVariable( 'Directory Target', array( 'name'=>'directory', 'type'=>'dir', 'value'=>'%dir%'));
      	break;
    	case 'ModuleGen' :
		    $this->AddVariable( 'Module Name', array( 'name'=>'module_name', 'type'=>'edit', 'value'=>''));
    		$this->AddVariable( 'Module ID', array( 'name'=>'module_id', 'type'=>'edit', 'value'=>''));
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

  public function ModuleGen(){
  	global $aParameter;
    $laResult[ 'err'] = 1;
    if ( ($aParameter[ 'module_name'] == '') or ($aParameter[ 'module_id'] == '') or ( $aParameter[ 'directory'] == '')){
      $laResult[ 'msg'] = 'Invalid parameter !';
      return json_encode( $laResult);
    }
    if ( !is_dir( $aParameter[ 'directory'])) {
      $laResult[ 'msg'] = 'Invalid Directory !';
      return json_encode( $laResult);
    }

    $lsModuleName = ucwords( $aParameter[ 'module_name']);
    $lsModuleName = str_replace( ' ', '', $lsModuleName);
    $aParameter[ 'module_name'] = $lsModuleName;
    $lsDirSource = __DIR__ . '/templates/modules/';
    $lsTargetDir = $aParameter[ 'directory'] . "/$lsModuleName";
    _CreateDirectory( $lsTargetDir);
    _GeneratePluginFiles( $lsModuleName, $lsDirSource, $lsTargetDir);

    $lsFileName = $lsTargetDir . '/' .  $lsModuleName . "-modules.aprj";
  	$laResult[ 'err'] = 0;
    $laResult[ 'msg'] = "Module '$lsModuleName' Created.";
    $laResult[ 'command'] = 'fileopen';
    $laResult[ 'parameter'] = $lsFileName;
    return json_encode( $laResult);
  }

  public function ControllerGenerator(){
  	global $aParameter;
    $laResult[ 'err'] = 1;
    if ( ($aParameter[ 'controller_name'] == '') or ($aParameter[ 'module_name'] == '') or ( $aParameter[ 'directory'] == '')){
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
    $aParameter[ 'controller_name_lowercase'] = strtolower( $lsModelName);

    $lsDirSource = __DIR__ . '/templates/controller/';
    $lsTargetDir = $aParameter[ 'directory'];
    _CreateDirectory( $lsTargetDir);
    _GeneratePluginFiles( $lsModelName, $lsDirSource, $lsTargetDir);

    $lsFileName = $lsTargetDir . '/' . "$lsModelName.php";

  	$laResult[ 'err'] = 0;
    $laResult[ 'msg'] = "Model '$lsModelName' Created.";
    $laResult[ 'command'] = 'fileopen';
    $laResult[ 'parameter'] = $lsFileName;
    return json_encode( $laResult);
  }

	public function HandlerFormGenerator(){
  	global $aParameter;
    $laResult[ 'err'] = 1;
    if ( ($aParameter[ 'handler_name'] == '') or ($aParameter[ 'module_name'] == '') or ( $aParameter[ 'directory'] == '')){
      $laResult[ 'msg'] = 'Invalid parameter !';
      return json_encode( $laResult);
    }
    if ( !is_dir( $aParameter[ 'directory'])) {
      $laResult[ 'msg'] = 'Invalid Directory !';
      return json_encode( $laResult);
    }

    $lsHandlerName = ucwords( $aParameter[ 'handler_name']);
    $lsHandlerName = str_replace( ' ', '_', $lsHandlerName);
    $aParameter[ 'handler_name'] = $lsHandlerName;
    $aParameter[ 'handler_name_lowercase'] = strtolower( $lsHandlerName);

    $lsDirSource = __DIR__ . '/templates/handler/';
    $lsTargetDir = $aParameter[ 'directory'];
    _CreateDirectory( $lsTargetDir);
    _GeneratePluginFiles( $lsHandlerName, $lsDirSource, $lsTargetDir);

    $lsFileName = $lsTargetDir . '/' . "$lsHandlerName.php";

  	$laResult[ 'err'] = 0;
    $laResult[ 'msg'] = "Model '$lsHandlerName' Created.";
    $laResult[ 'command'] = 'fileopen';
    $laResult[ 'parameter'] = $lsFileName;
    return json_encode( $laResult);
  }


  public function DBOjectGenerator(){
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

    $lsDirSource = __DIR__ . '/templates/dbobject/';
    $lsTargetDir = $aParameter[ 'directory'];
    _CreateDirectory( $lsTargetDir);
    _GeneratePluginFiles( $lsModelName, $lsDirSource, $lsTargetDir);

    $lsFileName = $lsTargetDir . '/' . "$lsModelName.php";

  	$laResult[ 'err'] = 0;
    $laResult[ 'msg'] = "Model '$lsModelName' Created.";
    $laResult[ 'command'] = 'fileopen';
    $laResult[ 'parameter'] = $lsFileName;
    return json_encode( $laResult);
  }

  public function TableDefGenerator(){
  	global $aParameter;
		require_once __DIR__ . "/../../php-includes/adodb/adodb.inc.php";

    $psModuleName = $aParameter['name'];
    $psDir = $aParameter['directory'];

    if ( empty($psModuleName) or empty($psDir)
    	or empty( $aParameter['dbhostname'])
    	or empty( $aParameter['dbusername'])
    	) {
    	return GenerateResult( 1, 'Uncomplete Parameter');
    }

    $psDatabase = 'mysql';
    if ( $aParameter['dbtype'] == 0) { $psDatabase = 'mysql';};
    if ( $aParameter['dbtype'] == 1) { $psDatabase = 'postgresql';};

		  //--- koneksi database
		  $pnrespon[ "db"] = 0;
		  $db = ADONewConnection( $psDatabase);
		  //$db->port = 3306;
		  $db->debug = false ;
		  $koneksi = $db->PConnect( $aParameter['dbhostname'], $aParameter['dbusername'], $aParameter['dbpassword'], $aParameter['dbname']);
		  //--- PROSES DISINI SMS-nya
		  if (!($koneksi)) {
	    	return GenerateResult( 2, "Failed Connection Database: " . $aParameter['dbname']);
		  }

    // get tables
	  $lsSQL = "SHOW TABLES";
	  $dq         = $db->Execute( $lsSQL);
	  $liTableCount = $dq->RecordCount();
	  while (!$dq->EOF) {
	    $aNamaTabel[] = $dq->fields;
	    $dq->MoveNext();
	  }


    // prepare output
		$lsHasil = "<?php\n"
			. "// Dibuat Dengan AksiIDE - TableDef Generator\n"
			. "// kopirait (k) 2008, KIOSS Project, AksiIDE - http://aksiide.com\n"
			. "//\n";
		$lsHasil .= ""
			. "function $psModuleName" . "_tables(){\n"
			. "\tglobal \$Aksi;\n"
			. "\t\$tables = array();\n"
			. "\n";

    $lsResult = "";
    foreach ( $aNamaTabel as $lsNamaTabel) {
			$liPos = strpos( $lsNamaTabel[0], $aParameter['dbtableprefix'] );
			if ($liPos === false) { continue;}

			$lsHasil .= "\n";
			$lsHasil .= "\t//-- Tabel : $lsNamaTabel[0]\n";
			$lsHasil .= "\t\$property = \"$lsNamaTabel[0]\";\n";
			$lsHasil .= "\t\$tables[ \"$lsNamaTabel[0]\"] = \$property;\n";
			$lsHasil .= "\t\$tables[ \"$lsNamaTabel[0]_column\"] = array(\n";

			$lsHasilColumnDef = "\t\$tables[ \"$lsNamaTabel[0]_column_def\"] = array(\n";

			$lsSQL = "SHOW COLUMNS FROM $lsNamaTabel[0]";
			$dq         = $db->Execute( $lsSQL);
			$liJmlField = $dq->RecordCount();

			while (!$dq->EOF){
				$lsNamaField = $dq->fields[0];
				$lsFieldType = $dq->fields[1];
				$lsFieldDefault = $dq->fields[4];

				//int
				$lsFieldType = str_replace("tinyint", "I1", $lsFieldType);
				$lsFieldType = str_replace("bigint", "I8", $lsFieldType);
				if ( strpos( $lsFieldType, 'int') !== false ) {
					$lsFieldType = "I";
				}
				$lsFieldType = str_replace("varchar", "C", $lsFieldType);
				$lsFieldType = str_replace("longtext", "XL", $lsFieldType);
				$lsFieldType = str_replace("mediumtext", "X", $lsFieldType);
				$lsFieldType = str_replace("text", "X", $lsFieldType);
				$lsFieldType = str_replace("datetime", "T", $lsFieldType);
				$lsFieldType = str_replace("timestamp", "T", $lsFieldType);
				$lsFieldType = str_replace("time", "T", $lsFieldType);
				$lsFieldType = str_replace("year", "D", $lsFieldType);
				$lsFieldType = str_replace("date", "D", $lsFieldType);
				//$lsFieldType = str_replace("double", "N(10.2)", $lsFieldType);
				//$lsFieldType = str_replace("float", "N(10.2)", $lsFieldType);
				$lsFieldType = str_replace("double", "F", $lsFieldType);
				$lsFieldType = str_replace("float", "F", $lsFieldType);

				//
				$lsFieldNull = "";
				if ( $dq->fields[2] == "NO" ){
					$lsFieldNull = "NOTNULL";
				}
				$lsFieldDefault = "";
				$lsS = trim( $dq->fields[4]);
				if ( $lsS == ""){
				}else{
					$lsFieldDefault = "DEFAULT " . $dq->fields[4];
				}
				$lsFieldKey = "";
				if ( $dq->fields[3] == "PRI" ){
					$lsFieldKey = "PRIMARY";
				}
				$lsFieldExtra = "";
				if ( $dq->fields[5] == "auto_increment" ){
					$lsFieldExtra = "AUTO";
				}

				$lsFieldDef = "";
				$lsFieldDef .= "$lsFieldType $lsFieldNull $lsFieldDefault $lsFieldExtra $lsFieldKey";
				$lsFieldDef = trim( $lsFieldDef);

				$lsHasil .= "\t\t\"$lsNamaField\" => \"$lsNamaField\", \n";
				$lsHasilColumnDef .= "\t\t\"$lsNamaField\" => \"$lsFieldDef\", \n";
				$dq->MoveNext();
			}
		//  $lsHasil .= "\t\t\"dummy\" => \"dummy\" \n";
			$lsHasilColumnDef .= "\t);\n";
			$lsHasil .= "\t);\n";

			$lsHasil .= $lsHasilColumnDef;
			$lsHasilColumnDef = "";

    } //-- foreach ( $aNamaTabel as $lsNamaTabel)

		$lsHasil .= "\n\n"
			. "  return \$tables;\n"
			. "}\n"
			. "\n";
		$lsHasil .= "?".">";

		$psTargetFile = $psDir . "/tables.php";
		$psTargetFile = str_replace( "\/", "/", $psTargetFile);
		$psTargetFile = str_replace( "//", "/", $psTargetFile);
		$fp = fopen( $psTargetFile, "w");
		fputs($fp, $lsHasil);
		fclose($fp);

    $lsParameter = print_r( $aParameter, true);
  	$laResult[ 'err'] = 0;
		$laResult[ 'msg'] = "Table Defs for '$psModuleName' generated."
    	. "\nfile:$psTargetFile";
    $laResult[ 'command'] = 'fileopen';
    $laResult[ 'parameter'] = $psTargetFile;
    return json_encode( $laResult);
  }

}//-- class ZikulaTableDef

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

$PlugIn = new ZikulaTableDef(0);
echo $PlugIn->$sFunctionName( );


