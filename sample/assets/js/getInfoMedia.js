const urlInput = document.querySelector('#urlInput');

urlInput.addEventListener('focusout', (e) => {
    e.preventDefault();
    const url = urlInput.value;
    
    const formData = new FormData();
    formData.append('urlInput', url);

    fetch('getVideo.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
});