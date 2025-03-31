<?php

/**
 * Odczytuje dane z pliku JSON i zwraca jako tablicę PHP.
 * Jeśli plik nie istnieje, zwraca pustą tablicę.
 */
function readJsonFile(string $filename): array {
    if (!file_exists($filename)) {
        return []; // Zwróć pustą tablicę, jeśli plik nie istnieje
    }

    $jsonData = file_get_contents($filename); // Pobieramy zawartość pliku

    return $jsonData ? json_decode($jsonData, true) : []; // Dekodujemy JSON do tablicy PHP
}

/**
 * Zapisuje tablicę PHP do pliku JSON.
 */
function writeJsonFile(string $filename, array $data): bool {
    $jsonData = json_encode($data, JSON_PRETTY_PRINT); // Kodujemy tablicę do formatu JSON
    return file_put_contents($filename, $jsonData) !== false; // Zapisujemy do pliku, zwracając wynik operacji
}