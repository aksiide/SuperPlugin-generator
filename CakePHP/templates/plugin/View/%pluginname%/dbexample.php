<h2><a href="<?php echo $this->base; ?>/%pluginshortname%">%pluginname%</a> : Your Mysql Access</h2>
<table>
	<thead><tr>
  	<th>Host</th>
    <th>User</th>
  </tr></thead>
<?php
foreach( $aData as $laItem ){
	$lsHTML = '<tr>';
  $lsHTML .= "<td>".$laItem['MyModel']['Host']."</td>";
  $lsHTML .= "<td>".$laItem['MyModel']['User']."</td>";
  $lsHTML .= '<tr>';
  echo $lsHTML;
}
?>
  <tbody>
  </tbody>
</table>

<p>
filename:
<pre>app/%pluginshortname%/View/%pluginname%/dbexample.php</pre>
</p>
