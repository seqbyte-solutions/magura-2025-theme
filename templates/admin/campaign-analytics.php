<?php
    if (!current_user_can('can_see_analitics')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
        return;
    }

    $url = 'https://api-magura.promoapp.ro/api/v1/campaign/analytics';
    $response = wp_remote_get($url);
    $data = json_decode(wp_remote_retrieve_body($response), true);
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="wrap">
    <h2>Rapoarte</h2>
    <br/>
    <div>
        <div>
            <canvas style="max-height: 300px; height:100%" id="perDayChart"></canvas>
            <div style="display: flex; justify-content: space-between; margin-top: 50px; margin-bottom: 50px; gap: 10px">
                <div style="width: 50%">
                    <canvas style="width: 100%;
                    max-height: 300px;" id="uniqueChart"></canvas>
                </div>
                <div style="width: 50%">
                    <canvas style="width: 100%;
                    max-height: 300px;" id="typeChart"></canvas>
                </div>
            </div>
            <canvas id="perCountyChart" style="max-height: 800px; min-height:400px; height: 100%;"></canvas>
            <canvas id="bannedChart" style="height: 100%; max-height:300px;"></canvas>
        </div>
        <div id="admin-charts-app">

        </div>
    </div>
</div>

<script>
    const adminChartsData = <?php echo json_encode($data); ?>;
  const sortedDailyData = adminChartsData?.data?.entries_by_date?.sort(
    (a, b) => new Date(a.entry_date) - new Date(b.entry_date)
  );
const dailyData = {
  labels: sortedDailyData?.map((entry) => entry.entry_date),
    datasets: [
      {
        label: "Înscrieri",
        data: sortedDailyData?.map((entry) => entry.entry_count),
        borderColor: "#DB0632",
        backgroundColor: "#DB0632",
        tension: 0.4
      },
    ],
};
const dailyOptions = {
    responsive: true,
    plugins: {
      legend: {
        display: false,
        position: "top",
      },
      title: {
        display: true,
        text: "Înscrieri pe zile",
      },
    },
};
// how can i set chart heiht to 300px?
const chartHeight = 300;
new Chart(
    document.getElementById("perDayChart"),
    {
      type: "line",
      data: dailyData,
      options: dailyOptions,
        height: chartHeight,
    }
  );


const uniqueData = {
    labels: [
        "Înscrieri totale",
        "Înscrieri unice",
    ],
    datasets: [
      {
        label: "Înscrieri",
        data: [
            parseInt(adminChartsData?.data?.total_entries),
            parseInt(adminChartsData?.data?.unique_entries)
        ],
        backgroundColor: ["#F9BAC5", "#DB0632"],
        borderColor: ["#DB0632", "#F9BAC5"],
        borderWidth: 1,
        barThickness: 100,
      }
    ],
};

const uniqueOptions = {
    responsive: true,
    plugins: {
      legend: {
        display: false,
        position: "top",
      },
      title: {
        display: true,
        text: "Statistici înscrieri",
      },
    },
}
new Chart(
    document.getElementById("uniqueChart"),
    {
      type: "bar",
      data: uniqueData,
      options: uniqueOptions,
    }
  );

const perCountyData = {
    labels: adminChartsData?.data?.by_counties?.map((entry) => entry.county),
    datasets: [
      {
        label: "Înscrieri",
        data: adminChartsData?.data?.by_counties?.map((entry) => entry.entry_count),
        backgroundColor: "#F9BAC5",
        borderColor: "#DB0632",
        borderWidth: 1, 
      },
    ],
};

const perCountyOptions = {
    responsive: true,
    aspectRatio: 1 / 2, 
    indexAxis: 'y',
    plugins: {
      legend: {
        display: false,
        position: "top",
      },
      title: {
        display: true,
        text: "Înscrieri pe judete",
      },
    },
}
new Chart(
    document.getElementById("perCountyChart"),
    {
      type: "bar",
      data: perCountyData,
      options: perCountyOptions,
    }
  );




const typeData = {
    labels: [
        "Necâștigătoare",
        "Câștigătoare",
        "Rezerve",
    ],
    datasets: [
      {
        label: "Înscrieri",
        data: [
            parseInt(adminChartsData?.data?.count_by_type[0]?.regular_entries),
            parseInt(adminChartsData?.data?.count_by_type[0]?.winner_entries),
            parseInt(adminChartsData?.data?.count_by_type[0]?.reserve_entries),
        ],
        backgroundColor: ["#F9BAC5", "#DB0632"],
        borderColor: ["#DB0632", "#DB0632"],
        borderWidth: 1,
        barThickness: 50,
      }
    ],
};

const typeOptions = {
    responsive: true,
    plugins: {
      legend: {
        display: false,
        position: "top",
      },
      title: {
        display: true,
        text: "Tipuri de înscrieri",
      },
    },
}
new Chart(
    document.getElementById("typeChart"),
    {
      type: 'pie',
      data: typeData,
      options: typeOptions,
    }
  );

const bannedData = {
  labels: [
    'Bon deja înscris',
    'Limită maximă de înscriere pe zi depășită',
  ],
  datasets: [
    {
      label: 'Înscrieri',
      data: [    
        parseInt(adminChartsData?.data?.banned_entries[0]?.entry_count),
        parseInt(adminChartsData?.data?.banned_entries?.[1]?.entry_count),
      ],
      backgroundColor: ['#F9BAC5', '#DB0632'],
      borderColor: ['#DB0632', '#DB0632'],
      borderWidth: 1,
      barThickness: 50,
    },
  ],
}

const bannedOptions = {
  responsive: true,
  plugins: {
    legend: {
      display: false,
      position: 'top',
    },
    title: {
      display: true,
      text: 'Înscrieri blocate',
    },
  },
}
new Chart(
    document.getElementById("bannedChart"),
    {
      type: "bar",
      data: bannedData,
      options: bannedOptions,
    }
  );
</script>

