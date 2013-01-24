<!DOCTYPE html>
<!--[if lt IE 7]>
    <html lang="en" class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7 ie6"></html>
    <![endif]--><!--[if IE 7]><html lang="en" class="no-js lt-ie10 lt-ie9 lt-ie8 ie7"></html>
    <![endif]--><!--[if IE 8]><html lang="en" class="no-js lt-ie10 lt-ie9 ie8"></html><![endif]-->
<!--[if IE 9]><html lang="en" class="no-js lt-ie10 ie9"></html><![endif]--><!--[if gt IE 9] <!-->
<html lang="es" class="no-js">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>
            Meu Sitio
        </title>
        <link rel="stylesheet" type="text/css" href="https://a248.e.akamai.net/secure.mlstatic.com/org-img/ch/ui/0.11.1/chico-mesh.min.css">
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <?php

        require_once "../mercadopago.php";
        require_once "../config.php";

        $mp = new MP ($client_id, $client_secret);

        $preference = array(
            "items" => array(
                array(
                    "title" => "iPad 2 32GB 3G + Wifi",
                    "quantity" => 1,
                    "currency_id" => "BRL",
                    "unit_price" => 500
                )
            )
        );

        $preference_result = $mp->create_preference($preference);
        ?>
        <div class="wrap">
            <header>
                <h1>Meu Sitio</h1>
            </header>
            <div class="ch-g1-2">
                <img src="ipad.png" style="width:80%;padding:1% 10%;">
            </div>
            <div class="ch-g1-2">
                <h2><?php echo $preference_result["response"]["items"][0]["title"]?></h2>
                <a id="btn_comprar" href="<?php echo $preference_result["response"]["init_point"]?>" class="blue-l-rn-aron" name="MP-Checkout">Comprar agora con MercadoPago</a>
            </div>
            <footer>
                <img src="mp.png" width="170" height="32" alt="MercadoPago">
            </footer>
        </div>
        <script type="text/javascript" src="http://mp-tools.mlstatic.com/buttons/render.js"></script>
    </body>
</html>