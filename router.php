<?php

// Pobieramy aktualną ścieżkę żądania
$requestUri = trim($_SERVER['REQUEST_URI'], '/');

// Definiujemy dostępne ścieżki i ich pliki
$routes = [
    'users' => 'api/users.php',
    'services' => 'api/services.php',
    'reservations' => 'api/reservations.php',
];

// Sprawdzamy, czy ścieżka istnieje w tablicy
if (array_key_exists($requestUri, $routes)) {
    require $routes[$requestUri]; // Przekierowujemy do odpowiedniego pliku
    exit;
}

// Jeśli ścieżka nie istnieje, zwracamy błąd 404
http_response_code(404);
echo json_encode(["error" => "Nie znaleziono endpointu: /$requestUri"], JSON_PRETTY_PRINT);
exit;