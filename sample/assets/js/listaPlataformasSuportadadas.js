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
        if (!response.ok) { 
            throw new Error('Erro na rede ao tentar buscar o recurso');
        }
        return response.text();
    }) // Parse the JSON response
    .then(data => {
        const linhas = data.split('\n');
        const lista = document.getElementById('listaResposta'); 
        // Adiciona cada linha como um item da lista.
        linhas.forEach((linha, index) => { 
            const item = document.createElement('li');
            const span = document.createElement('span');
            span.textContent = `Linha ${index + 1}: ${linha}`;
            item.classList.add('site-name');
            item.textContent = `${index + 1}: ${linha}`;
            item.appendChild(span);
            lista.appendChild(item);
        });
    })
    .catch((error) => {
        console.error('Error:', error); // Handle any errors
    });
}
