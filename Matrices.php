<?php

// Ejercicio 4: Operaciones con matrices 2x2

// Clase abstracta que define operaciones sobre matrices
abstract class MatrizAbstracta {
    abstract public function multiplicar(MatrizAbstracta $m): MatrizAbstracta;
    abstract public function inversa(): MatrizAbstracta;
}

// Clase concreta que implementa operaciones para matrices 2x2
class Matriz extends MatrizAbstracta {
    private array $data;

    public function __construct(array $data) {
        $this->data = $data;
    }

    // Multiplica la matriz actual por otra
    public function multiplicar(MatrizAbstracta $m): MatrizAbstracta {
        $a = $this->data; $b = $m->data;
        $res = [];
        foreach ($a as $i => $fila) {
            foreach ($b[0] as $j => $_) {
                $sum = 0.0;
                foreach ($fila as $k => $val) {
                    $sum += $val * $b[$k][$j];
                }
                $res[$i][$j] = $sum;
            }
        }
        return new self($res);
    }

    // Calcula la inversa de una matriz 2x2
    public function inversa(): self {
        $a = $this->data[0][0]; $b = $this->data[0][1];
        $c = $this->data[1][0]; $d = $this->data[1][1];
        $det = $a * $d - $b * $c;
        if ($det == 0) throw new RuntimeException('Matriz no invertible.');
        $inv = [[ $d/$det, -$b/$det ], [ -$c/$det, $a/$det ]];
        return new self($inv);
    }

    public static function determinante(array $m): float {
        return $m[0][0]*$m[1][1] - $m[0][1]*$m[1][0];
    }

    public function getData(): array {
        return $this->data;
    }
}

// Programa principal
echo "\n=== Operaciones con matrices 2x2 ===\n";

// Entrada: 4 números separados por coma (2x2)
$valores = explode(',', readline("Introduce 4 elementos separados por coma (fila por fila): "));
$matriz = [
    [ (float)$valores[0], (float)$valores[1] ],
    [ (float)$valores[2], (float)$valores[3] ]
];
$m = new Matriz($matriz);

// Muestra determinante e inversa
echo "Determinante: " . Matriz::determinante($matriz) . "\n";
try {
    $inv = $m->inversa();
    echo "Inversa:\n";
    print_r($inv->getData());
} catch (Throwable $e) {
    echo "Error: {$e->getMessage()}\n";
}
