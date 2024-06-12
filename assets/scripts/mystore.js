function deleteProduct(id) {
	const token = localStorage.getItem("token");
	if (parseInt(id) > 0){
		if (token.length > 0) {
			axios.delete("http://localhost:80/mystore/product/delete", {
				data: {
					token: token,
					id: id
				}
			}).then(r=> location.reload()).catch(error => {
				showAlert(error.response.data.text,  '#dc3545')
			});
		} else {
			showAlert('Seus dados não são validos faça o login novamente!', '#dc3545');
		}
	}else{
		showAlert('Não é possivel deletar esse item apenas ocultar', '#dc3545');
	}
}

function showProduct(id) {
	const token = localStorage.getItem("token");
	console.log(id)
	if (parseInt(id) > 0){
		if (token.length > 0) {
			axios.put("http://localhost:80/mystore/product/visibility", {
					token: token,
					id: id
			}).then(r=> location.reload()).catch(error => {
					showAlert('Infelizmente aconteceu um erro interno, aguarde novamente e posteriormente iremos resolver', '#dc3545');
			});
		} else {
			showAlert('Seus dados não são validos faça o login novamente!', '#dc3545');
		}
	}else{
		showAlert('Não é possivel ocultar esse item apenas ocultar', '#dc3545');
	}
}

function editProduct(id, storeId) {
	window.location.href=`/mystore/product/edit?id=${id}&store=${storeId}`
}

function createProduct() {
	window.location.href=`/mystore/product/new?token=${localStorage.getItem("token")}`	
}
