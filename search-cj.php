<?php
header('Content-Type: application/json');

// Get search keyword from the URL
$query = urlencode($_GET['q'] ?? '');

// CJ REST API credentials
$apiKey = '3J4hHIxe80Af5tyeu2NMccG4cw'; // Your API key
$websiteId = '101573733';               // Your PID
$advertiserIds = 'joined';              // “joined” searches all joined advertisers

// Build request URL
$url = "https://link-search.api.cj.com/v2/link-search?website-id=$websiteId&advertiser-ids=$advertiserIds&keywords=$query";

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: $apiKey"
]);

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// If CJ returns XML, convert it to JSON for easier use on your site
if ($httpcode == 200 && $response) {
    $xml = simplexml_load_string($response);
    $json = json_encode($xml);
    echo $json;
} else {
    echo json_encode(["error" => "Unable to fetch data from CJ API."]);
}
?>

