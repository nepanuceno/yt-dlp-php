

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validador de URL</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            line-height: 1.6;
        }
        .container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        .form-group input:focus {
            outline: none;
            border-color: #4CAF50;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 0.75rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .error-message {
            color: #f44336;
            margin-top: 0.5rem;
            font-size: 0.9rem;
        }
        .success-message {
            color: #4CAF50;
            margin-top: 0.5rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <form id="urlForm" action="baixar.php" method="POST">
            <div class="form-group">
                <label for="urlInput">Digite uma URL válida:</label>
                <input 
                    type="text" 
                    id="urlInput" 
                    name="urlInput" 
                    placeholder="https://www.youtube.com/watch?v=UzZTKgPLUYg" 
                    required
                >
                <div id="errorMessage" class="error-message"></div>
            </div>
            <button type="submit" class="btn">Enviar URL</button>
        </form>
    </div>

    <script>
        var form = document.getElementById('urlForm');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            
            const urlInput = document.getElementById('urlInput');
            const errorMessageElement = document.getElementById('errorMessage');
            const urlMidea = urlInput.value.trim();
            const url = 'extract.php';

            const data = {
                urlInput: urlMidea,
            };

            // Limpa mensagens anteriores
            errorMessageElement.textContent = '';
            urlInput.classList.remove('error');
            
            // Regex para validação de URL
            const urlRegex = new RegExp(
                '^(https?:\\/\\/)?' + // protocolo
                '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domínio
                '((\\d{1,3}\\.){3}\\d{1,3}))' + // ou endereço IP
                '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // porta e caminho
                '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
                '(\\#[-a-z\\d_]*)?$', 'i' // fragmento
            );
            
            if (!url) {
                errorMessageElement.textContent = 'Por favor, insira uma URL.';
                urlInput.classList.add('error');
                return;
            }
            
            if (!urlRegex.test(url)) {
                errorMessageElement.textContent = 'URL inválida. Verifique o formato.';
                urlInput.classList.add('error');
                return;
            }

            // Make the POST request
            fetch(url, {
            method: 'POST', // Specify the request method
            // headers: {
            //     'Content-Type': 'application/json' // Set the content type to JSON
            // },
            body: JSON.stringify(data) // Convert the data to a JSON string
            })
            .then(response => response.json()) // Parse the JSON response
            .then(data => {
            console.log('Success:', data); // Handle the response data
            })
            .catch((error) => {
            console.error('Error:', error); // Handle any errors
            }); 
        });
    </script>
</body>
</html>