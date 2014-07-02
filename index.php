<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			SensorTest.org - Sensor Modelling
		</title>

		<!-- JS: jQuery -->
		<script src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript"></script>

		<!-- JS: HighCharts -->
		<script src="http://code.highcharts.com/highcharts.js" type="text/javascript"></script>
		<script src="http://code.highcharts.com/maps/modules/map.js" type="text/javascript"></script>
		<script src="http://code.highcharts.com/modules/exporting.js" type="text/javascript"></script>

		<!-- JS -->
		<script src="scripts/sampler.js" type="text/javascript"></script>
		<script src="scripts/chart.js" type="text/javascript"></script>

		<!-- CSS: Bootstrap -->
		<link href="styles/third-party/bootstrap.min.css" rel="stylesheet" type="text/css">

		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="styles/base.css">
		<link rel="stylesheet" type="text/css" href="styles/sampler.css">

		<!-- JS: WhichBrowser -->
		<script type="text/javascript">
(function(){var p=[],w=window,d=document,e=f=0;p.push('ua='+encodeURIComponent(navigator.userAgent));e|=w.ActiveXObject?1:0;e|=w.opera?2:0;e|=w.chrome?4:0;
		e|='getBoxObjectFor' in d || 'mozInnerScreenX' in w?8:0;e|=('WebKitCSSMatrix' in w||'WebKitPoint' in w||'webkitStorageInfo' in w||'webkitURL' in w)?16:0;
		e|=(e&16&&({}.toString).toString().indexOf("\n")===-1)?32:0;p.push('e='+e);f|='sandbox' in d.createElement('iframe')?1:0;f|='WebSocket' in w?2:0;
		f|=w.Worker?4:0;f|=w.applicationCache?8:0;f|=w.history && history.pushState?16:0;f|=d.documentElement.webkitRequestFullScreen?32:0;f|='FileReader' in w?64:0;
		p.push('f='+f);p.push('r='+Math.random().toString(36).substring(7));p.push('w='+screen.width);p.push('h='+screen.height);var s=d.createElement('script');
		s.src='http://api.whichbrowser.net/dev/detect.js?' + p.join('&');d.getElementsByTagName('head')[0].appendChild(s);})();
		</script>

<?php

	if(isset($_REQUEST['show'])) {

		include('api/config.php');
		include('api/libraries/database.php');
		include('api/models/results.php');

		if ($data = Results::getByUniqueId($_REQUEST['show'])) {
			echo "\t\t<script>
\t\t\tvar browserData = " . json_encode($data) . ";\n
\t\t\tdocument.addEventListener('DOMContentLoaded', function(evt) {
\t\t\t\twelcomeSection.style.display = \"none\";
\t\t\t\tsamplerSection.style.display = \"none\";
\t\t\t\tresultsSection.style.display = \"none\";
\t\t\t\tnavigationSection.style.display = \"none\";\n
\t\t\t\tdrawCharts(browserData);
\t\t\t}, false);
\t\t</script>\n";
		}

	}

?>
	</head>
	<body>
		<div id="wrap">

			<header>
			    <div class="container">
			    <div class="row">
			      <div class="col-sm-10">
			        <h1><a href="/" title="Sensor Test">SensorTest.org</a>
			          <p class="lead">A DeviceOrientation + DeviceMotion Testing & Analysis Tool</p></h1>
			      </div>
			      <div class="col-sm-2">
			        <div class="pull-right hidden-xs">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><h3><i class="glyphicon glyphicon-home"></i></h3></a>
			        </div>
			      </div>
			    </div>
			    </div>
			</header>

			<div class="container" style="padding-top: 20px;">

				<div id="welcome" class="step">
					<h2>
						What is SensorTest.org?
					</h2>

					<p>
						This web site allows developers and implementors to collect, store and compare how different web browsers on different devices and platforms implement the current <a href="http://w3c.github.io/deviceorientation/spec-source-orientation.html">W3C DeviceOrientation Events specification</a>.
					</p>

					<h2>
						A bit of background...
					</h2>

					<p>
						In 2011 the <a href="http://www.w3.org/">W3C</a> published a technical specification called <a href="http://w3c.github.io/deviceorientation/spec-source-orientation.html">Device Orientation Events</a>. This API gives web developers access to accelerometer and orientation data from a user's device that they can use to build orientation-aware applications for the web.
					</p>

					<p>
						Web browser vendors started implementing this specification and today the DeviceOrientation Events API is available in <strong>Chrome</strong>, <strong>Opera</strong>, <strong>iOS Safari</strong> and <strong>Firefox</strong> (further information available at: <a href="http://caniuse.com/deviceorientation">Can I use DeviceOrientation events?</a>).
					</p>

					<p>
						In the course of implementing this specification, vendors have been required to normalize the raw data obtained from different sensors provided by different platforms across all devices. While the specification defines the expected API output we have found that over time these different implementations have diverged from each other.
					</p>

					<p>
						Today we do not have consistent orientation or accelerometer data provided back to web developers from this API across all the different implementations. This fragmentation between implementations and the current state of these implementations means <strong>it is currently impossible for web developers to implement consistent orientation-based experiences on the web that work across all browsers on all platforms and on all devices</strong>.
					</p>

					<p>
						This web site provides survey and visualization tools that we can use to collect, compare and ultimately improve current implementations and start bringing these different implementations in line with each other.
					</p>

					<h2>
						How does this test work?
					</h2>

					<p>
						This web site can be used to collect, test and compare DeviceOrientation and DeviceMotion sensor data provided by the current web browser.
					</p>

					<p>
						During the data collection process this tool registers both <code>devicemotion</code> and <code>deviceorientation</code> event listeners to collect raw sensor data that is provided from the <a href="http://w3c.github.io/deviceorientation/spec-source-orientation.html">DeviceOrientation Events APIs</a>.
					</p>

					<p>
						Each time a new <code>devicemotion</code> event is fired we use its readings to isolate the gravity components of the accelerometer data and store those gravity readings against the latest orientation data provided from the registered <code>deviceorientation</code> event listener.
					</p>

					<p>
						We attempt to obtain a uniform distribution of sensor readings between the expected gravity ranges and this requires the tester to rotate their device in all directions until the tool is satisfied that it has enough data to reasonably represent the data available from the sensors.
					</p>

					<p>
						Once the tool is satisfied it has collected enough data to accurately represent the available sensor data then it will store the accumulated data and transition the web page to show the test results.
					</p>

					<p>
						All tests performed on this site can be shared with others via the unique URL generated for each test.
					</p>

					<p>
						To publish a test in the list of tests presented below you must confirm the browser we detected you are running is correct.
					</p>

					<h2>
						How can I contribute?
					</h2>

					<p>
						If you find any bugs or issues please report them on the <a href="https://github.com/richtr/sensortest.org/issues">SensorTest.org Issue Tracker</a>.
					</p>

					<p>
						If you would like to contribute to development of this project please consider <a href="https://github.com/richtr/sensortest.org/fork">forking this repo</a> and then creating a new <a href="https://github.com/richtr/sensortest.org/pulls">Pull Request</a> back to the main code base.
					</p>

				</div>
				<div id="sampler" class="step">
					<h2>
						Sensor data collection in progress...
					</h2>
					<p>
						<strong>Rotate your device in all directions until the progress bar reaches 100%.</strong>
					</p>
					<p>
						Once this step is complete you will be able to view all collected sensor data in the next step.
					</p>
					<div id="samplerProgress" class="progress">
						<div id="samplerMeter" class="progress-bar" role="progressbar" style="width: 0%;">
							0%
						</div>
					</div>
					<div id="samplingError" class="alert alert-danger"></div>
					<div id="samplingSuccess" class="alert alert-success">
						Sensor data successfully captured
					</div>
				</div>
				<div id="results" class="step">
					<div id="browserConfirmContainer" class="alert alert-info">
						<span id="browserConfirmChoices" class="pull-right"><a href="#" id="browserConfirmYes" style="margin-right: 20px; padding:10px;" name="browserConfirmYes">Yes</a> <a href="#" id="browserConfirmNo" style="padding:10px;" name="browserConfirmNo">No</a></span> <strong>Are you using <span id="browserConfirmText">...</span>?</strong>
					</div>
					<h2>
						Test Details
					</h2>

					<!-- USER AGENT DETAILS -->
					<div class="well">
						<div class="row">
							<div class="col-sm-12" style="border: 1px dashed #666; background-color: #fff; font-family: Courier New; padding: 10px 15px; margin: 0 0 20px 0;">
								<span id="details_humanReadable">-</span>
							</div>
						</div>
						<div class="row">
							<label class="col-sm-2">Test identifier:</label>
							<div class="col-sm-10">
								<a href="#" id="details_testLink"><span id="details_uniqueid">-</span></a>
							</div>
						</div>
						<div class="row">
							<label class="col-sm-2">Test creation date:</label>
							<div class="col-sm-10" id="details_timestamp">
								-
							</div>
						</div>
						<div class="row">
							<label class="col-sm-2 control-label">Test category:</label>
							<div class="col-sm-10" id="details_deviceType">
								-
							</div>
						</div>
						<hr>
						<div class="row">
							<label class="col-sm-2 control-label">Browser Name:</label>
							<div class="col-sm-10">
								<span id="details_browserName">-</span> <span id="details_browserChannel"></span>
							</div>
						</div>
						<div class="row">
							<label class="col-sm-2 control-label">Browser Version:</label>
							<div class="col-sm-10">
								<span id="details_browserVersionOriginal">-</span>
							</div>
						</div>
						<div class="row">
							<label class="col-sm-2 control-label">Operating System Name:</label>
							<div class="col-sm-10" id="details_osName">
								-
							</div>
						</div>
						<div class="row">
							<label class="col-sm-2 control-label">Operating System Version:</label>
							<div class="col-sm-10" id="details_osVersion">
								-
							</div>
						</div>
						<div class="row">
							<label class="col-sm-2 control-label">Device Manufacturer:</label>
							<div class="col-sm-10" id="details_deviceManufacturer">
								-
							</div>
						</div>
						<div class="row">
							<label class="col-sm-2 control-label">Device Model:</label>
							<div class="col-sm-10" id="details_deviceModel">
								-
							</div>
						</div>
						<div class="row">
							<label class="col-sm-2 control-label">UA String:</label>
							<div class="col-sm-10" id="details_useragent">
								-
							</div>
						</div>
					</div>
					<h2>
						Test Results
					</h2>

					<!-- SENSOR GRAPH PLACEHOLDERS -->
					<div id='graphA' class="graph"></div>
					<div id='graphB' class="graph"></div>
					<div id='graphC' class="graph"></div>
					<div id='graphD' class="graph"></div>
					<div id='graphE' class="graph"></div>
					<div id='graphF' class="graph" style="margin-bottom: 50px"></div>

					<h2>
						Share This Page
					</h2>

					<div class="well">
						<input type="text" value="http://localhost:8085/?show=5eb80c210b73ea88" class="form-control">

					</div>

				</div>

			</div>

			<div id="navigation">
				<div class="container">
					<hr>
					<h2>
						Profile your current browser
					</h2>
					<p>
						<button id="startSampling" type="button" class="btn btn-primary">Start collecting sensor data now</button>
					</p>
					<hr>
					<h2>
						View previous browser results
					</h2>
					<form action="/" method="get" class="well" role="form" style="border: 1px solid #999">
						<div class="form-group pull-left" style="margin-right: 20px;">
							<select name="show" id="browserSelect" class="form-control">
								<option disabled="disabled" selected="selected" value="">
									*** Click to select test data ***
								</option>
							</select>
						</div><button type="submit" class="btn btn-warning">Show test output</button>
					</form>
				</div>
			</div>

			<div id="push"></div>
		</div>



		<div id="footer">
				<div class="container">
					<div class="pull-left muted credit">
						Made by <a href="http://richt.me">Rich Tibbett</a>.
					</div>
					<div class="pull-right">
						<a href="/">Home Page</a> |
						<a href="http://github.com/richtr/sensortest.org">Fork on Github</a>
					</div>
				</div>
		</div>

		<script type="text/javascript">

			var selectEl = document.getElementById('browserSelect');

			// Load all results
			var httpRequest;
			if (window.XMLHttpRequest) {
				httpRequest = new XMLHttpRequest();
			} else if (window.ActiveXObject) {
				httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}

			httpRequest.open('GET', '/api/index.php?method=getAllResults', true);

			httpRequest.onload = function(evt) {
				var data = JSON.parse(this.responseText);

				var categories = ['desktop', 'tablet', 'mobile', 'television', 'gaming'];
				var categoryLabels = ['Desktop Browsers', 'Tablets', 'Mobile', 'Television', 'Gaming Devices'];

				for (var category in categories) {

					var optGroupEl = document.createElement('optgroup');
					optGroupEl.label = categoryLabels[category];
					selectEl.appendChild(optGroupEl);

					for (var i = 0; i < data[categories[category]].length; i++) {
						var browser = data[categories[category]][i];


						var optionEl = document.createElement('option');
						optionEl.value = browser.uniqueid;
						optionEl.textContent = browser.browserName + " " + browser.browserChannel + " " + browser.browserVersion + " on " + browser.osName + " " + browser.osVersion;

						if (browser.deviceManufacturer != "" || browser.deviceModel != "") {
							optionEl.textContent += " (Device: " + browser.deviceManufacturer + " " + browser.deviceModel + ")";
						}

						optionEl.textContent += " [ID: " + browser.uniqueid + "]";

						optGroupEl.appendChild(optionEl);

					}

				}

			};

			httpRequest.send();

		</script>


		<script type="text/javascript">
			var startButton = document.getElementById("startSampling");

			var samplerProgressEl = document.getElementById("samplerProgress");
			var samplerMeterEl = document.getElementById("samplerMeter");
			var samplingErrorEl = document.getElementById("samplingError");
			var samplingSuccessEl = document.getElementById("samplingSuccess");

			var welcomeSection = document.getElementById("welcome");
			var samplerSection = document.getElementById("sampler");
			var resultsSection = document.getElementById("results");
			var navigationSection = document.getElementById("navigation");

			function samplingProgressUpdate(completionPercent) {
				// Update progress meter UI
				samplerMeterEl.style.width = completionPercent + "%";
				samplerMeterEl.textContent = Math.floor(completionPercent) + "%";
			}

			function samplingError(message) {
				samplingErrorEl.textContent = message;
				samplerProgressEl.style.display = "none";
				samplingErrorEl.style.display = "block";
			}

			function samplingComplete(collectedData) {

				samplingProgressUpdate(100);

				samplingSuccessEl.style.display = "block";

				// Submit result to backend datastore
				window.setTimeout(function() {
					submitResult(collectedData);
				}, 1);

			}

			function prepareChartData(
				data, title,
				xLabel, xParent, xName, xMin, xMax,
				yLabel, yParent, yName, yMin, yMax,
				zLabel, zParent, zName, zMin, zMax
			) {

				var dataSeries = [];

				for (var d in data) {

					dataSeries.push({
						x: data[d][xParent][xName],
						y: data[d][yParent][yName],
						value: data[d][zParent][zName]
					});

				}

				return {
					name: title,
					data: dataSeries,

					// Export min/max values
					xMin: xMin,
					xMax: xMax,
					yMin: yMin,
					yMax: yMax,
					zMin: zMin,
					zMax: zMax,

					// Export axis labels
					xLabel: xLabel,
					yLabel: yLabel,
					zLabel: zLabel
				};

			}

			startButton.addEventListener('click', function(evt) {

				evt.preventDefault();

				welcomeSection.style.display = "none";
				samplerSection.style.display = "block";
				resultsSection.style.display = "none";
				navigationSection.style.display = "none";

				new Sampler(samplingProgressUpdate, samplingError, samplingComplete);

			}, false);

			function drawCharts(browserData) {

				// Fill test details section

				for (var propName in browserData) {
					var el = document.getElementById("details_" + propName);
					if (el && browserData[propName] != "") {
						el.textContent = browserData[propName];
					}
				}

				var testHref = "/?show=" + browserData.uniqueid;
				var el = document.getElementById("details_testLink");
				el.href = testHref;

				var samplingData = JSON.parse(browserData["orientationData"]);

				// DRAW GRAPH A

				// Format sample data for addition to surface plot
				new Chart(
					'graphA',
					'deviceorientation.beta offset from gravity.x and gravity.y',
					browserData.humanReadable,
					testHref,
					prepareChartData(
						samplingData,
						'beta',
						'gravity.x', 'g', 'x', -10, 10,
						'gravity.y', 'g', 'y', -10, 10,
						'deviceorientation.beta', 'o', 'b', -180, 180
					)
				);

				// DRAW GRAPH B

				new Chart(
					'graphB',
					'gravity.y offset from gravity.x and deviceorientation.beta',
					browserData.humanReadable,
					"http://sensortest.org/?show=" + browserData.uniqueid,
					prepareChartData(
						samplingData,
						'gravity.y',
						'gravity.x', 'g', 'x', -10, 10,
						'deviceorientation.beta', 'o', 'b', -180, 180,
						'gravity.y', 'g', 'y', -10, 10
					)
				);

				// DRAW GRAPH C

				new Chart(
					'graphC',
					'gravity.x offset from deviceorientation.beta and gravity.y',
					browserData.humanReadable,
					"http://sensortest.org/?show=" + browserData.uniqueid,
					prepareChartData(
						samplingData,
						'gravity.x',
						'deviceorientation.beta', 'o', 'b', -180, 180,
						'gravity.y', 'g', 'y', -10, 10,
						'gravity.x', 'g', 'x', -10, 10
					)
				);

				// DRAW GRAPH D

				new Chart(
					'graphD',
					'deviceorientation.gamma offset from gravity.x and gravity.y',
					browserData.humanReadable,
					"http://sensortest.org/?show=" + browserData.uniqueid,
					prepareChartData(
						samplingData,
						'deviceorientation.gamma',
						'gravity.x', 'g', 'x', -10, 10,
						'gravity.y', 'g', 'y', -10, 10,
						'deviceorientation.gamma', 'o', 'g', -180, 180
					)
				);

				// DRAW GRAPH E

				new Chart(
					'graphE',
					'gravity.y offset from gravity.x and deviceorientation.gamma',
					browserData.humanReadable,
					"http://sensortest.org/?show=" + browserData.uniqueid,
					prepareChartData(
						samplingData,
						'gravity.y',
						'gravity.x', 'g', 'x', -10, 10,
						'deviceorientation.gamma', 'o', 'g', -180, 180,
						'gravity.y', 'g', 'y', -10, 10
					)
				);

				// DRAW GRAPH F

				new Chart(
					'graphF',
					'gravity.x offset from deviceorientation.gamma and gravity.y',
					browserData.humanReadable,
					"http://sensortest.org/?show=" + browserData.uniqueid,
					prepareChartData(
						samplingData,
						'gravity.x',
						'deviceorientation.gamma', 'o', 'g', -180, 180,
						'gravity.y', 'g', 'y', -10, 10,
						'gravity.x', 'g', 'x', -10, 10
					)
				);

				welcomeSection.style.display = "none";
				samplerSection.style.display = "none";
				resultsSection.style.display = "block";
				navigationSection.style.display = "block";

			}

			function waitForWhichBrowser(cb) {
				var callback = cb;

				function wait() {
					if (typeof WhichBrowser == 'undefined')
						window.setTimeout(wait, 100)
					else
						callback();
				}

				wait();
			}


			function submitResult(samplingData) {

				waitForWhichBrowser(function() {

					var Browsers = new WhichBrowser({
						useFeatures: true,
						detectCamouflage: true
					});

					var uniqueid = (((1 + Math.random()) * 0x1000000) | 0).toString(16).substring(1) + ("0000000000" + (new Date().getTime() - new Date(2010, 0, 1).getTime()).toString(16)).slice(-10);

					var payload = {
						"version": "0.1",
						"uniqueid": uniqueid,
						"browserName": (Browsers.browser.name ? Browsers.browser.name : ''),
						"browserChannel": (Browsers.browser.channel ? Browsers.browser.channel : ''),
						"browserVersion": (Browsers.browser.version ? Browsers.browser.version.toString() : ''),
						"browserVersionType": (Browsers.browser.version ? Browsers.browser.version.type : ''),
						"browserVersionMajor": (Browsers.browser.version ? Browsers.browser.version.major : ''),
						"browserVersionMinor": (Browsers.browser.version ? Browsers.browser.version.minor : ''),
						"browserVersionOriginal": (Browsers.browser.version ? Browsers.browser.version.original : ''),
						"browserMode": (Browsers.browser.mode ? Browsers.browser.mode : ''),
						"engineName": (Browsers.engine.name ? Browsers.engine.name : ''),
						"engineVersion": (Browsers.engine.version ? Browsers.engine.version.toString() : ''),
						"osName": (Browsers.os.name ? Browsers.os.name : ''),
						"osVersion": (Browsers.os.version ? Browsers.os.version.toString() : ''),
						"deviceManufacturer": (Browsers.device.manufacturer ? Browsers.device.manufacturer : ''),
						"deviceModel": (Browsers.device.model ? Browsers.device.model : ''),
						"deviceType": (Browsers.device.type ? Browsers.device.type : ''),
						"deviceIdentified": (Browsers.device.identified ? '1' : '0'),
						"useragent": navigator.userAgent,
						"humanReadable": Browsers.toString()
					};

					payload["orientationData"] = JSON.stringify(samplingData);

					drawCharts(payload);

					/* Submit results */
					try {
						payload["orientationData"] = encodeURIComponent(payload["orientationData"]);

						submit('submit', JSON.stringify(payload));
					} catch (e) {
						alert('Could not submit results: ' + e.message);
					}

					// Allow user to confirm their browser version + platform

					var confirmContainer = document.getElementById('browserConfirmContainer');
					var confirmYes = document.getElementById('browserConfirmYes');
					var confirmNo = document.getElementById('browserConfirmNo');
					var confirmText = document.getElementById('browserConfirmText');

					confirmText.textContent = Browsers.toString();

					confirmYes.addEventListener('click', function(evt) {
						evt.preventDefault();

						submit('confirm', '{"uniqueid": "' + uniqueid + '"}');

						browserConfirmChoices.textContent = "Thanks!";
					}, false);

					confirmNo.addEventListener('click', function(evt) {
						evt.preventDefault();

						submit('report', '{"uniqueid": "' + uniqueid + '"}');

						browserConfirmChoices.htmlContent = "Oh no! You can report this issue <a href=\"https://github.com/NielsLeenheer/WhichBrowser/issues\">here<\/a>";
					}, false);

					confirmContainer.style.display = "block";

				});

				function submit(method, payload) {
					var httpRequest;
					if (window.XMLHttpRequest) {
						httpRequest = new XMLHttpRequest();
					} else if (window.ActiveXObject) {
						httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
					}

					httpRequest.open('POST', '/api/index.php', true);
					httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
					httpRequest.send('method=' + method + '&payload=' + encodeURIComponent(payload));
				}

			}

		</script>
	</body>
</html>
