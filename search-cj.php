<?php
header('Content-Type: application/json');

// Get the search query from the URL
$query = $_GET['q'] ?? '';

// CJ credentials
$apiKey = '3J4hHIxe80Af5tyeu2NMccG4cw';
$cid = '7768506'; // your companyId

// CJ GraphQL endpoint
$url = 'https://ads.api.cj.com/query';

// GraphQL query
$graphqlQuery = [
    "query" => "
    query {
      products(companyId: $cid, keywords: \"$query\") {
        productIds
        items {
          name
          url
          price
          currency
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

// Return the API response
echo $response;

