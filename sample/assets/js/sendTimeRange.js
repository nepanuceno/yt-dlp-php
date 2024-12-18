const btnSendTimeRange = document.querySelector('#btnSendRangeTime');

btnSendTimeRange.addEventListener('click', function(e){
    e.preventDefault();

    const minValueDisplay = document.querySelector('#minValueDisplay').innerHTML;
    const maxValueDisplay = document.querySelector('#maxValueDisplay').innerHTML;
    const urlInput = document.getElementById('urlInput');

    const urlMidea = urlInput.value.trim();

    
    sendDataRangeTime(minValueDisplay, maxValueDisplay, urlMidea);
});

function getExtensionFromFilename(filename) 
{ 
    return filename.split('.').pop();
}

function getFileName(response)
{
    let filename = '';

    const contentDisposition = response.headers.get('Content-Disposition');

    if (contentDisposition && contentDisposition.includes('filename=')) {
        filename = contentDisposition.split('filename=')[1].split(';')[0].replace(/"/g, '');
    } else { 
        filename = response.url.split('/').pop();
    } 

    return filename;
}

function sendDataRangeTime(minValueDisplay, maxValueDisplay, urlMidea)
{
    let url = 'extract.php';
    let filename

    const data = {
        'minValueDisplay':minValueDisplay,
        'maxValueDisplay':(maxValueDisplay - minValueDisplay),
        'urlInput': urlMidea,
        'download' : true
    }

    // Make the POST request
    fetch(url, {
        method: 'POST', // Specify the request method
        headers: {
            'Content-Type': 'application/json' // Set the content type to JSON
        },
        body: JSON.stringify(data) // Convert the data to a JSON string
    })
    .then(response => {
        if (!response.ok) { 
            throw new Error('Erro na rede ao tentar buscar o recurso'); 
        }

        // Verifica se o tipo de conteúdo é um Blob 
        const contentType = response.headers.get('Content-Type'); 
        if (contentType && contentType.includes('application/octet-stream')) { 
            filename = getFileName(response);
            return response.blob(); 
        } else { 
            return response.json();
        }
    }) // Parse the JSON response
    .then(data => {

        if (data.status) {
            alert(data.message);
        } else {
            const urlObjeto = URL.createObjectURL(data);
            const link = document.createElement('a');
    
            link.href = urlObjeto;
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    })
    .catch((error) => {
        console.error('Error:', error); // Handle any errors
    });
}