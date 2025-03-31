<?php

class Service {
    private string $id; // ID usługi
    private string $name; // Nazwa usługi
    private float $price; // Cena usługi

    public function __construct(string $name, float $price) {
        $this->id = uniqid(); // Generowanie unikalnego ID
        $this->name = $name;
        $this->price = $price;
    }

    // Pobranie ID usługi
    public function getId(): string {
        return $this->id;
    }

    // Konwersja obiektu do tablicy (do JSON)
    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
        ];
    }
}