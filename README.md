### Baixar midea
./yt-dlp -f "bestaudio" -o espanta.mp3 "https://www.youtube.com/watch?v=CZf-gKp0hVM"

### Recortar midea
ffmpeg -i espanta.mp3 -ss 00:00:05.800 -to 00:00:10 -acodec libmp3lame -q:a 2 output.mp3