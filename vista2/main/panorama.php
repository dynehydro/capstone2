<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Vista - Interactive Panorama</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/panolens@0.11.0/build/panolens.min.js"></script>

    <!-- Include Font Awesome for the icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* General Styling */
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

        /* Go Back Icon */
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
    <!-- Header Section -->
    <header>
        <h1>Vista Museum</h1>
    </header>

    <!-- Go Back Icon -->
    <i class="fas fa-arrow-left go-back-icon" onclick="window.location.href='home.php';"></i>

    <!-- Panoramic View Section -->
    <section id="panorama-section">
        <div id="panorama-container"></div>
    </section>

    <!-- Footer Section -->
    <div class="footer">
        <p>&copy; 2024 Vista Museum. All rights reserved.</p>
    </div>

    <!-- JavaScript for Panoramic View -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 360-degree panorama image (local or external URL)
            const panoramaImage = 'img/panorama.jpg'; // Replace with your image file path
            
            // Check if Panolens.js is loaded
            if (typeof PANOLENS === 'undefined') {
                console.error("Panolens is not loaded correctly.");
                return;
            }

            const container = document.getElementById('panorama-container');
            const viewer = new PANOLENS.Viewer({
                container: container,
                autoRotate: false,  // Set to false for user control like Google Earth
                controlBar: true
            });

            // Create the panorama
            const panorama = new PANOLENS.ImagePanorama(panoramaImage);
            viewer.add(panorama);

            panorama.addEventListener('load', () => {
                console.log("Panorama loaded successfully.");
            });

            console.log("Panorama setup completed.");
        });
    </script>
</body>
</html>
