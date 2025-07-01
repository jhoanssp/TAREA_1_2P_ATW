<?php

// Ejercicio 5: Resolución de ecuaciones diferenciales

// Clase abstracta con método para resolver por Euler
abstract class EcuacionDiferencial {
    abstract public function resolverEuler(callable $f, float $x0, float $y0, float $h, int $n): array;
}

// Clase concreta que implementa el método de Euler
class EulerNumerico extends EcuacionDiferencial {
    public function resolverEuler(callable $f, float $x0, float $y0, float $h, int $n): array {
        $resultado = [];
        $x = $x0;
        $y = $y0;
        $resultado[$x] = $y;
        for ($i = 0; $i < $n; $i++) {
            $y += $h * $f($x, $y); // Aplicación de la fórmula de Euler
            $x += $h;
            $resultado[round($x, 5)] = $y;
        }
        return $resultado;
    }
}

// Programa principal
echo "\n=== Método de Euler ===\n";
echo "Resolviendo dy/dx = x + y (predefinida)\n";

// Entrada desde consola
$x0 = (float)readline("Ingrese x0: ");
$y0 = (float)readline("Ingrese y0: ");
$h  = (float)readline("Paso h: ");
$n  = (int)readline("Número de pasos: ");

// Ecuación diferencial f(x, y) = x + y
$ecuacion = fn($x, $y) => $x + $y;

// Se aplica el método
$metodo = new EulerNumerico();
$solucion = $metodo->resolverEuler($ecuacion, $x0, $y0, $h, $n);

// Mostrar solución aproximada
foreach ($solucion as $x => $y) {
    echo "x = $x => y ≈ $y\n";
}
