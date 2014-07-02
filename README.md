## What is SensorTest.org?

[SensorTest.org](http://sensortest.org) allows developers and implementors to collect, store and compare how different web browsers on different devices and platforms implement the current [W3C DeviceOrientation Events specification](http://w3c.github.io/deviceorientation/spec-source-orientation.html).

## A bit of background...

In 2011 the [W3C](http://www.w3.org/) published a technical specification called [Device Orientation Events](http://w3c.github.io/deviceorientation/spec-source-orientation.html). This API gives web developers access to accelerometer and orientation data from a user's device that they can use to build orientation-aware applications for the web.

Web browser vendors started implementing this specification and today the DeviceOrientation Events API is available in **Chrome**, **Opera**, **iOS Safari** and **Firefox** (further information available at: [Can I use DeviceOrientation events?](http://caniuse.com/deviceorientation)).

In the course of implementing this specification, vendors have been required to normalize the raw data obtained from different sensors provided by different platforms across all devices. While the specification defines the expected API output we have found that over time these different implementations have diverged from each other.

Today we do not have consistent orientation or accelerometer data provided back to web developers from this API across all the different implementations. This fragmentation between implementations and the current state of these implementations means **it is currently impossible for web developers to implement consistent orientation-based experiences on the web that work across all browsers on all platforms and on all devices**.

This web site provides survey and visualization tools that we can use to collect, compare and ultimately improve current implementations and start bringing these different implementations in line with each other.

## How does this test work?

This web site can be used to collect, test and compare DeviceOrientation and DeviceMotion sensor data provided by the current web browser.

During the data collection process this tool registers both `devicemotion` and `deviceorientation` event listeners to collect raw sensor data that is provided from the [DeviceOrientation Events APIs](http://w3c.github.io/deviceorientation/spec-source-orientation.html).

Each time a new `devicemotion` event is fired we use its readings to isolate the gravity components of the accelerometer data and store those gravity readings against the latest orientation data provided from the registered `deviceorientation` event listener.

We attempt to obtain a uniform distribution of sensor readings between the expected gravity ranges and this requires the tester to rotate their device in all directions until the tool is satisfied that it has enough data to reasonably represent the data available from the sensors.

Once the tool is satisfied it has collected enough data to accurately represent the available sensor data then it will store the accumulated data and transition the web page to show the test results.

All tests performed on this site can be shared with others via the unique URL generated for each test.

To publish a test in the list of tests presented below you must confirm the browser we detected you are running is correct.

## How can I contribute?

If you find any bugs or issues please report them on the [SensorTest.org Issue Tracker](https://github.com/richtr/sensortest.org/issues).

If you would like to contribute to development of this project please consider [forking this repo](https://github.com/richtr/sensortest.org/fork) and then creating a new [Pull Request](https://github.com/richtr/sensortest.org/pulls) back to the main code base.

## License

MIT