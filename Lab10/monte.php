<?php

$N = 20000;
$a1 = 0;
$A1 = 2 * sqrt(2);

$a2 = 0;
$A2 = 4 * sqrt(2);

$S = 0;

for ($j = 0; $j < $N; $j++) {
    $R1 = lcg_value();
    $x1 = $a1 + ($A1 - $a1) * $R1;

    $R2 = lcg_value();
    $x2 = $a2 + ($A2 - $a2) * $R2;

    if ($x2 >= 0.5 * $x1 && $x2 <= 2 * $x1) {
        $phi = sqrt(1 + pow($x1, 2));
        $S += $phi;
    }
}
$area = ($A1 - $a1) * ($A2 - $a2);

$J = $area * $S / $N;

echo "Наближене значення інтеграла J = " . round($J, 6) . "\n";

