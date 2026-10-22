<?php

namespace App\Models;

class Transaction {
    public function __construct(
        private ?int $id,
        private int $userId,
        private string $type, // 'ingreso' o 'gasto'
        private float $amount,
        private string $category,
        private ?string $createdAt = null
    ) {
        if (!in_array($type, ['ingreso', 'gasto'], true)) {
            throw new \InvalidArgumentException("Tipo de transacción inválido.");
        }
        if ($amount <= 0) {
            throw new \InvalidArgumentException("El monto debe ser mayor a cero.");
        }
    }

    public function getId(): ?int { return $this->id; }
    public function getUserId(): int { return $this->userId; }
    public function getType(): string { return $this->type; }
    public function getAmount(): float { return $this->amount; }
    public function getCategory(): string { return $this->category; }
}