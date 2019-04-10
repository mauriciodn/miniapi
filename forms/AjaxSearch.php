<?php

require_once(__DIR__ . '\..\controllers\HotelController.php');

$values = $_GET['hotelSearchForm'];
if (isset($values['destination']) && isset($values['checkin']) && isset($values['checkout']) && isset($values['guests'])) {
    $params = array(
        'guests[]' => $values['guests'],
        'checkin' => $values['checkin'],
        'checkout' => $values['checkout'],
        'destination' => $values['destination'],
        'rooms' => 1,
        'sort_criteria' => 'Overall',
        'sort_order' => 'desc',
        'per_page' => '25',
        'page' => '1',
        'currency' => 'USD',
    );
}

$hotelController = new HotelController();
$hotels = $hotelController->search('https://beta.id90travel.com/api/v1/hotels.json', $params);

header('Content-Type: application/json');

echo json_encode($hotels);