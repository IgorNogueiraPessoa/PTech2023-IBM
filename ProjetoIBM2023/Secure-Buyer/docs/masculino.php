<!DOCTYPE php>
<php lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Buyer</title>
    <!--Logo-->
    <link rel="apple-touch-icon" sizes="180x180" href="../conteudos/img/Icone/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../conteudos/img/Icone/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../conteudos/img/Icone/favicon-16x16.png">
    <link rel="manifest" href="../conteudos/img/Icone/site.webmanifest">
    <!--css-->
    <link rel="stylesheet" href="../conteudos/css/reset.css">
    <link rel="stylesheet" href="../conteudos/css/style.css">
    <link rel="stylesheet" href="../conteudos/css/novidades.css">
    
</head>
<body class="body">

    <!-- Inicio da página -->
    <div class="wrapper">
        <?php include 'navbar.php'; 

        include_once 'php-conexao-modelagem/produto.php';
        $prod = new Produto();
        include_once 'php-conexao-modelagem/link.php';
        $link = new Link();
        include_once 'php-conexao-modelagem/imagem_produto.php';
        $img = new Imagem();
        ?>

        <div class="novidades">
            <div class="title">
                <h1>Masculino</h1>
            </div>
            <div class="produtos">
                <div class="produtos-vetor">
                    <?php
                            
                    $existe1;
                    $prod->setsexo("male");
                    $produtos = $prod->filtro();
                    foreach($produtos as $row){
                        $existe1 = true;
                    } 
                    
                    if(isset($existe1) && $existe1){ ?>

                    <div class="produtos-container">
                    <?php
                            foreach($produtos as $row){
                                ?>

                                <div class="produtos-item">

                                    <div class="img">
                                        <a href="<?php  
                                            $link->setcod_produto($row['cod_produto']);
                                            $links = $link->consultar();
                                            foreach($links as $row2){
                                                $link_res = $row2['link_compra'];
                                                echo $link_res;
                                            } 
                                            ?>">
                                            <div class="vitrine">
                                            <img src="<?php
                                                $img->setcod_produto($row['cod_produto']);
                                                $imagens = $img->consultar2();
                                                foreach($imagens as $row2){
                                                    $imagem = $row2['imagem_produto'];
                                                    if(str_contains($imagem, 'vitrine'))
                                                    echo $imagem;
                                                }
                                            ?>" alt="" class="imgmodelo1">
                                            </div>
                                        </a>
                                    </div>
                                    <div class="name">
                                        <h3><?php echo $row['titulo_produto']; ?></h3>
                                    </div>
                                    <div class="preco">
                                        <p>R$ <?php echo number_format($row['preco_produto'],2,",","."); ?></p>
                                    </div>

                                </div>

                                <?php

                            }

                        ?>
                    </div>
                    <?php } ?>
                </div>
                
            </div>
        </div>        

        <?php include 'footer.php'; ?>
        
    </div>
    
</body>
<!--javascript-->
<script src="js/script.js"></script>
</php>