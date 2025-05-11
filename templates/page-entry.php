<?php
wp_enqueue_script('campaign-form', MAGURA_2025_THEME_URL . '/assets/js/campaign-form.js');
wp_localize_script(
    'campaign-form',
    'campaignData',
    []
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