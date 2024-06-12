<?php $this->load->view('components/Header'); ?>
<link rel="stylesheet" href="./assets/css/home.css">

	<main>
	<custom-svg src="./assets/svg/backgroundLogin.svg" class="background"></custom-svg>

		<?php
			if(sizeof($products) == 0){
				echo '<div class="alert">Sem produtos para venda</div>';
			}
		?>
		<div class="products">
			<?php foreach ($products as $product): ?>
			<div class="product">
					<img class="product-img"  id="image" src="data:image/png;base64,<?php echo $product['image']; ?>" alt="">
					<h1 class="product-title" id="title"><?php echo $product['title']; ?></h1>
					<h2 class="product-stock" max="<?php echo $product['stock']; ?>" id="stock">Estoque: <?php echo $product['stock']; ?></h2>
        	<h2 class="product-price" id="price">Preço: R$<?php echo number_format($product['price'], 2, ',', '.'); ?></h2>
					<div class="product-actions">
						<button class="product-buy" onclick="addBasket(<?php echo($product['id'])?>, this)">Adicionar ao carrinho</button>
						<div class="product-quantity">
							<input type="number" name="" id="" value="1" min="1" readonly>
							<custom-svg src="./assets/icons/carret.svg" id="up" class="carret" onclick="upQuantity(this)"></custom-svg>
							<custom-svg src="./assets/icons/carret.svg" id="down" class="carret" onclick="downQuantity(this)"></custom-svg>
						</div>
					</div>
			</div>
			<?php endforeach; ?>
		</div>
	</main>

	<script>
		function upQuantity(el) {
			const stock = el.parentNode.parentNode.parentNode.querySelector("#stock").getAttribute("max")
			const input = el.previousElementSibling
			if (parseInt(stock) >= parseInt(input.value) + 1){
				input.value = parseInt(input.value) + 1		
			}else{
				showAlert('Não é possivel comprar mais do que tem no estoque', '#dc3545');
			}
		}

		function downQuantity(el) {
			const input = el.previousElementSibling.previousElementSibling
			if (parseInt(input.value) - 1 > 0){
				input.value = parseInt(input.value) - 1
			}
		}

		function addBasket(id, el) {
			const quantity = el.parentNode.querySelector("input").value;
			const data = {id, quantity}
			let canPush = true;
			if (quantity > 0){
							if (localStorage.getItem("basket") == null){
				localStorage.setItem("basket", JSON.stringify([data]));
			}else{
				let local = JSON.parse(localStorage.getItem("basket"))
				local.forEach((element, index) => {
					if (element.id == data.id){
						local[index] = data;
						canPush = false;
					}
				});
				if (canPush){
					local.push(data)
				}
				localStorage.setItem("basket", JSON.stringify(local))
			}

			updateBasket()
			}

		}

	</script>

<?php $this->load->view('components/alert'); ?>
<script src="<?php echo base_url('assets/scripts/basket.js')?>"></script>
<script src="<?php echo base_url('assets/scripts/utils.js')?>"></script>
<?php $this->load->view('components/Footer'); ?>

