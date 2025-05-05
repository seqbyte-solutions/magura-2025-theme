<?php
wp_enqueue_script('gsap-scrollTrigger', MAGURA_2025_THEME_URL . '/assets/js/gsap-public/minified/ScrollTrigger.min.js', ['gsap']);
wp_enqueue_script('frontpage-script', MAGURA_2025_THEME_URL . '/assets/js/products.js', ['gsap', 'gsap-scrollTrigger']);

$cakes = [
    'Lapte' => MAGURA_2025_THEME_URL . '/assets/img/products/Magura-Prajitura-Lapte.png',
    'Cacao' => MAGURA_2025_THEME_URL . '/assets/img/products/Magura-Prajitura-Cacao.png',
    'Căpșuni' => MAGURA_2025_THEME_URL . '/assets/img/products/Magura-Prajitura-Capsuni.png',
    'Rom' => MAGURA_2025_THEME_URL . '/assets/img/products/Magura-Prajitura-Rom.png',
    'Alune' => MAGURA_2025_THEME_URL . '/assets/img/products/Magura-Prajitura-Alune.png',
    'Cocos' => MAGURA_2025_THEME_URL . '/assets/img/products/Magura-Prajitura-Cocos.png',
    'Mascarpone & Rodie' => MAGURA_2025_THEME_URL . '/assets/img/products/magura-red-rodie.png',
    'Bubblegum' => MAGURA_2025_THEME_URL . '/assets/img/products/magura-red-bubble.png',
    'Caise și Lavanda' => MAGURA_2025_THEME_URL . '/assets/img/products/magura_caise_si_lavanda.png',
    'Coacăze și lămâie' => MAGURA_2025_THEME_URL . '/assets/img/products/magura_coacaze_si_lamaie.png',
];

$cakes_multipack = [
    '6 buc Lapte' => MAGURA_2025_THEME_URL . '/assets/img/products/magura-6-buc-lapte.png',
    '6 buc Ciocolata' => MAGURA_2025_THEME_URL . '/assets/img/products/magura-6-buc-ciocolata.png',
];

$rulade = [
    'Cheesecake Fructe de Pădure' => MAGURA_2025_THEME_URL . '/assets/img/products/Magura-Rulada-Cheesecake-Fructe-Padure.png',
    'Iaurt Zmeură' => MAGURA_2025_THEME_URL . '/assets/img/products/Magura-Rulada-Iaurt-Zmeura.png',
];

$croisante = [
    'Medi Cacao' => MAGURA_2025_THEME_URL . '/assets/img/products/Magura-Croissant-Medi-Cacao.png',
    'Cacao Vanilie' => MAGURA_2025_THEME_URL . '/assets/img/products/Magura-Croissant-Cacao-Vanilie.png',
    'Vișine Vanilie' => MAGURA_2025_THEME_URL . '/assets/img/products/Magura-Croissant-Visine-Vanilie.png',
];

?>

<section class="products-section section-lateral-padding page-hero-section">
    <div class="content-box content-centered">
        <div class="heading-container heading-container-centered heading-red">
            <h2>Produse participante</h2>
        </div>
        <div class="products-section-content">
            <div class="products-list-container">
                <div class="heading-container heading-container-centered heading-red">
                    <h3>Prăjituri</h3>
                </div>
                <div class="products-list">
                    <?php
                    foreach ($cakes as $cake_name => $cake_img) {
                    ?>
                        <div class="product-item">
                            <div class="product-item-image">
                                <img src="<?php echo esc_url($cake_img); ?>" alt="Prăjitură Măgura" />
                            </div>
                            <div class="product-item-name">Prăjitură Măgura <?= $cake_name ?></div>

                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>

            <div class="products-list-container">
                <div class="heading-container heading-container-centered heading-red">
                    <h3>Prăjituri Multipack</h3>
                </div>
                <div class="products-list">
                    <?php
                    foreach ($cakes_multipack as $cake_name => $cake_img) {
                    ?>
                        <div class="product-item wider">
                            <div class="product-item-image">
                                <img src="<?php echo esc_url($cake_img); ?>" alt="Prăjitură Măgura" />
                            </div>
                            <div class="product-item-name">Multipack Prăjituri Măgura <?= $cake_name ?></div>

                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="products-list-container">
                <div class="heading-container heading-container-centered heading-red">
                    <h3>Rulade</h3>
                </div>
                <div class="products-list">
                    <?php
                    foreach ($rulade as $cake_name => $cake_img) {
                    ?>
                        <div class="product-item">
                            <div class="product-item-image">
                                <img src="<?php echo esc_url($cake_img); ?>" alt="Prăjitură Măgura" />
                            </div>
                            <div class="product-item-name">Ruladă Măgura <?= $cake_name ?></div>

                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="products-list-container">
                <div class="heading-container heading-container-centered heading-red">
                    <h3>Croissante</h3>
                </div>
                <div class="products-list">
                    <?php
                    foreach ($croisante as $cake_name => $cake_img) {
                    ?>
                        <div class="product-item">
                            <div class="product-item-image">
                                <img src="<?php echo esc_url($cake_img); ?>" alt="Prăjitură Măgura" />
                            </div>
                            <div class="product-item-name">Croissant Măgura <?= $cake_name ?></div>

                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>