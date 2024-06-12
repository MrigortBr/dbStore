<?php
use \Firebase\JWT\JWT;


class User {
    public $id;
    public $login;
    public $hashedPassword;
    public $typeuser;

    public function __construct($id, $login, $hashedPassword, $typeuser) {
        $this->id = $id;
        $this->login = $login;
        $this->hashedPassword = $hashedPassword;
        $this->typeuser = $typeuser;
    }

    public function verificarhashedPassword($password) {
        return password_verify($password, $this->hashedPassword);
    }

	public function generate_jwt() {
        $key = "CHAVE"; 
        $issuedAt = time();
        $payload = array(
            'iat' => $issuedAt,
            'data' => array(
                'id' => $this->id
			),
			'alg' => 'HS256'
        );

        return JWT::encode($payload, $key, 'HS256');
    }

	public function isStore() {
		if ($this->typeuser == "store") {
			return true;
		} else {
			return false;
		}
	}
}
?>
