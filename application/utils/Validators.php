<?php
require_once APPPATH . 'classes\ErrorMessages.php';
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
class Validators {

    // Método estático para validar o tipo de requisição
    public static function requestIsAllowed($requestAllowed) {
      if (strtoupper($requestAllowed) !== $_SERVER['REQUEST_METHOD']){
				$error = ErrorMessages::getErrorMessage("R01");
				http_response_code($error['code']);
				header('Content-Type: application/json; charset=utf-8');
				echo(json_encode(($error)));
				exit();			
			}
    }

		public static function validateJsonPayload($jsonPayload, $expectedFields) {
			$data = json_decode($jsonPayload, true);
			if (is_array($data)) {
				//Salva os campos diferentes
				$missingFields = array_diff($expectedFields, array_keys($data));
				if (!empty($missingFields)) {
					$error = ErrorMessages::getErrorMessage("R02");
					http_response_code($error['code']);
					header('Content-Type: application/json; charset=utf-8');
					echo(json_encode(($error)));
					exit();
				}else{
					return $data;
				}
			}else{
				$error = ErrorMessages::getErrorMessage("R02");
				http_response_code($error['code']);
				header('Content-Type: application/json; charset=utf-8');
				echo(json_encode(($error)));
				exit();
			}		
		}

		public static function decodeToken($token){
			try {
				$decoded = (array) JWT::decode($token, new Key("CHAVE", 'HS256'));
				$decodedData = (array) $decoded['data'] ;		
				return $decodedData['id'];
			}catch (Exception $ex) {
				$error = ErrorMessages::getErrorMessage("M01");
				http_response_code($error['code']);
				header('Content-Type: application/json; charset=utf-8');
				echo(json_encode(($error)));
				exit();
			}
		}
		
		public static function arrayIsEmpty($array){
			if (empty($array)) {
				$error = ErrorMessages::getErrorMessage("R02");
				http_response_code($error['code']);
				header('Content-Type: application/json; charset=utf-8');
				echo(json_encode(($error)));
				exit();
			}
		}
}

