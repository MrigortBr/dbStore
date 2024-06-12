<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'classes\NewUser.php';
require_once APPPATH . 'classes\ErrorMessages.php';
require_once APPPATH . 'utils\Validators.php';

class Register extends CI_Controller {

	public function index(){
		$this->load->helper('url');
    $this->load->view("register");
	}

		//Rota de cadastro de usario
	public function registerNewUser() {
		//Verifica se a requisição foi feita em Post
		Validators::requestIsAllowed('POST');
		//Pega os valores enviados por meio de requisição Post, passados no body
		$data = Validators::validateJsonPayload(file_get_contents('php://input'), array('login', 'password', "type"));
		//Lê o model UserModel
		$this->load->model('UserModel');
		//Cria uma instancia de usuario, e ao criar ja encripta a senha
		$user = new NewUser(null, $data['login'], $data['password'], $data['type']);
		//Verifica se o usuario existe no banco de dados
		if ($this->UserModel->userExist($user->login)) {
			//Se existir dispara um erro
			$error = ErrorMessages::getErrorMessage("R03");
			http_response_code($error['code']);
			header('Content-Type: application/json; charset=utf-8');
			echo(json_encode(($error)));
		}else{
			//Salva o usuario no banco de dados
			$user->id = $this->UserModel->saveUser($user);
			// Gere o token JWT
			$token = $user->generate_jwt();
			// Retorna o token como resposta
			header('Content-Type: application/json; charset=utf-8');
			http_response_code(200);
			echo json_encode(array('token' => $token, 'isStore' => $user->isStore()));
		}
	}
}
