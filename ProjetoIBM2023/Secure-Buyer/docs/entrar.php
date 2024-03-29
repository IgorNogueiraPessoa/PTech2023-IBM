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
    <link rel="stylesheet" href="../conteudos/css/entrar.css">

</head>
<body class="body">

    <!-- Inicio da página -->
    <div class="wrapper">

        <?php include 'navbar.php'; ?>

        <div class="content">
            <div class="box">
                <div class="title">
                    <h1>ENTRAR</h1>
                </div>
                <div class="formularioentrar">
                    <form name="formul" onsubmit="return validaform()" method="post" style="width: 100%;">
                        <div class="form-item">
                            <label title="Digite seu email">E-mail</label>
                            <input type="text" name="input_email" required>
                        </div>
                        <div class="form-item">
                            <label title="Digite uma mensagem para nós.">Senha</label>
                            <input type="password" name="senha" required>
                        </div>
                        <!--mensagem de erro-->
                        <div id="loginError" class="error-text"></div>

                        <div class="form-item">
                            <span class="esquecisenha"><a href="#">Esqueci a senha</a></span>
                        </div>
                        <div class="buttons">
                            <input type="submit" value="Enviar" name="btnenviar">
                            <input type="button" value="Voltar">
                        </div>
                        <div class="form-item">
                            <div class="cadastrar">
                                <span class="naotemconta">Ainda não possui cadastro? </span>
                                <span class="naotemconta"><a href="criar-conta.php"> Crie sua conta</a></span>
                            </div>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
       
        <?php include 'footer.php'; ?>
        
    </div>

      <?php
      if(password_verify("r", '$2y$10$nfCMOOhhXxWZhgX0uxD/9ux3wdfN1BvivOPI1AOWWicY9J1/AjjF6')){
            echo "igual";
      }

             extract($_POST, EXTR_OVERWRITE);
             if(isset($btnenviar))
              {
                  include_once 'php-conexao-modelagem/perfil.php';
                  $per=new Perfil();
                  $per->setemail(strtolower($input_email));
                  $perfis = $per->listar();
                  $verificado;
                  $administrador;

                  foreach($perfis as $row){

                    if(strtolower($row['email']) == $input_email && password_verify($senha, $row['senha']) == true){
                        $verificado = true;
                        $per->obterid();
                        $sqlresult = $per->obterid();
                       
                        if($row['adm'] == 1){   //verifica se é adm ou não se não leva para a pag normal se sim para a pag de adm :)///
                        $administrador = true;  
                        }else{
                            $administrador=false;
                        }

                    }else{
                        $verificado = false;
                    }
                    
                  }

                  if(isset($sqlresult)){
                        if(!empty($_SERVER['HTTP_CLIENTE_IP'])){
                            $ip_maquina = $_SERVER['HTTP_CLIENTE_IP'];
                        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                            $ip_maquina = $_SERVER['HTTP_X_FORWARDED_FOR'];
                        }else{
                            $ip_maquina = $_SERVER['REMOTE_ADDR'];
                        }

                        foreach ($sqlresult as $row) {
                            include_once 'php-conexao-modelagem/conexao.php';
                            $ip = new Conexao();
                            $ip->setendereco_ip($ip_maquina);
                            $ip->setcod_perfil($row['cod_perfil']);

                            $ips = $ip->listar();
                            foreach($ips as $row2){
                                if($ip_maquina = $row2['endereco_ip']){
                                    $ip->alterar();
                                if($administrador == true){
                                      echo "<script language='JavaScript'>window.location.replace('adm-pages/admpage.php');</script>";
                                }    
                                else{ echo "<script language='JavaScript'>window.location.replace('./index.php');</script>";}
                                }
                            }
                            $ip->salvar();
                            if($administrador == true){
                                echo "<script language='JavaScript'>window.location.replace('adm-pages/admpage.php');</script>";
                          }    
                          else{ echo "<script language='JavaScript'>window.location.replace('./index.php');</script>";}
                        }
                  }else{
                    echo "<script language='JavaScript'>
                         document.getElementById('loginError').textContent = 'Email ou senha incorretos';
                         document.formul.input_email.classList.add('error-border');
                         document.formul.senha.classList.add('error-border');
                        </script>";
              }
            }
      ?>
</body>
<!--javascript-->
<script src="../conteudos/js/script.js"></script>
<script src="../conteudos/js/entrar.js"></script>
</php>