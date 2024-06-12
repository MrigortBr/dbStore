<?php $this->load->view('components/Header'); ?>
	<main>
	<custom-svg src="./assets/svg/backgroundLogin.svg"></custom-svg>
		<link rel="stylesheet" href="./assets/css/login.css">
		<div class="login">
			<h1 class="login-title">Registrar</h1>
			<input type="text" name="login" id="login" class="login-input" placeholder="login">
			<input type="password" name="password" id="password" class="login-input" placeholder="senha">
			<div class="container">
        	<label class="label" id="user">
            <span>Usuario</span>
            <input id="user-input" class="input" value="user" name="radio" type="radio">
        	</label>
        	<label class="label" id="store">
            <span>Empresa</span>
            <input id="store-input" class="input" checked="checked" value="store" name="radio" type="radio">
        	</label>
			</div>
				<button class="login-button" onclick="register()">Registrar</button>
				<p onclick="window.location.href ='/login'">Ja tem uma conta? <b>clique aqui para fazer login</b></p>

		</div>
	</main>

	<script src="<?php echo base_url('assets/scripts/utils.js')?>"></script>
	<script src="<?php echo base_url('assets/scripts/auth.js')?>"></script>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	<?php $this->load->view('components/alert'); ?>
	
<?php $this->load->view('components/Footer'); ?>


