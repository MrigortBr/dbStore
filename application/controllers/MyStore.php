<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
require_once APPPATH . 'classes\ErrorMessages.php';
require_once APPPATH . 'classes\Store.php';
require_once APPPATH . 'utils\Validators.php';

class MyStore extends CI_Controller {

	public function index(){
		$token = $_GET['token'];
		$this->load->helper('url');
		$this->load->model('UserModel');

		//Tenta decodificar a chave JWT em um try para poder tratar a Exception se a key for invalida
		try {
			//Decodifica a chave JWT
			$decoded = (array) JWT::decode($token, new Key("CHAVE", 'HS256'));
			//Pega o id do usuario/loja na chave JWT
			$idStore = ((array) $decoded['data'])['id'];
			$userFinded = $this->UserModel->getUserById($idStore);

			if ($userFinded['typeUser'] == "store"){
				//Lê o model de loja
				$this->load->model('StoreModel');
				//Pega todos os produtos da loja
				$products = $this->StoreModel->getAllProducts($idStore);
				//Valida se esta vazio para nao precisar fazer mais requisições
				if (!empty($products)){
					//Busca todas as vendas desse produto
					foreach ($products as &$product) {
						$product['sales'] = ($this->StoreModel->getAllSales($product['id']));
					}
					//Renderiza a view mystore passando todos os produtos
				}
				$this->load->view('mystore', array('products'=> $products));
			}else{
				$error = ErrorMessages::getErrorMessage("M02");
				http_response_code($error['code']);
				header('Content-Type: application/json; charset=utf-8');
				echo(json_encode(($error)));
			}

		} catch (Exception $ex) {
			$error = ErrorMessages::getErrorMessage("M01");
			http_response_code($error['code']);
			header('Content-Type: application/json; charset=utf-8');
			echo(json_encode(($error)));
		}
	}
	
	public function Delete() {
		Validators::requestIsAllowed('DELETE');
		//Pega os valores enviados por meio de requisição Post, passados no body
		$data = Validators::validateJsonPayload(file_get_contents('php://input'), array('id', 'token'));
		//Decodifica o Token
		$idStore = Validators::decodeToken($data['token']);
		//Lê o model StoreModel
		$this->load->model('StoreModel');
		//Deleta o produto					
		$result = $this->StoreModel->deleteProductById($idStore, $data['id']);
		if ($result['success']) {
				header('Content-Type: application/json; charset=utf-8');
				http_response_code(200);
				echo json_encode(array('success' => true, 'message' => 'Produto deletado com sucesso'));
		 } else {
				if ($result['error_code'] == 1451) {
					$error = ErrorMessages::getErrorMessage("S01");
					http_response_code($error['code']);
					header('Content-Type: application/json; charset=utf-8');
					echo(json_encode(($error)));
			} else {
				$error = ErrorMessages::getErrorMessage("R02");
				http_response_code($error['code']);
				header('Content-Type: application/json; charset=utf-8');
				echo(json_encode(($error)));
				}
		}
	}

	public function Show(){
		Validators::requestIsAllowed('PUT');
		//Pega os valores enviados por meio de requisição Post, passados no body
		$data = Validators::validateJsonPayload(file_get_contents('php://input'), array('id', 'token'));
		//Decodifica o Token
		$idStore = Validators::decodeToken($data['token']);
		//Cria uma variavel para o id do produto
		$idProduct =  $data['id'];
		//Lê o model StoreModel
		$this->load->model("StoreModel");
		//Verifica se tem algum produto com os parametros passados
		$product = $this->StoreModel->getProductById($idStore, $idProduct);
		Validators::arrayIsEmpty($product);
		//Utilizando o operador bitwise XOR ele inverte o valor 0 = 1 e 1 = 0
		$product['visible'] ^= 1;
		//Atualiza o metodo
		$this->StoreModel->showProduct($product, $idStore);
	}

	public function editView(){
		$id = $_GET['id'];
		$storeId = $_GET['store'];

		if ($id !='' && $storeId !='') {
			$this->load->helper('url');
			$this->load->model('StoreModel');
			$product = $this->StoreModel->getProductById($storeId, $id);
			Validators::arrayIsEmpty($product);
			$this->load->view("editProduct", array("product"=> $product));
		}
	}

	public function update(){
		$id = $this->input->post('id');
		$title = $this->input->post('title');
		$price = $this->input->post('price');
		$stock = $this->input->post('stock');
		$token = $this->input->post('token');
		$idStore = Validators::decodeToken($token);
		$fileBase = $this->input->post('fileBase');

		if ($_FILES['file'] && $_FILES['file']['tmp_name'] && $fileBase != "true") {
			$base64Image = $this->convertImageToBase64($_FILES['file']['tmp_name']);
		} else {
			$base64Image = $this->input->post('file');
		}
		
		$data = array(
			'title' => $title,
			'price' => $price,
			'stock' => $stock,
			'image' => $base64Image
			
		);

		$this->load->model("StoreModel");
		$result = $this->StoreModel->updateProduct($id, $idStore, $data);


	}

	public function createView(){
		$this->load->helper('url');
		Validators::requestIsAllowed('GET');
		$token = $_GET['token'];
		$idStore = Validators::decodeToken($token);
		$product = $product = array(
			'id' => null,
			'title' => 'Titulo',
			'image' => '',
			'price' => 0.00,
			'stock' => 0,
			'store_id' => $idStore,
			'show' => 1
	);	
		$this->load->view("newProduct", array("product"=> $product));


	}

	public function create(){
		$id = $this->input->post('id');
		$title = $this->input->post('title');
		$price = $this->input->post('price');
		$token = $this->input->post('token');
		$stock = $this->input->post('stock');
		$idStore = Validators::decodeToken($token);
		$fileBase = $this->input->post('fileBase');

		if ($_FILES['file'] && $_FILES['file']['tmp_name'] && $fileBase != "true") {
			$base64Image = $this->convertImageToBase64($_FILES['file']['tmp_name']);
		} else {
			$base64Image = $this->input->post('file');
		}

		$data = array(
			"id" => null,
			'title' => $title,
			'price' => $price,
			'image' => $base64Image,
			"stock" => $stock,
			"store_id" => $idStore,
			"visible" => 1

		);

		$this->load->model("StoreModel");
		$result = $this->StoreModel->saveProduct($data);
		print_r($result);

	}

	private function convertImageToBase64($imagePath) {
		// Verifica se o arquivo existe
		if (file_exists($imagePath)) {
				// Lê o conteúdo do arquivo
				$imageData = file_get_contents($imagePath);
				// Converte o conteúdo para base64
				$base64Image = base64_encode($imageData);
				return $base64Image;
		} else {
				return null;
		}
}
}
