<?php
header('Content-Type: application/json');

// Get the search query from the URL (?q=keyword)
$query = $_GET['q'] ?? '';

// Your CJ credentials
$apiKey = '3J4hHIxe80Af5tyeu2NMccG4cw'; // Your API key
$cid = '7768506';                       // Your CID
$pid = '101573733';                     // Your PID

// CJ GraphQL endpoint
$url = 'https://ads.api.cj.com/query';

// GraphQL query according to current CJ schema
$graphqlQuery = [
    "query" => "
    query {
      products(companyId: $cid, pid: $pid, keywords: \"$query\") {
        nodes {
          id
          name
          description
          deeplinkUrl
          advertiserName
        }
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

if(curl_errno($ch)){
    echo json_encode(['error' => curl_error($ch)]);
} else {
    echo $response;
}

curl_close($ch);
?>
