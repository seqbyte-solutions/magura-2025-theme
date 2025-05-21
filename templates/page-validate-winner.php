<?php
wp_enqueue_script('validate-form', MAGURA_2025_THEME_URL . '/assets/js/validate-form.js');
wp_localize_script(
    'validate-form',
    'validateData',
    [
        'api_url' => "https://api-magura.promoapp.ro/api/v1/",
        'api_token' => "a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0",
        'ajax_url' => admin_url('admin-ajax.php'),
        'security' => wp_create_nonce('send_email_nonce'),
    ]
);
?>

<section class="section-lateral-padding page-hero-section">
    <div class="content-box content-centered">
        <div class="heading-container heading-container-centered heading-red">
            <h2>Revendicarea premiului</h2>
        </div>
        <div class="campaign-form-container">
            <div id="validate-form-app"></div>
        </div>
    </div>
</section>