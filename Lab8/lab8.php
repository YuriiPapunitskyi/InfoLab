<?php

if ($argc != 4) {
    echo "Невірна кількість аргументів. Синтаксис: V P1 P2\n";
    exit(1);
}

$V = floatval($argv[1]);
$P1 = floatval($argv[2]);
$P2 = floatval($argv[3]);

function calculateCost($r, $h, $P1, $P2) {
    $costBottom = $P1 * pi() * $r * $r;
    $costWalls = $P2 * 2 * pi() * $r * $h;
    return $costBottom + $costWalls;
}

function lagrangeOptimization($P1, $P2, $V) {
    $r = pow(($V * $P1) / (2 * pi() * $P2), 1 / 3);
    $h = $V / (pi() * $r * $r);

    return [
        'radius' => $r,
        'height' => $h,
        'cost' => calculateCost($r, $h, $P1, $P2)
    ];
}

function randomSearch($V, $P1, $P2, $iterations = 100000) {
    $bestCost = INF;
    $bestR = 0;
    $bestH = 0;

    // Задаємо розумний діапазон значень для r
    $r_min = 0.01;
    $r_max = pow(3 * $V / (4 * pi()), 1 / 3) * 2; // Оцінка максимального радіуса

    for ($i = 0; $i < $iterations; $i++) {
        $r = $r_min + lcg_value() * ($r_max - $r_min);
        $h = $V / (pi() * $r * $r);

        if ($h <= 0) {
            continue;
        }

        $cost = calculateCost($r, $h, $P1, $P2);

        if ($cost < $bestCost) {
            $bestCost = $cost;
            $bestR = $r;
            $bestH = $h;
        }
    }

    return [
        'radius' => $bestR,
        'height' => $bestH,
        'cost' => $bestCost
    ];
}

$resultLagrange = lagrangeOptimization($P1, $P2, $V);
$resultRandom = randomSearch($V, $P1, $P2);

echo "Метод Лагранжа:\n";
echo "  Радіус: " . round($resultLagrange['radius'], 4) . " м\n";
echo "  Висота: " . round($resultLagrange['height'], 4) . " м\n";
echo "  Мінімальна вартість: " . round($resultLagrange['cost'], 2) . " грн\n\n";

echo "Метод випадкового пошуку:\n";
echo "  Радіус: " . round($resultRandom['radius'], 4) . " м\n";
echo "  Висота: " . round($resultRandom['height'], 4) . " м\n";
echo "  Мінімальна вартість: " . round($resultRandom['cost'], 2) . " грн\n";
