<?php
error_reporting(0);
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

// Send the API command to retrieve the interface traffic statistics
$response = $api->comm($command, $params);

// Calculate the upload and download bandwidth usage in kilobits per second (Kbps) or megabits per second (Mbps)
$inBits = $response[0]['tx-bits-per-second'];
$outBits = $response[0]['rx-bits-per-second'];
$downloadBandwidth = ($inBits > 0) ? $inBits / 1000 : 0;
$uploadBandwidth = ($outBits > 0) ? $outBits / 1000 : 0;

// Format the bandwidth usage as Kbps or Mbps depending on the calculated values
$downloadBandwidthFormatted = ($downloadBandwidth < 1000) ? round($downloadBandwidth, 2) . ' Kbps' : round($downloadBandwidth / 1000, 2) . ' Mbps';
$uploadBandwidthFormatted = ($uploadBandwidth < 1000) ? round($uploadBandwidth, 2) . ' Kbps' : round($uploadBandwidth / 1000, 2) . ' Mbps';

$totalRx = $ARRAY[0]['bytes-in'];
$totalTx = $ARRAY[0]['bytes-out'];
$totalRxFormatted = formatBytes($totalRx);
$totalTxFormatted = formatBytes($totalTx);

// Return the upload and download bandwidth as plain text
echo 'Download:   '. $downloadBandwidthFormatted . '<br>'.'Upload:   ' . $uploadBandwidthFormatted;
echo 'Total RX: ' . $totalRxFormatted . '<br>';
echo 'Total TX: ' . $totalTxFormatted;
function formatBytes($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

    $bytes /= pow(1024, $pow);

    return round($bytes, $precision) . ' ' . $units[$pow]; 
}

// Disconnect from the RouterOS API client
$api->disconnect();
?>
