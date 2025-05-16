<?php

// Параметри матеріалу
$rho = 1e-7;        // Ом·м
$L0 = 0.01;         // Початкова довжина, м
$A0 = 1e-8;         // Початкова площа, м²

// Параметри мікротріщин
$eps_th = 0.03;     // Порогова деформація (3%)
$alpha = 5;         // Інтенсивність утворення тріщин
$beta = 0.01;       // Втрачена площа на 1 тріщину (1%)

// Генератор Пуассонівського розподілу
function poisson($lambda) {
    $L = exp(-$lambda);
    $k = 0;
    $p = 1;
    do {
        $k++;
        $p *= mt_rand() / mt_getrandmax();
    } while ($p > $L);
    return $k - 1;
}

function resistanceWithCracks($L, $L0, $A0, $rho, $eps_th, $alpha, $beta) {
    $eps = ($L - $L0) / $L0;

    if ($eps < $eps_th) {
        return $rho * $L / $A0;
    }

    $lambda = $alpha * ($eps - $eps_th) * 100;
    $N = poisson($lambda);
    $A_eff = $A0 * (1 - $beta * $N);

    if ($A_eff <= 0) {
        return INF; // Плівка повністю втратила провідність
    }

    return $rho * $L / $A_eff;
}

echo "L (мм)\tДеформація (%)\tОпір (Ом)\n";
for ($L = $L0; $L <= $L0 * 1.40; $L += 0.0005) {
    $R = resistanceWithCracks($L, $L0, $A0, $rho, $eps_th, $alpha, $beta);
    $eps = ($L - $L0) / $L0;
    $Rstr = is_infinite($R) ? "∞" : sprintf("%.4e", $R);
    printf("%.3f\t%.1f\t\t%s\n", $L * 1000, $eps * 100, $Rstr);
}
