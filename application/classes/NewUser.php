<?php
use \Firebase\JWT\JWT;


class NewUser {
    public $id;
    public $login;
    public $password;
    public $typeuser;

    public function __construct($id, $login, $password, $typeuser) {
        $this->id = $id;
        $this->login = $login;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        $this->typeuser = $typeuser;
    }

    public function generate_jwt() {
        $key = "CHAVE"; 
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; 
        $payload = array(
            'iat' => $issuedAt,
            'exp' => $expirationTime,
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
