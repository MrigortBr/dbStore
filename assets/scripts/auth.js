function login() {
	var login = document.getElementById("login").value;
	var password = document.getElementById("password").value;

	if (login && password) {
			axios.post("http://localhost:80/login/new", {
					login: login,
					password: password,
			}).then(response => {
					localStorage.setItem("token", response.data.token)
					localStorage.setItem("isStore", response.data.isStore)
					window.location.href = "/"
			}).catch(error => {
				showAlert(error.response.data.text, '#dc3545');
			});
	} else {
			showAlert('Por favor, preencha todos os campos.', '#dc3545');
	}
}

function register() {
	var login = document.getElementById("login").value;
	var password = document.getElementById("password").value;
	var type = null;

	if (document.getElementById("store-input").checked){
		type = document.getElementById("store-input").value
	}else{
		type = document.getElementById("user-input").value
	}

	if (login != "" && password != "") {
			axios.post("http://localhost:80/register/new", {
					login: login,
					password: password,
					type: type
			}).then(response => {
					localStorage.setItem("token", response.data.token)
					localStorage.setItem("isStore", response.data.isStore)
					window.location.href = "/"
			}).catch(error => {
				showAlert(error.response.data.text, '#dc3545');
			});
	} else {
		showAlert('Por favor, preencha todos os campos.', '#dc3545');
	}
}

function logout() {
	localStorage.removeItem("token")
	localStorage.removeItem("isStore")
	localStorage.removeItem("basket")
	location.reload()
}

function goLogin() {
	window.location.href = "/login"
}
