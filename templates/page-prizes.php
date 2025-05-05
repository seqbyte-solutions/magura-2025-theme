<?php
wp_enqueue_script('prizes-script', MAGURA_2025_THEME_URL . '/assets/js/prizes.js', ['gsap']);
?>

<section class="section-lateral-padding page-hero-section">
    <div class="content-box content-centered">
        <div class="heading-container heading-container-centered heading-red">
            <h2>Premii</h2>
        </div>
        <div class=prizes-container>
            <div class="prize-item" onClick="openModal('ghiozdan')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 460.4 398.35">
                    <path d="m239.01,341.86c-120.53-4.38-179.69-122.72-173.12-201.61C71.87,68.58,87.81,0,197.38,0c135.87,0,258.58,116.14,262.97,181.89,3.07,46.12-111.69,163.96-221.33,159.97Z" style="fill: #F9BAC5; opacity: .45;" />
                    <path d="m246.5,398.24c134.2-4.88,200.07-136.64,192.75-224.47-6.65-79.8-24.4-156.15-146.4-156.15-151.28,0-287.91,129.32-292.79,202.51-3.42,51.36,124.35,182.55,246.43,178.11Z" style="fill: #F9BAC5; opacity: .45;" />
                </svg>
                <div class="prize-item-content">
                    <img src="<?= MAGURA_2025_THEME_URL ?>/assets/img/prize_ghiozdan.png" alt="">
                    <div class="prize-item-content-text">
                        <h4>1500x</h4>
                        <p>Rucsac Măgura<br />[Diverse culori]</p>
                    </div>
                </div>
            </div>
            <div class="prize-item" onClick="openModal('vacanta')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 579.62 415.95">
                    <path d="m0,218.27C0,143.09,80.4,61.84,245.09,63.65c149.68,1.64,305.95,34.54,332.27,126.66,21.71,75.98-115.14,184.23-294.43,180.94C151.9,368.84,0,316.96,0,218.27Z" style="fill: #F9BAC5; opacity: .45;" />
                    <path d="m267.46,415.83c-146.61-5.33-218.58-149.27-210.58-245.24C64.15,83.42,83.54,0,216.82,0c165.27,0,314.54,141.28,319.87,221.25,3.74,56.11-135.86,199.44-269.23,194.59Z" style="fill: #F9BAC5; opacity: .45;" />
                </svg>
                <div class="prize-item-content">
                    <img src="<?= MAGURA_2025_THEME_URL ?>/assets/img/prize_vacanta.png" alt="">
                    <div class="prize-item-content-text">
                        <h4>5x</h4>
                        <h3>Marele<br />premiu</h3>
                    </div>
                </div>
            </div>
            <div class="prize-item" onClick="openModal('cesti')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 521.37 320.5">
                    <path d="m511.37,38.38C465.4-34.9,234.55-.71,122.64,119.37c-19.45,20.87-49.63,54.14-43.99,91.5,10.64,70.48,144.52,127.27,249.86,100.65,136.48-34.49,223.38-208.54,182.86-273.14Z" style="fill: #F9BAC5; opacity: .45;" />
                    <path d="m5.98,95.1c34.34-66.96,236.99-54.67,343,41,18.42,16.62,47.08,43.2,45,76-3.93,61.88-115.7,121.16-209,106C64.11,298.46-24.29,154.13,5.98,95.1Z" style="fill: #F9BAC5; opacity: .45;" />
                </svg>
                <div class="prize-item-content">
                    <img src="<?= MAGURA_2025_THEME_URL ?>/assets/img/prize_cani.png" alt="">
                    <div class="prize-item-content-text">
                        <h4>750x</h4>
                        <p>Set Măgura<br />2 cești + 2 prăjituri</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="prizes-details-modal" data-index="ghiozdan">
    <div class="prizes-details-modal-box">
        <div class="prizes-details-modal-header">
            <h2>
                Rucsac Măgura, Diverse culori
            </h2>
            <button type="button" onclick="closeModal()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                    <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                </svg>
            </button>
        </div>
        <div class="prizes-details-modal-content">
            <p>
                Rucsac XD Design personalizat Magura, antifurt, material rPET , Volum 16L , buzunar captusit pentru Laptop/Tableta, dimensiune 15,6" , multiple buzunare cu protectie RFID, port USB, material sustenabil rezistent la apa, bretele reglabile, Diverse Culori: visiniu (100 bucați), bej (100 bucați), model fluturi Magura (1300 bucați).<br /><br />
                Dimensiuni: 30 (h) x 18 (w) x 45 (d) cm, Greutate 645g;</p>
        </div>
    </div>
</div>
<div class="prizes-details-modal" data-index="vacanta">
    <div class="prizes-details-modal-box">
        <div class="prizes-details-modal-header">
            <h2>
                Circuit Turistic 2 persoane, Îmbrățișează România
            </h2>
            <button type="button" onclick="closeModal()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                    <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                </svg>
            </button>
        </div>
        <div class="prizes-details-modal-content">
            <p>
                Voucherul de vacanță poate fi utilizat exclusiv prin intermediul agenției de turism ACH CUSTOM EVENTS.<br /><br />
                Valoarea nominală a voucherului este de 4.000 lei, TVA inclus. <br /><br />
                Voucherul este valabil în perioada 15 mai 2025 – 15 august 2026, respectiv timp de 1 (un) an de la data de start a campaniei.</p>
        </div>
    </div>
</div>
<div class="prizes-details-modal" data-index="cesti">
    <div class="prizes-details-modal-box">
        <div class="prizes-details-modal-header">
            <h2>
                Set Măgura, 2 cești+2 prăjituri
            </h2>
            <button type="button" onclick="closeModal()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                    <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                </svg>
            </button>
        </div>
        <div class="prizes-details-modal-content">
            <p>
                Ceasca Espresso double 100ml, model flat bottom, fara toarta, rosu mat exterior/ rosu lucios interior, personalizare logo Magura.<br /><br />
                Ceasca Americano 150 ml, model flat bottom, fara toarta, rosu mat exterior/ rosu lucios interior, personalizare logo Magur
                Prajitura Magura Lapte: blat cacao, crema Lapte si glazura de cacao, 35g.<br /><br />
                Prajitura Magura Ciocolata: blat vanilie, crema ciocolata si glazura de cacao si lapte 35g .<br /><br />
                Cutie ambalare, carton nature.</p>
        </div>
    </div>
</div>