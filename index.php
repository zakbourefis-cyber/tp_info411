<?php
$pageTitle = 'Accueil';
$extraCss  = 'index.css';
$rootPath  = '';
require_once 'include/connexion.php';
include 'include/header.php';
include 'include/menu.php';
?>

<main>

    <!-- ── Hero ─────────────────────────────────────────── -->
    <section class="hero">
        <div class="hero-inner">
            <div class="hero-eyebrow">Location Premium</div>
            <h1 class="hero-title">
                L'excellence<br>
                <em>automobile</em><br>
                à votre portée.
            </h1>
            <p class="hero-subtitle">
                Une sélection rigoureuse de véhicules haut de gamme.
                Réservation immédiate, tarifs transparents.
            </p>
            <div class="hero-cta">
                <a href="catalogue.php" class="btn btn-primary btn-lg">Voir le catalogue</a>
                <?php if (!isLoggedIn()): ?>
                    <a href="register.php" class="btn btn-outline btn-lg">Créer un compte</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="hero-scroll-hint">
            <span class="scroll-label">Défiler</span>
            <div class="scroll-line"></div>
        </div>
    </section>

    <!-- ── Stats ─────────────────────────────────────────── -->
    <div class="stats-bar">
        <div class="stats-inner">
            <div class="stat-item reveal">
                <div class="stat-number" data-target="48" data-suffix="+">48+</div>
                <div class="stat-label">Véhicules</div>
            </div>
            <div class="stat-item reveal reveal-delay-1">
                <div class="stat-number" data-target="1200" data-suffix="+">1200+</div>
                <div class="stat-label">Clients satisfaits</div>
            </div>
            <div class="stat-item reveal reveal-delay-2">
                <div class="stat-number" data-target="8" data-suffix=" ans">8 ans</div>
                <div class="stat-label">D'expérience</div>
            </div>
            <div class="stat-item reveal reveal-delay-3">
                <div class="stat-number" data-target="98" data-suffix="%">98%</div>
                <div class="stat-label">Satisfaction</div>
            </div>
        </div>
    </div>

    <!-- ── Features ──────────────────────────────────────── -->
    <section class="features-section">
        <div class="container">
            <div class="features-header reveal">
                <div class="section-eyebrow">Pourquoi DriveNow</div>
                <h2 class="section-title">Une expérience de location repensée</h2>
            </div>
            <div class="features-grid">
                <div class="feature-card reveal">
                    <div class="feature-number">01</div>
                    <h3>Sélection rigoureuse</h3>
                    <p>Chaque véhicule est soigneusement sélectionné, entretenu et inspecté avant chaque location.</p>
                </div>
                <div class="feature-card reveal reveal-delay-1">
                    <div class="feature-number">02</div>
                    <h3>Tarification claire</h3>
                    <p>Prix affiché par jour, sans frais cachés. Vous savez exactement ce que vous payez, avant de réserver.</p>
                </div>
                <div class="feature-card reveal reveal-delay-2">
                    <div class="feature-number">03</div>
                    <h3>Réservation instantanée</h3>
                    <p>Créez votre compte en deux minutes et réservez votre véhicule directement en ligne, 24h/24.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ── CTA band ───────────────────────────────────────── -->
    <div class="cta-band">
        <div class="cta-inner">
            <div class="cta-text reveal">
                <h2>Prêt à prendre la route ?</h2>
                <p>Consultez notre catalogue et réservez votre véhicule dès aujourd'hui.</p>
            </div>
            <div class="cta-actions reveal reveal-delay-2">
                <a href="catalogue.php" class="btn btn-primary btn-lg">Parcourir le catalogue</a>
            </div>
        </div>
    </div>

</main>

<?php include 'include/footer.php'; ?>
