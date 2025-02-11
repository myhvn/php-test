<?php

define('API_URL', 'https://crm.belmar.pro/api/v1/');
define('API_TOKEN', 'ba67df6a-a17c-476f-8e95-bcdb75ed3958');

function addLead($data) {
    $url = API_URL . 'addlead';
    $headers = [
        'token: ' . API_TOKEN,
        'Content-Type: application/json',
    ];
    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => $headers,
    ];

    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}


function getStatuses($dateFrom = '', $dateTo = '', $page = 0, $limit = 100) {
    $url = API_URL . 'getstatuses';
    $headers = [
        'token: ' . API_TOKEN,
        'Content-Type: application/json',
    ];

    $data = [
        'date_from' => $dateFrom ?: '2022-12-01 00:00:00',
        'date_to' => $dateTo ?: date('Y-m-d H:i:s'),
        'page' => $page,
        'limit' => $limit,
    ];

    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => $headers,
    ];

    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);

    if (isset($responseData['status']) && $responseData['status'] === true) {
        return $responseData['data'];  
    } else {
        return [];  
    }
}
