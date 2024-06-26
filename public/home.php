<?php
    session_start();
    $verify = isset($_SESSION['active']) ? true : header("Location:/ConectaMaesProject/public/login.php");
    require_once "../app/services/crud/userFunctions.php"; 
    require_once "../app/services/crud/postFunctions.php";
    require_once '../app/services/helpers/dateChecker.php';
    $currentUserData = queryUserData($conn, "Usuario", $_SESSION['idUsuario']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/ConectaMaesProject/app/assets/styles/style.css">
    <link rel="icon" href="/ConectaMaesProject/app/assets/imagens/logos/final/Conecta_Mães_Logo_Icon.png">
    <title>ConectaMães - Home</title>
</head>

<body class="<?php echo $currentUserData['tema'];?>">

    <?php include_once ("../app/includes/headerHome.php");?>

    <main class="Ho-Main mainSystem">
        <section class="asideLeft">
            <img src="" class="backCells cellsLeft">
        </section>

        <section class="timeline">
            <form class="Ho-postSomething" method="post" enctype="multipart/form-data">
                <div class="Ho-postTop">
                    <a class="Ho-userProfileImage" href="/ConectaMaesProject/public/home/perfil.php">
                        <img src="<?php echo "/ConectaMaesProject/app/assets/imagens/fotos/perfil/".$currentUserData['linkFotoPerfil'];?>">
                    </a>

                    <div class="Ho-postText">
                        <textarea name="conteudoEnvio" id="postText" cols="65" rows="3" class="Ho-postTextContent" placeholder="Como você está se sentindo?" oninput="postCharLimiter()"></textarea>
                        <div class="Ho-characters">
                            <span class="Ho-charactersNumber">0</span>/<span class="Ho-maxCharacters">200</span>
                        </div>
                    </div>
                </div>

                <div class="Ho-postBottom">
                    <div class="Ho-extraInputs">
                        <div class="Ho-imageInput">
                            <input type="file" id="Ho-imageSelector" name="linkAnexoEnvio" accept="image/*" onchange="addPost()">
                            <label for="Ho-imageSelector">
                                <i class="bi bi-images Ho-iconLabel"></i>
                                <p> Imagem </p>
                            </label>
                        </div>
                    </div>

                    <div class="Ho-submitArea">
                        <div class="Ho-submitPost">
                            <button type="submit" value="submit" name="postPostagem" class="Ho-submitBtn">Postar</button>

                            <div class="Ho-postStyle">
                                <i class="bi bi-caret-down-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="Ho-postAttachments">
                    <span class="Ho-preview"></span>
                </div>
                <?php
                    if(isset($_POST['postPostagem'])){
                        sendPost($conn,"Postagem", $currentUserData['idUsuario']);
                    }
                ?>
            </form>


            <?php
                $count = 0;

                // Consulta inicial para obter todas as publicações usando a função fornecida
                $publicacoes = queryMultiplePosts($conn, "tipoPublicacao <> 'Auxilio'", "dataCriacaoPublicacao DESC");

                if (count($publicacoes) > 0) {
                    // Loop para mostrar publicações
                    foreach ($publicacoes as $dadosPublicacao) {
                        $postOwner = queryUserData($conn, "Usuario", $dadosPublicacao["idUsuario"]);

                        // Verificar se o link da foto de perfil está presente
                        $profileImage = !empty($postOwner['linkFotoPerfil']) ? $postOwner['linkFotoPerfil'] : 'caminho/padrao/para/imagem.png';

                        // Formatar a data da publicação utilizando a função do arquivo dateChecker.php
                        $mensagemData = postDateMessage($dadosPublicacao["dataCriacaoPublicacao"]);
                        ?>
                        <article class="Ho-post">
                            <div class="postOwnerImage">
                                <img src="<?php echo "/ConectaMaesProject/app/assets/imagens/fotos/perfil/".$postOwner['linkFotoPerfil'];?>">
                            </div>

                            <div class="postContent">
                                <div class="postTimelineTop">
                                    <div class="postUserNames">
                                        <p class="postOwnerName">
                                            <?php 
                                                $partesDoNomeCompletoOwner = explode(" ", $postOwner['nomeCompleto']);
                                                $firstNameOwner = $partesDoNomeCompletoOwner[0];
                                                $lastNameOwner = $partesDoNomeCompletoOwner[count($partesDoNomeCompletoOwner) - 1];
                                                
                                                // Concatena a primeira e a última palavra separadas por um espaço
                                                $firstAndLastNameOwner = $firstNameOwner . " " . $lastNameOwner;

                                                echo htmlspecialchars( $firstAndLastNameOwner); 
                                            ?>
                                        </p>
                                        <p class="postOwnerUser">
                                            <?php echo '@' . htmlspecialchars($postOwner['nomeDeUsuario']); ?>
                                        </p>
                                    </div>

                                    <div class="postInfo">
                                        <ul class="postDate"><li><?php echo htmlspecialchars($mensagemData); ?></li></ul>
                                        <div class="bi bi-three-dots postMoreButton"></div>
                                    </div>
                                </div>

                                <div class="postTitles">  
                                    <p class="postTitle"><?php echo htmlspecialchars($dadosPublicacao['titulo']); ?></p>
                                    <p class="textPost"><?php echo htmlspecialchars($dadosPublicacao['conteudo']); ?></p>
                                </div>

                                <div class="postTimelineBottom">
                                    <div class="postLikes">
                                        <i class="bi bi-heart-fill"></i>
                                        <p>50</p>
                                    </div>
                                    <div class="postComments">
                                        <i class="bi bi-chat-fill"></i>
                                        <p>10</p>
                                    </div>
                                </div>
                            </div>
                        </article>

                        <?php
                        $count++;

                        /* A cada 50 publicações, mostrar "sugestões"
                            if ($count % 50 == 0) {
                                echo "Sugestões<br><br>";
                            }
                        */
                    }

                    //criar html para 
                    echo "FIM...<br>";
                } else {
                    //criar html para 
                    echo "Nenhuma publicação encontrada<br>";
                }
            ?>


        </section>

        <section class="asideRight">
            <div class="searchBar">
                <i class="bi bi-search"></i>
                <input type="search" class="searchBarInput" placeholder="Pesquisar">
            </div>

            <div class="asideRightFooter">
                <a href="">Sobre o ConectaMães</a>
                <a href="">Suporte</a>
                <a href="">Termos de Privacidade</a>
                <a href="">CEFET-MG</a>
                <h4>© 2024 ConectaMães do CEFET-MG</h4>
            </div>
        </section>
    </main>

    <?php include_once ("../app/includes/modais.php");?>
    
    <script src="/ConectaMaesProject/app/assets/js/system.js"></script>
    <script>        
        toggleTheme();
    </script>
</body>
</html>
