<?php

include_once(__DIR__ . '/../src/relatorios.php');

$totalAtendidos = contarPacientesAtendidos();
$totalGrau3 = contarPorGrau(3);
$totalGrau2 = contarPorGrau(2);
$totalGrau1 = contarPorGrau(1);

if ($aba === 'distribuicao') {
    echo "<ul>";
    echo "<li><strong>Grau 3:</strong> " . $totalGrau3 . " paciente(s)</li>";
    echo "<li><strong>Grau 2:</strong> " . $totalGrau2 . " paciente(s)</li>";
    echo "<li><strong>Grau 1:</strong> " . $totalGrau1 . " paciente(s)</li>";
    echo "</ul>";
} else {
    echo "<p>Total de pacientes atendidos hoje: <strong>" . $totalAtendidos . "</strong></p>";
}
?>