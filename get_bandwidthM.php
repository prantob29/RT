<?php
$interface = $_POST['interface'];

// Define RouterOS API credentials and parameters for MikroTik interface statistics
$host = '172.17.1.2';
$username = 'rt';
$password = '123123';
$command = '/interface/monitor-traffic';
$params = array(
    'interface' => '<pppoe-'.$interface.'>',
    'once' => '',
);

// Create a new RouterOS API client and connect to the router
require_once('routeros_api.class.php');
$api = new RouterosAPI();
$api->connect($host, $username, $password);

// Send the API command to retrieve interface statistics
$response = $api->comm($command, $params);

// Calculate the bandwidth usage in kilobits per second (Kbps)
$inBytes = $response[0]['rx-bits-per-second'] / 8;
$outBytes = $response[0]['tx-bits-per-second'] / 8;
$bandwidth = ($inBytes + $outBytes) / 1000;

// Format the bandwidth usage as Kbps or Mbps depending on the calculated speed
if ($bandwidth < 1000) {
    $bandwidthFormatted = round($bandwidth, 2) . ' Kbps';
} else {
    $bandwidthFormatted = round($bandwidth / 1000, 2) . ' Mbps';
}

// Return the bandwidth usage as plain text
echo $bandwidthFormatted;

// Disconnect from the RouterOS API client
$api->disconnect();
?>
