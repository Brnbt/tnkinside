<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits Ecwid</title>
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 10px;
        }
        .product {
            border: 1px solid #1d2026;
            background-color: #0d0f13;
            border-radius: 10px;
            overflow: hidden;
            width: calc(50% - 20px); /* 50% width for each product */
            max-width: 300px;
            text-align: center;
            text-decoration: none;
            color: inherit;
            margin-bottom: 20px;
            transition: transform 0.2s;
        }

        .product:hover{
        transform: scale(1.03);
        }

        .product img {
            width: 100%;
            height: auto;
        }
        .product h3 {
            margin: 10px 0;
            color: White;
        }
        .product p {
            margin: 0;
            padding-bottom: 10px;
        }
        .price {
            color: #daf37c;
            font-weight: bold;
            margin: 10px 0;
        }

        /* Media Query for mobile devices */
        @media screen and (max-width: 768px) {
            .product {
                width: calc(100% - 20px); /* Full width for each product */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a target="_blank" href="https://tnkboutique.company.site/products/T-SHIRT-TNK-NOIR-p664542001" class="product">
            <img src="https://d2j6dbq0eux0bg.cloudfront.net/images/69393524/4352496559.jpg" >
            <h3>T-SHIRT TNK NOIR</h3>
            <p class="price">15,99€</p>
        </a>
        <a target="_blank" href="https://tnkboutique.company.site/products/T-SHIRT-TNK-CLASSIQUE-p666043327" class="product">
            <img src="https://d2j6dbq0eux0bg.cloudfront.net/images/69393524/4355826635.jpg" >
            <h3>T-SHIRT TNK CLASSIQUE</h3>
            <p class="price">13,99€</p>
        </a>
        <a target="_blank" href="https://tnkboutique.company.site/products/SWEAT-SHIRT-TNK-NOIR-p666308972" class="product">
            <img src="https://d2j6dbq0eux0bg.cloudfront.net/images/69393524/4356304323.jpg">
            <h3>SWEAT-SHIRT TNK NOIR</h3>
            <p class="price">34,99€</p>
        </a>
    </div>
</body>
</html>
