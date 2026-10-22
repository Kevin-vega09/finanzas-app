<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Services\FinanceService;

class FinanceServiceTest extends TestCase
{
    private FinanceService $financeService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->financeService = new FinanceService();
    }

    /**
     * Verifica que el cálculo del saldo total suma correctamente ingresos y resta gastos.
     */
    public function testCalculateBalanceCorrectly(): void
    {
        $transactions = [
            ['type' => 'ingreso', 'amount' => 1500000.0, 'category' => 'Salario'],
            ['type' => 'gasto',   'amount' => 300000.0,  'category' => 'Servicios'],
            ['type' => 'gasto',   'amount' => 200000.0,  'category' => 'Alimentación'],
            ['type' => 'ingreso', 'amount' => 500000.0,  'category' => 'Freelance']
        ];

        $totalBalance = $this->financeService->calculateBalance($transactions);

        // Resultado esperado: 1,500,000 - 300,000 - 200,000 + 500,000 = 1,500,000
        $this->assertEquals(1500000.0, $totalBalance, "El saldo total calculado no es correcto.");
    }

    /**
     * Verifica que si no existen transacciones el saldo devuelto sea cero.
     */
    public function testCalculateBalanceReturnsZeroWhenEmpty(): void
    {
        $transactions = [];
        $totalBalance = $this->financeService->calculateBalance($transactions);

        $this->assertEquals(0.0, $totalBalance, "El saldo para un listado vacío debe ser 0.0.");
    }

    /**
     * Verifica que el resumen por categoría agrupe y reste los saldos correctamente.
     */
    public function testCalculateSummaryByCategory(): void
    {
        $transactions = [
            ['type' => 'ingreso', 'amount' => 2000.0, 'category' => 'Inversión'],
            ['type' => 'gasto',   'amount' => 500.0,  'category' => 'Alimentación'],
            ['type' => 'gasto',   'amount' => 300.0,  'category' => 'Alimentación'],
            ['type' => 'gasto',   'amount' => 100.0,  'category' => 'Transporte']
        ];

        $summary = $this->financeService->calculateSummaryByCategory($transactions);

        $this->assertEquals(2000.0, $summary['Inversión']);
        $this->assertEquals(-800.0, $summary['Alimentación']);
        $this->assertEquals(-100.0, $summary['Transporte']);
    }
}
