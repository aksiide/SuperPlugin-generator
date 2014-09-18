<?php


//===========================================================================//
// _CreateDirectory
//---------------------------------------------------------------------------//
function _CreateDirectory( $psDir){
  if ( !file_exists( $psDir)) {
    mkdir( $psDir, 755, true);
    $lsISI = "http://aksiide.com";
    _SaveFile( "$psDir/index.html", $lsISI);
  }
}
//===========================================================================//
// Save File
//---------------------------------------------------------------------------//
function _SaveFile( $psNamaFile, $psIsi){
	global $sNamaModul;
	$lsTargetFile = str_replace("%namamodul%", $sNamaModul, $psNamaFile);

	$path_parts = pathinfo( $lsTargetFile);
  $lsNamaFile = $path_parts[ "filename"] . "." . @$path_parts[ "extension"];
  $psIsi = str_replace("%namafile%", $lsNamaFile, "$psIsi");

  $fp = fopen( $lsTargetFile, "w+");
  fwrite($fp, $psIsi);
  fclose($fp);
}
//===========================================================================//
// Read File
//---------------------------------------------------------------------------//
function _ReadFile( $psNamaFile){
  $laReturn["err"] = 0;
  $laReturn[ 'content'] = '';
  $handle = @fopen( $psNamaFile, "r");
  if ( !$handle){
	  return $laReturn;
  }
  $lsISI = @fread($handle, filesize($psNamaFile));
  @fclose( $handle);
  $laReturn[ 'content'] = $lsISI;
  return $laReturn;
}

function _ConvertFileName( $psFileName){
	global $aParameter;
  $lsFileName = $psFileName;
  foreach( $aParameter as $lsKey => $lsValue ){
  	$lsSearch = "%$lsKey%";
    $lsFileName = str_replace( $lsSearch, $lsValue, $lsFileName);
  }
	return $lsFileName;
}

function _ConvertContent( $psContent, $psFileName = ''){
	global $aParameter;
  $lsContent = $psContent;
  foreach( $aParameter as $lsKey => $lsValue ){
  	$lsSearch = "%$lsKey%";
    $lsContent = str_replace( $lsSearch, $lsValue, $lsContent);
  }
  if ( $psFileName != ''){
  	$lsContent = str_replace( '%filename%', $psFileName, $lsContent);
  }
  $lsContent = str_replace( '%date%', date( 'Y-m-d H:i:s'), $lsContent);
	return $lsContent;
}



