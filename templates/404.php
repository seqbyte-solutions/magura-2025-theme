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
                <div class="maintenance-content-text">
                    <img  src="<?= MAGURA_2025_THEME_URL ?>/assets/img/magura_logo_white.svg" class="maintenance-logo" />
                    <h1>Suntem la o îmbrățișare distanță de o nouă călătorie Măgura. Ne revedem cu mii de premii, din 15 Mai!</h1>
                    <div id="countdown" class="maintenance-countdown simply-countdown"></div>
                </div>
                <div class="maintenance-image-container">
                    <img src="<?= MAGURA_2025_THEME_URL ?>/assets/img/maintenance.png" />
                    <div class="maintenance-image-background-overflow">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        simplyCountdown('#countdown', {
            year: 2025,
            month: 5,
            day: 15,
            hours: 0,
            minutes: 0,
            seconds: 0,
            words: { 
                 days: { root: 'zi', lambda: (root, n) => n > 1 ? 'zile' : root },
            hours: { root: 'oră', lambda: (root, n) => n > 1 ?  'ore' : root },
            minutes: { root: 'minut', lambda: (root, n) => n > 1 ?  'minute' : root },
            seconds: { root: 'secundă', lambda: (root, n) => n > 1 ?  'secunde' : root }
            },
            plural: true, 
            inline: false, 
            refresh: 1000, 
        });
    </script>

    <?php
        wp_footer();
    ?>
</body>
</html>