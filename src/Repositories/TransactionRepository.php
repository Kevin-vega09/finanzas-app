<?php

namespace App\Repositories;

use App\Models\Transaction;
use PDO;

class TransactionRepository {
    public function __construct(private PDO $db) {}

    public function create(Transaction $transaction): bool {
        $sql = "INSERT INTO transacciones (user_id, type, amount, category, created_at) 
                VALUES (:userId, :type, :amount, :category, NOW())";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':userId'   => $transaction->getUserId(),
            ':type'     => $transaction->getType(),
            ':amount'   => $transaction->getAmount(),
            ':category' => htmlspecialchars(strip_tags($transaction->getCategory())) // Sanitización
        ]);
    }

    public function getByUserId(int $userId): array {
        $sql = "SELECT id, user_id, type, amount, category, created_at 
                FROM transacciones 
                WHERE user_id = :userId";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':userId' => $userId]);
        
        return $stmt->fetchAll();
    }
}