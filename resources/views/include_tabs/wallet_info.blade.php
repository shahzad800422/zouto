<style>
    /* Wallet Info Blade... */
    div#myModal {
        overflow: auto;
    }

    .btn-delete,
    .btn-paid,
    .btn-parcel,
    .btn-join-parcel,
    .btn-supp,
    .btn-hs,
    .btn-arc {
        margin-bottom: 10px;
        display: none;
    }

    .truncate {
        width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
    }

    .product_information .row {
        display: flex;
        margin: auto;
        gap: 10px;
        align-items: center;
    }

    .select_div {
        text-align: center;
        width: 30%;
        display: flex;
        margin-left: auto;
        align-items: center;
        margin-bottom: 10px;
    }

    @media (min-width: 1200px) {
        .container {
            width: 100%;
        }
    }

    /* End Wallet Info Blade... */
</style>
<h3>Wallet Info </h3>
<!--<button type="button" class="btn btn-delete" name="button">Delete selected data</button>-->
<!--<button type="button" class="btn btn-paid" name="button">Mark Paid selected</button>-->
<!--<button type="button" class="btn btn-parcel" name="button">Create Parcel</button>-->
<!--<button type="button" class="btn btn-join-parcel" name="button">Join Parcel</button>-->
<!--<button type="button" class="btn btn-supp" name="button">Update Supplier Tracking</button>-->
<!--<button type="button" class="btn btn-hs" name="button">Update HS Code</button>-->
<!--<button type="button" class="btn btn-arc" name="button">Archive</button>-->

<table id="example24" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Cart ID</th>
            <th>Ajouter</th>
            <th>Dépense client</th>
            <th>Remboursement client</th>
            <th>Date</th>
        </tr>
        </th>
    </thead>
    <tbody>
        <?php

        if (count($walletInfo['list']) > 0) {
            foreach ($walletInfo['list'] as $result) {
        ?>
                <tr>
                    <td><?php echo $result['id_cart']; ?></td>
                    <td><?php echo $result['ajouter']; ?></td>
                    <td><?php echo $result['de_client']; ?></td>
                    <td><?php echo $result['re_client']; ?></td>
                    <td><?php echo $result['transaction_date']; ?></td>
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>
