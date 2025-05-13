<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <meta name="author" content="Seqbyte Solutions">

    <?php 
    wp_head();
    ?>
</head>
<body>
    <div class="maintenance-page">
        <div class="content-box content-centered">
            <div class="maintenance-content">
                <div class="notfound-content-text">
                    <img  src="<?= MAGURA_2025_THEME_URL ?>/assets/img/magura_logo_white.svg" class="maintenance-logo" />
                    <h1 class="notfound-title">
                        404
                    </h1>
                    <h2>Pagina pe care încercați să o accesați nu există.</h2>
                    <a href="/" class="notfound-back-to-home">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 395.64 241.73">
                    <path class="hero-cta-bubble-1" d="m198.43,237.81C79.67,258.58,6.14,192.64,2.25,139.65-1.29,91.51,5.35,43.44,112.79,21.95c133.23-26.65,258.78,2.73,281.7,67.62,13.11,37.11-88.03,129.35-196.06,148.24Z" style="fill: #fff; opacity: .45;" />
                    <path class="hero-cta-bubble-2" d="m3.73,45.23C30.52-13.33,217.89-19.15,322.32,52.22c18.15,12.4,46.43,32.29,46.87,59.8.83,51.91-97.76,110.2-184.71,104.96C71.83,210.19-19.88,96.85,3.73,45.23Z" style="fill: #fff; opacity: .45;" />
                </svg>
                <span>Înapoi acasă</span></a>
                </div>
                <div class="maintenance-image-container">
                    <img src="<?= MAGURA_2025_THEME_URL ?>/assets/img/maintenance.png" />
                    <div class="maintenance-image-background-overflow">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        wp_footer();
    ?>
</body>
</html>