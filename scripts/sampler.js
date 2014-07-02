/**
 * Collect devicemotion/deviceorientation sample data with a uniform distribution
 */

var Sampler = function( progressCallback, errorCallback, successCallback ) {

	// Approximate upper bound of expected gravity provided in accelerationIncludingGravity data
	var gravity = 9.8;

	// buckets at 0.01 value intervals
	var buckets = {};

	var numberOfBuckets = gravity * gravity * gravity;

	// Number of full buckets. We expect this number to equal
	var filledBuckets = 0;

	var deviceOrientation = {};

	// Low-pass filter to isolate gravity components
	var gravityX = 0, gravityY = 0, gravityZ = 0;
	var bucketXPos = 0, bucketYPos = 0, bucketZPos = 0;

	var collectDeviceOrientationData = function(evt) {
		if (evt.beta === undefined || evt.beta === null) {
			abortSampler("DeviceOrientation does not provide a valid beta reading");
			return;
		}

		if (evt.gamma === undefined || evt.gamma === null) {
			abortSampler("DeviceOrientation does not provide a valid gamma reading");
			return;
		}

		deviceOrientation = evt;
	}

	var abortSampler = function(message) {
		window.removeEventListener('deviceorientation', collectDeviceOrientationData, false);
		window.removeEventListener('devicemotion', collectDeviceMotionData, false);

		errorCallback.call(this, message);
	}

	var collectDeviceMotionData = function(evt) {

		if (!evt.accelerationIncludingGravity || !evt.acceleration) {
			abortSampler("DeviceMotion does not provide a accelerationIncludingGravity property");
			return;
		}

		/*
		// Use a low-pass filter to determine gravity components (turns out this is too slow to use!)
		var alpha = 0.8;
		gravityX = alpha * gravityX + (1 - alpha) * evt.accelerationIncludingGravity.x;
    gravityY = alpha * gravityY + (1 - alpha) * evt.accelerationIncludingGravity.y;
    gravityZ = alpha * gravityZ + (1 - alpha) * evt.accelerationIncludingGravity.z;*/

		// Determine gravity components using complimentary sensor data
		gravityX = evt.accelerationIncludingGravity.x - evt.acceleration.x;
		gravityY = evt.accelerationIncludingGravity.y - evt.acceleration.y;
		gravityZ = evt.accelerationIncludingGravity.z - evt.acceleration.z;

		if (gravityX === undefined || gravityX === null || isNaN(gravityX)) {
			abortSampler("DeviceMotion does not provide full accelerometer x-axis readings");
			return;
		}

		if (gravityY === undefined || gravityY === null || isNaN(gravityY)) {
			abortSampler("DeviceMotion does not provide full accelerometer y-axis readings");
			return;
		}

		if (gravityZ === undefined || gravityZ === null || isNaN(gravityZ)) {
			abortSampler("DeviceMotion does not provide full accelerometer z-axis readings");
			return;
		}

		// Acquire the nearset bucket for this raw data
		bucketXPos = gravityX.toFixed(0);
		bucketYPos = gravityY.toFixed(0);
		bucketZPos = gravityZ.toFixed(0);

		var bucketId = bucketXPos + "/" + bucketYPos + "/" + bucketZPos;

		var completionPercent = 0;

		// If no bucket exists at this point then take a new sample
		if (!buckets[bucketId]) {

			buckets[bucketId] = {
				'g': {
					'x': gravityX,
					'y': gravityY
				},
				'o': {
					'b': deviceOrientation.beta,
					'g': deviceOrientation.gamma
				}
			};

			filledBuckets++;

			completionPercent = (filledBuckets / numberOfBuckets) * 100;

			// Fire a progress callback
			progressCallback.call(this, completionPercent);

		}

		if (filledBuckets >= numberOfBuckets) {

			// Data collection stage is complete. Move on to data modelling stage.
			window.removeEventListener('deviceorientation', collectDeviceOrientationData, false);
			window.removeEventListener('devicemotion', collectDeviceMotionData, false);

			// Fire the completion callback
			successCallback.call(this, buckets);

		}

	};

	window.addEventListener('deviceorientation', collectDeviceOrientationData, false);
	window.addEventListener('devicemotion', collectDeviceMotionData, false);

};
