const urlInput = document.querySelector('#urlInput');

function parseVideoInfo(text) {
    const lines = text.split('\n').filter(line => line && !line.includes('--') && !line.includes('youtube') && !line.includes('info'));
    const parts = lines[0].split(/([^A-Za-z])/);
    const headers = parts.filter(part => /[A-Za-z]+/.test(part));
    const columns = headers.flat();
    let result = [];
    
    for(i=1; i<lines.length; i++) {
        const line = lines[i].split(/([^A-Za-z0-9])/);
        const infos = line.filter(info => {
            return /[A-Za-z0-9]+/.test(info) && !line.includes('images') && !line.length==0
        });
        if (infos.length != 0) {
            result.push(infos);
        }
    }

    return result;
}

/**
 * Creates a select element from an array of options
 * @param {Array} options - Array of objects containing value and text for options
 * @param {string} [selectId] - Optional ID for the select element
 * @param {Function} [onChange] - Optional callback for change event
 * @returns {HTMLSelectElement} The created select element
 */
const createSelect = (options, selectId = '', onChange = null) => {
    // Create select element
    const select = document.createElement('select');
    
    // Add optional ID
    if (selectId) {
        select.id = selectId;
    }
    
    // Add placeholder option
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = 'Selecione uma opção';
    defaultOption.disabled = true;
    defaultOption.selected = true;
    select.appendChild(defaultOption);
    
    // Add options from array
    options.forEach(item => {
        const option = document.createElement('option');
        option.value = item.value || item;
        option.textContent = item.text || item;
        select.appendChild(option);
    });
    
    // Add optional change event listener
    if (onChange) {
        select.addEventListener('change', (event) => onChange(event.target.value));
    }
    
    return select;
};


urlInput.addEventListener('focusout', (e) => {
    e.preventDefault();
    const url = urlInput.value;
    const ul = document.createElement('ul');

    const formData = new FormData();
    formData.append('urlInput', url);

    fetch('getVideo.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        const videoData = parseVideoInfo(data);
        let optionsWithValues = [];
        optionsWithValues.push({
            'value': 0,
            'text': 'Selecione um formato de vídeo'
        });
        
        videoData.forEach(info => {
            optionsWithValues.push({
                'value': info[0],
                'text': `Formato: ${info[1]} - Resolução: ${ info[2] } - Tamanho: ${info[5]}`
            });            
        });

        const select = createSelect(
            optionsWithValues,
            'videoFormat',
            (value) => console.log(`Selected format: ${value}`)
        );

        document.querySelector('#select-video').style.display = 'block';
        document.getElementById('select-video').appendChild(select);

    })
    .catch((error) => {
        console.error('Error:', error);
    });
});