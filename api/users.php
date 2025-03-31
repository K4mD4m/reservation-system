<?php

require_once 'classes/User.php'; // Import klasy User
require_once 'utils.php'; // Import funkcji do JSON

$usersFile = __DIR__ . '/../data/users.json';

// Obsługa metod HTTP
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Pobieramy listę użytkowników
    $users = readJsonFile($usersFile); // Odczytujemy użytkowników z pliku
    echo json_encode($users, JSON_PRETTY_PRINT); // Zwracamy użytkowników w formacie JSON
    exit;
}

if ($method === 'POST') {
    //Odczytujemy dane z żądania (JSON)
    $input = json_decode(file_get_contents('php://input'), true);

    // Walidacja danych
    if (!isset($input['name']) || !isset($input['email'])) {
        http_response_code(400);
        echo json_encode(["error" => "Brak wymaganych pól: name, email"]);
        exit;
    }

    //Tworzymy nowego użytkownika
    $user = new User($input['name'], $input['email']); 

    // Pobieramy aktualną listę użytkowników i dodajemy nowego
    $users = readJsonFile($usersFile); 
    $users[] = $user->toArray();

    // Zapisujemy do pliku
    writeJsonFile($usersFile, $users);

    //Zwracamy odpowiedź z nwoym użytkownikiem
    http_response_code(201);
    echo json_encode($user->toArray(), JSON_PRETTY_PRINT);
    exit;
}

// Jeśli metoda nie jest obsługiwana
http_response_code(405); 
echo json_encode(["error" => "Metoda $method nie jest dozwolona"]);
exit;