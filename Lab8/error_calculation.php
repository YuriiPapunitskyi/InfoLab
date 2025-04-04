<?php
$r_exact = 0.5684;  // Оптимальний радіус (метод Лагранжа)
$h_exact = 0.9852;    // Оптимальна висота (метод Лагранжа)
$cost_exact =  3048.35; // Мінімальна вартість (метод Лагранжа)

$r_num = 0.651;   // Оптимальний радіус (метод випадкового пошуку)
$h_num = 0.7511;    // Оптимальна висота (метод випадкового пошуку)
$cost_num = 2995.49; // Мінімальна вартість (метод випадкового пошуку)

function calculateError($exact, $approx) {
    return abs(($approx - $exact) / $exact) * 100;
}

$error_r = calculateError($r_exact, $r_num);
$error_h = calculateError($h_exact, $h_num);
$error_cost = calculateError($cost_exact, $cost_num);

echo "Похибка радіуса: " . round($error_r, 4) . "%\n";
echo "Похибка висоти: " . round($error_h, 4) . "%\n";
echo "Похибка вартості: " . round($error_cost, 4) . "%\n";
?>