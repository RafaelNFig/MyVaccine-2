<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/c8e307d42e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('assets/style/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/icon.png') }}">
    <title>My Vaccine</title>
</head>
<body>

    <header>
        <nav class="navbar">
            <a href="{{ route('home') }}"><img src="{{ asset('assets/img/logo.png') }}" alt="logo" class="logo" /></a>

            <ul class="menu">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('vaccines.index') }}">Postos de Vacinação</a></li>
                <li><a href="{{ route('vaccination-history.index') }}">Histórico de Vacinas</a></li>
            </ul>

            @auth
                <div class="user-info">
                    <span>Olá, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">Sair</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="login-btn">Login</a>
            @endauth
        </nav>
    </header>

    <main class="main-section">
        <div class="intro">
            <h1>Encontre <span class="highlight">postos de vacinação</span> próximos a você.</h1>
            <p>O My Vaccine facilita o acesso à vacinação, permitindo que você encontre postos de saúde, consulte vacinas disponíveis e gerencie seu histórico de imunização de forma prática e segura.</p>
            <a href="{{ route('vaccines.index') }}" class="cta-button">Encontrar Postos</a>
        </div>

        <div class="intro-image">
            <img src="{{ asset('assets/img/vetor-main.jpg') }}" alt="Vacinação">
        </div>
    </main>

    <section class="features">
        <ul class="features-list">
            <li>
                <img src="{{ asset('assets/img/check-heart-icon.png') }}" alt="">
                <div>
                    <p class="title">Imunização Segura</p>
                    <p class="desc">Encontre vacinas recomendadas para você.</p>
                </div>
            </li>
            <li>
                <img src="{{ asset('assets/img/health-check-icon.png') }}" alt="">
                <div>
                    <p class="title">Gestão Inteligente</p>
                    <p class="desc">Postos podem atualizar estoques em tempo real.</p>
                </div>
            </li>
            <li>
                <img src="{{ asset('assets/img/syringe-vaccine-icon.png') }}" alt="">
                <div>
                    <p class="title">Histórico de Vacinas</p>
                    <p class="desc">Acompanhe suas doses e próximas aplicações.</p>
                </div>
            </li>
        </ul>
    </section>

    <section class="info-section">
        <div class="info-text">
            <h2>Dados seguros e sempre <span class="highlight">disponíveis.</span></h2>
            <p>O My Vaccine protege suas informações com segurança e confiabilidade. Todos os dados são armazenados de forma segura, garantindo que você tenha acesso rápido e confiável sempre que precisar.</p>
        </div>
        <div class="info-image">
            <img src="{{ asset('assets/img/vetor-section-1.jpg') }}" alt="">
        </div>
    </section>

    <section class="info-section reverse">
        <div class="info-image">
            <img src="{{ asset('assets/img/vetor-section-2.png') }}" alt="">
        </div>
        <div class="info-text">
            <h2>Acompanhe a disponibilidade de vacinas em <span class="highlight">tempo real.</span></h2>
            <p>Com o My Vaccine, você pode consultar rapidamente a disponibilidade de vacinas em diferentes postos de saúde. Acesse informações atualizadas sobre estoques e planeje sua vacinação de forma prática e sem complicações.</p>
        </div>
    </section>

    <section class="info-section">
        <div class="info-text">
            <h2>Localize postos de saúde com <span class="highlight">facilidade.</span></h2>
            <p>Com nossa ferramenta de busca, você encontra rapidamente os postos de vacinação mais próximos da sua localização. Visualize endereços, horários de funcionamento e vacinas disponíveis de forma simples e acessível.</p>
        </div>
        <div class="info-image">
            <img src="{{ asset('assets/img/vetor-section-3.png') }}" alt="">
        </div>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-brand">
                <img src="{{ asset('assets/img/logo-white.png') }}" alt="Logo My Vaccine">
                <p>Facilitando o acesso à vacinação.</p>
            </div>

            <div class="footer-links">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('vaccines.index') }}">Postos de Vacinação</a>
                <a href="{{ route('vaccination-history.index') }}">Histórico de Vacinas</a>
            </div>

            <div class="footer-socials">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
        </div>

        <div class="footer-bottom">
            &copy; 2025 My Vaccine. Todos os direitos reservados.
        </div>
    </footer>

</body>
</html>