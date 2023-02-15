<h3>Shipped Products</h3>
<table id="example4" class="display" style="width:100%">
    <thead>
        <!-- <tr>
	    <th></th>
	    <th>AWB</th>
	    <th>Sent Date</th>
	    <th>Date today</th>
	    <th>Minimum delivery date</th>
	    <th>Maximum delivery date</th>
	    <th>Day in late</th>
	    <th>Integration dhl</th>
	    <th>Integration dhl date</th>
	  </tr> -->
        <tr>
            <th></th>
            <th>Product ID</th>
            <th>Product Image</th>
            <th>Product Title</th>
            <th>Shipped Staus</th>
            <th>Minimum delivery date</th>
            <th>Maximum delivery date</th>
            <th>Day in late</th>
            <th>Integration dhl</th>
            <th>Integration dhl date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $domain_url = env('APP_URL');
        $logos = array(
            'conforama.fr' => asset('logos/conforama.fr.png'),
            'allobebe.fr' => asset('logos/allobebe.fr.png'),
            'leroymerlin.fr' => asset('logos/leroymerlin.fr.png'),
            'kiabi.com' => asset('logos/kiabi.com.png'),
            'tikamoon.com' => asset('logos/tikamoon.com.png'),
            'manomano.fr' => asset('logos/manomano.fr.png'),
            'zalando.fr' => asset('logos/zalando.fr.png'),
            'vente-unique.com' => asset('logos/vente-unique.com.png'),
            'darty.com' => asset('logos/darty_logo.png'),
            'ubaldi.com' => asset('logos/ubaldi_logo.png'),
            'cdiscount.com' => asset('logos/logo-cdiscount.png'),
            'amazon.fr' => asset('logos/amazon-fr-logo.jpg')
        );
        if (count($shippedProducts['products']) > 0) {
            $counter = 1;
            foreach ($shippedProducts['products'] as $result) {
                $logo_url = '';
                if (!empty($result['product_image'])) {
                    $logo_url = $result['product_image'];
                } else {
                    $logo_url = $domain_url . '/freeLogo.jpeg';
                }
        ?>
                <tr>
                    <td></td>
                    <td><?= $result['id_customer'] . " - " . $result['id']; ?></td>
                    <td> <img src="<?= $logo_url ?>" width="100" alt=""> </td>
                    <td><?= $result['title'] ?></td>
                    <td>
                        <select data-id="<?= $result['id']; ?>" class="shipped_status" name="">
                            <option <?php if ($result['shipped_status'] == 1) {
                                        echo "selected";
                                    } ?> value="1">Prêt a être expédié – en préparation</option>
                            <option <?php if ($result['shipped_status'] == 2) {
                                        echo "selected";
                                    } ?> value="2">Pris en charge - expédié</option>
                            <option <?php if ($result['shipped_status'] == 3) {
                                        echo "selected";
                                    } ?> value="3">Arrivé en Israel – en douane</option>
                            <option <?php if ($result['shipped_status'] == 4) {
                                        echo "selected";
                                    } ?> value="4">Arrivé à notre hub de distribution</option>
                            <option <?php if ($result['shipped_status'] == 5) {
                                        echo "selected";
                                    } ?> value="5">En livraison imminente</option>
                        </select>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
        <?php
                $counter++;
            }
        } ?>
    <tbody>
</table>
<script>
    // Shipped Products....
    $(".shipped_status").on("change", function() {
        let status = $(this).val();
        let id = $(this).data("id");
        $.ajax({
            type: "POST",
            url: APP_URL + "/update_shipped_status",
            data: {
                id,
                status
            },
            success: function(data) {
                alert("status updated");
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            },
        });
    });
    // End Shipped Products...
</script>
