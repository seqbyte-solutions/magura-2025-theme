<?php
if (!current_user_can('can_see_analitics')) {
    wp_die(__('You do not have sufficient permissions to access this page.'));
    return;
}

class Castigatori_List_Table extends WP_List_Table
{
    public function get_columns()
    {
        $columns = [
            'entry_uuid' => 'ID',
            'created_at' => 'Data',
            'last_name' => 'Nume',
            'first_name' => 'Prenume',
            'status' => 'Status',
            // 'type' => "Tip",
            'prize' => "Premiu",
            'awb' => "AWB",
            'awb_status' => "Status AWB",
            'actions' => 'Acțiuni',
        ];
        return $columns;
    }

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

        $url = 'https://api-magura.promoapp.ro/api/v1/campaign/entries/validations/paginate';

        $prize_won_filter = isset($_REQUEST['prize_won_filter']) ? absint($_REQUEST['prize_won_filter']) : '';
        $search_filter = isset($_REQUEST['search']) ? sanitize_text_field($_REQUEST['search']) : '';

        // Adaugă parametrii de filtrare la URL
        // $url .= '&per_page=' . $per_page . '&offset=' . $offset;

        $url .= '?page=' . $current_page;
        $url .= '&type=winner';
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

    public function column_status($item)
    {
        if ($item['status'] === "pending") {
            return "<span class='validation-status pending'>În așteptare</span>";
        } else if ($item['status'] === "validated") {
            return "<span class='validation-status validated'>Validat</span>";
        } else if ($item['status'] === "rejected") {
            return "<span class='validation-status rejected'>Respins</span>";
        } else if ($item['status'] === "expired") {
            return "<span class='validation-status rejected'>Expirat</span>";
        }
        return "-";
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

    public function column_poza_bon($item)
    {

        $image_url = 'https://api-magura.promoapp.ro/uploads/' . $item['additional_data']['reciep_image'];
        // return '<img src="'.$image_url.'" />';
        return '<button onclick="openLightBox(event)" data-src="' . $image_url . '" class="lightbox" style="cursor:pointer;background:none;border:none;outline:none;"><img src="' . $image_url . '" width="50" height="50" style="object-fit: cover;"></button>';
    }

    public function column_metadata($item)
    {
        $metadata = $item['metadata'];
        if (empty($metadata)) {
            return "-";
        }
        $metadata = json_decode($metadata, true);

        $output = "<ul>
        <li>IP: " . $metadata['ip_address'] . "</li>
        <li>User Agent: " . $metadata['user_agent'] . "</li>
        <li>Reffer URL: " . $metadata['reffer'] . "</li>
       </ul>";
        return $output;
    }

    public function column_actions($item)
    {
        $entry_id = $item['entry_id'];
        $output = '<div class="actions" style="display: flex; gap: 5px;flex-wrap:wrap;">';
        if (empty($item['awb']) && current_user_can('manage_options') && $item['status'] === "validated") {
            $output .= '<button class="button" type="button" onclick="generateAwb(\'' . $entry_id . '\')" data-entry-id="' . $item['entry_id'] . '">Generează AWB</button>';
        }
        $output .= '<button class="button button-primary" type="button" onclick="openPreviewModal(\'' . $item['entry_uuid'] . '\')">Vizualizează</button>';

        return $output . '</div>';
    }

    public function extra_tablenav($which)
    {
        if ($which == "top") {
?>
            <div class="alignleft actions">
                <form method="get">
                    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                    <select name="prize_won_filter">
                        <option value="">Toate Premiile</option>
                        <option value="1" <?php echo (isset($_REQUEST['prize_won_filter']) && $_REQUEST['prize_won_filter'] == '1') ? 'selected' : ''; ?>>Circuit turistic "Îmbrățișează România"</option>
                        <option value="2" <?php echo (isset($_REQUEST['prize_won_filter']) && $_REQUEST['prize_won_filter'] == '2') ? 'selected' : ''; ?>>Set Măgura</option>
                        <option value="3" <?php echo (isset($_REQUEST['prize_won_filter']) && $_REQUEST['prize_won_filter'] == '3') ? 'selected' : ''; ?>>Rucsac vișiniu</option>
                        <option value="4" <?php echo (isset($_REQUEST['prize_won_filter']) && $_REQUEST['prize_won_filter'] == '4') ? 'selected' : ''; ?>>Rucsac bej</option>
                        <option value="5" <?php echo (isset($_REQUEST['prize_won_filter']) && $_REQUEST['prize_won_filter'] == '5') ? 'selected' : ''; ?>>Rucsac model fluturi</option>

                    </select>

                    <input type="text" name="search" value="<?php echo isset($_REQUEST['search']) ? sanitize_text_field($_REQUEST['search']) : ''; ?>" placeholder="Caută" />
                    <input type="submit" class="button" value="Filtrează">
                </form>
            </div>
<?php
        }
    }
}

$castigatori_list_table = new Castigatori_List_Table();
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
        max-height: 80vh;
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

    .validation-status {
        border-radius: 4px;
        color: #fafafa;
        padding: 2px 5px;
    }

    .validation-status.pending {
        background-color: #f58634;
    }

    .validation-status.validated {
        background-color: #00a859;

    }

    .validation-status.rejected {
        background-color: #ec3237;
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
</style>

<div class="wrap">
    <h2>Statusuri validari</h2>
    <br />
    <div>
        <?php
        $castigatori_list_table->prepare_items();
        // Display the table
        $castigatori_list_table->display();
        ?>
    </div>
</div>

<div class="entry-preview-modal" id="entry-preview-modal" style="display:none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Vizualizare detalii</h2>

            <span class="close" onclick="closePreviewModal()">&times;</span>

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
                const additionalInfo = JSON.parse(validation?.additional_info);
                let additionalInfo_output = '';
                if (additionalInfo !== null) {
                    additionalInfo_output = `<h3>Detalii livrare</h3>
                <p><strong>CNP:</strong> ${additionalInfo?.cnp}</p>
                <p><strong>Nume:</strong> ${additionalInfo?.last_name}</p>
                <p><strong>Prenume:</strong> ${additionalInfo?.first_name}</p>
                <p><strong>Telefon:</strong> ${additionalInfo?.phone}</p>
                <p><strong>Email:</strong> ${additionalInfo?.email}</p>
                <p><strong>Județ:</strong> ${additionalInfo?.county}</p>
                <p><strong>Localitate:</strong> ${additionalInfo?.locality}</p>
                <p><strong>Adresa:</strong> ${additionalInfo?.address}</p>
                <p><strong>Cod poștal:</strong> ${additionalInfo?.postal_code}</p>
                <br/>`;
                }
                const metadata = JSON.parse(entry?.metadata);
                // Populate the modal with the data
                let output = `
                <h2>ID Inscriere: ${entry?.entry_id}</h2>
            ${additionalInfo_output}
                <h3>Detalii inscriere</h3>
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
                if (current_user_can('manage_options')) {
                ?>
                    if (validation === null && entry?.type === "winner") {
                        // output += `
                        //     <div style="margin-top:15px;">
                        //     <button class="validate-button" onclick="validateWinner(${entry.id})">Valideaza</button>
                        //     </div>
                        //     `;
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
        const modalBody = document.querySelector('.modal-body');
        modalBody.innerHTML = '';
    }
</script>