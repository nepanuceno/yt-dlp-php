var form = document.getElementById('urlForm');

// Para mostrar o loading
function showLoading() {
    document.querySelector('.loading-overlay').classList.add('loading');
}

// Para esconder o loading
function hideLoading() {
    document.querySelector('.loading-overlay').classList.remove('loading');
}

form.addEventListener('submit', function(event) {
    event.preventDefault();
    
    const urlInput = document.getElementById('urlInput');
    const errorMessageElement = document.getElementById('errorMessage');
    const audioFormat = document.getElementById('audioFormat').value;
    const urlMidea = urlInput.value.trim();
    const url = 'extract.php';

    const data = {
        urlInput: urlMidea,
        audioFormat: audioFormat
    };

    // Limpa mensagens anteriores
    errorMessageElement.textContent = '';
    urlInput.classList.remove('error');
    showLoading();
    
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
        headers: {
            'Content-Type': 'application/json' // Set the content type to JSON
        },
        body: JSON.stringify(data) // Convert the data to a JSON string
    })
    .then(response => response.json()) // Parse the JSON response
    .then(data => {
        let maxTime = Math.floor(data.duracao);
        let valueMaxRange = document.querySelector('.range-wrapper');
        document.querySelector('.range-selector-container').style.display = 'block';
        
        valueMaxRange.setAttribute('data-max', maxTime);
        const rangeWrapper = document.getElementById('rangeWrapper');
        const rangeSelector = new DynamicRangeSelector(rangeWrapper);
        
        hideLoading();
        document.querySelector('#btnSendUrl').style.display = 'none';
        document.querySelector('#btnSendRangeTime').style.display = 'block';
        console.log('Success:', valueMaxRange, maxTime); // Handle the response data
    })
    .catch((error) => {
        console.error('Error:', error); // Handle any errors
    });
});