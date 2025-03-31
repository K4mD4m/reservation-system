<?php 

class Reservation {
    private string $id; // ID rezerwacji
    private string $userId; // ID użytkownika
    private string $serviceId; // ID usługi
    private string $date; // Data rezerwacji

    public function __construct(string $userId, string $serviceId, string $date) {
        $this->id = uniqid(); // Generowanie unikalnego ID
        $this->userId = $userId;
        $this->serviceId = $serviceId;
        $this->date = $date;
    }

    // Konwersja obiektu do tablicy (do JSON)
    public function toArray(): array {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'serviceId' => $this->serviceId,
            'date' => $this->date,
        ];
    }
}