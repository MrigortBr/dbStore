    <style>
        body {
            font-family: Arial, sans-serif;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        .bottom-alert {
            display: none;
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: #fff;
            padding: 15px 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            animation: slideIn 0.5s, slideOut 0.5s 2.5s;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(100%);
            }
            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }

        @keyframes slideOut {
            from {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
            to {
                opacity: 0;
                transform: translateX(-50%) translateY(100%);
            }
        }
    </style>

    <div id="bottomAlert" class="bottom-alert"></div>

    <script>
				let timeOut = null
        function showAlert(message, color) {
            const alert = document.getElementById('bottomAlert');
            alert.style.display = 'block';
            alert.style.backgroundColor = color;
            alert.textContent = message;

            // Hide the alert after 3 seconds
						clearTimeout(timeOut);
            timeOut = setTimeout(() => {
                alert.style.display = 'none';
            }, 3000);
        }
    </script>

