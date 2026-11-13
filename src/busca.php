<?php
/**
 * Basta informar o cpf xxx.xxx.xxx-xx e o paciente será localizado.
 * O resultado será o array com os dados do paciente, caso contrário será false.
 * @param string $cpf
 * @return array
 */
function localizarPaciente(string $cpf): array|bool{
    
    $caminho = '../dados/paciente.json';
    $json = file_get_contents($caminho);
    $busca = json_decode($json, true);   
    $paciente = buscarPorValor($busca, $cpf);   
    if($paciente === null){
        return false;
    }
    return $paciente;
}

/**
 * Se você quer uma função pronta para retornar apenas um registro específico com base em uma chave e um valor
 * @param array $jsonDecode
 * @param string $valorProcurado
 * @param string $chave
 * 
 */
function buscarPorValor(array $jsonDecode, string $valorProcurado, string $chave = 'cpf'): ?array {
    foreach ($jsonDecode as $item) {
        if (isset($item[$chave]) && $item[$chave] === $valorProcurado) {
            return $item; // Retorna o array interno encontrado
        }
    }
    return null; // Retorna nulo se não encontrar
}

$paciente = localizarPaciente('123');
