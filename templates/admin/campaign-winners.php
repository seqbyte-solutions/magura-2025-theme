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
            'entry_id' => 'ID',
            'created_at' => 'Data',
            'last_name' => 'Nume',
            'first_name' => 'Prenume',
            'phone' => 'Telefon',
            'email' => 'Email',
            'status' => 'Status',
            // 'type' => "Tip",
            'prize' => "Premiu",
            'poza_bon' => 'Imagine',
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
        $url .= '&type=winner';
        if (!empty($prize_won_filter)) {
            $url .= '&prize=' . $prize_won_filter;
        }
        if (!empty($date_filter)) {
            $url .= '&date=' . $date_filter;
        }
        if (!empty($search_filter)) {
            $url .= '&search=' . $search_filter;
        }        // add header X-API-KEY
        $headers = [
            'X-API-KEY' => defined('MAGURA_API_KEY') ? MAGURA_API_KEY : get_option('magura_api_key', 'tUBP2HIACXBvhc6LD47cPQrX7YSk4iBEn7prR7GmtbgOSPN1XtZEMR9u7g65N57OoJx2IEWdCJeV2EJTl9MYH3CL8Q5njzMqqvjRX7b23AOQjhEauLuRvbXT1xXb2qQI'),
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
        $actions = array(
            'edit' => sprintf('<button value="%s" onclick="openValidateModal("%s")">Vezi detalii</button>', $_REQUEST['page'], $item['entry_id'], $item['entry_id']),
            'reserve' => sprintf('<button onclick="openReserveModal(%s)">Înlocuieste cu o rezervă</button>',  $item['entry_id']),
        );
        return $this->row_actions($actions);
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
                    <input type="date" min="2025-05-15" max="2025-9-01" name="date_filter" value="<?php echo isset($_REQUEST['date_filter']) ? sanitize_text_field($_REQUEST['date_filter']) : ''; ?>" />
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
</style>

<div class="wrap">
    <h2>Castigatori</h2>
    <br />
    <div>
        <?php
            $castigatori_list_table->prepare_items();
       
            $castigatori_list_table->display();
        ?>
    </div>
</div>


<div class="sgs-lightbox" style="display:none;">
    <button onclick="closeLightBox(event)">
        <span class="dashicons dashicons-no-alt"></span>
    </button>
    <img src="" />
</div>

<div class="winner-modal" style="display:none;">
    <button onclick="closeWinnerModal(event)">
        <span class="dashicons dashicons-no-alt"></span>
    </button>
        <h2>Detalii câștigător</h2>
        <div class="winner-details"></div>
    </div>

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

    function closeWinnerModal(e){
        e.preventDefault();
        console.log("close")
        const winnerModal = document.querySelector(".winner-modal");
        winnerModal.style.display = "none";
        const winnerDetails = winnerModal.querySelector(".winner-details");
        winnerDetails.innerHTML = "";
    }
</script>