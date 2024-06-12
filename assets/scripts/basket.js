function updateBasket() {
	const local = JSON.parse(localStorage.getItem("basket"))

	if (local == null){
		document.getElementById("basket").setAttribute("qnt", 0)
		return;
	}

	let size = 0
	local.forEach(element => {
		size += parseInt(element.quantity)
	});
	document.getElementById("basket").setAttribute("qnt", size)
}
