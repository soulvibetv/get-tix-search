<?php
header('Content-Type: application/json');

// Get the search query from the URL
$keywords = $_GET['q'] ?? '';

// Your CJ credentials
$apiKey = '3J4hHIxe80Af5tyeu2NMccG4cw'; // Your API key
$companyId = 7768506;                    // Your CID
$feedId = 101573733;                      // Your Feed ID

// CJ GraphQL endpoint
$url = 'https://ads.api.cj.com/query';

// GraphQL query for product search
$graphqlQuery = [
    "query" => "
    query {
      products(feedId: $feedId, keywords: \"$keywords\") {
        id
        name
        url
        price
        currency
      }
    }
    "
];

// Initialize cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $apiKey",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($graphqlQuery));

$response = curl_exec($ch);

// Handle errors
if ($response === false) {
    echo json_encode([
        'error' => curl_error($ch)
    ]);
} else {
    echo $response;
}

curl_close($ch);
?>

