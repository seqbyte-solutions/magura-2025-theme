<?php
$winners = [
    'vacanta' => [
        'title' => 'Circuit Turistic "Îmbrățișează România"',
        'image' => MAGURA_2025_THEME_URL . '/assets/img/prize_vacanta.png',
        'winners' => []
    ],
    'ghiozdan' => [
        'title' => 'Rucsac Măgura [Diverse culori]',
        'image' => MAGURA_2025_THEME_URL . '/assets/img/prize_ghiozdan.png',
        'winners' => [
            'Nume 1',
            'Nume 2',
            'Nume 3',
            'Nume 1',
            'Nume 2',
            'Nume 3',
            'Nume 1',
            'Nume 2',
            'Nume 3',
            'Nume 1',
            'Nume 2',
            'Nume 3',
            'Nume 1',
            'Nume 2',
            'Nume 3',
        ]
    ],
    'cesti' => [
        'title' => 'Set Măgura 2 cești + 2 prăjituri',
        'image' => MAGURA_2025_THEME_URL . '/assets/img/prize_cani.png',
        'winners' => [
            'Nume 1',
            'Nume 2',
            'Nume 3',
        ]
    ],
];

$background = [
    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 460.4 398.35">
  <g>
    <g>
      <path d="m239.01,341.86c-120.53-4.38-179.69-122.72-173.12-201.61C71.87,68.58,87.81,0,197.38,0c135.87,0,258.58,116.14,262.97,181.89,3.07,46.12-111.69,163.96-221.33,159.97Z" style="fill: #F9BAC5; opacity: .45;"/>
      <path d="m246.5,398.24c134.2-4.88,200.07-136.64,192.75-224.47-6.65-79.8-24.4-156.15-146.4-156.15-151.28,0-287.91,129.32-292.79,202.51-3.42,51.36,124.35,182.55,246.43,178.11Z" style="fill: #F9BAC5; opacity: .45;"/>
    </g>
  </g>
</svg>',
    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 579.62 471.21">
  <g>
    <g>
      <path d="m544.69,361.42c-18.74,41.75-35.89,61.67-54.43,75.91-32.98,25.34-72.17,33.2-106.94,33.84-93.65,1.74-195.08-44.58-280.48-203.95C62.28,191.52,53.18,36.54,130.66,5.25c73.53-29.69,208.36,74.57,259.14,110.66,95.92,68.19,202.46,139.48,154.89,245.5Z" style="fill: #F9BAC5; opacity: .45;"/>
      <path d="m0,243.53C0,168.35,80.4,87.11,245.09,88.92c149.68,1.64,305.95,34.54,332.27,126.66,21.71,75.98-115.14,184.23-294.43,180.94C151.9,394.1,0,342.23,0,243.53Z" style="fill: #F9BAC5; opacity: .45;"/>
    </g>
  </g>
</svg>',
    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 475.24 480.88">
  <g>
    <g>
      <path d="m245.72,469.78c-120.53-4.38-179.69-122.72-173.12-201.61,5.97-71.67,21.91-140.25,131.48-140.25,135.87,0,258.58,116.14,262.97,181.89,3.07,46.12-111.69,163.96-221.33,159.97Z" style="fill: #F9BAC5; opacity: .45;"/>
      <path d="m368.51,12.68c41.4,19.51,60.99,37.03,74.89,55.83,24.72,33.45,31.85,72.77,31.85,107.55,0,93.67-48.19,194.22-209.12,276.65-76.43,39.15-231.56,45.38-261.4-32.68-28.32-74.06,78.42-206.94,115.45-257.04C190.13,68.34,263.39-36.86,368.51,12.68Z" style="fill: #F9BAC5; opacity: .45;"/>
    </g>
  </g>
</svg>'
];
$bg_index = 0;

?>

<section class="section-lateral-padding page-hero-section">
    <div class="content-box content-centered">
        <div class="heading-container heading-container-centered heading-red">
            <h2>Câștigători</h2>
        </div>
        <div class="winners-list-container">
            <?php
            foreach ($winners as $prize_key => $prize) :
            ?>
                <div class="winners-list-group">
                    <div class="winners-list-group-content">
                        <div class="winners-list-group-image-container">
                            <div class="winners-list-group-image">
                                <?php
                                echo $background[$bg_index];
                                $bg_index++;
                                ?>
                                <img src="<?php echo $prize['image']; ?>" alt="<?php echo $prize['title']; ?>">
                            </div>
                        </div>

                        <div class="winners-list-group-winners">
                            <div class="winners-list-group-title">
                                <h3><?php echo $prize['title']; ?></h3>
                            </div>
                            <?php if (count($prize['winners']) > 0) : ?>
                                <ul class="winners-list-group-winners-ul">
                                    <?php foreach ($prize['winners'] as $winner) : ?>
                                        <li><?php echo $winner; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else : ?>
                                <p>Nu sunt câștigători pentru acest premiu.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
            ?>
        </div>
    </div>
</section>