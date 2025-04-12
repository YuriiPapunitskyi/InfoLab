<?php

$V = floatval($argv[1]);
$P1 = floatval($argv[2]);
$P2 = floatval($argv[3]);

$result1 = lagrangeMethod($V, $P1, $P2);
$result2 = randomSearch($V, $P1, $P2);

echo "Метод Лагранжа:\n";
echo "r = " . round($result1['r'], 4) . " м\n";
echo "h = " . round($result1['h'], 4) . " м\n";
echo "Вартість = " . round($result1['cost'], 2) . " грн\n\n";

echo "Метод випадкового пошуку:\n";
echo "r = " . round($result2['r'], 4) . " м\n";
echo "h = " . round($result2['h'], 4) . " м\n";
echo "Вартість = " . round($result2['cost'], 2) . " грн\n";


function lagrangeMethod($V, $P1, $P2) {
    $pi = pi();

    $costFunction = function($r) use ($P1, $P2, $V, $pi) {
        if ($r <= 0) return INF;
        $h = $V / ($pi * $r * $r);
        return $P1 * $pi * $r * $r + $P2 * 2 * $pi * $r * $h;
    };

    $minCost = INF;
    $bestR = 0;
    for ($r = 0.01; $r <= 100; $r += 0.01) {
        $cost = $costFunction($r);
        if ($cost < $minCost) {
            $minCost = $cost;
            $bestR = $r;
        }
    }

    $bestH = $V / ($pi * $bestR * $bestR);

    return ['r' => $bestR, 'h' => $bestH, 'cost' => $minCost];
}



function randomSearch($V, $P1, $P2, $iterations = 5000)
{
    $pi = pi();
    $minCost = INF;
    $bestR = 0;
    $bestH = 0;

    for ($i = 0; $i < $iterations; $i++) {
        $r = mt_rand(1, 10000) / 100; // від 0.01 до 100
        $h = $V / ($pi * $r * $r);

        if ($h <= 0) continue;

        $cost = $P1 * $pi * $r * $r + $P2 * 2 * $pi * $r * $h;

        if ($cost < $minCost) {
            $minCost = $cost;
            $bestR = $r;
            $bestH = $h;
        }
    }

    return ['r' => $bestR, 'h' => $bestH, 'cost' => $minCost];
}
