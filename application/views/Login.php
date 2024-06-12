<?php $this->load->view('components/Header'); ?>
	<main>
	<custom-svg src="./assets/svg/backgroundLogin.svg"></custom-svg>
		<link rel="stylesheet" href="./assets/css/login.css">
		<div class="login">
			<h1 class="login-title">Logar</h1>
			<input type="text" name="login" id="login" class="login-input" placeholder="login">
			<input type="password" name="password" id="password" class="login-input" placeholder="senha">
			<button class="login-button" onclick="login()">Login</button>
			<div></div>
			<p onclick="window.location.href ='/register'">Não tem uma conta?<b> Clique aqui e registre</b></p>

		</div>
	</main>
	<footer>

	</footer>

	<script src="<?php echo base_url('assets/scripts/utils.js')?>"></script>
	<script src="<?php echo base_url('assets/scripts/auth.js')?>"></script>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	<?php $this->load->view('components/alert'); ?>

<?php $this->load->view('components/Footer'); ?>


