<?php

// Ejercicio 2: Cálculo de estadísticas básicas

// Clase abstracta que define los métodos estadísticos principales
abstract class Estadistica {
    abstract protected function calcularMedia(array $datos): float;
    abstract protected function calcularMediana(array $datos): float;
    abstract protected function calcularModa(array $datos): array;
}

// Clase concreta que implementa métodos estadísticos básicos
class EstadisticaBasica extends Estadistica {
    
    // Genera un informe para varios conjuntos de datos
    public function generarInforme(array $datasets): array {
        $informe = [];
        foreach ($datasets as $nombre => $datos) {
            sort($datos); // Se ordenan para calcular la mediana
            $informe[$nombre] = [
                'media'   => $this->calcularMedia($datos),
                'mediana' => $this->calcularMediana($datos),
                'moda'    => $this->calcularModa($datos)
            ];
        }
        return $informe;
    }

    protected function calcularMedia(array $datos): float {
        return array_sum($datos) / count($datos);
    }

    protected function calcularMediana(array $datos): float {
        $n = count($datos);
        $mid = intdiv($n, 2);
        return $n % 2 ? $datos[$mid] : ($datos[$mid - 1] + $datos[$mid]) / 2;
    }

    // Devuelve la(s) moda(s) del conjunto (puede haber más de una)
    protected function calcularModa(array $datos): array {
        $freq = array_count_values(array_map('strval', $datos)); // Contamos como strings para evitar errores
        $max = max($freq);
        $modasStr = array_keys(array_filter($freq, fn($v) => $v === $max));
        return array_map('floatval', $modasStr);
    }
}

// Programa principal
echo "\n=== Estadística básica ===\n";

// Entrada de múltiples conjuntos de datos
$datasets = [];
$cant = (int)readline('¿Cuántos conjuntos de datos? ');
for ($i = 1; $i <= $cant; $i++) {
    $nombre = readline("Nombre del conjunto #$i: ");
    $lista  = readline('Valores separados por coma: ');
    $datasets[$nombre] = array_map('floatval', explode(',', $lista));
}

// Se genera el informe estadístico
$est = new EstadisticaBasica();
$inf = $est->generarInforme($datasets);

// Se imprime el resultado
print_r($inf);
