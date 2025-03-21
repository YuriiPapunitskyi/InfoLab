<?php

$x = [];
$y = [];
$sx = $sx2 = $sy = $sy2 = $sxy = 0;

$filename = __DIR__ . "/stat1.dan";
if (!file_exists($filename)) {
    die("File $filename is not opened\n");
}

$file = fopen($filename, "r");
if (!$file) {
    die("Error opening file\n");
}

$N = 0;
while (($line = fgets($file)) !== false) {
    list($x_val, $y_val) = sscanf($line, "%lf %lf");
    $x[] = $x_val;
    $y[] = $y_val;
    $sx += $x_val;
    $sx2 += pow($x_val, 2);
    $sy += $y_val;
    $sy2 += pow($y_val, 2);
    $sxy += $x_val * $y_val;
    $N++;
}

fclose($file);

if ($N < 2) {
    die("Not enough data to calculate statistics\n");
}

$df = $N - 2;
$critical_values = [
    0.1 => [
        1 => 0.988, 2 => 0.9, 3 => 0.805, 12 => 0.457, 30 => 0.231,
        50 => 0.231, 100 => 0.164
    ],
    0.05 => [
        1 => 0.997, 2 => 0.95, 3 => 0.878, 4 => 0.811, 12 => 0.532,
        30 => 0.349, 50 => 0.273, 100 => 0.195
    ],
    0.02 => [
        1 => 0.999, 2 => 0.98, 3 => 0.934, 12 => 0.612, 30 => 0.405,
        50 => 0.231, 100 => 0.23
    ]
];

$mx = $sx / $N;
$my = $sy / $N;
$Dx = ($sx2 - $sx * $sx / $N) / ($N - 1);
$Dy = ($sy2 - $sy * $sy / $N) / ($N - 1);
$sigx = sqrt($Dx);
$sigy = sqrt($Dy);
$Rxy = ($sxy - $sx * $sy / $N) / ($N - 1);

if ($sigx * $sigy != 0) {
    $rxy = $Rxy / ($sigx * $sigy);
    printf("mx=%lg my=%lg sigx=%lg sigy=%lg rxy=%lg\n", $mx, $my, $sigx, $sigy, $rxy);

    foreach ([0.05, 0.02, 0.01] as $alpha) {
        $critical_value = $critical_values[$alpha][$df] ?? null;
        if ($critical_value !== null) {
            if (abs($rxy) > $critical_value) {
                printf("rxy is statistically significant at α=%g (critical value: %g)\n", $alpha, $critical_value);
            } else {
                printf("rxy is NOT statistically significant at α=%g (critical value: %g)\n", $alpha, $critical_value);
            }
        } else {
            printf("No critical value found for df=%d at α=%g\n", $df, $alpha);
        }
    }
} else {
    printf("denominator = 0 for sigx=%lg sigy=%lg\n", $sigx, $sigy);
}
