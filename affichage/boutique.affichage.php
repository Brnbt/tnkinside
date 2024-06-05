<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .hero-section {
            background-image: url('img/banna.jpg');
            height: 40vh;
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            width: 95%;
            border-bottom: 1px solid #1d2026;
            border-radius: 5px;
            margin: 0 auto; 
            transition: transform 0.2s;

        }

        .hero-section:hover{
        transform: scale(1.03);
        }

        .overlay {
            background: rgba(0, 0, 0, 0.5);
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .content {
            color: white;
            text-align: center;
            padding: 0 1rem; /* Add some padding for better text wrapping on mobile */
        }

        .content h1 {
            font-size: 2rem; /* Adjust font size for better readability on mobile */
            margin-bottom: 1rem;
        }

        .content p {
            font-size: 1rem; /* Adjust font size for better readability on mobile */
            margin-bottom: 1.5rem; /* Adjust margin for better spacing on mobile */
        }

        .shop-now-button {
            background-color: #fff;
            color: #000;
            padding: 0.75rem 1.5rem; /* Adjust padding for better button size on mobile */
            text-decoration: none;
            font-size: 1rem;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .shop-now-button:hover {
            background-color: #ddd;
        }

        /* Add media query for further adjustments on smaller screens */
        @media (max-width: 600px) {
            .content h1 {
                font-size: 1.5rem; /* Further adjust font size for smaller screens */
            }

            .content p {
                font-size: 0.9rem; /* Further adjust font size for smaller screens */
            }

            .shop-now-button {
                padding: 0.5rem 1rem; /* Further adjust button padding for smaller screens */
            }
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div class="overlay">
            <div class="content">
                <h1>T-SHIRT TNK NOIR</h1>
                <p>19,99€</p>
                <a target="_blank" href="https://tnkboutique.company.site" class="shop-now-button">Disponible</a>
            </div>
        </div>
    </div>
</body>
</html>
