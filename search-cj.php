<?php
header('Content-Type: application/json');

// Get search keyword from the URL
$query = urlencode($_GET['q'] ?? '');

// CJ REST API credentials
$apiKey = '3J4hHIxe80Af5tyeu2NMccG4cw'; // Developer key
$websiteId = '101573733';               // Your PID (Website ID)
$advertiserIds = 'joined';              // Search all joined advertisers

// Build request URL
$url = "https://link-search.api.cj.com/v2/link-search?website-id=$websiteId&advertiser-ids=$advertiserIds&keywords=$query";

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: $apiKey",
    "Accept: application/xml"
]);

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Handle response
if ($httpcode == 200 && $response) {
    $xml = simplexml_load_string($response);
    $json = json_encode($xml);
    echo $json;
} else {
    echo json_encode([
        "error" => "CJ API request failed",
        "status_code" => $httpcode,
        "response" => $response ?: "No response from server"
    ]);
}
?>

