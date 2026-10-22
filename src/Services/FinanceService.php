<?php

namespace App\Services;

class FinanceService {
    /**
     * Calcula el saldo total disponible sumando ingresos y restando gastos.
     */
    public function calculateBalance(array $transactions): float {
        $total = 0.0;
        foreach ($transactions as $t) {
            if ($t['type'] === 'ingreso') {
                $total += (float)$t['amount'];
            } elseif ($t['type'] === 'gasto') {
                $total -= (float)$t['amount'];
            }
        }
        return $total;
    }

    /**
     * Agrupa y calcula los saldos agrupados por categoría.
     */
    public function calculateSummaryByCategory(array $transactions): array {
        $summary = [];
        foreach ($transactions as $t) {
            $cat = $t['category'];
            $amount = (float)$t['amount'];
            if (!isset($summary[$cat])) {
                $summary[$cat] = 0.0;
            }
            $summary[$cat] += ($t['type'] === 'ingreso') ? $amount : -$amount;
        }
        return $summary;
    }
}