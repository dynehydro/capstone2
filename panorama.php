<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Vista - Interactive Panorama</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum/build/pannellum.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: white;
            padding: 20px 0;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 9999;
        }

        header h1 {
            font-size: 36px;
            margin: 0;
        }

        #panorama-container {
            width: 100%;
            height: 90vh;
            background-color: #000;
            margin-top: 0;
        }

        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        .footer p {
            margin: 0;
        }

      
        .go-back-icon {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 30px;
            color: white;
            cursor: pointer;
            z-index: 9999;
        }

        .go-back-icon:hover {
            color: #ddd;
        }
    </style>
</head>
<body>
        <h1>Vista Museum</h1>
    </header>

 
    <i class="fas fa-arrow-left go-back-icon" onclick="window.location.href='home.php';"></i>


    <section id="panorama-section">
        <div id="panorama-container"></div>
    </section>

    
    <div class="footer">
        <p>&copy; 2024 Vista Museum. All rights reserved.</p>
    </div>

  
    <script src="https://cdn.jsdelivr.net/npm/pannellum/build/pannellum.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            pannellum.viewer('panorama-container', {
                type: 'equirectangular',
                panorama: 'img/panorama.jpg', 
                autoLoad: true,
                compass: true,
                pitch: 10, 
                yaw: 180, 
                hfov: 110, 
                showFullscreenCtrl: true, 
                showControls: true 
            });

            console.log("Panorama setup completed.");
        });
    </script>
</body>
</html>
