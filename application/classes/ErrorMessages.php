<?php
class ErrorMessages {
    // Array associativo para armazenar mensagens de erro com base no InternalCode
    private static $errors = array(
        'R01' => array('code' => 405, 'internalCode'=> 'R01','text' => 'Método não aceito para essa rota'),
		'R02' => array('code' => 400, 'internalCode'=> 'R02','text' => 'Parâmetros enviado são invalidos'),
		'R03' => array('code' => 401, 'internalCode'=> 'R03','text' => 'Usuario ja registrado'),
		'M01' => array('code' => 401, 'internalCode'=> 'M01','text' => 'Token invalido, tente fazer login novamente'),
		'M02' => array('code' => 403, 'internalCode'=> 'M02','text' => 'Apenas o dono da loja pode acessar essa rota.'),
		'S01' => array('code' => 400, 'internalCode'=> 'S01','text' => 'Não é possivel deletar esse produto por conta que ja houve venda!'),

	);

    // Método estático para recuperar a mensagem de erro com base no InternalCode
    public static function getErrorMessage($internalCode) {
        // Verifica se o InternalCode existe no array de erros
        if (array_key_exists($internalCode, self::$errors)) {
            // Retorna a mensagem de erro correspondente
            return self::$errors[$internalCode];
        } else {
            // Se o InternalCode não existir, retorna uma mensagem de erro padrão
            return array('code' => 500, 'text' => 'InternalCode não encontrado');
        }
    }
}

