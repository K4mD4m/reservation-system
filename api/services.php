<?php 

require_once '../classes/Service.php'; // Import klasy Service
require_once '../utils.php'; // Importujemy funkcji do JSON

$servicesFile = '../data/services.json'; // Ścieżka do pliku z usługami

// Obsługa metod HTTP
$method = $_Server['REQUEST_METHOD'];

if ($method === 'GET') {
    // Pobieramy listę usług
    $services = readJsonFile($servicesFile);
    echo json_encode($services, JSON_PRETTY_PRINT);
    exit;
}

if ($method === 'POST') {
    // Odczytujemy dane z żądania (JSON)
    $input = json_decode(file_get_contents('php://input'), true);

    // Walidacja danych
    if (!isset($input['name']) || !isset($input['price']) || !is_numeric($input['price'])) {
        http_response_code(400);
        echo json_encode(["error" => "Brak wymaganych pól: name, price (liczba)"]);
        exit;
    }

    // Tworzymy nową usługę
    $service = new Service($input['name'], (float) $input['price']);

    // Pobieramy aktualną listę usług i dodajemy nową
    $services = readJsonFile($servicesFile);
    $services[] = $service->toArray();

    // Zapisujemy do pliku
    writeJsonFile($servicesFile, $services);

    // Zwracamy odpowiedź z nową usługą
    http_response_code(201);
    echo json_encode($service->toArray(), JSON_PRETTY_PRINT);
    exit;
}

// Jeśli metoda nie jest obsługiwana
http_response_code(405);
echo json_encode(["error" => "Metoda $method nie jest dozwolona"]);
exit;