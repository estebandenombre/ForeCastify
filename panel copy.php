

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AnalyticaPro</title>
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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
</head>

<body>
  <nav class="navbar">
      <div class="logo">
      <h3>Analytica<span>Pro</span></h3>
      </div>
      <ul class="nav-links">
        <button><img src="/build/img/cable.png" alt="Data Base Connection"></button>
        <button><img src="/build/img/dba.png" alt="Data Base"></button>
        <button><img src="/build/img/table.png" alt="Tables"></button>
        <button><img src="/build/img/analysis.png" alt="Analysis"></button>
        <button><img src="/build/img/ma.png" alt="MA"></button>
      </ul>
  </nav>
  <div class="contenedor_panel_info">
    <div class="contenedor_info">
      <div class="left">Tablas
        <ul class="listado_tablas">
          <li>Población</li>
          <li>Ventas</li>
        </ul>
      </div>
      <div class="right">
        <table class="tabla ocultar">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Edad</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Juan</td>
              <td>30</td>
            </tr>
            <tr>
              <td>2</td>
              <td>María</td>
              <td>25</td>
            </tr>
            <tr>
              <td>3</td>
              <td>Pedro</td>
              <td>28</td>
            </tr>
            <tr>
              <td>4</td>
              <td>Luisa</td>
              <td>22</td>
            </tr>
          </tbody>
        </table>
      
    <table class="tabla">   
      <thead>
        <tr>
          <th>País</th>
          <th>Ventas (en millones USD)</th>
          <th>Unidades Vendidas</th>
          <th>Beneficio (en millones USD)</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Estados Unidos</td>
          <td>350</td>
          <td>500,000</td>
          <td>80</td>
        </tr>
        <tr>
          <td>China</td>
          <td>250</td>
          <td>400,000</td>
          <td>60</td>
        </tr>
        <tr>
          <td>Alemania</td>
          <td>120</td>
          <td>200,000</td>
          <td>30</td>
        </tr>
        <tr>
          <td>Brasil</td>
          <td>80</td>
          <td>150,000</td>
          <td>20</td>
        </tr>
      </tbody>
    </table>
        
        
      </div>
    </div>
    <div class="contendor_estadistica" id="movableWindow" onmousedown="startDragging(event)">
      <nav class="navbar">
        <div class="logo">
        <h3>Analytica<span>Pro</span></h3>
        </div>
        <ul class="nav-links">
          <li><img src="/build/img/table.png" alt="Tables"></li>
        </ul>
        <button class="minimize-button" onclick="minimizeWindow()"><img src="/build/img/minimizar.png" alt="mini"></button>
        <button class="maximize-button" onclick="maximizeWindow()"><img src="/build/img/max.png" alt="max"></button>
        <button class="close-button" onclick="closeWindow()"><img src="/build/img/close.png" alt="exit"></button>
      </nav>
      <canvas id="grafica"></canvas>
      
    </div>
  </div>

  
 
    
  
  


  


    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script type="text/javascript" src="vanilla-tilt.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://hammerjs.github.io/dist/hammer.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="build/js/bundle.min.js"></script>
    
    
    
  

    
</body>

</html>