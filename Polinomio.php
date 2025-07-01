<?php

// Ejercicio 3: Manejo de polinomios

// Clase abstracta con métodos para evaluar y derivar un polinomio
abstract class PolinomioAbstracto {
    abstract public function evaluar(float $x): float;
    abstract public function derivada(): self;
}

// Clase concreta que representa un polinomio como un array asociativo
class Polinomio extends PolinomioAbstracto {
    private array $terminos;

    public function __construct(array $terminos) {
        $this->terminos = $terminos;
    }

    // Evalúa el polinomio en x
    public function evaluar(float $x): float {
        $suma = 0.0;
        foreach ($this->terminos as $grado => $coef) {
            $suma += $coef * pow($x, $grado);
        }
        return $suma;
    }

    // Calcula la derivada del polinomio
    public function derivada(): self {
        $der = [];
        foreach ($this->terminos as $grado => $coef) {
            if ($grado == 0) continue; // Derivada de constante es 0
            $der[$grado - 1] = $coef * $grado;
        }
        return new self($der ?: [0 => 0]);
    }

    public function getTerminos(): array {
        return $this->terminos;
    }

    // Suma dos polinomios representados como arrays
    public static function sumarPolinomios(array $p1, array $p2): array {
        $suma = $p1;
        foreach ($p2 as $grado => $coef) {
            $suma[$grado] = ($suma[$grado] ?? 0) + $coef;
        }
        ksort($suma);
        return $suma;
    }
}

// Programa principal
echo "\n=== Manejo de polinomios ===\n";

// Entrada: grado:coef,grado:coef,...
$input = readline("Ingrese polinomio como grado:coef,grado:coef ... Ej: 2:3,1:-4,0:5 → ");
$pairs = array_map('trim', explode(',', $input));
$terminos = [];
foreach ($pairs as $pair) {
    [$g,$c] = array_map('floatval', explode(':', $pair));
    $terminos[(int)$g] = $c;
}
$p = new Polinomio($terminos);

$x = (float)readline('Valor de x para evaluar: ');
echo "P($x) = {$p->evaluar($x)}\n";
echo "Derivada: ";
print_r($p->derivada()->getTerminos());


