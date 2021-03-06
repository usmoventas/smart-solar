<!DOCTYPE html>
<html>

<head>
<link href="css/960/960.css" rel="stylesheet" />
<link href="css/960/reset.css" rel="stylesheet" />
<link href="css/960/text.css" rel="stylesheet" />
<link href="css/default.css" rel="stylesheet" />
<link href="css/summary.css" rel="stylesheet" />


<script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="js/highcharts.js" type="text/javascript"></script>
<script src="js/themes/gray.js" type="text/javascript"></script>
<!-- DataTables CSS -->
<link href="css/dataTables.css" rel="stylesheet" type="text/css">
<!-- jQuery -->
<script charset="utf8" src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
<!-- DataTables -->
<script charset="utf8" src="js/jquery.dataTables.min.js" type="text/javascript"></script>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="stylesheet" />
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<link href="/resources/demos/style.css" rel="stylesheet" />


<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Summary - smartSOLAR</title>

<script type="text/javascript">
$(document).ready(function() {
	$('#locations').dataTable( {
		"sScrollY": "310px",
		"bPaginate": false
	} );
} );</script>


</head>

<body>
<?php
	include('utilities/lock.php');
?>
<header>
	<div class="container_12">
		<div class="grid_3">
			<a href="index.php">
			<img alt="smartSOLAR" src="images/smartSolarHeader.png" /> </a>
		</div>
		<div class="grid_7">
			<br />
			<div id="cssmenu">
				<ul>
					<li class="active"><a href="summary.php"><span>Summary</span></a></li>
					<li class="has-sub"><a href="#"><span>Charging Station</span></a>
					<ul>
						<li><a href="environment.php"><span>Environment</span></a></li>
						<li class="last"><a href="systemInformation.php"><span>System Information</span></a></li>
					</ul>
					</li>
					<li><a href="loadDetails.php"><span>Battery Load</span></a></li>
					<li class="last"><a href="about.html"><span>About</span></a></li>
				</ul>
			</div>
		</div>
		<div id="logout" class="grid_2">
			<br />
			Welcome <?php echo $login_session;?>.<br />
			<a href="logout.php">Sign out</a> </div>
	</div>
</header>
<div id="content">
	<div class="container_12">
		<div>
			<br />
		</div>
		<div class="grid_4 prefix_1">
			<h1>Summary</h1>
		</div>
		<div class="clear">
		</div>
		<div class="grid_12">
			<p>A list of the charging stations currently being monitored can be 
			found below, along with geographical locations and system statuses.</p>
		</div>
		<div class="clear">
		</div>
	
		<div class="grid_6">
		<table id="locations">
			<thead>
			<tr>
				<th>Location</th>
				<th>Last Updated</th>
			</tr>
			</thead>
			<tbody>
			<?php
				$result = mysql_query("SELECT * FROM locations");
				while ($row = mysql_fetch_array($result)) { ?>
					<tr>
						<td><?php echo $row['name']?></td>
						<?php $time = strtotime($row['lastUpdated'])?>
						<td><?php echo date('d-m-y H:i',$time)?></td>
					</tr> 
				<?php } ?>	
			</tbody>
		</table>
		</div>
		<div class="grid_6">
			<iframe frameborder="0" height="350" marginheight="0" marginwidth="0" scrolling="no" src="https://maps.google.co.uk/maps/ms?msa=0&amp;msid=213975019524709072744.0004d8b18f49135a416da&amp;ie=UTF8&amp;t=h&amp;ll=13.664669,-15.02037&amp;spn=0.233523,0.315857&amp;z=11&amp;output=embed" width="460">
			</iframe><br />
			<small>View
			<a href="https://maps.google.co.uk/maps/ms?msa=0&amp;msid=213975019524709072744.0004d8b18f49135a416da&amp;ie=UTF8&amp;t=h&amp;ll=13.664669,-15.02037&amp;spn=0.233523,0.315857&amp;z=11&amp;source=embed" style="color: #0000FF; text-align: left">
			smartSOLAR locations</a> in a larger map</small> </div>
		<div class="clear">
		</div>
		<div class="grid_6 prefix_3">
			<br />
			<br />
			<button id="button" onclick="parent.location='environment.php'" type="button">
			Go to charging station details</button><br />
			<br />
		</div>
	</div>
</div>
<footer>
	<div id="container" class="container_12">
		<div id="footer1" class="grid_4">
&nbsp;<img alt="Affiliate Logos" src="images/logos.png" /></div>
		<div id="footer2" class="grid_4">
			<br />
			<h4>Site Index</h4>
			<ul>
				<li>Stuff</li>
				<li>More Stuff</li>
			</ul>
		</div>
		<div id="footer3" class="grid_4 ">
			<br />
			<h4>Contacts</h4>
			<ul>
				<li><a href="http://www.strath.ac.uk">University of Strathclyde</a></li>
				<li><a href="http://www.strath.ac.uk/eee/gambiaproject/">Gambia 
				Project</a></li>
				<li><a href="http://arduino.cc">Arduino</a></li>
			</ul>
		</div>
	</div>
</footer>

</body>

</html>
