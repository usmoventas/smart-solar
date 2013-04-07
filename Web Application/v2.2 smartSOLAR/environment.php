<!DOCTYPE html>
<html>

<head>
<link href="css/960/960.css" rel="stylesheet" />
<link href="css/960/reset.css" rel="stylesheet" />
<link href="css/960/text.css" rel="stylesheet" />
<link href="css/default.css" rel="stylesheet" />
<link href="css/environment.css" rel="stylesheet" />
<script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="js/themes/smartSOLAR.js" type="text/javascript"></script>
<!-- DataTables CSS -->
<link href="css/dataTables.css" rel="stylesheet" type="text/css" />
<!-- jQuery -->
<script charset="utf8" src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
<!-- DataTables -->
<script charset="utf8" src="js/jquery.dataTables.min.js" type="text/javascript"></script>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="stylesheet" />
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<script>
  $(function() {
    $( "#datepicker" ).datepicker({ 
    	dateFormat: "d MM, yy", 
    	altField: "#sqlFormattedDate",
      altFormat: "yy-mm-dd",
      "maxDate": new Date()
    });
  });
  </script>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Environment - smartSOLAR</title>
<style type="text/css">
#datepicker {
	width: 147px;
}
</style>
</head>

<body>

<?php
	include('utilities/lock.php');
?>

<script type="text/javascript">
        $(document).ready(function() {
            var options = {
                chart: {
                    renderTo: 'graph',
                    type: 'line',
              //      marginRight: 130,
            //        marginBottom: 50
                },
                title: {
                    text: 'Irradiance and Temperature',
                    x: -20 //center
                },
                subtitle: {
                    text: 'Source: <?php echo $location ?>',
                    x: -20
                },
                xAxis: {
                	type: 'datetime',
                    categories: [],
                     labels: {
                    rotation: -45,
                    align: 'right',
                   }
                                 
				},
                yAxis: [{
                	min: 0,
                    title: {
                        text: 'Irradiance W/m2'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                    }]
                },{
                	min: 0,
                    title: {
                        text: 'Temperature C'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                    }],
                    opposite: true
                }],
               tooltip: {
                    formatter: function() {
                            return '<b>'+ this.series.name +'</b><br/>'+
                            this.x +': '+ this.y;
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -10,
                    y: 100,
                    borderWidth: 0
                },
                series: []
            }
            
             $.getJSON("utilities/environmentJSON.php?locParam=<?php echo $location?>&dateParam=<?php echo $date?>", function(json) {
                options.xAxis.categories = json[0]['data'];
                options.series[0] = json[1];
                options.series[1] = json[2];
                options.series[1].yAxis = 1;
                chart = new Highcharts.Chart(options);
            });
        });
        </script>
        
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
					<li class="last"><a href="index.php"><span>About</span></a></li>
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
			<h1>Environment</h1>
		</div>
		<div class="grid_7">
			<form action="" method="post">
				<select id="locations" name="location">
				<option value="">Select a location</option>
				<?php
						$result = mysql_query("SELECT * FROM locations");
						while ($row = mysql_fetch_array($result)) { ?>
				<option value="<?php echo $row['name']?>"><?php echo $row['name']?>
				</option>
				<?php } ?></select>
				<input id="datepicker" name="humandate" readonly="" type="text" value="Select a date" />
				<input id="sqlFormattedDate" name="thedate" readonly="" type="hidden" />
				<button id="submit" type="submit"><span>Load location data</span>
				</button>
			</form>
		</div>
		<div class="clear">
		</div>
		<div class="grid_12">
			<p>To generate an environment data report select a location and date 
			from the dropdown box above and hit 'load location data'.</p>
			<p>To only load historical data, leave the date field blank.</p>
		</div>
		<div class="clear">
		</div>
		<div id="data" class="container_12">
			<?php
				if($_SERVER["REQUEST_METHOD"] == "POST")
				{
					// Location sent from form
					$location=($_POST['location']);
					$date=($_POST['thedate']);
					$humandate=($_POST['humandate']);

					if($location != "Select a loaction"){?>
			<div class="grid_12">
				<h2>Report for <?php echo($location); ?></h2>
			</div>
			<div class="clear">
			</div>
			<?php if($humandate != "Select a date"){ ?>
			<script type="text/javascript">
        $(document).ready(function() {
            var options = {
                chart: {
                    renderTo: 'graph',
                    type: 'line',
              //      marginRight: 130,
            //        marginBottom: 50
                },
                title: {
                    text: 'Irradiance and Temperature',
                    x: -20 //center
                },
                subtitle: {
                    text: 'Source: <?php echo $location ?>',
                    x: -20
                },
                xAxis: {
                	type: 'datetime',
                    categories: [],
                     labels: {
                    rotation: -45,
                    align: 'right',
                   }
                                 
				},
                yAxis: [{
                	min: 0,
                    title: {
                        text: 'Irradiance W/m2'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                    }]
                },{
                	min: 0,
                    title: {
                        text: 'Temperature C'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                    }],
                    opposite: true
                }],
               tooltip: {
                    formatter: function() {
                            return '<b>'+ this.series.name +'</b><br/>'+
                            this.x +': '+ this.y;
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -10,
                    y: 100,
                    borderWidth: 0
                },
                series: []
            }
            
             $.getJSON("utilities/environmentJSON.php?locParam=<?php echo $location?>&dateParam=<?php echo $date?>", function(json) {
                options.xAxis.categories = json[0]['data'];
                options.series[0] = json[1];
                options.series[1] = json[2];
                options.series[1].yAxis = 1;
                chart = new Highcharts.Chart(options);
            });
        });
        </script>
        <div class="grid_12">
        <p>Irradiance and temperature data for <?php echo($humandate); ?>
				at the charging station in <?php echo($location); ?>.</p>
        </div>
			<div id="graph" class="grid_12">

			</div>
			<div class="clear">
			</div>
			<div>
				<br />
			</div>
			<div id="maximums" class="grid_4 prefix_8">
				<?php
					$con = mysql_connect("localhost","root","");
				
					if (!$con) {
					  die('Could not connect: ' . mysql_error());
					}
				
					mysql_select_db("smartsolar", $con);
					$result = mysql_query("SELECT MAX(irradiance) FROM environment WHERE location='".$location."' AND DATE(datetime) = '".$date."'");
					$maxirradiance =  mysql_fetch_array($result)[0];
					
					$result = mysql_query("SELECT MAX(temperature) FROM environment WHERE location='".$location."' AND DATE(datetime) = '".$date."'");
					$maxtemp =  mysql_fetch_array($result)[0];
					
					$result = mysql_query("SELECT MIN(temperature) FROM environment WHERE location='".$location."' AND DATE(datetime) = '".$date."'");
					$mintemp =  mysql_fetch_array($result)[0];

					mysql_close($con);
				?>
				<p>Maximum irradiance: <b><?php echo number_format($maxirradiance,3) ?>
				</b>W/m2</p>
				<p>Maximum temperature: <b><?php echo number_format($maxtemp,1) ?>
				</b>&deg;C</p>
				<p>Minumum temperature: <b><?php echo number_format($mintemp,1) ?>
				</b>&deg;C</p>
			</div>
			<div class="clear"></div>
			<?php } ?>
        <div class="grid_12">
        <p>Historical irradiance and temperature data at the charging station in <?php echo($location); ?>.</p>
        </div>

			<div class="grid_12" id="trends"></div>

			<script src="js/highstock.js" type="text/javascript"></script>
						<script src="js/themes/smartSOLAR.js" type="text/javascript"></script>


			<script>
$(function() {

$.getJSON('utilities/environmentTrendsJSON.php?locParam=<?php echo $location ?>', function(json) {
		// Create the chart
		$('#trends').highcharts('StockChart', {			
			buttons: [{
			    type: 'day',
			    count: 1,
			    text: '1d'
			}, {
			    type: 'week',
			    count: 1,
			    text: '1w'
			}, {
			    type: 'month',
			    count: 1,
			    text: '1m'
			}, {
			    type: 'ytd',
			    text: 'YTD'
			}, {
			    type: 'year',
			    count: 1,
			    text: '1y'
			}, {
			    type: 'all',
			    text: 'All'
			}],
			rangeSelector : {
			buttonTheme: { // styles for the buttons
	    		fill: 'none',
	    		stroke: 'none',
	    		style: {
	    			color: '#5E5E5E',
	    			fontWeight: 'bold'
	    		},
	    		states: {
	    			hover: {
	    				fill: '5E5E5E'
	    			},
	    			select: {
	    				style: {
	    					color: 'white'
	    				}
	    			}
	    		}
	    	},
	    	inputStyle: {
	    		color: '#039',
	    		fontWeight: 'bold'
	    	},
	    	labelStyle: {
	    		color: 'silver',
	    		fontWeight: 'bold'
	    	},
				selected : 1,
				inputEnabled: false,
				buttons: [{
					type: 'day',
					count: 1,
					text: '1d'
				}, {
					type: 'week',
					count: 1,
					text: '1w'
				}, {
					type: 'month',
					count: 1,
					text: '1m'
				}, {
					type: 'ytd',
					text: 'YTD'
				}, {
					type: 'year',
					count: 1,
					text: '1y'
				}, {
					type: 'all',
					text: 'All'
				}]
			},

			title : {
				text : 'Environment History'
			},
			 subtitle: {
                    text: 'Source: <?php echo $location ?>',
                },
scrollbar: {
				barBackgroundColor: 'gray',
				barBorderRadius: 7,
				barBorderWidth: 0,
				buttonBackgroundColor: 'gray',
				buttonBorderWidth: 0,
				buttonBorderRadius: 7,
				trackBackgroundColor: 'none',
				trackBorderWidth: 1,
				trackBorderRadius: 8,
				trackBorderColor: '#CCC'
		    },
                yAxis: [{
                	min: 0,
                    plotLines: [{
                        value: 0,
                        width: 1,
                    }]
                },{
                	min: 0,
                	opposite: true,
                    plotLines: [{
                        value: 0,
                        width: 1,
                    }]
                }],
			
			series : [{
				name : 'Irradiance: ',
				data : json[0],
				type: 'areaspline',
				tooltip: {
					valueDecimals: 2
				}
			},{
				name : 'Temperature: ',
				data : json[1],
				type: 'spline',
				yAxis: 1,
				tooltip: {
					valueDecimals: 2
				}
			},]
		});
	});

});
</script>
			<div class="clear"></div>
			<div class="grid_12">
							<p>Below is list of all historical samples recorded for the environment conditions.</p>
			</div>
			<div class="grid_6">
			<table id="enSamples">
				<thead>
					<tr>
						<th>Time Sampled</th>
						<th>Irradiance</th>
						<th>Temperature</th>
					</tr>
				</thead>
				<?php
					$con = mysql_connect("localhost","root","");
				
					if (!$con) {
					  die('Could not connect: ' . mysql_error());
					}
				
					mysql_select_db("smartsolar", $con);

				
					$result = mysql_query("SELECT * FROM environment WHERE location='".$location."'");
					while ($row = mysql_fetch_array($result)) { ?>
				<tr>
					<?php $time = strtotime($row['datetime'])?>
					<td><?php echo date('d-m-y H:i',$time)?></td>

					<td><?php echo number_format($row['irradiance'],2)?></td>
					<td><?php echo number_format($row['temperature'],2)?></td>
				</tr>
				<?php } ?>
			</table>
		</div>
<!-- DataTables -->
<script charset="utf8" src="js/jquery.dataTables.min.js" type="text/javascript"></script>

		  <script type="text/javascript">
			$(function() {
					$('#enSamples').dataTable( {
					"sScrollY": "300px",
					"bPaginate": true,
					"aaSorting": [[ 0, "desc" ]]
			} )
			});
</script>
				<div class="grid_4 prefix_2">
				<?php
					$result = mysql_query("SELECT MAX(irradiance) FROM environment WHERE location='".$location."'");
					$peakirradiance =  mysql_fetch_array($result)[0];
					
					$result = mysql_query("SELECT AVG(irradiance) FROM environment WHERE location='".$location."'");
					$avirradiance =  mysql_fetch_array($result)[0];
					
					$result = mysql_query("SELECT MAX(temperature) FROM environment WHERE location='".$location."'");
					$peaktemp =  mysql_fetch_array($result)[0];
					
					$result = mysql_query("SELECT AVG(temperature) FROM environment WHERE location='".$location."'");
					$avtemp =  mysql_fetch_array($result)[0];
					
					$result = mysql_query("SELECT MIN(temperature) FROM environment WHERE location='".$location."'");
					$mintemp =  mysql_fetch_array($result)[0];					
					
				?>
				<h3>Overall Measurements</h3>
				<p>Maximum irradiance: <b><?php echo number_format($peakirradiance,3) ?>
				</b>W/m2</p>
				<p>Average irradiance: <b><?php echo number_format($avirradiance,3) ?>
				</b>W/m2</p>
				<p><br/>Maximum temperature: <b><?php echo number_format($peaktemp,1) ?>
				</b>&deg;C</p>
				<p>Average temperature: <b><?php echo number_format($avtemp,1) ?>
				</b>&deg;C</p>
				<p>Minumum temperature: <b><?php echo number_format($mintemp,1) ?>
				</b>&deg;C</p>
			</div>
			<div class="clear"></div>

			<?php }
				}
			?></div>
	</div>
	<div>
		<br />
	</div>
</div>
<footer>
	<div id="container" class="container_12">
		<div id="footer1" class="grid_4">
			<img alt="Affiliate Logos" src="images/logos.png" /></div>
		<div id="footer2" class="grid_4">
			<br />
			<h4>Site Index</h4>
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="summary.php">Summary</a></li>
				<li><a href="environment.php">Environment Data</a></li>
				<li><a href="systemInformation.php">System Information</a></li>
				<li><a href="loadDetails.php">Battery Details</a></li>

			</ul>
		</div>
		<div id="footer3" class="grid_4 ">
			<br />
			<h4>Contacts</h4>
			<ul>
				<li><a href="http://www.strath.ac.uk">University of Strathclyde</a></li>
				<li><a href="http://www.strath.ac.uk/eee/gambiaproject/">Gambia 
				Project</a></li>
				<li><a href="http://www.strath.ac.uk/viprojects/">VIP</a></li>
				<li><a href="http://arduino.cc">Arduino</a></li>
			</ul>
		</div>
	</div>
</footer>


</body>

</html>