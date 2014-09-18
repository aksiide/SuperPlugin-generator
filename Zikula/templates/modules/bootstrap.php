<?php
/**
 * Project Name:
 * File: bootstrap.php
 *
 * @author     ______________________
 * @copyright
 * @Generated %date%
 * @package %module_name%
 * @generator  AksiIDE, http://www.aksiide.com
 *
 **/



// Bootstrap - Used for global setup at module load time.
$helper = ServiceUtil::getService('doctrine_extensions');
$helper->getListener('sluggable');
$helper->getListener('standardfields');

