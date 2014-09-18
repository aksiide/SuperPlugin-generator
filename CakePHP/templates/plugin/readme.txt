
make sure add line :
CakePlugin::load('%pluginname%');
or
CakePlugin::load('%pluginname%', array('routes'=>true, 'bootstrap'=>true));


to file:
app/Config/bootstrap.php


