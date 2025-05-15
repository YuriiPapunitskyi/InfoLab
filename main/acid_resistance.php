<?php

// Початкові параметри
$rho0 = 1.0e-7;
$L0 = 0.01;
$A0 = 1.0e-8;
$R0 = $rho0 * $L0 / $A0;

// Кислотні параметри
$Vbubble = 1e-9; // м³
$r = 2;          // бульбашки/сек
$kA = 5000;
$kRho = 1000;

// Гранична умова: критичний об'єм кислоти
$Vcrit = 5e-8; // наприклад, 50 нл

function resistanceWithDestruction($t, $R0, $Vbubble, $r, $kA, $kRho, $Vcrit)
{
    $V = $Vbubble * $r * $t;
    if ($V >= $Vcrit) {
        return INF; // Плівка повністю зруйнована
    }
    return $R0 * (1 + $kRho * $V) * exp($kA * $V);
}

// Виведення
echo "Time (s)\tAcid Volume (nL)\tResistance (Ohms)\n";
for ($t = 0; $t <= 60; $t += 2) {
    $V = $Vbubble * $r * $t;
    $Vnano = $V * 1e9;
    $R = resistanceWithDestruction($t, $R0, $Vbubble, $r, $kA, $kRho, $Vcrit);
    $Rstr = is_infinite($R) ? "∞" : sprintf("%.6e", $R);
    printf("%2d\t\t%.2f\t\t%s\n", $t, $Vnano, $Rstr);
}




