function openStore() {
	window.location.href = `/mystore?token=${localStorage.getItem("token")}`
}

function openBasket() {
	window.location.href = `/basket`
}

document.addEventListener("DOMContentLoaded", function() {
	const customSvgElements = document.querySelectorAll('custom-svg');

	customSvgElements.forEach(async (element) => {
			const src = element.getAttribute('src');
			if (src) {
					try {
							const response = await fetch(src);
							if (!response.ok) {
									throw new Error(`HTTP error! status: ${response.status}`);
							}
							const svgText = await response.text();
							const parser = new DOMParser();
							const svgDoc = parser.parseFromString(svgText, 'image/svg+xml');
							const svgElement = svgDoc.querySelector('svg');
							svgElement.classList = element.classList
							svgElement.id = element.id
							svgElement.onclick = element.onclick
							if (svgElement) {
									element.replaceWith(svgElement);
							} else {
									console.error(`No <svg> found in ${src}`);
							}
					} catch (error) {
							console.error(`Failed to fetch and parse SVG: ${error}`);
					}
			} else {
					console.error('No "src" attribute found on <custom-svg> element');
			}
	});
});
