@extends('layouts.app')

@section('content')
<style type="text/css">
    /* All customers... */
    .boxes h3 {
        color: black;
    }

    .boxes ul li {
        list-style: none;
        font-size: 18px;
        font-weight: bold;
    }

    .row.box_par2 {
        margin-top: 100px;
    }

    .row.box_par {
        padding-top: 50px;
    }

    svg {
        height: 20px;
        width: 20px;
    }

    /* End All customers... */
</style>
<h2 class="text-center">Customers</h2>
<div class="container main_head">
    <div class="col-md-3">
        <div class="row box_par">
            <?php

            if (count($customers) > 0) {
                foreach ($customers as $result) {

            ?>
                    <?php
                    $id = $result['id_customer']
                    ?>
                    <div><a href="{{ $domain_url }}/index2_customer?id={{ $result['id_customer']}}&cart={{ $result['id_cart']}}&sum={{ $result['paid_amount']}}" target="_blank">{{ $result['firstname'] . ' ' . $result['lastname']}}</a></div>
            <?php
                }
            }
            ?>
        </div>
    </div>
    <div class="col-md-9">
        <table id="personalinfos" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Sr. no</th>
                    <th>Customer ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($list) > 0) {
                    $counter = 1;
                    foreach ($list as $result) {
                        $result2 = Helper::dbQuery('SELECT * FROM transaction where id_customer="' . $result['id_customer'] . '"');
                        if (count($result2) > 0) {
                            $get_data = $result2[0];
                            if (!empty($get_data)) {
                                $id_cart = $get_data['id_cart'];
                                $sum = $get_data['paid_amount'];
                            } else {
                                $id_cart = '00';
                                $sum = '0';
                            }
                ?>
                            <tr>
                                <td><?php echo $counter; ?></td>
                                <td><?php echo $result['id_customer']; ?></td>
                                <td><a target="_blank" href="{{ $domain_url }}/index2_customer?id=<?php echo $result['id_customer']; ?>&cart=<?php echo $id_cart; ?>&sum=<?php echo $sum; ?>"><?php echo $result['firstname'] . ' ' . $result['lastname']; ?></a></td>
                                <td><?php echo $result['email']; ?></td>
                                <td><?php echo $result['phone']; ?></td>
                            </tr>
                <?php
                            $counter++;
                        }
                    }
                } ?>
            <tbody>
        </table>
    </div>
</div>
<script>
    // All Customers...
    $(function() {
        $("#personalinfos").DataTable();
    });
    // End All Customers...
</script>
@endsection
