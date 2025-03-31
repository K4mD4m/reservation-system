<?php

class User {
    private string $id; // ID użytkownika
    private string $name; // Imię uzytkownika
    private string $email; // Email użytkownika

    public function __construct(string $name, string $email) {
        $this->id = uniqid(); // Generowanie unikalnego ID
        $this->name = $name;
        $this->email = $email;
    }

    // Pobranie ID użytkownika
    public function getId(): string {
        return $this->id;
    }

    // Konwersja obiektu do tablicy (do JSON)
    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}