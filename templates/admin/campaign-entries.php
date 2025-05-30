<?php
if (!current_user_can('can_see_analitics')) {
    wp_die(__('You do not have sufficient permissions to access this page.'));
    return;
}

class Inscrieri_List_Table extends WP_List_Table
{
    public function get_columns()
    {
        $columns = [
            'entry_id' => 'ID',
            'created_at' => 'Data',
            'last_name' => 'Nume',
            'first_name' => 'Prenume',
            'phone' => 'Telefon',
            'email' => 'Email',
            'type' => "Tip",
            'prize' => "Premiu",
            'status' => 'Status',
            'actions' => 'Acțiuni',
        ];
        return $columns;
    }

    // Define sortable columns
    public function get_sortable_columns()
    {
        $sortable_columns = array(
            'created_at'  => array('created_at', false), // true means it's already sorted
            // 'last_name' => array('last_name', false),
            // 'first_name'   => array('first_name', false)
        );
        return $sortable_columns;
    }

    // Define the primary column
    public function get_primary_column_name()
    {
        return 'entry_id'; // Or 'last_name' if you prefer
    }

    public function prepare_items()
    {


        // Set up pagination
        $per_page = 10;
        $current_page = $this->get_pagenum();
        $offset = ($current_page - 1) * $per_page;

        $url = 'https://api-magura.promoapp.ro/api/v1/campaign/entries/paginate';

        // Preia datele de filtrare
        $type_filter = isset($_REQUEST['type_filter']) ? sanitize_text_field($_REQUEST['type_filter']) : '';
        $prize_won_filter = isset($_REQUEST['prize_won_filter']) ? absint($_REQUEST['prize_won_filter']) : '';
        $date_filter = isset($_REQUEST['date_filter']) ? sanitize_text_field($_REQUEST['date_filter']) : '';
        $search_filter = isset($_REQUEST['search']) ? sanitize_text_field($_REQUEST['search']) : '';

        // Adaugă parametrii de filtrare la URL
        // $url .= '&per_page=' . $per_page . '&offset=' . $offset;

        $url .= '?page=' . $current_page;
        if (!empty($type_filter)) {
            $url .= '&type=' . $type_filter;
        }
        if (!empty($prize_won_filter)) {
            $url .= '&prize=' . $prize_won_filter;
        }
        if (!empty($date_filter)) {
            $url .= '&date=' . $date_filter;
        }
        if (!empty($search_filter)) {
            $url .= '&search=' . $search_filter;
        }

        // add header X-API-KEY
        $headers = [
            'X-API-KEY' => 'tUBP2HIACXBvhc6LD47cPQrX7YSk4iBEn7prR7GmtbgOSPN1XtZEMR9u7g65N57OoJx2IEWdCJeV2EJTl9MYH3CL8Q5njzMqqvjRX7b23AOQjhEauLuRvbXT1xXb2qQI',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
        $response = wp_remote_get($url, [
            'headers' => $headers
        ]);

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        // Set up pagination
        $this->set_pagination_args([
            'total_items' => $data['pagination']['total_entries'],
            'per_page'    => $data['pagination']['limit'],
            'total_pages' => $data['pagination']['total_pages']
        ]);

        // Assign items
        $this->items = $data['data'];

        // Assign columns (needed for display)
        $this->_column_headers = array($this->get_columns(), array(), $this->get_sortable_columns(), $this->get_primary_column_name());
    }

    public function column_entry_id($item)
    {
        return $item['entry_id'];
    }

    public function column_default($item, $column_name)
    {
        return isset($item[$column_name]) ? esc_html($item[$column_name]) : 'N/A';
    }

    public function column_prize($item)
    {
        if (empty($item['prize_id'])) {
            return "-";
        }

        if ($item['prize_id'] === "1") {
            return 'Circuit turistic "Îmbrățișează România"';
        } else if ($item['prize_id'] === "2") {
            return "Set Măgura";
        } else if ($item['prize_id'] === "3") {
            return "Rucsac vișiniu";
        } else if ($item['prize_id'] === "4") {
            return "Rucsac bej";
        } else if ($item['prize_id'] === "5") {
            return "Rucsac model fluturi";
        }
        return $item['prize_id'];
    }

    public function column_type($item)
    {
        if ($item['type'] === "winner") {
            return "Câștigător";
        } else if ($item['status'] === 'rejected') {
            return "RESPINS";
        } else if ($item['type'] === "reserve") {
            return "Rezervă";
        }
        return "-";
    }

    public function column_email($item)
    {
        return '<a href="mailto: ' . $item['email'] . '">' . $item['email'] . '</a>';
    }
    public function column_phone($item)
    {
        return '<a href="tel: ' . $item['phone'] . '">' . $item['phone'] . '</a>';
    }

    public function column_status($item)
    {
        if ($item['status'] === 'rejected') {
            return '<span class="entries-status-dot"  style="background: red;">Invalidat</span>';
        }

        if ($item['is_validated'] === '0') {
            return '<span class="entries-status-dot" style="background: gray;">Nevizualizat</span>';
        } else if ($item['is_validated'] === '-1') {
            return '<span class="entries-status-dot"  style="background: red;">Invalidat</span>';
        } else if ($item['is_validated'] === '1') {
            return '<span class="entries-status-dot"  style="background: orange;">În așteptare</span>';
        } else if ($item['is_validated'] === '2') {
            return '<span class="entries-status-dot"  style="background: green;">Validat</span>';
        }
    }

    // public function column_poza_bon($item)
    // {

    //     $image_url = 'https://api-magura.promoapp.ro/uploads/' . $item['additional_data']['reciep_image'];
    //     // return '<img src="'.$image_url.'" />';
    //     return '<button onclick="openLightBox(event)" data-src="' . $image_url . '" class="lightbox" style="cursor:pointer;background:none;border:none;outline:none;"><img src="' . $image_url . '" width="50" height="50" style="object-fit: cover;"></button>';
    // }

    public function column_actions($item)
    {

        return '<button class="button button-primary" type="button" onclick="openPreviewModal(\'' . $item['entry_id'] . '\')">Vizualizează</button>';
        return sprintf('<button class="button button-primary" type="button" onclick="openPreviewModal("%s")">Vizualizează</button>', $item['entry_id']);
    }

    public function extra_tablenav($which)
    {
        if ($which == "top") {
?>
            <div class="alignleft actions">
                <form method="get">
                    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                    <select name="type_filter">
                        <option value="">Toate Tipurile</option>
                        <option value="winner" <?php echo (isset($_REQUEST['type_filter']) && $_REQUEST['type_filter'] == 'winner') ? 'selected' : ''; ?>>Câștigător</option>
                        <option value="reserve" <?php echo (isset($_REQUEST['type_filter']) && $_REQUEST['type_filter'] == 'reserve') ? 'selected' : ''; ?>>Rezervă</option>
                    </select>
                    <select name="prize_won_filter">
                        <option value="">Toate Premiile</option>
                        <option value="1" <?php echo (isset($_REQUEST['prize_won_filter']) && $_REQUEST['prize_won_filter'] == '1') ? 'selected' : ''; ?>>Circuit turistic "Îmbrățișează România"</option>
                        <option value="2" <?php echo (isset($_REQUEST['prize_won_filter']) && $_REQUEST['prize_won_filter'] == '2') ? 'selected' : ''; ?>>Set Măgura</option>
                        <option value="3" <?php echo (isset($_REQUEST['prize_won_filter']) && $_REQUEST['prize_won_filter'] == '3') ? 'selected' : ''; ?>>Rucsac vișiniu</option>
                        <option value="4" <?php echo (isset($_REQUEST['prize_won_filter']) && $_REQUEST['prize_won_filter'] == '4') ? 'selected' : ''; ?>>Rucsac bej</option>
                        <option value="5" <?php echo (isset($_REQUEST['prize_won_filter']) && $_REQUEST['prize_won_filter'] == '5') ? 'selected' : ''; ?>>Rucsac model fluturi</option>

                    </select>
                    <input type="date" min="2025-05-15" max="2025-9-01" name="date_filter" value="<?php echo isset($_REQUEST['date_filter']) ? sanitize_text_field($_REQUEST['date_filter']) : ''; ?>" />
                    <input type="text" name="search" value="<?php echo isset($_REQUEST['search']) ? sanitize_text_field($_REQUEST['search']) : ''; ?>" placeholder="Caută" />
                    <input type="submit" class="button" value="Filtrează">
                </form>
            </div>
<?php
        }
    }
}

// Instanțiem clasa tabelului
$inscrieri_list_table = new Inscrieri_List_Table();
?>
<style>
    .sgs-lightbox {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: 10000000;
        background: #1a1a1a85;
        align-content: center;
        justify-content: center;
        align-items: center;
        display: none;
    }

    .sgs-lightbox button {
        margin-top: 10px;
        margin-right: 10px;
        color: #fff;
        background: none;
        cursor: pointer;
        border: none;
        outline: none;
        position: absolute;
        top: 0;
        right: 0;
    }

    .sgs-lightbox button span {
        font-size: 41px;
        width: 41px;
        height: 41px;
    }

    .sgs-lightbox img {
        max-height: 95vh;
        max-width: 80vw;
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .column-poza_bon {
        max-width: 60px;
        width: 60px;
    }

    .column-metadata {
        width: 300px;
    }

    .entry-preview-modal {
        background-color: rgba(0, 0, 0, 0.5);
        position: fixed;
        top: 0;
        left: 0;
        display: none;
        justify-content: center;
        width: calc(100% - 40px);
        height: calc(100% - 40px);
        padding: 20px;
        overflow: auto;
        z-index: 99999;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #888;
        width: 100%;
        max-width: 600px;
        height: max-content;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header .close {
        font-size: 34px;
    }

    .modal-body img {
        max-height: 400px;
        margin: 0 auto;
        display: block;
    }

    .validate-button {
        color: #fafafa;
        border-radius: 7px;
        background: #00b000;
        font-size: 18px;
        padding: 7px 15px;
        outline: none;
        border: 1px solid #1a1a1a55;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .validate-button:hover {
        background: #00b00095;
    }

    .table-validate-button {
        color: #fafafa;
        border-radius: 4px;
        border: 1px solid #1a1a1a55;
        background: #00b000;
        padding: 3px 10px;
        transition: 0.2s ease;
    }

    .table-validate-button:hover {
        background: #00b00095;
    }

    .entries-status-dot {
        padding: 2px 10px 3px;
        text-align: center;
        color: #fff;
        border-radius: 100px;
        display: block;
        width: max-content;
    }
</style>
<div class="wrap">
    <h2>Inscrieri</h2>
    <br />
    <div>
        <?php


        // Process the data as needed
        // For example, you can print it out
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';

        $inscrieri_list_table->prepare_items();
        // Display the table
        $inscrieri_list_table->display();


        ?>
    </div>
</div>

<div class="entry-preview-modal" id="entry-preview-modal" style="display:none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Vizualizare inscriere</h2>

            <span class="close" onclick="closePreviewModal()">&times;</span>

        </div>
        <div class="modal-body">

        </div>
    </div>
</div>
<div class="entry-preview-modal" id="reserves-preview-modal" style="display:none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Rezerve disponibile </h2>

            <span class="close" onclick="closeReserveSelector()">&times;</span>

        </div>
        <div class="modal-body">

        </div>
    </div>
</div>

<div class="sgs-lightbox" style="display:none;">
    <button onclick="closeLightBox(event)">
        <span class="dashicons dashicons-no-alt"></span>
    </button>
    <img src="" />
</div>



<script>
    const customLightbox = document.querySelector(".sgs-lightbox");

    let isLoading = false;

    function openLightBox(e) {
        e.preventDefault();

        const image = e.currentTarget.dataset.src;
        console.log("open", image);
        customLightbox.style.display = "flex";
        const imgEl = customLightbox.querySelector("img");
        console.log("imgel", imgEl);
        imgEl.setAttribute("src", image);
    }

    function closeLightBox(e) {
        e.preventDefault();
        console.log("close")
        customLightbox.style.display = "none";
        const imgEl = customLightbox.querySelector("img");
        console.log("imgel", imgEl);
        imgEl.setAttribute("src", "");
    }

    function getPrizeById(id) {
        if (id === "1") {
            return 'Circuit turistic "Îmbrățișează România"';
        } else if (id === "2") {
            return "Set Măgura";
        } else if (id === "3") {
            return "Rucsac vișiniu";
        } else if (id === "4") {
            return "Rucsac Bej";
        } else if (id === "5") {
            return "Rucsac Model Fluturi";
        }
        return id;
    }

    function openPreviewModal(id) {
        const modal = document.getElementById('entry-preview-modal');
        modal.style.display = "flex";
        const modalBody = document.querySelector('.modal-body');
        modalBody.innerHTML = '<p>Se încarcă...</p>';
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'get_campaign_entry_data',
                entry_id: id,
                _wpnonce: '<?php echo wp_create_nonce('entry_data'); ?>'
            },
            success: function(response) {
                console.log(response);

                const entry = response?.data?.data?.entry;
                const validation = response?.data?.data?.validation;
                if (!entry) {
                    console.error('No entry data found');
                    return;
                }

                const additionalData = JSON.parse(entry?.additional_data);
                const metadata = JSON.parse(entry?.metadata);
                // Populate the modal with the data
                let output = `
                <h2>ID Inscriere: ${entry?.entry_id}</h2>
                <p><strong>Data inscriere:</strong> ${entry?.created_at}</p>
                <p><strong>Nume:</strong> ${entry?.last_name}</p>
                <p><strong>Prenume:</strong> ${entry?.first_name}</p>
                <p><strong>Telefon:</strong> ${entry?.phone}</p>
                <p><strong>Email:</strong> ${entry?.email}</p>
                ${entry?.type === "winner" || entry?.type === "reserve" ? `
                <p><strong>Tip:</strong> ${entry?.type === "winner" ? "Câștigător" : "Rezervă"}</p>
                <p><strong>Premiu:</strong> ${getPrizeById(entry?.prize_id)}</p>
                ` : ''}
                <br/>
                <h3>Detalii suplimentare</h3>
                <p><strong>Judet:</strong> ${additionalData?.county}</p>
                <p><strong>Localitate:</strong> ${additionalData?.locality}</p>
                <p><strong>Nr. bon:</strong> ${additionalData?.reciep_number}</p>
                <br/>
                <h3>Metadata</h3>
                <p><strong>Adresa IP:</strong> ${metadata?.ip_address}</p>
                <p><strong>User agent:</strong> ${metadata?.user_agent}</p>
                <p><strong>Reffer URL:</strong> ${metadata?.reffer}</p>

                <br/>
                <h3>Poza bonului fiscal</h3>
                <img src="https://api-magura.promoapp.ro/uploads/${additionalData?.reciep_image}" alt="Bon" style="max-width: 100%; height: auto; cursor: pointer;" onclick="openLightBox(event)" data-src="https://api-magura.promoapp.ro/uploads/${additionalData?.reciep_image}" />
                `;

                <?php
                if (current_user_can('manage_options') || current_user_can('can_manage_campaigns')) {
                ?>
                    if (validation === null && entry?.type === "winner") {
                        output += `
                            <div style="margin-top:15px;">
                            <button id="validate-button" class="button button-primary button-large" onclick="validateWinner(${entry.id})">Validează</button>
                            <button id="reject-button" class="button button-secondary button-large" onclick="openReserveSelector(${entry.id})" style="color: red; border: 1px solid #ff1a1a55;">Respinge</button> 
                            </button>
                            </div>
                            `;
                    }

                <?php
                }
                ?>

                modalBody.innerHTML = output;

                // Show the modal

            },
            error: function(error) {
                console.error('Error fetching data:', error);
                alert('Error fetching entry data');
            }
        });
    }

    function closePreviewModal() {
        const modal = document.getElementById('entry-preview-modal');
        modal.style.display = "none";
        const modalBody = document.querySelector('#entry-preview-modal .modal-body');
        modalBody.innerHTML = '';
    }

    function validateWinner(id) {
        if (confirm("Sigur vrei sa validezi acest castigator?") === false) {
            return;
        }
        document.getElementById('validate-button').innerHTML = "Se valideaza...";
        document.getElementById('validate-button').disabled = true;
        document.getElementById('validate-button').style.cursor = "not-allowed";

        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'validate_campaign_winner',
                entry_id: id,
                _wpnonce: '<?php echo wp_create_nonce('entry_data'); ?>'
            },
            success: function(response) {
                console.log(response);
                if (response?.success) {
                    alert("Castigator validat cu succes!");
                    closePreviewModal();
                } else {
                    alert("Eroare la validare");
                }

            },
            error: function(error) {
                console.error('Error fetching data:', error);
                alert('Error fetching entry data');
                document.getElementById('validate-button').innerHTML = "Validează";
                document.getElementById('validate-button').disabled = false;
                document.getElementById('validate-button').style.cursor = "pointer";
            }
        });
    }

    function openReserveSelector(id) {
        const modal = document.getElementById('reserves-preview-modal');
        modal.style.display = "flex";
        const modalBody = document.querySelector('#reserves-preview-modal .modal-body');
        modalBody.innerHTML = '<p>Se încarcă...</p>';
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'get_campaign_entry_reserves',
                entry_id: id,
                _wpnonce: '<?php echo wp_create_nonce('entry_data'); ?>'
            },
            success: function(response) {
                console.log(response);

                const reserves = response?.data?.data;
                console.log("reserves", reserves);

                let output = `
                <form onSubmit="saveSelectedRserve(this.reserve_id.value, ${id}); return false;">
                    <ul>`;

                reserves.forEach(reserve => {
                    output += `
                        <li>
                            <label style="display: flex; gap:10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 5px;">
                                <input type="radio" style="margin-top:7px" name="reserve_id" value="${reserve.id}" />
                                <div>
                                <h4 style="margin: 0; font-size: 16px; font-weight: bold;">
                                ${reserve.last_name} ${reserve.first_name}
                                </h4>
                                <p style="margin: 0; font-size: 14px; color: #555;">
                                ${getPrizeById(reserve.prize_id)} - ${reserve.entry_id} - ${reserve.created_at}
                                </p>
                                
                                </div>
                            </label>
                        </li>`;
                });


                output += `</ul>
                <button type="submit" class="button button-primary large" id="validate-button"  >Selectează</button>
                </form>

               `;

                modalBody.innerHTML = output;

                // Show the modal

            },
            error: function(error) {
                console.error('Error fetching data:', error);
                alert('Error fetching entry data');
            }
        });
    }

    function closeReserveSelector() {
        const modal = document.getElementById('reserves-preview-modal');
        modal.style.display = "none";
        const modalBody = document.querySelector('#reserves-preview-modal .modal-body');
        modalBody.innerHTML = '';
    }

    async function saveSelectedRserve(id, entry_id) {
        if (confirm("Sigur vrei sa selectezi aceasta rezerva?") === false) {
            return;
        }

        console.log("Selected reserve ID:", id, " for entry ID:", entry_id);
        document.getElementById('validate-button').innerHTML = "Se încarcă...";
        document.getElementById('validate-button').disabled = true;
        document.getElementById('validate-button').style.cursor = "not-allowed";

        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'switch_campaign_entry_reserve',
                entry_id: entry_id,
                reserve_id: id,
                _wpnonce: '<?php echo wp_create_nonce('entry_data'); ?>'
            },
            success: function(response) {
                console.log(response);
                if (response?.success) {
                    alert("Rezerva selectata cu succes!");
                    console.log("Rezerva selectata cu succes!");
                    location.reload();
                } else {
                    alert("Eroare la selectarea rezervei");
                }
            },
            error: function(error) {
                console.error('Error fetching data:', error);
                alert('Error fetching entry data');
                document.getElementById('validate-button').innerHTML = "Validează";
                document.getElementById('validate-button').disabled = false;
                document.getElementById('validate-button').style.cursor = "pointer";
            }
        });



    }
</script>