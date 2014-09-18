<?php

Configure::write( 'yourconfig', 'find this text @ %pluginname%/Config/bootstrap.php' );
Configure::write( 'Exception.handler',
	function( $error ) {
  	echo "<br>error: ".$error->getMessage( )
    	. "<br><br>make sure you have configured the database, route or bootstrap.<br>file: app/Config/database.php"
    	;
    echo "<br><pre>This is error trapper @ '%pluginname%/Config/bootstrap.php'";
  }
);

