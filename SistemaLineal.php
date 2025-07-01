<?php

// Ejercicio 1: Sistema de ecuaciones lineales

// Clase abstracta que define los métodos que debe implementar un sistema de ecuaciones
abstract class SistemaEcuaciones {
    abstract public function calcularResultado(): array;
    abstract public function validarConsistencia(): bool;
}

// Clase concreta que representa un sistema lineal de 2x2
class SistemaLineal extends SistemaEcuaciones {
    private array $eq1;
    private array $eq2;

    public function __construct(array $eq1, array $eq2) {
        $this->eq1 = $eq1;
        $this->eq2 = $eq2;
    }

    // Verifica si el sistema es consistente usando el determinante (regla de Cramer)
    public function validarConsistencia(): bool {
        $det = $this->eq1['x'] * $this->eq2['y'] - $this->eq1['y'] * $this->eq2['x'];
        return $det != 0;
    }

    // Calcula la solución del sistema usando sustitución
    public function calcularResultado(): array {
        if (!$this->validarConsistencia()) {
            throw new RuntimeException("El sistema no tiene solución única.");
        }

        // Variables de ecuación 1: a1x + b1y = c1
        $a1 = $this->eq1['x']; $b1 = $this->eq1['y']; $c1 = $this->eq1['c'];

        // Variables de ecuación 2: a2x + b2y = c2
        $a2 = $this->eq2['x']; $b2 = $this->eq2['y']; $c2 = $this->eq2['c'];

        // Cálculo usando sustitución
        $y = ($c2 * $a1 - $c1 * $a2) / ($b2 * $a1 - $b1 * $a2);
        $x = ($c1 - $b1 * $y) / $a1;

        return ['x' => $x, 'y' => $y];
    }
}

// Programa principal
echo "\n=== Sistema de 2 ecuaciones lineales ===\n";

// Entrada de ecuaciones desde consola
$eq1 = [
    'x' => (float)readline('Ecuación 1 - coef x: '),
    'y' => (float)readline('Ecuación 1 - coef y: '),
    'c' => (float)readline('Ecuación 1 - término independiente: ')
];
$eq2 = [
    'x' => (float)readline('Ecuación 2 - coef x: '),
    'y' => (float)readline('Ecuación 2 - coef y: '),
    'c' => (float)readline('Ecuación 2 - término independiente: ')
];

try {
    $sistema = new SistemaLineal($eq1, $eq2);
    $sol = $sistema->calcularResultado();
    echo "\nSolución: x = {$sol['x']}, y = {$sol['y']}\n";
} catch (Throwable $e) {
    echo "\nError: {$e->getMessage()}\n";
}



