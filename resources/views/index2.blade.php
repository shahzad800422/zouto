@extends('layouts.app')

@section('content')
<style type="text/css">
    /* Index2 ... */
    .row {
        margin: 0;
    }

    .col-md-12.boxes {
        border: 2px solid #000;
        display: flex;
        justify-content: center;
        padding: 60px;
        border-radius: 20px;
        min-height: 285px;
        margin-bottom: 10px !important;
    }

    .container.main_head {
        padding-top: 60px;
    }

    h4.text-center.pt-1 {
        font-weight: bold;
    }

    /* End Index2 ... */
</style>
<div class="container main_head">
    <div class="row box_par">
        <div>
            <div class="col-md-4">
                <div class="col-md-12 boxes" style="margin: unset">
                    <img src="{{ asset('images/new_index/Screenshot_1.png') }}">
                </div>
                <h4 class="text-center pt-1"><a href="<?php echo $domain_url; ?>/all_customers" style="color: #000">CUSTOMERS ACCOUNT</h4></a>
            </div>
            <div class="col-md-8">
                <div class="col-md-12 boxes" style="margin: unset;display: block;padding: 40px;">
                    <?php
                    // $sql = "SELECT * FROM customer_product_wishlist INNER JOIN shopify_customers on (shopify_customers.id_customer = customer_product_wishlist.id_customer) WHERE customer_product_wishlist.status = 2 GROUP BY customer_product_wishlist.id_customer";
                    if (count($customers) > 0) {
                        $counter = 0;
                        foreach ($customers as $result) {
                            if ($counter < 5) { ?>
                                <div class="row" style="display: flex;width: 100%;justify-content: space-between;">
                                    <div class="col-md-5">
                                        <h4><a href="{{ $domain_url }}/index2_customer?id=<?php echo $result['id_customer']; ?>&cart=<?php echo $result['id_cart']; ?>&sum=<?php echo $result['paid_amount']; ?>" target="_blank" style="color: black"><?php echo $result['firstname'] . ' ' . $result['lastname'] . ' ' . $result['payment_type']; ?></a></h4>
                                    </div>
                                    <div class="col-md-3">
                                        <h4><?php echo $result['paid_amount'] . ' € ' . $result['payment_method']; ?></h4>
                                    </div>
                                </div> <?php
                                        $counter++;
                                    }
                                }
                            } ?>
                    <!--<div class="row" style="display: flex;width: 100%;justify-content: space-between;">-->
                    <!--    <div class="col-md-3">-->
                    <!--        <h4>Mikhael</h4>-->
                    <!--    </div>-->
                    <!--    <div class="col-md-3">-->
                    <!--        <h4>100</h4>-->
                    <!--    </div>-->
                    <!-- </div>-->
                </div>
            </div>
        </div>
        <div class="col-md-8 table">

        </div>

    </div>
    <div class="row box_par">
        <div class="col-md-4">
            <div class="col-md-12 boxes" style="margin-left: 0">
                <img src="{{ asset('images/new_index/Screenshot_2.png') }}">
            </div>
            <h4 class="text-center pt-1"><a href="<?php echo $domain_url; ?>/shipment_new" style="color: #000">CREATE A SHIPMENT</a></h4>
        </div>
        <div class="col-md-4">
            <div class="col-md-12 boxes">
                <img src="{{ asset('images/new_index/Screenshot_3.png') }}">
            </div>
            <h4 class="text-center pt-1"><a target="_blank" href="<?php echo $domain_url; ?>/seller" style="color: #000">ZOUTO CLUB</a></h4>
        </div>
        <div class="col-md-4">
            <div class="col-md-12 boxes">
                <img src="{{ asset('images/new_index/Screenshot_4.png') }}">
            </div>
            <h4 class="text-center pt-1">MAINTENENCE</h4>
        </div>
    </div>
</div>

@endsection
