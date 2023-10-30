<?php

$verify_token = $_GET['hub_verify_token'];

if ($my_verify_token === $verify_token)
{
    echo $challenge;
    exit;
}

$access_token = 'EAAQIkjE81BABOZByY067UB57R7LnTYdsOS2Ts9xvtiUmCeiVaSPLrfBdSZCDTw0NXI3yCDTUXt57NVpX0w1nZCkVMOlZCaUOSnRlZB3hJAdrHUpNiTyO5OiCWjnGvJzuv2iG9kWGKw1METNiayp30ZBRunQplMdVA1naQbMItktRjPHQWAID8l6Ia1xZAMN8xBu0LVin2ESZBZBZBj2uWZB';