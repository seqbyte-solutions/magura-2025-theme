<?php

$campaigns = [
    [
        'title' => '',
        'image' => MAGURA_2025_THEME_URL . '/assets/img/imbratisari/ncp_2021.jpg',
    ],
    [
        'title' => '',
        'image' => MAGURA_2025_THEME_URL . '/assets/img/imbratisari/ncp_2022.jpg',
    ],
    [
        'title' => '',
        'image' => MAGURA_2025_THEME_URL . '/assets/img/imbratisari/ncp_2023.jpg',
    ],
    [
        'title' => '',
        'image' => MAGURA_2025_THEME_URL . '/assets/img/imbratisari/ncp_2024.jpg',
    ]
]

?>

<section class="section-lateral-padding page-hero-section">
    <div class="content-box content-centered">
        <div class="heading-container heading-container-centered heading-red">
            <h2>Îmbrățișările Măgura</h2>
        </div>
        <div class="campaigns-history-list">
            <?php for ($i = count($campaigns) - 1; $i >= 0; $i--): ?>
                <div class="campaign-history-item">
                    <div class="campaign-history-image">
                        <img src="<?php echo $campaigns[$i]['image']; ?>" alt="<?php echo $campaigns[$i]['title']; ?>">
                    </div>
                    <div class="campaign-history-title">
                        <h3><?php echo $campaigns[$i]['title']; ?></h3>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>