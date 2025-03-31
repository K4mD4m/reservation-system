<?php

// Nagłówki dla API (CORS i JSON)
header("Access-Control-Allow-Origin: *"); // Pozwala na dostęp z dowolnej domeny
header("Content-Type: application/json"); // Odpowiedź w formacie JSON
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Dozwolone metody
header("Access-Control-Allow-Headers: Content-Type"); // Pozwalamy na JSON w żądaniach

// Jeśli to zapytanie OPTIONS, kończymy je tutaj
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Przekierowanie do routera
require 'router.php';