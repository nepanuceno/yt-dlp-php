const urlInput = document.querySelector('#urlInput');


function parseVideoInfo(text) {
    const lines = text.split('\n').filter(line => line && !line.includes('--') && !line.includes('youtube') && !line.includes('info'));
    let result = [];
    
    for(i=1; i<lines.length; i++) {
        const line = lines[i].split(/([^A-Za-z0-9-])/);
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
        option.setAttribute('data-extension', item.extension);
        option.textContent = item.text || item;
        select.appendChild(option);
    });
    
    // Add optional change event listener
    if (onChange) {
        select.addEventListener('change', (event) => onChange(event.target.value));
    }
    
    return select;
};

function getInfoMedia()
{
    const url = urlInput.value;
    const formData = new FormData();

    formData.append('urlInput', url);
 
    fetch('getMediaOptions.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        let optionsWithValues = [];
        const arrInfo = JSON.parse(data);

        arrInfo.forEach((info, key) => {
            if (key > 0) {
                optionsWithValues.push({
                    'value': info.id,
                    'extension': info.ext,
                    'text': `Formato: ${info.ext} - Resolução: ${ info.resolution } - Tamanho: ${info.filesize}`
                });            
            }
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
};
