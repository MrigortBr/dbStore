<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'classes\User.php';
require_once APPPATH . 'classes\ErrorMessages.php';
require_once APPPATH . 'utils\Validators.php';

class Login extends CI_Controller {

	public function index(){
		$this->load->helper('url');
    $this->load->view("login");
	}

	//Rota de login do usuario
	public function LoginNew() {
		//Verifica se a requisição foi feita em Post
		Validators::requestIsAllowed('POST');
		//Pega os valores enviados por meio de requisição Post, passados no body
		$data = Validators::validateJsonPayload(file_get_contents('php://input'), array('login', 'password'));
		//Lê o model UserModel
		$this->load->model('UserModel');
		//Busca o usuario informado
		$userFinded = $this->UserModel->getUserByLogin($data['login']);
		//Verifica se o array retornado é vazio (logo nao existe)
		Validators::arrayIsEmpty($userFinded);
		//Instancia um usuario
		$user = new User($userFinded['id'],$data['login'], $data['password'], $userFinded['typeUser']);
		//Valida a senha do usuario
		if (password_verify($data['password'], $userFinded['password'])) {
			// Gera o token JWT
			$token = $user->generate_jwt();
			// Retorna o token como resposta
			header('Content-Type: application/json; charset=utf-8');
			http_response_code(200);
			echo json_encode(array('token' => $token, 'isStore' => $user->isStore()));
		} else {
			$error = ErrorMessages::getErrorMessage("R02");
			http_response_code($error['code']);
			header('Content-Type: application/json; charset=utf-8');
			echo(json_encode(($error)));
		}
	}
}

    

