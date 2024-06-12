<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>dbStore</title>
    <link rel="icon" href="<?php echo base_url('assets/ico.ico'); ?>" type="image/x-icon">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/header.css')?>">
</head>
<body style="overflow-x: hidden;">
<script src="<?php echo base_url('assets/scripts/basket.js')?>"></script>
	<header>
		<div class="logo" onclick="window.location.href ='/'" title="Voltar para pagina principal">
				<img src="<?php echo base_url('assets/ico.ico'); ?>" alt="">
				<h1>dbStore</h1>
		</div>
		
		<div class="actions">
			<script>
						// Verifica se há um token no localStorage
						const tokenExists = localStorage.getItem('token');
						const isStore = localStorage.getItem('isStore');
						
						// Se o token existir, exibe as duas primeiras imagens
						if (tokenExists) {
								document.write('<div id="basket" qnt="0"><custom-svg src="<?php echo base_url('assets/icons/basket.svg'); ?>"  alt="" title="Abrir sua cesta" onclick="openBasket()" ></custom-svg></div> ');
								if (isStore == "true"){
									document.write('<img src="<?php echo base_url('assets/icons/store.svg'); ?>" alt="" onclick="openStore()" title="Abrir sua Loja"> ');	
								}
								document.write('<img src="<?php echo base_url('assets/icons/logout.svg'); ?>" alt="" onclick="logout()"title="Sair da conta"> ');
						} else if (window.location.pathname != "/register" && window.location.pathname != "/login") { // Caso contrário, exibe apenas a primeira imagem
								document.write('<img src="<?php echo base_url('assets/icons/login.svg'); ?>"  alt=""  onclick="goLogin()" title="Fazer login">');
						}

						updateBasket()
				</script>
					<script src="<?php echo base_url('assets/scripts/auth.js')?>"></script>
					<script src="<?php echo base_url('assets/scripts/utils.js')?>"></script>

		</div>
  </header>  

	

