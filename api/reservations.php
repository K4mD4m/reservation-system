<?php

require_once 'classes/Reservation.php'; // Import klasy Reservation
require_once "utils.php"; // Import funkcji do JSON

$usersFile = __DIR__ . '/../data/users.json';
$servicesFile = __DIR__ . '/../data/services.json';
$reservationsFile = __DIR__ . '/../data/reservations.json';

// Obsługa metod HTTP
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    //Pobieramy listę rezerwacji
    $reservations = readJsonFile($reservationsFile);
    echo json_encode($reservations, JSON_PRETTY_PRINT);
    exit;
}

if ($method === 'POST') {
    // Odczytujemy dane z żądania (JSON)
    $input = json_decode(file_get_contents('php://input'), true);

    // Walidacja danych
    if (!isset($input['userId']) || !isset($input['serviceId']) || !isset($input['date'])) {
        http_response_code(400);
        echo json_encode(["error" => "Brak wymaganych pól: userId, serviceId, date"]);
        exit;
    }

    // Pobieramy użytkowników i usługi, żeby sprawdzić, czy ID są poprawne
    $users = readJsonFile($usersFile);
    $services = readJsonFile($servicesFile);

    // Sprawdzamy, czy użytkownik i usluga istnieją 
    $userExists = array_filter($users, fn($u) => $u['id'] === $input['userId']);
    $serviceExists = array_filter($services, fn($s) => $s['id'] === $input['serviceId']);

    if (!$userExists || !$serviceExists) {
        http_response_code(400);
        echo json_encode(["error" => "Nieprawidłowe userId lub serviceId"]);
        exit;
    }

    // Tworzymy nową rezerwację
    $reservation = new Reservation($input['userId'], $input['serviceId'], $input['date']);

    // Pobieramy aktualne rezerwacje i dodajemy nową
    $reservations = readJsonFile($reservationsFile);
    $reservations[] = $reservation->toArray();

    // Zapisujemy do pliku 
    writeJsonFile($reservationsFile, $reservations);

    // Zwracamy odpowiedź z nową rezerwacją
    http_response_code(201);
    echo json_encode($reservation->toArray(), JSON_PRETTY_PRINT);
    exit;
}

// Jeśli metoda nie jest obsługiwana
http_response_code(405);
echo json_encode(["error" => "Metoda $method nie jest obsługiwana"]);
exit;