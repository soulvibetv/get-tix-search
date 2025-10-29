<?php
header('Content-Type: application/json');

// Get search query from URL
$keywords = $_GET['q'] ?? '';

// CJ credentials
$apiKey = '3J4hHIxe80Af5tyeu2NMccG4cw';
$companyId = '7768506';  // Your CID
$programId = '101573733'; // Your PID

// CJ GraphQL endpoint
$url = 'https://ads.api.cj.com/query';

// GraphQL query (matches CJ schema)
$graphqlQuery = [
    "query" => "
    query {
      products(companyId: $companyId, programId: $programId, keywords: \"$keywords\") {
        items {
          id
          name
          link
          advertiserName
          price {
            amount
            currency
          }
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
curl_close($ch);

echo $response;
?>

