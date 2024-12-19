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
</head>
<body>
    <div class="container">
        <div class="loading-overlay">
            <div class="loading-spinner"></div>
        </div>

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
                    <option value="m4a">M4A - Boa qualidade e tamanho reduzido</option>
                    <option value="wav">WAV - Áudio sem compressão</option>
                    <option value="opus">OPUS - Alta qualidade em baixo bitrate</option>
                    <option value="vorbis">OGG/Vorbis - Formato livre</option>
                    <option value="flac">FLAC - Áudio sem perdas</option>
                    <option value="aac">AAC - Qualidade superior</option>
                </select>
            </div>

            <button type="submit" class="btn" id="btnSendUrl">Enviar URL</button>
        </form>
        <button type="button" class="btn" id="btnSendRangeTime">Download</button>
    </div>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/range.js"></script>
    <script src="assets/js/sendTimeRange.js"></script>
</body>
</html>