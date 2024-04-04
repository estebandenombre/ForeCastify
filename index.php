<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AnalyticaPro</title>
  <link rel="icon" href="/build/img/data-analytics.png" type="image/png">
  <link rel="stylesheet" href="build/css/app.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans&family=Playfair+Display:ital,wght@1,900&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,900&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body>
  <div class="video-container">
    <video autoplay muted loop id="video-background">
      <source src="build/img/video.mp4" type="video/mp4">
    </video>
    <div class="contenedor_titulo animate__animated animate__fadeOut animate__delay-2s">
      <h1>Bio<span>Nets</span></h1>
      <h2>Data Analysis</h2>
    </div>
    <div class="login-form-container animate__animated animate__fadeIn animate__delay-2s">
      <form action="login.php" method="post" class="login-form">
        <h2>Login</h2>
        <input type="text" id="username" name="username" placeholder="User" required>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <p>Don't have an account? <a href="registro.php">Sign up</a></p>

      </form>
    </div>
  </div>







  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
  <script type="text/javascript" src="vanilla-tilt.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://hammerjs.github.io/dist/hammer.min.js"></script>
  <script src="build/js/bundle.min.js"></script>





</body>

</html>