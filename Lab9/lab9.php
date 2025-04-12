<?php
$k_otv = 15000;
$ro = 1400;
$f = 800;
$n = 10000;

$intervals = [
    [10, 10.5], [10.5, 11], [11, 11.5], [11.5, 12], [12, 12.5],
    [12.5, 13], [13, 13.5], [13.5, 14], [14, 14.5], [14.5, 15]
];
$frequencies = [0.05, 0.06, 0.12, 0.10, 0.25, 0.15, 0.10, 0.08, 0.05, 0.04];

$cumFreq = [];
$sum = 0;
foreach ($frequencies as $freq) {
    $sum += $freq;
    $cumFreq[] = $sum;
}

function generateG($intervals, $cumFreq) {
    $ksi = mt_rand() / mt_getrandmax();
    for ($i = 0; $i < count($cumFreq); $i++) {
        if ($ksi <= $cumFreq[$i]) {
            $a = $intervals[$i][0];
            $b = $intervals[$i][1];
            $F_prev = $i == 0 ? 0 : $cumFreq[$i - 1];
            $F_curr = $cumFreq[$i];
            return $a + ($b - $a) * ($ksi - $F_prev) / ($F_curr - $F_prev);
        }
    }
    return $intervals[count($intervals) - 1][1];
}

$dk_values = [];
for ($i = 0; $i < $n; $i++) {
    $G = generateG($intervals, $cumFreq);
    $dk = pow((6 * $G) / (pi() * $k_otv * $ro * $f), 1 / 3);
    $dk_values[] = $dk;
}

$mean_dk = array_sum($dk_values) / $n;
$sum_sq_diff = 0;
foreach ($dk_values as $dk) {
    $sum_sq_diff += pow($dk - $mean_dk, 2);
}
$std_dk = sqrt($sum_sq_diff / ($n - 1));

echo "Математичне очікування d_k: " . round($mean_dk, 6) . " м\n";
echo "Середньоквадратичне відхилення: " . round($std_dk, 6) . " м\n";
