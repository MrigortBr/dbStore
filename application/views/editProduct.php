<?php $this->load->view('components/Header'); ?>
<main>
	<input type="file" name="" id="file"  onchange="updateImagePreview(event)">
	<custom-svg src="<?php echo base_url('assets/svg/backgroundLogin.svg')?>" class="background"></custom-svg>
	
	<div class="product">
        <img class="product-img" id="image" src="data:image/png;base64,<?php echo $product['image']; ?>" alt="" onclick="triggerFileInput()">
				<input type="text" name="" id="title" value="<?php echo $product['title']; ?>" placeholder="titulo">
				<input type="number" name="" id="stock" value="<?php echo $product['stock']; ?>" placeholder="estoque">
				<input type="text" name="" id="price" value="<?php echo number_format($product['price'], 2, ',', '.'); ?>"  placeholder="preço">
    </div>
	<div class="functions">
		<div class="function-button" onclick="updateProduct(<?php echo $product['id']?>)">
			<custom-svg src="<?php echo base_url('assets/icons/check.svg')?>"></custom-svg>
			<button>Atualizar</button>
		</div>
		<div class="function-button" onclick="showProduct(<?php echo $product['id']?>)">
			<?php
				$idProduct = $product['id'];
				if ($product['visible'] == 1) {
					echo '<custom-svg src="../../assets/icons/eye.svg" class="product-buttons visible" id="product-delete"></custom-svg>';
				}else{
					echo '<custom-svg src="../../assets/icons/eye-slash.svg" class="product-buttons hidden" id="product-delete"></custom-svg>';
				}
			?>			
			<button>Ocultar</button>
		</div>
		<div class="function-button" onclick="deleteProduct(<?php echo $idProduct?>)">
			<custom-svg src="../../assets/icons/delete.svg" class="product-buttons" id="product-delete"></custom-svg>
			<button>Deletar</butto>
		</div>
	</div>

</main>



<script>
    function triggerFileInput() {
        document.getElementById('file').click();
    }
		
		function updateImagePreview(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementsByClassName('product-img')[0].src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
		
    function updateProduct(productId) {
        const title = document.getElementById('title').value;
        const price = document.getElementById('price').value;
				const stock = document.getElementById('stock').value;
				const token =localStorage.getItem("token");
        const fileInput = document.getElementById('file');
        const file = fileInput.files[0];
				

        const formData = new FormData();
        formData.append('id', productId);
        formData.append('title', title);
        formData.append('price', price);
				formData.append('token', token);
				formData.append('stock', stock);
        if (file) {
            formData.append('file', file);
        }else{
					formData.append('file', "<?php echo $product['image'];?>")
					formData.append("fileBase", true)
				}

				console.log(formData.get('file'));

        axios.post('http://localhost:80/mystore/product/update', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(response => {
            showAlert('Produto atualizado com sucesso', '#28a745');
        }).catch(error => {
            showAlert('Erro ao atualizar o produto', '#dc3545');
            console.error(error);
        });
    }



	</script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	<?php $this->load->view('components/alert'); ?>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/edit.css')?>">
	<script src="<?php echo base_url('assets/scripts/utils.js')?>"></script>
	<script src="<?php echo base_url('assets/scripts/mystore.js')?>"></script>
	<?php $this->load->view('components/Footer'); ?>
