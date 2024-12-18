const btnSendTimeRange = document.querySelector('#btnSendRangeTime');

btnSendTimeRange.addEventListener('click', function(e){
    e.preventDefault();

    const minValueDisplay = document.querySelector('#minValueDisplay').innerHTML;
    const maxValueDisplay = document.querySelector('#maxValueDisplay').innerHTML;

    console.log(minValueDisplay, maxValueDisplay);
    
    sendDataRangeTime(minValueDisplay, maxValueDisplay);
    
});

function sendDataRangeTime(minValueDisplay, maxValueDisplay)
{
    let url = 'extract.php';
    const data = {
        'minValueDisplay':minValueDisplay,
        'maxValueDisplay':(maxValueDisplay - minValueDisplay)
    }

    console.log(data);

     // Make the POST request
    fetch(url, {
        method: 'POST', // Specify the request method
        headers: {
            'Content-Type': 'application/json' // Set the content type to JSON
        },
        body: JSON.stringify(data) // Convert the data to a JSON string
    })
    .then(response => response.blob()) // Parse the JSON response
    .then(data => {
        // Faz algo com o Blob, como criar um URL de objeto 
        const urlObjeto = URL.createObjectURL(data);
        
        // Cria um elemento <a> dinamicamente 
        const link = document.createElement('a'); 
        link.href = urlObjeto; 
        link.download = 'arquivo'; 
        // Nome do arquivo para download 
        document.body.appendChild(link); 
        // Simula um clique no link 
        link.click(); 
        // Remove o link do documento 
        document.body.removeChild(link);
    })
    .catch((error) => {
        console.error('Error:', error); // Handle any errors
    });
}