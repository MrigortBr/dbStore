<?php $this->load->view('components/Header'); ?>
<main>
	<input type="file" name="" id="file"  onchange="updateImagePreview(event)">
	<custom-svg src="<?php echo base_url('assets/svg/backgroundLogin.svg')?>" class="background"></custom-svg>
	
	<div class="product">
        <img class="product-img" id="image" src="" alt="" onclick="triggerFileInput()">
		<input type="text" name="" id="title" placeholder="Titulo">
		<input type="number" name="" id="stock" placeholder="estoque">
		<input type="number" name="" id="price" placeholder="Preço">
    </div>
	<div class="functions">
		<div class="function-button" onclick="newProduct(<?php echo $product['id']?>)">
			<custom-svg src="<?php echo base_url('assets/icons/check.svg')?>"></custom-svg>
			<button>Criar</button>
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
		
    function newProduct(productId) {
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
		formData.append('stock', stock);
				formData.append('token', token);
        if (file) {
            formData.append('file', file);
        }else{
					formData.append('file', "<?php echo $product['image'];?>")
					formData.append("fileBase", true)
				}

        axios.post('http://localhost/mystore/product/create', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(response => {
			//window.location.href = `http://localhost/mystore?token=${token}`
        }).catch(error => {
            showAlert('Erro ao atualizar o produto', '#dc3545');
        });
    }

	</script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	<?php $this->load->view('components/alert'); ?>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/edit.css')?>">
	<script src="<?php echo base_url('assets/scripts/utils.js')?>"></script>
	<script src="<?php echo base_url('assets/scripts/mystore.js')?>"></script>
	<?php $this->load->view('components/Footer'); ?>
