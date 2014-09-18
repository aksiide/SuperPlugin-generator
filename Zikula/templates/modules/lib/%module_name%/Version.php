<?php
%header%

class %module_name%_Version extends Zikula_AbstractVersion {

	/**
	 * Module meta data.
	 *
	 * @return array Module metadata.
	*/
	public function getMetaData() {
  	$meta = array();
		$meta["displayname"]    = $this->__( "%module_name%");
		$meta["description"]    = $this->__( "%module_name% Module");

		//! module name that appears in URL
    // your module page : http://....../%module_id%
		$meta["url"]            = $this->__( "%module_id%");

		$meta["version"]        = "0.0.1";
		$meta["securityschema"] = array(
    	"%module_name%::"      => "::",
	    "%module_name%:User:"  => "UserName::"
    );

		// Example Module depedencies
    /*
		$meta['dependencies'] = array(
			array(
				'modname' => 'MyAksi',
				'minversion' => '0.12.0',
				'maxversion' => '',
				'status' => ModUtil::DEPENDENCY_RECOMMENDED,
			),
			array(
				'modname' => 'CustomerManagement',
				'minversion' => '0.0.1',
				'maxversion' => '',
				'status' => ModUtil::DEPENDENCY_RECOMMENDED,
			),
		);
    */
		return $meta;
	}
}
