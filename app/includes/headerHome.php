<header class="headerHome">
    <a href="/ConectaMaesProject/public/index.php"><img src="/ConectaMaesProject/app/assets/imagens/logos/final/Conecta_Mães_Logo_Black.png" class="A-headerLogo" alt="Logo do ConectaMães"></a>

    <div class="headerPageLinks">
        <a class="homePageLink pageLink active" id="homePageLink" href="/ConectaMaesProject/public/home.php">
            <img class="homePageIcon headerIcon" src="/ConectaMaesProject/app/assets/imagens/icons/home_off.png" alt="Ícone da página inicial">
            <p>Home</p>
            <span class="pageSelector"></span>
        </a>

        <a class="reportPageLink pageLink" id="reportPageLink" href="/ConectaMaesProject/public/home/relatos.php">
            <img class="reportPageIcon headerIcon" src="/ConectaMaesProject/app/assets/imagens/icons/reports_off.png" alt="Ícone da página de relatos">
            <p>Relatos</p>
            <span class="pageSelector"></span>
        </a>

        <a class="helpPageLink pageLink" id="helpPageLink" href="/ConectaMaesProject/public/home/pedidos.php">
            <img class="helpPageIcon headerIcon" src="/ConectaMaesProject/app/assets/imagens/icons/helps_off.png" alt="Ícone da página de pedidos">
            <p>Pedidos</p>
            <span class="pageSelector"></span>
        </a>
    </div>

    <div class="userContainer">
        <img class="notificationsModalIcon headerIcon" src="/ConectaMaesProject/app/assets/imagens/icons/notifications_off.png" alt="Ícone do modal de notificações">
        <div class="userInformations">
            <span class="userRealName">Nome do Usuário</span>
            <span class="userNickname">@usuario</span>
        </div>
        <div class="userAccount" onclick="openHeaderUserFunctions();">
            <div class="userProfileImage">
                <img src="/ConectaMaesProject/app/assets/imagens/fotos/Renan-Moura.png" alt="Foto de perfil do usuário">
            </div>    
            <i class="bi bi-chevron-down"></i>
        </div>
    </div>

    <div class="userFunctionsModal close">
        <a href="/ConectaMaesProject/public/home/perfil.php" class="userFunctions">
            <i class="bi bi-person-fill pageIcon"></i>
            <p>Perfil</p>
        </a>
        <a href="/ConectaMaesProject/public/admin.php" class="userFunctions">
            <i class="bi bi-key-fill pageIcon"></i>
            <p>Administração</p>
        </a>
        <a href="/ConectaMaesProject/public/home/config.php" class="userFunctions">
            <i class="bi bi-gear-fill pageIcon"></i>
            <p>Configurações</p>
        </a>
        <span></span>
        <a href="/ConectaMaesProject/app/services/helpers/logOut.php" class="userFunctions">
            <i class="bi bi-arrow-left-circle pageIcon"></i>
            <p>Sair</p>
        </a>
        <span></span>
    </div>
</header>

<script>
    function openHeaderUserFunctions() {
        const userFunctionsModal = document.querySelector('.userFunctionsModal');
        userFunctionsModal.classList.toggle('close');
    }

    function toggleHeaderActivePage() {
        const homePageLink = document.getElementById('homePageLink');
        const reportPageLink = document.getElementById('reportPageLink');
        const helpPageLink = document.getElementById('helpPageLink');
        const currentUrl = window.location.href;

        switch (true) {
            case currentUrl.includes('/ConectaMaesProject/public/home.php'):
                homePageLink.classList.add('active');
                reportPageLink.classList.remove('active');
                helpPageLink.classList.remove('active');
                break;
            case currentUrl.includes('/ConectaMaesProject/public/home/relatos.php'):
                homePageLink.classList.remove('active');
                reportPageLink.classList.add('active');
                helpPageLink.classList.remove('active');
                break;
            case currentUrl.includes('/ConectaMaesProject/public/home/pedidos.php'):
                homePageLink.classList.remove('active');
                reportPageLink.classList.remove('active');
                helpPageLink.classList.add('active');
                break;
            default:
                homePageLink.classList.remove('active');
                reportPageLink.classList.remove('active');
                helpPageLink.classList.remove('active');
                break;
        }
    }

    toggleHeaderActivePage();
</script>
