<?php
session_start();
include_once('php/conexao.php');

// Verificar se o formulário de login foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once('php/processa_login.php');
}
// Consulta ao banco de dados para recuperar as imagens do carrossel
$sql = "SELECT * FROM imagens_carrossel";
$result = mysqli_query($conexao, $sql);


// Verificar se a variável de sessão sucesso_depoimento está definida
if (isset($_SESSION['sucesso_depoimento']) && $_SESSION['sucesso_depoimento']) {
    // Exibir a mensagem de sucesso
    echo "<p class='text-success'>Depoimento enviado com sucesso!</p>";
    // Remover a variável de sessão para que a mensagem não seja exibida novamente após o próximo carregamento da página
    unset($_SESSION['sucesso_depoimento']);
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONFINTER | Consolidando sonhos</title>

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Raleway:300,400,500,600,700|Poppins:300,400,500,600,700" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="lib/nivo-slider/css/nivo-slider.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    
    <script src="assets/css/js/plugin.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Incluindo SweetAlert2 para as notificações -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Raleway:300,400,500,600,700|Poppins:300,400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Scripts Necessários -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@srexi/purecounterjs@1.1.5/dist/purecounter_vanilla.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function () {
            // Remover a máscara de data antes de enviar o formulário
            $('#form-requisicao').submit(function () {
                var dataNascimento = $('#data_nascimento').val();
                var dataLimpa = dataNascimento.replace(/\D/g, '');
                var dataFormatada = dataLimpa.replace(/(\d{2})(\d{2})(\d{4})/, '$3-$2-$1');
                $('#data_nascimento').val(dataFormatada);
            });

            // Validação do formulário
            $('#form-requisicao').submit(function (event) {
                if ($('#nome').val().trim() === '') {
                    alert('Por favor, preencha o campo nome.');
                    event.preventDefault();
                    return;
                }

                if ($('#telefone').val().trim() === '') {
                    alert('Por favor, preencha o campo telefone.');
                    event.preventDefault();
                    return;
                }

                if ($('#email').val().trim() === '') {
                    alert('Por favor, preencha o campo email.');
                    event.preventDefault();
                    return;
                }

                if ($('#horario_contato').val().trim() === '') {
                    alert('Por favor, preencha o campo horário de contato.');
                    event.preventDefault();
                    return;
                }

                if ($('input[name="categoria[]"]:checked').length === 0) {
                    alert('Por favor, selecione pelo menos uma categoria.');
                    event.preventDefault();
                    return;
                }
            });

            // Exibir o campo "Outros" quando a opção é selecionada
            $('#outros_check').change(function () {
                if ($(this).is(':checked')) {
                    $('#outros_info_div').show();
                } else {
                    $('#outros_info_div').hide();
                }
            });

            // Máscara para telefone
            $('#telefone').mask('(00) 00000-0000');
        });
    </script>
<style>
.accessibility-btn:focus {
    outline: 2px solid #000;
}
.section-title h2, .section-headline h2 {
    font-size: 2.5em;
    font-weight: bold;
}
.floating-buttons a {
    font-size: 2.5em; /* Increase the size of the icons */
}
#modalSimulacao {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}
#modalSimulacao h2 {
    font-size: 1.5em;
    margin-bottom: 20px;
}
#modalSimulacao form {
    display: flex;
    flex-direction: column;
}
#modalSimulacao form label {
    margin-bottom: 5px;
}
#modalSimulacao form input,
#modalSimulacao form select,
#modalSimulacao form button {
    margin-bottom: 15px;
    padding: 10px;
    font-size: 1em;
}
#modalSimulacao form button {
    background-color: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
}
#modalSimulacao form button:hover {
    background-color: #0056b3;
}
#modalSimulacao #resultado {
    margin-top: 20px;
}
#modalSimulacao .close-btn {
    background-color: #dc3545;
    color: #fff;
    border: none;
    cursor: pointer;
    padding: 10px;
    font-size: 1em;
}
#modalSimulacao .close-btn:hover {
    background-color: #c82333;
}
.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
}
.icon-help {
    font-size: 80px; /* Increase the size of the icons */
}
.form-group.col-md-4 {
    display: inline-block;
    width: 48%;
}
.form-group.col-md-2 {
    display: inline-block;
    width: 23%;
}
.carousel-item {
    height: 100vh;
    min-height: 300px;
    background: no-repeat center center scroll;
    background-size: cover;
}
.carousel-container {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
}
.carousel-container .container {
    text-align: center;
    color: #fff;
}
.carousel-container .container p {
    font-size: 2em;
    font-weight: bold;
}
</style>
</head>
<body>
<!-- Inicio Menu Flutuante E-mail e Redes Sociais -->
<div class="floating-buttons">
    <a href="https://www.instagram.com/confintersp?igsh=a3NuaGJrem5pYzZu" target="_blank" class="instagram" title="Instagram"><i class="bi bi-instagram"></i></a>
    <a href="https://api.whatsapp.com/send?phone=11948016298" target="_blank" class="whatsapp"><i class="bi bi-whatsapp" title="WhatsApp"></i></a>
    <a href="mailto:contato@confinter.com.br" class="email"><i class="bi bi-envelope-at" title="E-mail"></i></i></a>
</div>
<!-- Fim do Menu Flutuante E-mail e Redes Sociais -->

<!-- ======= Inicio Header ======= -->
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="#sobre">Sobre</a></li>
                <li><a class="nav-link scrollto" href="#valores">Nossos Valores</a></li>
                <li><a class="nav-link scrollto" href="#servicos">Serviços</a></li>
                <li><a class="nav-link scrollto" href="#requi">Requisições</a></li>
                <li><a class="nav-link scrollto" href="#faq">Dúvidas</a></li>
                <li><a class="nav-link scrollto" href="#depoimentos">Depoimentos</a></li>
                <li><a class="nav-link scrollto" href="#chegar">Como Chegar</a></li>
                <li><a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->
    </div>
</header><!-- Fim do Header -->

 <!-- Modal Login -->
 <div id="loginModal" class="modal fade modal-login" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
              <!-- Logo da Empresa -->
              <div class="col-md-6 d-none d-md-block text-center">
                <img src="assets/img/logo01-black.png" class="img-fluid login-logo" id="logo-img" alt="Logo da Empresa">
              </div>
              <div class="col-12 col-md-6">
                <form action="php/processa_login.php" method="POST">
                  <!-- Campo de Usuário -->
                  <div class="form-outline mb-4">
                    <input type="text" class="form-control form-control-lg" id="user" name="usuario" placeholder="Usuário" required />
                    <label class="form-label" for="user">Usuário</label>
                  </div>
  
                  <!-- Campo de Senha -->
                  <div class="form-outline mb-3">
                    <input type="password" class="form-control form-control-lg" id="senha" name="senha" placeholder="Senha" required />
                    <label class="form-label" for="senha">Senha</label>
                  </div>
  
                  <!-- Lembrar e Esqueci a Senha -->
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                      <input class="form-check-input me-2" type="checkbox" value="" />
                      <label class="form-check-label">Lembrar</label>
                    </div>
                    <a href="#!" class="text-body">Esqueceu a senha?</a>
                  </div>
  
                  <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- VLibras - Intérprete de Libras -->
<div vw class="enabled">
    <div vw-access-button class="active"></div>
    <div vw-plugin-wrapper>
        <div class="vw-plugin-top-wrapper"></div>
    </div>
</div>

<!-- Script VLibras -->
<script>
    (function loadVLibras() {
        const script = document.createElement('script');
        script.src = 'https://vlibras.gov.br/app/vlibras-plugin.js';
        script.defer = true;
        script.onload = function () {
            console.log("VLibras carregado com sucesso!");
            new VLibras.Widget();
        };
        document.body.appendChild(script);
    })();
</script>
<!-- Seção de Slides -->
<section id="hero">
    <div class="hero-container">
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000" role="region" aria-label="Slider de Herói">
            <ol id="hero-carousel-indicators" class="carousel-indicators">
                <?php
                $active = true;
                $index = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $activeClass = $active ? 'class="active"' : '';
                    echo "<li data-bs-target='#heroCarousel' data-bs-slide-to='$index' $activeClass></li>";
                    $active = false;
                    $index++;
                }
                ?>
            </ol>
            <div class="carousel-inner" role="listbox">
                <?php
                mysqli_data_seek($result, 0); // Reset result pointer
                $active = true;
                while ($row = mysqli_fetch_assoc($result)) {
                    $image = $row['nome_arquivo'];
                    $caption = $row['legenda'];
                    $activeClass = $active ? 'active' : '';
                    echo "<div class='carousel-item $activeClass' style='background-image: url(assets/img/slider/$image)'>
                            <div class='carousel-container'>
                                <div class='container'>
                                    <p class='animate__animated animate__fadeInDown'>$caption</p>
                                </div>
                            </div>
                          </div>";
                    $active = false;
                }
                ?>
            </div>
            <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev" aria-label="Slide anterior">
                <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next" aria-label="Próximo slide">
                <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
            </a>
        </div>
    </div>
</section>

<main id="main">
    <!-- Seção Sobre -->
    <section id="sobre" class="about">
        <div class="container" data-aos="fade-up">
            <div class="section-headline text-center">
                <h2>Sobre Nós</h2>
                <div class="row">
                    <div class="col-md-12">
                        <div class="darkmode-white-text">
                            <p>
                                A <strong>CONFINTER</strong> é uma empresa especializada em Consultoria Financeira e Correspondente Bancário que atua na intermediação de negócios, presencialmente e online.
                            </p>
                            <p>
                                Seguimos as diretrizes do Banco Central do Brasil, nos termos da Resolução no 3.954/2011. Nosso procedimento de avaliação de crédito é submetido à política de crédito da Instituição Financeira escolhida pelo usuário e está submetida a aprovação.
                            </p>
                            <p>
                                Antes da contratação de qualquer serviço através de nossos parceiros e consultores, você receberá todas as condições e informações relativas à linha de crédito a ser contratada, de forma completa e transparente.
                            </p>
                        </div>
                    </div>
                </div>
</div>
        </div>
    </section>
    <!-- Fim da Seção Sobre -->

    <!-- Seção Missão, Visão e Valores -->
    <section id="valores" class="services section-bg">
        <div class="container" data-aos="fade-up">
            <div class="section-headline text-center">
                <h2>Nossos Valores</h2>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                    <div class="icon-box iconbox-blue">
                        <div class="icon">
                            <img src="assets/img/missao.png" alt="Missão da empresa">
                        </div>
                        <h4>Missão</h4>
                        <p>Facilitar o acesso a crédito consignado e fornecer consultoria financeira personalizada, visando o equilíbrio e bem-estar financeiro dos nossos clientes.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
                    <div class="icon-box iconbox-orange">
                        <div class="icon">
                            <img src="assets/img/visao.png" alt="Visão da empresa">
                        </div>
                        <h4>Visão</h4>
                        <p>Ser reconhecida como a empresa líder em intermediação de negócios, destacando-se pela excelência no atendimento ao cliente e pela construção de relacionamentos sólidos e duradouros.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0" data-aos="zoom-in" data-aos-delay="300">
                    <div class="icon-box iconbox-pink">
                        <div class="icon">
                            <img src="assets/img/valores.png" alt="Valores da empresa">
                        </div>
                        <h4>Valores</h4>
                        <p>
                            <strong>Transparência:</strong> Agimos com total transparência em nossas operações e informações, promovendo a confiança mútua.<br>
                            <strong>Comprometimento Personalizado:</strong> Nos dedicamos a entender as necessidades individuais de cada cliente, oferecendo soluções financeiras.<br>
                            <strong>Respeito e Empatia:</strong> Valorizamos a diversidade e tratamos todos com respeito e empatia, construindo relações duradouras.<br>
                            <strong>Sustentabilidade Financeira:</strong> Comprometemo-nos a promover práticas financeiras sustentáveis, visando o bem-estar financeiro a longo prazo de nossos clientes.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fim da Seção Missão, Visão e Valores -->

    <!-- Seção de Serviços -->
    <section id="servicos" class="services-area area-padding">
        <div class="container faq" data-aos="fade-up">
            <div class="section-title text-center">
                <h2>Nossos Serviços</h2>
            </div>
            <div class="row text-center">
                <div class="col-md-3 col-sm-6">
                    <div class="single-services">
                        <div class="service-box">
                            <i class="bi bi-briefcase icon-help" aria-hidden="true"></i>
                            <h4><a href="#">Consultoria</a></h4>
                            <p>Nossos especialistas ajudarão desde a abertura de contas até delinear a melhor estratégia para os diferentes mercados financeiros.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="single-services">
                        <div class="service-box">
                            <i class="bi bi-person-vcard-fill icon-help" aria-hidden="true"></i>
                            <h4><a href="#">Intermediação de Negócios</a></h4>
                            <p>Atuando como correspondentes bancários com mais de 15 anos de experiência. Parceria com os principais bancos e financeiras de crédito consignado no país.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="single-services">
                        <div class="service-box">
                            <i class="bi bi-credit-card icon-help" aria-hidden="true"></i>
                            <h4><a href="#">Cartões de Crédito Consignado</a></h4>
                            <p>Conveniado com os principais bancos, ao todo são mais de 250 convênios ativos em Governos, Prefeituras e para aposentados e pensionistas do INSS.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="single-services">
                        <div class="service-box">
                            <i class="bi bi-cash-coin icon-help" aria-hidden="true"></i>
                            <h4><a href="#">Saque Aniversário FGTS</a></h4>
                            <p>No saque-aniversário você pode sacar o valor que possui em FGTS com taxas a partir de 1.29% a.m..</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fim da Seção de Serviços -->

     <!-- Seção Requisição de Análise de Crédito -->
     <section id="requi" class="requisicoes section-bg">
        <div class="container">
            <div class="section-title">
                <h2>Requisição de Análise de Crédito</h2>
            </div>
            <div class="formulario-modal" id="requisicaoForm">
                <form action="php/process.php" method="POST" id="form-requisicao">
                    <div class="form-group">
                        <label for="nome">Nome completo:</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="data_nascimento">Data de Nascimento:</label>
                            <input type="text" class="form-control" id="data_nascimento" name="data_nascimento" placeholder="Insira sua data de nascimento" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="telefone">Telefone:</label>
                            <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="(00) 00000-0000" required maxlength="15">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="email">E-mail:</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="seu@email.com" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="horario_contato">Horário para Contato:</label>
                            <input type="time" class="form-control" id="horario_contato" name="horario_contato" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tipo">Tipo:</label>
                        <textarea class="form-control" id="tipo" name="tipo" rows="3" maxlength="250"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Categoria:</label>
                        <div class="form-row">
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="aposentado" name="categoria[]" value="Aposentado">
                                    <label class="form-check-label" for="aposentado">Aposentado</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pensionista" name="categoria[]" value="Pensionista">
                                    <label class="form-check-label" for="pensionista">Pensionista</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="servidor_publico" name="categoria[]" value="Servidor Público">
                                    <label class="form-check-label" for="servidor_publico">Servidor Público</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="outros_check" name="categoria[]" value="Outros">
                                    <label class="form-check-label" for="outros_check">Outros</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="outros_info_div" style="display: none;">
                        <label for="outros_info">Insira outras informações se necessário:</label>
                        <input type="text" class="form-control" id="outros_info" name="outros_info" maxlength="200">
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Enviar Requisição</button>
                    </div>
                </form>
                <script>
                    $(document).ready(function () {
                        // Aplicar máscara para data de nascimento
                        $('#data_nascimento').mask('00/00/0000');

                        $('#form-requisicao').submit(function (event) {
                            event.preventDefault(); // Impede o envio padrão do formulário
                            let isValid = true;
                            let missingFields = [];

                            if ($('#nome').val().trim() === '') {
                                missingFields.push('Nome');
                                isValid = false;
                            }
                            if ($('#telefone').val().trim() === '') {
                                missingFields.push('Telefone');
                                isValid = false;
                            }
                            if ($('#email').val().trim() === '') {
                                missingFields.push('E-mail');
                                isValid = false;
                            }

                            if (!isValid) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro',
                                    text: `Os seguintes campos estão faltando: ${missingFields.join(', ')}`,
                                    timer: 3000,
                                    showConfirmButton: false
                                });
                            } else {
                                // Formatar a data de nascimento antes de enviar o formulário
                                let dataNascimento = $('#data_nascimento').val();
                                let dataFormatada = dataNascimento.replace(/(\d{2})[-\/](\d{2})[-\/](\d{4})/, '$3-$2-$1');
                                $('#data_nascimento').val(dataFormatada);

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Requisição Enviada',
                                    text: 'Sua requisição foi enviada com sucesso!',
                                    timer: 3000,
                                    showConfirmButton: false
                                }).then(function() {
                                    // Aqui você pode submeter o formulário após o alerta
                                    $('#form-requisicao')[0].submit();
                                });
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </section>
    <!-- Fim da Seção Requisição de Análise de Crédito -->
   
   <!-- Inicio da Seção Simulação -->
    <section id="analise-credito" class="section-bg">
        <div class="container" data-aos="fade-up">
            <div class="section-title text-center">
                <h2>Análise de Crédito</h2>
                <p>Simule seu empréstimo consignado e veja as melhores opções para você.</p>
                <button class="btn btn-primary" onclick="abrirModal()">Simular Empréstimo</button>
            </div>
        </div>
    </section>
    
    <div class="modal-overlay" id="modalOverlay"></div>
    <div id="modalSimulacao">
        <h2>Simulador de Empréstimo</h2>
        <form id="formSimulacao">
            <label for="valor">Valor desejado:</label>
            <input type="number" id="valor" required>
            <label for="parcelas">Parcelas:</label>
            <select id="parcelas">
                <option value="12">12x</option>
                <option value="24">24x</option>
                <option value="36">36x</option>
            </select>
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" required>
            <button type="button" onclick="simularEmprestimo()">Simular</button>
        </form>
        <div id="resultado"></div>
        <button class="close-btn" onclick="fecharModal()">Fechar</button>
    </div>

    <script>
        function abrirModal() {
            document.getElementById("modalSimulacao").style.display = "block";
            document.getElementById("modalOverlay").style.display = "block";
        }

        function fecharModal() {
            document.getElementById("modalSimulacao").style.display = "none";
            document.getElementById("modalOverlay").style.display = "none";
        }

        function simularEmprestimo() {
            let valor = document.getElementById("valor").value;
            let parcelas = document.getElementById("parcelas").value;
            let cpf = document.getElementById("cpf").value;

            if (!valor || !parcelas || !cpf) {
                alert('Por favor, preencha todos os campos.');
                return;
            }

            let chaveAES = "chaveSegura1234567890123456";
            let cpfCriptografado = CryptoJS.AES.encrypt(cpf, chaveAES).toString();

            fetch('api/simulacao.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ valor, parcelas, cpf: cpfCriptografado })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById("resultado").innerHTML = `<p>Parcela mensal: R$ ${data.parcela}</p>`;
            })
            .catch(error => console.error('Erro:', error));
        }
    </script>
    <?php
// API Simulação
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    $valor = $input['valor'];
    $parcelas = $input['parcelas'];
    $cpfCriptografado = $input['cpf'];

    $chaveAES = "chaveSegura1234567890123456";
    $cpf = openssl_decrypt(base64_decode($cpfCriptografado), 'aes-256-cbc', $chaveAES, 0, substr($chaveAES, 0, 16));

    $api_url = "https://api.serasaexperian.com/simulacao";
    $response = file_get_contents($api_url . "?valor=$valor&parcelas=$parcelas&cpf=$cpf");
    echo $response;
}
?>

    <!-- Seção Dúvidas Frequentes -->
    <section id="faq" class="faq section-bg">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Dúvidas Frequentes</h2>
            </div>
            <div class="faq-list" style="font-size: 14px;">
                <ul>
                    <li data-aos="fade-up">
                        <i class="bx bx-help-circle icon-help"></i>
                        <a data-bs-toggle="collapse" class="collapse show" data-bs-target="#check1" style="width: 100%;">
                            Em que área a empresa opera?
                            <i class="bx bx-chevron-down icon-show"></i>
                            <i class="bx bx-chevron-up icon-close"></i>
                        </a>
                        <div id="check1" class="collapse show" data-bs-parent=".faq-list">
                            <p>Operamos como prestadores de serviços, há mais de 15 anos nas áreas de Crédito Consignado, Intermediação de Negócios, Consultoria Financeira e Cobranças.</p>
                        </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="100">
                        <i class="bx bx-help-circle icon-help"></i>
                        <a data-bs-toggle="collapse" data-bs-target="#check2" class="collapsed" style="width: 100%;">
                            Porquê escolher a CONFINTER?
                            <i class="bx bx-chevron-down icon-show"></i>
                            <i class="bx bx-chevron-up icon-close"></i>
                        </a>
                        <div id="check2" class="collapse" data-bs-parent=".faq-list">
                            <p>Você terá um atendimento rápido e prático em todo território nacional. Nossos profissionais são dinâmicos e altamente qualificados, oferecendo suporte eficiente, soluções práticas com foco em resultados.</p>
                        </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="200">
                        <i class="bx bx-help-circle icon-help"></i>
                        <a data-bs-toggle="collapse" data-bs-target="#check3" class="collapsed" style="width: 100%;">
                            O que é empréstimo consignado?
                            <i class="bx bx-chevron-down icon-show"></i>
                            <i class="bx bx-chevron-up icon-close"></i>
                        </a>
                        <div id="check3" class="collapse" data-bs-parent=".faq-list">
                            <p>O consignado é uma modalidade de crédito em que os pagamentos são descontados automaticamente do salário do servidor ou do benefício do INSS do tomador. Por conta dessa dinâmica, a taxa de inadimplência é baixa e o risco para os bancos muito pequeno, e é isso que faz com que o crédito consignado tenha uma das menores taxas do mercado.</p>
                        </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="300">
                        <i class="bx bx-help-circle icon-help"></i>
                        <a data-bs-toggle="collapse" data-bs-target="#check4" class="collapsed" style="width: 100%;">
                            Quem pode solicitar crédito consignado?
                            <i class="bx bx-chevron-down icon-show"></i>
                            <i class="bx bx-chevron-up icon-close"></i>
                        </a>
                        <div id="check4" class="collapse" data-bs-parent=".faq-list">
                            <p>Aqui na CONFINTER, o crédito consignado está disponível para alguns públicos, entre eles: Beneficiário do INSS (BPC/LOAS), Servidores Públicos Municipais, Estaduais e Federais do SIAPE, Militares das Forças Armadas e Aposentados e Pensionistas do INSS.</p>
                        </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="400">
                        <i class="bx bx-help-circle icon-help"></i>
                        <a data-bs-toggle="collapse" data-bs-target="#check5" class="collapsed" style="width: 100%;">
                            Quais são as taxas de juros?
                            <i class="bx bx-chevron-down icon-show"></i>
                            <i class="bx bx-chevron-up icon-close"></i>
                        </a>
                        <div id="check5" class="collapse" data-bs-parent=".faq-list">
                            <p>Oferecemos Empréstimo Consignado com taxas personalizadas que podem variar dependendo do tipo de convênio, operação, prazo, valor solicitado e perfil do cliente. As taxas de juros máximas são de 1.72% ao mês no empréstimo consignado para aposentado e/ou pensionista do INSS e Beneficiário do INSS (BPC/LOAS); e para Servidores Públicos à partir de 1.93% ao mês.</p>
                        </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="500">
                        <i class="bx bx-help-circle icon-help"></i>
                        <a data-bs-toggle="collapse" data-bs-target="#check6" class="collapsed" style="width: 100%;">
                            Como é feita a análise de crédito?
                            <i class="bx bx-chevron-down icon-show"></i>
                            <i class="bx bx-chevron-up icon-close"></i>
                        </a>
                        <div id="check6" class="collapse" data-bs-parent=".faq-list">
                            <p>Prezando sempre pela saúde financeira, optamos pelas melhores estratégias de acordo com a gama de bancos parceiros e financeiras, buscando o melhor custo-benefício para nossos clientes.</p>
                        </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="600">
                        <i class="bx bx-help-circle icon-help"></i>
                        <a data-bs-toggle="collapse" data-bs-target="#check7" class="collapsed" style="width: 100%;">
                            Como a CONFINTER pode me ajudar hoje?
                            <i class="bx bx-chevron-down icon-show"></i>
                            <i class="bx bx-chevron-up icon-close"></i>
                        </a>
                        <div id="check7" class="collapse" data-bs-parent=".faq-list">
                            <p>A CONFINTER atua também como Correspondente Digital autorizado pelo Banco Central e pode intermediar operações de crédito ajudando você, consumidor, a escolher as melhores opções de crédito disponíveis para seu perfil. Conosco, você não precisa sair de casa ou do trabalho perdendo tempo indo até o banco, enfrentando filas e burocracia! Nós fazemos todo o processo e acompanhamos o seu caso, digitalmente até a liberação do crédito em conta.</p>
                        </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="700">
                        <i class="bx bx-help-circle icon-help"></i>
                        <a data-bs-toggle="collapse" data-bs-target="#check8" class="collapsed" style="width: 100%;">
                            Como faço para assinar o meu contrato?
                            <i class="bx bx-chevron-down icon-show"></i>
                            <i class="bx bx-chevron-up icon-close"></i>
                        </a>
                        <div id="check8" class="collapse" data-bs-parent=".faq-list">
                            <p>A assinatura é de forma digital, podendo ser enviado um link por WhatsApp ou SMS, enviado para o seu número de celular informado no formulário. A maioria dos bancos exigem: o envio do documento de identidade; o aceite (SIM) na CCB: essa etapa o cliente verifica se todas as condições contratadas e precisa dar o aceite para seguir para a assinatura; tirar uma selfie (foto de si mesmo) que é a etapa de assinatura digital do cliente. Entretanto, essa modalidade pode variar de acordo com as exigências de cada Instituição Financeira.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Fim da Seção Dúvidas Frequentes -->

    <!-- ======= Seção Enviar Depoimentos ======= -->
    <section id="envdepoimentos" class="testimonials">
        <div class="container-fluid container-center">
            <div class="row justify-content-center">
                <div class="col-md-8 col-sm-8 col-xs-12 text-center">
                    <div class="section-headline text-center">
                        <h2 class="br">Enviar Depoimento</h2>
                    </div>
                    <!-- Adicionando um identificador único ao formulário -->
                    <form id="form-depoimento" action="php/enviar_depoimento.php" method="POST">
                        <div class="form-group">
                            <input type="text" name="nome" class="br form-control" id="nome" placeholder="Insira o nome, em branco enviará como Anônimo" data-rule="minlen:4" data-msg="" />
                            <div class="br validation"></div>
                        </div>
                        <div class="form-group">
                            <textarea class="br form-control" name="mensagem" rows="5" data-rule="required" data-msg="Por favor escreva algo para nós" placeholder="Mensagem"></textarea>
                            <!-- Adicionando um identificador único ao elemento onde a mensagem de erro será exibida -->
                            <div id="erro-mensagem" class="text-danger">
                                <?php
                                // Verificar se a variável de sessão erro_mensagem está definida
                                if (isset($_SESSION['erro_mensagem'])) {
                                    // Exibir a mensagem de erro
                                    echo $_SESSION['erro_mensagem'];
                                    // Remover a variável de sessão para que a mensagem não seja exibida novamente após atualizar a página
                                    unset($_SESSION['erro_mensagem']);
                                }
                                ?>
                            </div>
                            <div class="br validation"></div>
                            <div class="en validation"></div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Enviar Depoimento</button>
                        </div>
                    </form>
                    <script>
                        $('#form-depoimento').submit(function (event) {
                            event.preventDefault(); // Impede o envio padrão do formulário
                            // Validação e lógica de envio do formulário
                            Swal.fire({
                                icon: 'success',
                                title: 'Depoimento Enviado',
                                text: 'Seu depoimento foi enviado com sucesso!',
                                timer: 3000,
                                showConfirmButton: false
                            }).then(function() {
                                // Aqui você pode submeter o formulário após o alerta
                                $('#form-depoimento')[0].submit();
                            });
                        });
                    </script>
                </div>
            </div>
        </div><!-- Fim Item Depoimentos -->
        <script>
    window.onload = function() {
        // Verificar se a URL contém o parâmetro de erro
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('erro')) {
            // Rolar a página até a mensagem de erro
            const erroMensagem = document.getElementById('erro-mensagem');
            if (erroMensagem) {
                erroMensagem.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    };
</script>
    <!-- Fim da Seção Enviar Depoimentos -->

    <!-- Seção Depoimentos -->
    <section id="depoimentos" class="testimonials">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Depoimentos</h2>
            </div>
            <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper-wrapper darkmode-white-text">
                    <?php
                    $sql = "SELECT nome, mensagem FROM depoimentos WHERE status_mod = 'aprovado'";
                    $result = mysqli_query($conexao, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $nome = $row['nome'] ? $row['nome'] : "Anônimo";
                            $mensagem = $row['mensagem'];
                    ?>
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <p>
                                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                <?php echo $mensagem; ?>
                                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                            </p>
                            <h3><?php echo $nome; ?></h3>
                        </div>
                    </div><!-- Fim Item Depoimentos -->
                    <?php
                        }
                    } else {
                        echo "<div class='swiper-slide'><div class='testimonial-item'><p>Nenhum depoimento aprovado disponível.</p></div></div>";
                    }
                    ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
    <!-- Fim da Seção Depoimentos -->

    <!-- Seção Contato -->
    <section id="chegar" class="contact">
        <div class="container" data-aos="fade-up">
            <div class="section-headline text-center">
                <h2>Contato</h2>
            </div>
            <div>
                <iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3657.674620432733!2d-46.34657878502169!3d-23.529135784679013!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce43de0d92a6f5%3A0x8f85eeb0c19e3c32!2sMarina%20La%20Regina!5e0!3m2!1sen!2sus!4v1648523258379!5m2!1sen!2sus&hl=pt-BR" frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
            <div class="row mt-5">
                <div class="col-lg-4 col-md-6 footer-contact darkmode-white-text">
                    <h3><img src="assets/img/logo01-black.png" alt="Logo da empresa" width="125px"></h3>
                    <p>
                        Rua Maria la Regina<br>
                        Poá, São Paulo<br>
                        Brasil <br><br>
                        <ul>
                            <li><i class="bx bx-phone-outgoing"></i> <a href="#">(11)94801-6298</a></li>
                            <li><i class="bx bx-mail-send"></i> <a href="mailto:contato@confinter.com.br">contato@confinter.com.br</a></li>                                                 
                        </ul>
                    </p>
                </div>
                <div class="col-lg-3 col-md-6 footer-links darkmode-white-text">
                   <h4>Links Úteis</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="#sobre">Sobre</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#valores">Nossos Valores</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#servicos">Serviços</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#requi">Requisições</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#faq">Dúvidas</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#depoimentos">Depoimentos</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#chegar">Como Chegar</a></li>
                    </ul>
                </div>
                <div class="col-lg-5 col-md-6 footer-newsletter darkmode-white-text">
                    <h4>Para Informações</h4>
                    <p>Cadastre seu E-mail</p>
                    <form action="" method="post">
                        <input type="email" name="email" placeholder="Seu e-mail"><input class="btn btn-primary" type="submit" value="Inscreva-se">
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Fim da Seção Contato -->
</main>

<!-- Início do Footer -->
<footer id="footer">
    <div class="footer-top">       
    <div class="container d-md-flex py-4">
        <div class="me-md-auto text-center text-md-start">
            <div class="copyright darkmode-white-text">
                &copy; Copyright <strong><span>CONFINTER <?php echo date("Y"); ?></span></strong>. Todos os Direitos Reservados.
            </div>
            <div class="credits">
                Desenvolvido por <a href="https://github.com/finandolopes/DRP01-Projeto-Integrador-em-Computa-o-II-Turma-006">DRP01 Projeto Integrador em Computação II Turma 006</a> 
            </div>
        </div>           
    </div>
</footer>
<!-- Fim do Footer -->   

<!-- Elementos adicionais -->
<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center" aria-label="Voltar ao topo"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/venobox/venobox.min.js"></script>
<script src="lib/nivo-slider/js/jquery.nivo.slider.min.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

<!-- Initialize Nivo Slider -->
<script>
    $(window).on('load', function() {
        $('#ensign-nivoslider').nivoSlider();
    });
</script>

<script src="assets/js/plugin.js"></script>
<!-- Importar o arquivo de validações JS -->
<script src="form-validation.js"></script>
</body>
</html>



