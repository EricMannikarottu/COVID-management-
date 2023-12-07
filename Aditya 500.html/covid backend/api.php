<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

function getRandomNumber() {
    return rand(1000, 1000000);
}

$globalData = [
    'totalCases' => getRandomNumber(),
    'totalDeaths' => rand(1000, 100000),
    'totalRecovered' => rand(10000, 40000),
    'totalAmbulances' =>rand(1000, 15000),
];

$countryData = [
    'CountryA' => [
        'totalCases' => getRandomNumber(),
        'totalDeaths' => rand(1000, 100000),
        'totalRecovered' => rand(10000, 40000),
        'totalAmbulances' => rand(100, 1000),
    ],
    'CountryB' => [
        'totalCases' => getRandomNumber(),
        'totalDeaths' => rand(1000, 100000),
        'totalRecovered' => rand(10000, 40000),
        'totalAmbulances' => rand(100, 1000),
    ],
    // Add more countries as needed
];

if (isset($_GET['endpoint'])) {
    $endpoint = $_GET['endpoint'];

    switch ($endpoint) {
        case 'global':
            echo json_encode($globalData);
            break;

        case 'country':
            if (isset($_GET['countryName'])) {
                $countryName = $_GET['countryName'];
                if (array_key_exists($countryName, $countryData)) {
                    echo json_encode($countryData[$countryName]);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Country not found']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Country name parameter missing']);
            }
            break;

        case 'countries':
            $countries = array_keys($countryData);
            echo json_encode($countries);
            break;

        default:
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint not found']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Endpoint parameter missing']);
}
?>
