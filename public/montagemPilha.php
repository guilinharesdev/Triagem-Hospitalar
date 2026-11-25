<?php

include_once(__DIR__ . '/../src/pilha.php');

$historicos = listarHistoricoPlantao();

?>

<?php if (empty($historicos)) { ?>

    <p class="vazio">Nenhum atendimento registrado no plantão.</p>

<?php } else { ?>

    <table>
        <thead>
            <tr>
                <th>Horário</th>
                <th>Ação</th>
                <th>Paciente</th>
                <th>Grau</th>
                <th>ID</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($historicos as $item) { ?>
                <tr>
                    <td><?php echo $item['timestamp']; ?></td>
                    <td><?php echo $item['acao']; ?></td>
                    <td><?php echo $item['dados_novos']['nome'] ?? 'Sem nome'; ?></td>
                    <td><?php echo $item['dados_novos']['gravidade'] ?? '-'; ?></td>
                    <td><?php echo $item['paciente_id'] ?? '-'; ?></td>

                </tr>
            <?php } ?>
        </tbody>
    </table>

<?php } ?>