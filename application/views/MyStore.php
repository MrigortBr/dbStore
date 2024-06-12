<?php $this->load->view('components/Header'); ?>
<main>
	<custom-svg src="./assets/svg/backgroundLogin.svg" class="background"></custom-svg>

	<div class="dashBoard">
	<span id="totalSales" class="statistics">
		<h1>Total de vendas</h1>
		<p id="totalSales-text"></p>
	</span>
	<div id="date-widget">
  <input type="date" class="date-input" id="start-date" onchange="updateStartDate(this)"> 
	<p>Até</p>
  <input type="date" class="date-input" id="end-date" onchange="updateEndDate(this)">
  <div id="difference"></div>
</div>
	<span id="totalSalesValue" class="statistics">
		<h1>Total de lucro</h1>
		<p id="totalSalesValue-text"></p>

	</span>
</div>

	<div class="products">
			<div class="product product-new" onclick="createProduct()">
						<img class="product-img" src="./assets/svg/image.svg" alt="">
						<h1 class="product-title">Criar novo produto</h1>
						<span></span>
						<div class="product-actions-new">
								<button>Criar Produto</button>
						</div>
				</div>

	<?php foreach ($products as $product): ?>
    <div class="product" onclick="selectProduct(<?php echo $product['id']?>, this)">
        <img class="product-img" id="image" src="data:image/png;base64,<?php echo $product['image']; ?>" alt="">
        <h1 class="product-title" id="title"><?php echo $product['title']; ?></h1>
				<h2 class="product-stock" id="stock">Estoque: <?php echo $product['stock']; ?></h2>
        <h2 class="product-price" id="price">Preço: R$<?php echo number_format($product['price'], 2, ',', '.'); ?></h2>
        <div class="product-actions">
						<custom-svg src="./assets/icons/edit.svg" class="product-buttons" id="product-edit" onclick="editProduct(<?php echo $product['id']?>, <?php echo $product['store_id']?>)"></custom-svg>
						<?php
							$idProduct = $product['id'];
							if ($product['visible'] == 1) {
								echo '<custom-svg src="./assets/icons/eye.svg" class="product-buttons visible" id="product-delete" onclick="showProduct(' . $idProduct . ')"></custom-svg>';
							}else{
								echo '<custom-svg src="./assets/icons/eye-slash.svg" class="product-buttons hidden" id="product-delete" onclick="showProduct(' . $idProduct . ')"></custom-svg>';
							}
						?>
						<?php
							$classDelete = count($product['sales']) > 0 ? 'blocked' : '';
							$idProduct = $product['id'];
							if ($classDelete == "blocked"){
								$idProduct = 0;
							}
						?>
						<custom-svg src="./assets/icons/delete.svg" class="product-buttons <?php echo $classDelete?>" id="product-delete" onclick="deleteProduct(<?php echo $idProduct?>)"></custom-svg>
        </div>
    </div>
<?php endforeach; ?>


		</div>
		<?php
			$products_json = json_encode($products);
		?>
		<script>
			var products = JSON.parse(`<?php echo $products_json?>`)
			let startDate = new Date(Date.now());
			let endDate = new Date(Date.now());
			let productSelected = 0;
			let statistics = calculateSalesStatistics(products);
			let productSelectedData = products;


			function calculateSalesStatistics(saleProducts) {
					let totalSales = 0;
					let totalSalesValue = 0;
					
					console.log(saleProducts);

					saleProducts.forEach(product => {
								product.sales.forEach(sale => {
									if (parseInt(sale.amount) > 0){

										if (isDateInRange(new Date(sale.created_at))){
											totalSales += parseInt(sale.amount)
											totalSalesValue += parseFloat(sale.priceFinal)
										}

									}

								});
							
					});
					return {
							totalSales: totalSales,
							totalSalesValue: totalSalesValue,
					};
			}

			function updateStatistics(salesStatistics) {
					document.getElementById('totalSales-text').innerText = salesStatistics.totalSales;
					document.getElementById('totalSalesValue-text').innerText = salesStatistics.totalSalesValue.toFixed(2).replace('.', ',');
			}
			updateStatistics(statistics);

			function selectProduct(id, element) {
				if (productSelected != id){
					products.forEach(product => {
						if (product.id == id){
							statistics = calculateSalesStatistics([product])
							productSelected = product.id
							updateStatistics(statistics);
							if (document.getElementById("selected")){
								document.getElementById("selected").id = "";
							} 
							element.id = "selected"
							productSelectedData = [product]
						}
					});
				}else{
					statistics = calculateSalesStatistics(products);
					productSelected = 0;
					if (document.getElementById("selected")){
								document.getElementById("selected").id = "";
							} 
					updateStatistics(statistics);
					productSelectedData = products
				}
			}

			function initDate() {
				document.getElementById("start-date").value = startDate.toISOString().split('T')[0];
				document.getElementById("end-date").value = endDate.toISOString().split('T')[0];
			}

			function isDateInRange(date) {
				startDate.setHours(0, 0, 0, 0);
				endDate.setHours(0, 0, 0, 0);
    		date.setHours(0, 0, 0, 0);
				return date >= startDate && date <= endDate;
			}

			function updateStartDate(el) {
				startDate = new Date(el.value);
				statistics = calculateSalesStatistics(productSelectedData)
				updateStatistics(statistics);
			}

			function updateEndDate(el) {
				endDate = new Date(el.value);
				statistics = calculateSalesStatistics(productSelectedData)
				updateStatistics(statistics);
			}
			
			initDate()

		</script>

</main>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	<?php $this->load->view('components/alert'); ?>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/mystore.css')?>">
	<script src="<?php echo base_url('assets/scripts/utils.js')?>"></script>
	<script src="<?php echo base_url('assets/scripts/mystore.js')?>"></script>
	<?php $this->load->view('components/Footer'); ?>
