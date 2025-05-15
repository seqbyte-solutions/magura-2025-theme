<?php

$entries = get_option('campaign_entries');

$total_entries = 0;
$counties = [
   'bucuresti-ilfov' =>
   array(
      'name' => 'Bucuresti și Ilfov',
      'entries' => 0,
   ),
   'constanta' =>
   array(
      'name' => 'Constanța',
      'entries' => 0,
   ),
   'braila' =>
   array(

      'name' => 'Brăila',
      'entries' => 0,
   ),
   'vrancea' =>
   array(
      'name' => 'Vrancea',
      'entries' => 0,
   ),
   'neamt' =>
   array(
      'name' => 'Neamț',
      'entries' => 0,
   ),
   'botosani' =>
   array(
      'name' => 'Botoșani',
      'entries' => 0,
   ),
   'maramures' =>
   array(
      'name' => 'Maramureș',
      'entries' => 0,
   ),
   'salaj' =>
   array(
      'name' => 'Sălaj',
      'entries' => 0,
   ),
   'bihor' =>
   array(
      'name' => 'Bihor',
      'entries' => 0,
   ),
   'hunedoara' =>
   array(
      'name' => 'Hunedoara',
      'entries' => 0,
   ),
   'arad' =>
   array(
      'name' => 'Arad',
      'entries' => 0,
   ),
   'timis' =>
   array(
      'name' => 'Timiș',
      'entries' => 0,
   ),
   'mehedinti' =>
   array(
      'name' => 'Mehedinți',
      'entries' => 0,
   ),
   'gorj' =>
   array(
      'name' => 'Gorj',
      'entries' => 0,
   ),
   'valcea' =>
   array(
      'name' => 'Vâlcea',
      'entries' => 0,
   ),
   'teleorman' =>
   array(
      'name' => 'Teleorman',
      'entries' => 0,
   ),
   'olt' =>
   array(
      'name' => 'Olt',
      'entries' => 0,
   ),
   'dambovita' =>
   array(
      'name' => 'Dâmbovița',
      'entries' => 0,
   ),
   'prahova' =>
   array(
      'name' => 'Prahova',
      'entries' => 0,
   ),
   'brasov' =>
   array(
      'name' => 'Brașov',
      'entries' => 0,
   ),
   'covasna' =>
   array(
      'name' => 'Covasna',
      'entries' => 0,
   ),
   'iasi' =>
   array(
      'name' => 'Iași',
      'entries' => 0,
   ),
   'galati' =>
   array(
      'name' => 'Galați',
      'entries' => 0,
   ),
   'ialomita' =>
   array(
      'name' => 'Ialomița',
      'entries' => 0,
   ),
   'mures' =>
   array(
      'name' => 'Mureș',
      'entries' => 0,
   ),
   'bistrita-nasaud' =>
   array(
      'name' => 'Bistrița-Năsăud',
      'entries' => 0,
   ),
   'bacau' =>
   array(
      'name' => 'Bacău',
      'entries' => 0,
   ),
   'tulcea' =>
   array(
      'name' => 'Tulcea',
      'entries' => 0,
   ),
   'suceava' =>
   array(
      'name' => 'Suceava',
      'entries' => 0,
   ),
   'cluj' =>
   array(
      'name' => 'Cluj',
      'entries' => 0,
   ),
   'caras-severin' =>
   array(
      'name' => 'Caraș-Severin',
      'entries' => 0,
   ),
   'vaslui' =>
   array(
      'name' => 'Vaslui',
      'entries' => 0,
   ),
   'sibiu' =>
   array(
      'name' => 'Sibiu',
      'entries' => 0,
   ),
   'harghita' =>
   array(
      'name' => 'Harghita',
      'entries' => 0,
   ),
   'satu_mare' =>
   array(
      'name' => 'Satu Mare',
      'entries' => 0,
   ),
   'buzau' =>
   array(
      'name' => 'Buzău',
      'entries' => 0,
   ),
   'arges' =>
   array(
      'name' => 'Argeș',
      'entries' => 0,
   ),
   'dolj' =>
   array(
      'name' => 'Dolj',
      'entries' => 0,
   ),
   'calarasi' =>
   array(
      'name' => 'Călărași',
      'entries' => 0,
   ),
   'giurgiu' =>
   array(
      'name' => 'Giurgiu',
      'entries' => 0,
   ),
   'alba' =>
   array(
      'name' => 'Alba',
      'entries' => 0,
   ),
];

foreach ($counties as $key => $county) {

   $countyName = $county['name'];

   if ($key === 'bucuresti-ilfov') {
      $countyEntries = 0;
      $countyEntries2 = 0;
      foreach ($entries as $entry) {
         if (isset($entry['county']) && $entry['county'] === "București") {
            $countyEntries = $entry['entry_count'];
         }
         if (isset($entry['county']) && $entry['county'] === "Ilfov") {
            $countyEntries2 = $entry['entry_count'];
         }
      }
      $sum = (int) $countyEntries + (int) $countyEntries2;
      if ($sum > 0) {
         $counties[$key]['entries'] = (int) $sum;
         $total_entries +=  (int) $sum;
      }
      continue;
   }
   $countyEntries = 0;
   foreach ($entries as $entry) {
      if (isset($entry['county']) && $entry['county'] === $countyName) {
         $countyEntries = $entry['entry_count'];
         break;
      }
   }
   $counties[$key]['entries'] =  (int) $countyEntries;
   $total_entries +=  (int) $countyEntries;
}


wp_enqueue_script('magura-map', MAGURA_2025_THEME_URL . '/assets/js/magura-map.js');
wp_localize_script('magura-map', 'mapData', [
   'totalEntries' => $total_entries,
   'countiesData' => $counties,
]);
?>

<div id="map-app" class="map-app"></div>