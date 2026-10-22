<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Models\Transaction;
use InvalidArgumentException;

class TransactionTest extends TestCase
{

    /**
     * Verifica que la entidad acepte un objeto con datos válidos.
     */
    public function testValidTransactionCreation(): void
    {
        $transaction = new Transaction(1, 10, 'ingreso', 250.50, 'Ventas');

        $this->assertEquals('ingreso', $transaction->getType());
        $this->assertEquals(250.50, $transaction->getAmount());
        $this->assertEquals('Ventas', $transaction->getCategory());
    }

    /**
     * Verifica que se lance una excepción si el monto es cero o negativo.
     */
    public function testTransactionThrowsExceptionOnInvalidAmount(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("El monto debe ser mayor a cero.");

        new Transaction(1, 10, 'ingreso', -50.0, 'Ventas');
    }

    /**
     * Verifica que se lance una excepción si el tipo no es 'ingreso' ni 'gasto'.
     */
    public function testTransactionThrowsExceptionOnInvalidType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Tipo de transacción inválido.");

        new Transaction(1, 10, 'prestamo', 100.0, 'Ventas');
    }
}
