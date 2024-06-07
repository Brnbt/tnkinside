<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits Ecwid</title>
    <style>
        .container {
            display: flex;
            justify-content: space-evenly;
            margin-top: 20px;
            overflow-x: auto;
            padding-bottom: 20px;
            align-items: center;
            flex-wrap: wrap;
            padding: 20px;
            max-width: 1200px;
            margin: auto;
        }

        .product {
            background-color: #0d0f13;
            border-radius: 10px;
            border: 1px solid #1d2026;
            padding: 15px;
            margin-bottom: 20px;
            overflow: hidden;
            text-align: center;
            flex: 1 1 30%;
            max-width: 30%;
            box-sizing: border-box;
            transition: transform 0.7s;
            text-decoration: none;
            color: inherit;
        }

        .product:hover {
            transform: scale(1.05);
        }

        .product img {
            border-radius: 10px;
            margin-bottom: 10px;
            display: block;
            width: 100%;
            height: auto;
            max-width: 100%;
        }

        .product h3 {
            font-size: 18px;
            color: #daf37c;
            margin-bottom: 5px;
        }

        .product p {
            font-size: 14px;
            color: #ffffff;
            margin-bottom: 5px;
            width: 100%;
        }

        .product .price {
            font-size: 14px;
            font-weight: bold;
            margin: 10px 0;
        }

        @media (max-width: 1200px) {
            .product {
                flex: 1 1 45%;
                max-width: 45%;
            }
        }

        @media (max-width: 768px) {
            .product {
                flex: 1 1 100%;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a target="_blank" href="https://tnkboutique.company.site/products/T-SHIRT-TNK-NOIR-p664542001" class="product">
            <img src="https://d2j6dbq0eux0bg.cloudfront.net/images/69393524/4352496559.jpg" alt="T-SHIRT TNK NOIR">
            <h3>T-SHIRT TNK NOIR</h3>
            <p class="price">15,99€</p>
        </a>
        <a target="_blank" href="https://tnkboutique.company.site/products/T-SHIRT-TNK-CLASSIQUE-p666043327" class="product">
            <img src="https://d2j6dbq0eux0bg.cloudfront.net/images/69393524/4355826635.jpg" alt="T-SHIRT TNK CLASSIQUE">
            <h3>T-SHIRT TNK CLASSIQUE</h3>
            <p class="price">13,99€</p>
        </a>
        <a target="_blank" href="https://tnkboutique.company.site/products/SWEAT-SHIRT-TNK-NOIR-p666308972" class="product">
            <img src="https://d2j6dbq0eux0bg.cloudfront.net/images/69393524/4356304323.jpg" alt="SWEAT-SHIRT TNK NOIR">
            <h3>SWEAT-SHIRT TNK NOIR</h3>
            <p class="price">34,99€</p>
        </a>
    </div>
</body>
</html>
