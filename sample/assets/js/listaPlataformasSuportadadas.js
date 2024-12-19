const consultaPlataformas = document.querySelector('#consultaPlataformas');

consultaPlataformas.addEventListener('click', function(e){
    e.preventDefault();

    consultar();
});


function consultar()
{
    const data = {}
    const url = 'plataformasSuportadas.php';

    fetch(url, {
        method: 'POST'
    })
    .then(response => {
        return response;
    }) // Parse the JSON response
    .then(data => {
        console.log(data);
    })
    .catch((error) => {
        console.error('Error:', error); // Handle any errors
    });
}
