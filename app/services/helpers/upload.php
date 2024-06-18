<?php
    function uploadPFP($conn, $userId){
        $diretorioPfP =  __DIR__ . '/../../assets/imagens/fotos/perfil/';
    
        if (isset($_FILES['fotoPerfilRegistro']) && $_FILES['fotoPerfilRegistro']['error'] == UPLOAD_ERR_OK) {
            $imgTemp = $_FILES['fotoPerfilRegistro']['tmp_name'];
            $imgNomeOriginal = $_FILES['fotoPerfilRegistro']['name'];
            $imgExtensao = strtolower(pathinfo($imgNomeOriginal, PATHINFO_EXTENSION));
        
            // Verifica se a extensão é permitida (.png ou .jpeg)
            if (in_array($imgExtensao, ['png', 'jpeg', 'jpg'])) {
                $imgNomeUnico = uniqid() . "." . $imgExtensao;
                $caminhoDestino = $diretorioPfP . $imgNomeUnico;
    
                // Move o arquivo para o diretório de destino
                if (move_uploaded_file($imgTemp, $caminhoDestino)) {
                    $imgNomeUnicoDb = mysqli_real_escape_string($conn, $imgNomeUnico);
                    
                    // Atualiza o link da foto de perfil no banco de dados do usuário
                    $queryUpdate = "UPDATE Usuario SET linkFotoPerfil = '$imgNomeUnicoDb' WHERE idUsuario = $userId";
    
                    if (!mysqli_query($conn, $queryUpdate)) {
                        echo "Erro ao atualizar o banco de dados: " . mysqli_error($conn) . "<br>";
                    }
                } else {
                    echo "Erro ao mover o arquivo para o diretório de destino.<br>";
                }
            } else {
                echo "Formato de imagem não suportado. Apenas .png e .jpeg são permitidos.<br>";
            }
        } else {
            echo "Nenhuma imagem enviada ou erro no upload.<br>";
        }
    }

    //alterar updatePFP pra que quando salvar a imagem salvar com um uniqId, não com o nome do arquivo enviado
    function updatePFP($conn, $userId) { 
        $diretorioPfP =  __DIR__ . '/../../assets/imagens/fotos/perfil/';
        $linkFotoPerfil = null; // Inicializa com null para manter o valor existente se não houver upload
    
        if (isset($_FILES['fotoPerfilEdit']) && $_FILES['fotoPerfilEdit']['error'] == UPLOAD_ERR_OK) {
            $imgTemp = $_FILES['fotoPerfilEdit']['tmp_name'];
            $imgNomeOriginal = $_FILES['fotoPerfilEdit']['name'];
            $imgExtensao = strtolower(pathinfo($imgNomeOriginal, PATHINFO_EXTENSION));
    
            // Verifica se a extensão é permitida (.png ou .jpeg)
            if (in_array($imgExtensao, ['png', 'jpeg', 'jpg'])) {
                // Obtém o nome atual da foto de perfil do banco de dados
                $query = "SELECT linkFotoPerfil FROM Usuario WHERE idUsuario = '$userId'";
                $result = mysqli_query($conn, $query);
                $userData = mysqli_fetch_assoc($result);
                $linkFotoPerfilAtual = $userData['linkFotoPerfil'];
    
                // Define o caminho completo para o arquivo atual e novo
                $caminhoArquivoAtual = $diretorioPfP . $linkFotoPerfilAtual;
                $caminhoDestino = $diretorioPfP . $imgNomeOriginal;
    
                // Remove o arquivo atual se existir
                if (!empty($linkFotoPerfilAtual) && file_exists($caminhoArquivoAtual)) {
                    unlink($caminhoArquivoAtual);
                }
    
                // Move o novo arquivo para o diretório de destino
                if (move_uploaded_file($imgTemp, $caminhoDestino)) {
                    $linkFotoPerfil = $imgNomeOriginal; // Define o link da nova foto para atualização no banco de dados
    
                    // Atualiza o link da foto de perfil no banco de dados
                    $queryUpdate = "UPDATE Usuario SET linkFotoPerfil = '$linkFotoPerfil' WHERE idUsuario = '$userId'";
                    if (!mysqli_query($conn, $queryUpdate)) {
                        echo "Erro ao atualizar o banco de dados: " . mysqli_error($conn) . "<br>";
                    }
                } else {
                    echo "Erro ao mover o arquivo para o diretório de destino.<br>";
                }
            } else {
                echo "Formato de imagem não suportado. Apenas .png e .jpeg são permitidos.<br>";
            }
        }
    
        return $linkFotoPerfil;
    }

    function uploadAnexo(){
        $diretorioAnexo = "/app/assets/imagens/fotos/anexos/";

        if (isset($_FILES['img']) && $_FILES['img']['error'] == UPLOAD_ERR_OK) {
            $imgTemp = $_FILES['img']['tmp_name'];
            $imgNomeOriginal = $_FILES['img']['name'];
            
            // Gera um nome único para a img usando uniqid() e preserva a extensão original
            $extensao = pathinfo($imgNomeOriginal, PATHINFO_EXTENSION);
            $imgNomeUnico = uniqid() . "." . $extensao;
            
            // Caminho completo para onde a img será movida
            $caminhoDestino = $diretorioAnexo . $imgNomeUnico;
            
            // Move a img para o diretório de destino
            if (move_uploaded_file($imgTemp, $caminhoDestino)) {
                echo "img enviada com sucesso! Nome único: " . $imgNomeUnico;
            } else {
                echo "Erro ao mover a img.";
            }
        } else {
            echo "Nenhuma img enviada ou erro no upload.";
        }
    }


    

