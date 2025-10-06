<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Lirik Lagu - Tante Culik Aku Dong</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: black;
      color: #fff;
      font-family: 'Courier New', monospace;
      overflow: hidden;
    }

    /* Background video */
    video {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: -1;
      filter: brightness(0.6);
    }

    /* Box lirik */
    .lyrics {
      font-size: 1.8em;
      text-align: center;
      white-space: pre-line;
      text-shadow: 0px 0px 10px #ff0, 0px 0px 20px #f0f;
      min-height: 100px;
      padding: 20px;
      background: rgba(0, 0, 0, 0.4);
      border-radius: 12px;
    }

    .fade-in {
      animation: fadeIn 1s forwards;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Logo musik */
    .logo {
      position: fixed;
      top: 20px;
      left: 20px;
      font-size: 2.5em;
      color: #ff0;
      text-shadow: 0px 0px 10px #f0f, 0px 0px 20px #0ff;
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% { transform: scale(1); opacity: 0.7; }
      50% { transform: scale(1.2); opacity: 1; }
      100% { transform: scale(1); opacity: 0.7; }
    }
  </style>
</head>
<body>
  <!-- Background video -->
  <video autoplay loop muted>
    <source src="bg.mp4" type="video/mp4">
  </video>

  <!-- Logo musik -->
  <div class="logo">
    <i class="fa-solid fa-music"></i>
  </div>

  <!-- Box lirik -->
  <div class="lyrics" id="lyricBox"></div>

  <script>
    const lyrics = [
      "Temanku semua pada jahat tante,\nAku lagi susah mereka gak ada,\nCoba kalo lagi jaya,\nAku dipuja pujanya tante.",
      "Sudah terbiasa terjadi tante,\nTeman datang ketika lagi butuh saja,\nCoba kalo lagi susah,\nMereka semua menghilang."
    ];

    let index = 0;
    const lyricBox = document.getElementById("lyricBox");

    function typeWriter(text, i, callback) {
      if (i < text.length) {
        lyricBox.innerHTML = text.substring(0, i + 1);
        setTimeout(() => typeWriter(text, i + 1, callback), 100);
      } else if (callback) {
        setTimeout(callback, 4000);
      }
    }

    function showLyrics() {
      if (index < lyrics.length) {
        lyricBox.classList.remove("fade-in");
        lyricBox.innerHTML = "";
        typeWriter(lyrics[index], 0, () => {
          index++;
          lyricBox.classList.add("fade-in");
          setTimeout(showLyrics, 1000);
        });
      }
    }

    // Start
    showLyrics();
  </script>
</body>
</html>
