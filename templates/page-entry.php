<?php
wp_enqueue_script('campaign-form', MAGURA_2025_THEME_URL . '/assets/js/campaign-form.js');
wp_localize_script(
    'campaign-form',
    'campaignData',
    [
        'api_url' => "https://api.promoapp.ro/v1/campaigns/magura2025/submit",
        'api_token' => "a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0",
    ]
);
// wp_enqueue_style('campaign-form', MAGURA_2025_THEME_URL . '/assets/js/campaign-form.css');
?>

<section class="section-lateral-padding page-hero-section">
    <div class="content-box content-centered">
        <div class="heading-container heading-container-centered heading-red">
            <h2>Înscrie-te</h2>
        </div>
        <div class="campaign-form-container">
            <div id="campaign-form-app"></div>
        </div>
    </div>
</section>