<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validador de URL</title>
    
    <!-- wRunner CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/range.css">
    <link rel="stylesheet" href="assets/css/loading.css">
    <link rel="stylesheet" href="assets/css/listaSuportados.css">
</head>
<body>
    <div class="container">
        <div class="loading-overlay">
            <div class="loading-spinner"></div>
        </div>

        <div class="content-wrapper">
            <!-- Coluna esquerda com sites suportados -->
            <div class="supported-sites">
            <h2>Sites Suportados</h2>
        
            <div class="sites-category">
                <h3>Plataformas de Vídeo</h3>
                <ul class="sites-list">
                    <li>
                        <span class="site-name">YouTube</span>
                        <span class="site-desc">Vídeos e playlists</span>
                    </li>
                    <li>
                        <span class="site-name">Vimeo</span>
                        <span class="site-desc">Vídeos e canais</span>
                    </li>
                    <li>
                        <span class="site-name">Dailymotion</span>
                        <span class="site-desc">Vídeos</span>
                    </li>
                </ul>
            </div>

        <div class="sites-category">
            <h3>Redes Sociais</h3>
            <ul class="sites-list">
                <li>
                    <span class="site-name">Instagram</span>
                </li>
                <li>
                    <span class="site-name">Facebook</span>
                </li>
                <li>
                    <span class="site-name">TikTok</span>
                </li>
            </ul>
        </div>

        <div class="sites-category">
            <h3>Áudio</h3>
            <ul class="sites-list">
                <li>
                    <span class="site-name">SoundCloud</span>
                </li>
                <li>
                    <span class="site-name">Spotify</span>
                </li>
                <li>
                    <span class="site-name">Bandcamp</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Coluna direita com o formulário -->
    <div class="form-container">
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
            <div class="range-selector-container">
                <div class="range-label" id="rangeLabel">Selecione o Intervalo para recortar o áudio</div>
                <div 
                    class="range-wrapper" 
                    id="rangeWrapper" 
                    data-min="0" 
                    data-max="0" 
                    data-start-min=""
                    data-start-max=""
                >
                    <div class="range-track" id="rangeTrack"></div>
                    <div class="range-handle" id="minHandle"></div>
                    <div class="range-handle" id="maxHandle"></div>
                </div>
                <div class="range-values">
                    <span id="minValueDisplay">0</span>
                    <span id="maxValueDisplay">1000</span>
                </div>
            </div>
            <div class="form-group">
                <label for="audioFormat">Selecione o formato do áudio:</label>
                <select id="audioFormat" name="audioFormat" required>
                    <option value="">Selecione um formato</option>
                    <option value="mp3">MP3 - Formato mais comum</option>
                    <option value="m4a">M4A - Boa qualidade</option>
                    <option value="wav">WAV - Sem compressão</option>
                    <option value="opus">OPUS - Alta qualidade</option>
                    <option value="vorbis">OGG - Formato livre</option>
                </select>
            </div>
            <div class="spinner-container">
                <div class="spinner"></div>
            </div>
            <button type="submit" class="btn" id="btnSendUrl">Enviar URL</button>
        </form>
    </div>
</div>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/range.js"></script>
    <script src="assets/js/sendTimeRange.js"></script>
</body>
</html>