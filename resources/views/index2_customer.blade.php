@extends('layouts.app')

@section('content')
<style type="text/css">
    /* index2_customer */
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

    /* End index2_customer */
</style>
<h2 class="text-center"><?php echo @$get_data['firstname'] . ' ' . @$get_data['lastname']; ?>, <?php echo @$get_data['city']; ?></h2>
<div class="container main_head">
    <div class="row box_par">
        <div class="col-md-4 boxes" style="margin-left: 0">
            <h3><a href="{{ $domain_url }}/shipment_new_with_user?id=<?php echo $_GET['id']; ?>&cart=<?php echo $_GET['cart']; ?>" style="color: #000"><?php echo @$get_count['total']; ?> articles are pending</a></h3>
            <ul>
                <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <title>Artboard-9</title>
                        <g id="Right-3" data-name="Right">
                            <path d="M21.707,11.293l-7-7A1,1,0,0,0,13,5V8H3A1,1,0,0,0,2,9v6a1,1,0,0,0,1,1H13v3a1,1,0,0,0,1.707.707l7-7A1,1,0,0,0,21.707,11.293ZM15,16.586V15a1,1,0,0,0-1-1H4V10H14a1,1,0,0,0,1-1V7.414L19.586,12Z" style="fill:#1c1b1e" />
                        </g>
                    </svg><?php echo count($ready_count2) ?> bought successful</li>
                <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <title>Artboard-9</title>
                        <g id="Right-3" data-name="Right">
                            <path d="M21.707,11.293l-7-7A1,1,0,0,0,13,5V8H3A1,1,0,0,0,2,9v6a1,1,0,0,0,1,1H13v3a1,1,0,0,0,1.707.707l7-7A1,1,0,0,0,21.707,11.293ZM15,16.586V15a1,1,0,0,0-1-1H4V10H14a1,1,0,0,0,1-1V7.414L19.586,12Z" style="fill:#1c1b1e" />
                        </g>
                    </svg><?php echo count($matchh_count) ?> are waiting action</li>
                <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <title>Artboard-9</title>
                        <g id="Right-3" data-name="Right">
                            <path d="M21.707,11.293l-7-7A1,1,0,0,0,13,5V8H3A1,1,0,0,0,2,9v6a1,1,0,0,0,1,1H13v3a1,1,0,0,0,1.707.707l7-7A1,1,0,0,0,21.707,11.293ZM15,16.586V15a1,1,0,0,0-1-1H4V10H14a1,1,0,0,0,1-1V7.414L19.586,12Z" style="fill:#1c1b1e" />
                        </g>
                    </svg><?php echo count($ready_count) ?> ready to be ship</li>
                <!--<li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>Artboard-9</title><g id="Right-3" data-name="Right"><path d="M21.707,11.293l-7-7A1,1,0,0,0,13,5V8H3A1,1,0,0,0,2,9v6a1,1,0,0,0,1,1H13v3a1,1,0,0,0,1.707.707l7-7A1,1,0,0,0,21.707,11.293ZM15,16.586V15a1,1,0,0,0-1-1H4V10H14a1,1,0,0,0,1-1V7.414L19.586,12Z" style="fill:#1c1b1e"/></g></svg>5 are unavailable</li>-->
            </ul>
        </div>
        <div class="col-md-4 boxes">
            <h3><a href="{{ $domain_url }}/wallet_new?id_customer=<?php echo $_GET['id']; ?>&cart=<?php echo $_GET['cart']; ?>&sum=<?php echo number_format($pr, 2); ?>" style="color: #000"><?php echo number_format($wallet_amt, 2); ?>€ in wallet</a></h3>
            <ul>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <title>Artboard-9</title>
                        <g id="Right-3" data-name="Right">
                            <path d="M21.707,11.293l-7-7A1,1,0,0,0,13,5V8H3A1,1,0,0,0,2,9v6a1,1,0,0,0,1,1H13v3a1,1,0,0,0,1.707.707l7-7A1,1,0,0,0,21.707,11.293ZM15,16.586V15a1,1,0,0,0-1-1H4V10H14a1,1,0,0,0,1-1V7.414L19.586,12Z" style="fill:#1c1b1e" />
                        </g>
                    </svg>180€ in simulator
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <title>Artboard-9</title>
                        <g id="Right-3" data-name="Right">
                            <path d="M21.707,11.293l-7-7A1,1,0,0,0,13,5V8H3A1,1,0,0,0,2,9v6a1,1,0,0,0,1,1H13v3a1,1,0,0,0,1.707.707l7-7A1,1,0,0,0,21.707,11.293ZM15,16.586V15a1,1,0,0,0-1-1H4V10H14a1,1,0,0,0,1-1V7.414L19.586,12Z" style="fill:#1c1b1e" />
                        </g>
                    </svg>150€ in shipment pricebox
                </li>
            </ul>
        </div>
        <div class="col-md-4 boxes">
            <h3>1 order by the way</h3>
            <ul>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <title>Artboard-9</title>
                        <g id="Right-3" data-name="Right">
                            <path d="M21.707,11.293l-7-7A1,1,0,0,0,13,5V8H3A1,1,0,0,0,2,9v6a1,1,0,0,0,1,1H13v3a1,1,0,0,0,1.707.707l7-7A1,1,0,0,0,21.707,11.293ZM15,16.586V15a1,1,0,0,0-1-1H4V10H14a1,1,0,0,0,1-1V7.414L19.586,12Z" style="fill:#1c1b1e" />
                        </g>
                    </svg>789456123
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <title>Artboard-9</title>
                        <g id="Right-3" data-name="Right">
                            <path d="M21.707,11.293l-7-7A1,1,0,0,0,13,5V8H3A1,1,0,0,0,2,9v6a1,1,0,0,0,1,1H13v3a1,1,0,0,0,1.707.707l7-7A1,1,0,0,0,21.707,11.293ZM15,16.586V15a1,1,0,0,0-1-1H4V10H14a1,1,0,0,0,1-1V7.414L19.586,12Z" style="fill:#1c1b1e" />
                        </g>
                    </svg>
                </li>
            </ul>
        </div>
    </div>
    <div class="row box_par2">
        <div class="col-md-4 boxes" style="margin-left: 0">
            <h3><a target="_blank" href="{{ $domain_url }}/wishlist?id=<?php echo $_GET['id']; ?>&cart=<?php echo $_GET['cart']; ?>&sum=<?php echo @$_GET['sum']; ?>" style="color: #000"><?php echo count($result3) ?> refrences in wishlist</a></h3>
            <!--<h3><a target="_blank" href="#" style="color: #000"><?php echo $wgt; ?> in simulator</a></h3>-->
            <ul>
                <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <title>Artboard-9</title>
                        <g id="Right-3" data-name="Right">
                            <path d="M21.707,11.293l-7-7A1,1,0,0,0,13,5V8H3A1,1,0,0,0,2,9v6a1,1,0,0,0,1,1H13v3a1,1,0,0,0,1.707.707l7-7A1,1,0,0,0,21.707,11.293ZM15,16.586V15a1,1,0,0,0-1-1H4V10H14a1,1,0,0,0,1-1V7.414L19.586,12Z" style="fill:#1c1b1e" />
                        </g>
                    </svg><?php echo number_format(@$wish_price, 2); ?>€ in buy list</li>
                <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <title>Artboard-9</title>
                        <g id="Right-3" data-name="Right">
                            <path d="M21.707,11.293l-7-7A1,1,0,0,0,13,5V8H3A1,1,0,0,0,2,9v6a1,1,0,0,0,1,1H13v3a1,1,0,0,0,1.707.707l7-7A1,1,0,0,0,21.707,11.293ZM15,16.586V15a1,1,0,0,0-1-1H4V10H14a1,1,0,0,0,1-1V7.414L19.586,12Z" style="fill:#1c1b1e" />
                        </g>
                    </svg><?php echo number_format(@$tax, 2); ?>€ in shipment pricebox</li>
                <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <title>Artboard-9</title>
                        <g id="Right-3" data-name="Right">
                            <path d="M21.707,11.293l-7-7A1,1,0,0,0,13,5V8H3A1,1,0,0,0,2,9v6a1,1,0,0,0,1,1H13v3a1,1,0,0,0,1.707.707l7-7A1,1,0,0,0,21.707,11.293ZM15,16.586V15a1,1,0,0,0-1-1H4V10H14a1,1,0,0,0,1-1V7.414L19.586,12Z" style="fill:#1c1b1e" />
                        </g>
                    </svg><?php echo number_format(@$exp, 2); ?>€ in simulator</li>
                <!--<li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>Artboard-9</title><g id="Right-3" data-name="Right"><path d="M21.707,11.293l-7-7A1,1,0,0,0,13,5V8H3A1,1,0,0,0,2,9v6a1,1,0,0,0,1,1H13v3a1,1,0,0,0,1.707.707l7-7A1,1,0,0,0,21.707,11.293ZM15,16.586V15a1,1,0,0,0-1-1H4V10H14a1,1,0,0,0,1-1V7.414L19.586,12Z" style="fill:#1c1b1e"/></g></svg><?php echo number_format(@$wish_price, 2); ?>€ articles </li>-->
                <!--<li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>Artboard-9</title><g id="Right-3" data-name="Right"><path d="M21.707,11.293l-7-7A1,1,0,0,0,13,5V8H3A1,1,0,0,0,2,9v6a1,1,0,0,0,1,1H13v3a1,1,0,0,0,1.707.707l7-7A1,1,0,0,0,21.707,11.293ZM15,16.586V15a1,1,0,0,0-1-1H4V10H14a1,1,0,0,0,1-1V7.414L19.586,12Z" style="fill:#1c1b1e"/></g></svg><?php echo @$wgt; ?>kg in simulator</li>-->
            </ul>
        </div>
        <div class="col-md-4 boxes" style="margin-left: 0;text-align: center;border: 2px solid #000;border-radius: 30px;padding: 20px;">
            <a href="{{ $domain_url }}/matching?id=<?php echo $_GET['id']; ?>&cart=<?php echo $_GET['cart']; ?>"><img src="{{ $domain_url }}/images/new_index/matching.png"></a>
        </div>
    </div>
</div>
<div class="col-md-12" style="text-align: center;padding: 30px 0;font-size: 18px;font-weight: bold;">
    <a href="{{ $domain_url }}/index_new">
        < arrière</a>
</div>
@endsection
