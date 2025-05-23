<svg class="footer-top-vector" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 254.1 92.5">
    <g style="opacity: .41;">
        <path d="m147.59,18.92C144.14,10.19,129.37-1.27,117.68.11c-.29.03-.44.35-.28.59.47.75,1.18,2.4,1.03,5.39-.36,7.34-11.9,14.39-13.84,17.81h0c-1.68,1.98-3.06,4.23-4.07,6.6-3,6.98-2.32,14.04.23,21,.82,2.25,1.86,4.43,2.8,6.64-.14.11-.13.1-.27.22-1.31-.92-2.57-1.93-3.94-2.74-5.44-3.19-11.1-4.57-17.05-1.41-8.48,4.5-11.31,14.56-6.04,22.69,4.12,6.36,11.78,8.46,19.63,8.35,0,0,19.72,2.22,38.91-17.75.97-1.01,1.86-1.97,2.69-2.89h0c3.23-3.61,5.38-6.6,6.72-9.45,8.61-14.7,7.57-27.56,3.39-36.2v-.04Z" style="fill: #db0032;" />
    </g>
    <path d="m254.1,60.28v32.22H0v-14.19s.04-.08.07-.13c.02-.05.05-.11.09-.17.61-1.14,2.53-4.22,6.54-6.49.22-.12.43-.24.66-.35.24-.13.49-.25.74-.37.24-.11.49-.22.75-.32,1.37-.57,2.94-1.02,4.71-1.3.25-.05.49-.08.75-.11.12-.02.24-.03.36-.04.55-.07,1.13-.12,1.72-.14,4.76-.21,10.78.78,18.3,3.93v-.07c1.59.67,15.43,6.9,29.42,10.78,8.12,2.25,16.85,3.93,25.22,5.19-.23-.22-.47-.43-.69-.66-.22-.21-.43-.43-.64-.65-.22-.24-.44-.48-.65-.73-.2-.23-.39-.46-.58-.7-.22-.29-.44-.58-.65-.88-.15-.2-.29-.41-.43-.62-.19-.29-.37-.58-.54-.87-.15-.25-.29-.51-.43-.77,0-.02-.02-.04-.03-.06-.69-1.31-1.25-2.73-1.63-4.24-2.99-11.65,4.3-22.37,16.05-24.32,8.23-1.36,14.35,2.49,19.5,8.39,1.3,1.5,2.38,3.18,3.56,4.78.21-.08.19-.07.4-.15-.24-2.97-.6-5.94-.68-8.92-.25-9.2,1.73-17.77,8.01-24.8,2.13-2.39,4.63-4.49,7.39-6.16,3.64-3.24,19.99-7,23.31-15.49,1.35-3.46,1.16-5.69.91-6.75-.08-.35.22-.66.57-.59,14.3,3,27.16,22.31,27.78,33.94,1.43,11.23-1.97,25.82-15.96,39.17-.73.7-1.5,1.4-2.3,2.1-2.7,2.82-6.42,5.5-11.64,8.47h-.01c-1.25.71-2.59,1.44-4.01,2.19-2.18.46-4.38.87-6.59,1.23,6.36-.44,12.92-1.19,19.35-2.37.75-.12,1.49-.24,2.23-.37.74-.12,1.48-.25,2.21-.39.64-.11,1.28-.23,1.91-.36,1.49-.28,2.97-.58,4.43-.9.58-.12,1.17-.25,1.75-.38.53-.12,1.06-.24,1.59-.37.62-.14,1.24-.28,1.85-.44.57-.14,1.14-.28,1.7-.42,11.84-2.98,22.53-6.79,31.69-10.68.44-.18.87-.37,1.3-.55.82-.35,1.62-.7,2.4-1.05,12.54-5.57,21.86-11.07,26.92-14.29,2.37-1.51,3.8-2.51,4.2-2.79l.07-.06s.77,1.15,1.04,2.85c.07.38.11.79.11,1.22Z" style="fill: #db0032;" />

</svg>
<footer class="footer">
    <div class="content-box content-centered">
        <div class="footer-content">
            <div class="footer-row">
                <div class="footer-row-column">
                    <div class="footer-logo">
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <img src="<?php echo esc_url(MAGURA_2025_THEME_URL . '/assets/img/magura_logo_white.svg'); ?>" alt="Măgura" />
                        </a>
                    </div>
                </div>
                <div class="footer-row-column">
                    <?php
                    wp_nav_menu([
                        'theme_location'    => 'footer',
                        'container'         => 'nav',
                        'container_class'   => 'footer-nav',
                        'menu_class'        => 'footer-nav-list'
                    ]);
                    ?>
                </div>
                <div class="footer-row-column">
                    <?php
                    wp_nav_menu([
                        'theme_location'    => 'footer-utils',
                        'container'         => 'nav',
                        'container_class'   => 'footer-nav',
                        'menu_class'        => 'footer-nav-list'
                    ]);
                    ?>
                </div>
                <div class="footer-row-column">
                    <div class="footer-anpc-bagdes-container">
                        <a class="footer-anpc-bagde" href="https://anpc.ro/ce-este-sal/" target="_blank">
                            <img src="<?= MAGURA_2025_THEME_URL ?>/assets/img/anpc-sal.svg" />
                        </a>
                        <a class="footer-anpc-bagde" href="https://ec.europa.eu/consumers/odr" target="_blank">
                            <img src="<?= MAGURA_2025_THEME_URL ?>/assets/img/anpc-sol.svg" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyrights">
            &copy; <?php echo date('Y'); ?> Kandia Dulce. Toate drepturile rezervate.
        </div>
    </div>
</footer>


<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K948JQW4"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->