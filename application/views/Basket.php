<?php $this->load->view('components/Header'); ?>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/basket.css')?>">
<main>
	<custom-svg src="./assets/svg/backgroundLogin.svg" class="background"></custom-svg>
	<h1 class="basket-title">Lista de compras</h1>
	<div class="basket-list">
		<div class="products">
		</div>
		<div class="checkout">
			<span class="checkout-qnt">Quantidade de itens:&nbsp;<a>0</a></span>
			<span class="checkout-price">Preço total: R$&nbsp;<a>00,00</a></span>
		</div>
	</div>
	<button class="basket-clear" onclick="clearBasket()">Apagar carrinho</button>
	<button class="basket-finish" onclick="buy()">Finalizar compra</button>
</main>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
	let products = []

	if (localStorage.getItem("basket") != undefined && localStorage.getItem("basket") != []){
		axios.post("http://localhost:80/basket/list", {
					token: localStorage.getItem("token"),
					basket: JSON.parse(localStorage.getItem("basket")),
					
			}).then(response => {
				products = response.data
				products.forEach(element => {
					createProduct(element.image, element.title, element.quantity, calculateAndFormat(parseFloat(element.price), parseInt(element.quantity)),element.id)
				});
				loadCheckout()
			}).catch(error => {
				console.log(error);
				showAlert("Não foi possivel realizar sua requisição tente novamente mais tarde", '#dc3545');
			});
	}


	function switchQuantity(el) {
		const value = el.value;
		const id = parseInt(el.parentNode.getAttribute("id"));
		let product = null
		products.forEach(element => {
			if (element.id == id){
				product =element;
				return;
			}
		});

		if (value > 0){
			if (parseInt(product.stock) < parseInt(value)){
				el.value = product.stock
				showAlert('Não é possivel comprar mais do que tem no estoque', '#dc3545');
			}
		}else{
			el.value = 1
			showAlert('A quantidade de produtos deve ser maior que 0', '#dc3545');
		}

		let local = JSON.parse(localStorage.getItem("basket"))
		local.forEach(element => {
			if (element.id == id){
				element.quantity = el.value
			}
		});
		products.forEach(element => {
			if (element.id == id){
				product.quantity = el.value;
				loadCheckoutIndividual(product)
				return;
			}
		});

		localStorage.setItem("basket", JSON.stringify(local))
		loadCheckout()
		updateBasket()
	}

	function loadCheckoutIndividual(product) {
		const element = document.querySelector(`[id="${product.id}"]`).querySelector("p");
		element.innerHTML = calculateAndFormat(parseFloat(product.price), parseInt(product.quantity))
	}

	function removeElement(el){
		const id = parseInt(el.parentNode.getAttribute("id"));
		const newLocal = []
		products.forEach((element, index) => {
			if (element.id != id){
				newLocal.push(element)
			}
		});
		
		products = newLocal;
		localStorage.setItem("basket", JSON.stringify(newLocal))
		updateBasket()
		loadCheckout()
		showAlert('Produto retirado do carrinho com sucesso', '#28a745');
		const element = document.querySelector(`[id="${id}"]`);
		document.getElementsByClassName("products")[0].removeChild(element)
	}

	function loadCheckout() {
		let qnt = 0;
		let price = 0;

		products.forEach(element => {
			qnt += parseInt(element.quantity);
			price += parseInt(element.quantity) *parseFloat(element.price)
		});

		document.getElementsByClassName("checkout-qnt")[0].querySelector("a").innerHTML = qnt
		document.getElementsByClassName("checkout-price")[0].querySelector("a").innerHTML = formatToTwoDecimalPlaces(price.toString())
	}

	function calculateAndFormat(floatValue, intValue) {
    // Retornar a string no formato desejado
    return `R$${formatToTwoDecimalPlaces(floatValue.toString())} * ${intValue} = R$${formatToTwoDecimalPlaces((floatValue * intValue).toString())}`;
	}

	function createProduct(imgSrc, title, quantity, priceFormatted ,id) {
    // Cria uma nova div
    var div = document.createElement('div');
		div.setAttribute("id", id)
    div.classList.add('product');

    // Cria uma imagem
    var img = document.createElement('img');
    img.classList.add('product-img');
    img.src = "data:image/png;base64,"+imgSrc;
    img.alt = 'Product Image';
    div.appendChild(img);

    // Cria um título
    var h1 = document.createElement('h1');
    h1.classList.add('product-title');
    h1.textContent = title;
    div.appendChild(h1);

		// Cria um título
		var p = document.createElement('p');
    p.classList.add('product-price');
    p.textContent = priceFormatted;
    div.appendChild(p);

    // Cria um input de quantidade
    var input = document.createElement('input');
    input.classList.add('product-quantity');
    input.type = 'number';
    input.placeholder = 'Quantidade';
    input.value = quantity;
    input.onchange = function() {
        switchQuantity(this);
    };
    div.appendChild(input);

    // Cria um botão de remover
    var customSvg = document.createElement('custom-svg');
		customSvg.onclick = function(){removeElement(this)}
    customSvg.classList.add('product-remove');
    customSvg.innerHTML = '<img src="./assets/icons/delete.svg" alt="Remove">';
    div.appendChild(customSvg);

    // Adiciona a nova div ao corpo do documento
		document.getElementsByClassName("products")[0].appendChild(div)
}

	function formatToTwoDecimalPlaces(number){
    // Convert the string to a float
    let floatNumber = parseFloat(number.replace(',', '.'));

    // Format the number to two decimal places
    let formattedNumber = floatNumber.toFixed(2);

    // Replace the decimal point with a comma
    formattedNumber = formattedNumber.replace('.', ',');

    return formattedNumber;
}

	function clearBasket() {
		localStorage.removeItem("basket")
		updateBasket()		
		window.location.href = "/"
	}

	function buy(){
		if (products.length != 0){
			axios.post("http://localhost:80/basket/buy", {
					token: localStorage.getItem("token"),
					basket: JSON.parse(localStorage.getItem("basket")),
			}).then(response => {
				document.getElementsByClassName("products")[0].innerHTML = ""
				localStorage.removeItem("basket")
				updateBasket()
				products = [{quantity: 0, price: 0}]
				loadCheckout()
				showAlert('Compra realizada com sucesso', '#28a745');
			}).catch(error => {
				console.log(error);
				showAlert("Não foi possivel realizar sua requisição tente novamente mais tarde", '#dc3545');
			});
	}else{
		showAlert("Precisa ter itens no carrinho para poder comprar", '#dc3545');
	}
	}

</script>
<?php $this->load->view('components/alert'); ?>
<?php $this->load->view('components/Footer'); ?>
