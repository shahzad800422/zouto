<?php

namespace App\Http\Controllers;

use Helper;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Archived Products...
        $res_arr = Helper::dbQuery("SELECT * FROM customer_product_wishlist INNER JOIN shopify_customers on (shopify_customers.id_customer = customer_product_wishlist.id_customer) WHERE customer_product_wishlist.status = 2 GROUP BY customer_product_wishlist.id_customer");
        $data['archivedProducts']['customers'] = $res_arr;

        $res_arr = Helper::dbQuery("SELECT shopify_customers.firstname, shopify_customers.lastname, customer_product_wishlist.* FROM customer_product_wishlist INNER JOIN shopify_customers on (shopify_customers.id_customer = customer_product_wishlist.id_customer) WHERE customer_product_wishlist.status = 2 AND is_archived IS NOT NULL GROUP BY customer_product_wishlist.id");
        $data['archivedProducts']['products'] = $res_arr;
        // End Archived Products...

        // In Stock Products...
        $res_arr = Helper::dbQuery("SELECT * FROM customer_product_wishlist INNER JOIN shopify_customers on (shopify_customers.id_customer = customer_product_wishlist.id_customer) WHERE customer_product_wishlist.status = 1 and customer_product_wishlist.instock = 1 GROUP BY customer_product_wishlist.id_customer");
        $data['inStockProducts']['customers'] = $res_arr;

        $res_arr = Helper::dbQuery('SELECT * FROM customer_product_wishlist WHERE status = 1 and instock = 1 AND is_archived IS NULL ORDER BY `customer_product_wishlist`.`id` DESC');
        $data['inStockProducts']['products'] = $res_arr;
        // End In Stock Products...

        // Wishlist Products...
        $res_arr = Helper::dbQuery("SELECT * FROM customer_product_wishlist INNER JOIN shopify_customers on (shopify_customers.id_customer = customer_product_wishlist.id_customer) WHERE customer_product_wishlist.status = 2 GROUP BY customer_product_wishlist.id_customer");
        $data['wishlistProducts']['customers'] = $res_arr;

        $res_arr = Helper::dbQuery("SELECT shopify_customers.firstname, shopify_customers.lastname, customer_product_wishlist.* FROM customer_product_wishlist INNER JOIN shopify_customers on (shopify_customers.id_customer = customer_product_wishlist.id_customer) WHERE customer_product_wishlist.status = 2 AND customer_product_wishlist.is_archived IS NULL GROUP BY customer_product_wishlist.id");
        $data['wishlistProducts']['products'] = $res_arr;

        $res_arr = Helper::dbQuery("SELECT * FROM customer_product_wishlist WHERE parcel_number IS NOT NULL GROUP BY parcel_number");
        $data['wishlistProducts']['parcels'] = $res_arr;

        // End Wishlist Products...
        // Shipped Products...
        $res_arr = Helper::dbQuery('SELECT * FROM customer_product_wishlist WHERE status = 4 AND is_archived IS NULL');
        $data['shippedProducts']['products'] = $res_arr;

        // End Shipped Products...
        // Upload CSV...
        $res_arr = Helper::dbQuery("SELECT * FROM shipping_weight_prices");
        $data['uploadCSV']['prices'] = $res_arr;

        // End Upload CSV...
        // Customers Info...
        $res_arr = Helper::dbQuery('SELECT * FROM shopify_customers');
        $data['customersInfo']['list'] = $res_arr;

        // End Customers Info...
        // Colisreal Parcel...
        $res_arr = Helper::dbQuery('SELECT * FROM customer_product_wishlist WHERE parcel_number IS NOT NULL AND parcel_for=1 AND is_archived IS NULL GROUP BY parcel_number');
        $data['colisrealParcel']['products'] = $res_arr;

        // End Colisreal Parcel...
        // Personal Parcel...
        $res_arr = Helper::dbQuery('SELECT * FROM customer_product_wishlist WHERE parcel_number IS NOT NULL AND parcel_for=2 AND is_archived IS NULL GROUP BY parcel_number');
        $data['personalParcel']['products'] = $res_arr;
        // End Personal Parcel...
        // Wallet Info...

        $res_arr = Helper::dbQuery("SELECT * FROM transaction_wallet_info ORDER BY id DESC");
        $data['walletInfo']['list'] = $res_arr;

        // End Wallet Info...
        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Dashboard';
        return view('index', $data);
    }
    public function index2()
    {
        // Customers...
        $res_arr = Helper::dbQuery("SELECT * FROM transaction INNER JOIN shopify_customers on (shopify_customers.id_customer = transaction.id_customer) GROUP BY transaction.id ORDER BY transaction.id DESC");
        $data['customers'] = $res_arr;
        $data['domain_url'] = env('APP_URL');
        // End Customers...
        $data['title'] = 'Dashboard';
        return view('index2', $data);
    }
    public function all_customers()
    {
        // Customers...
        $res_arr = Helper::dbQuery("SELECT * FROM transaction INNER JOIN shopify_customers on (shopify_customers.id_customer = transaction.id_customer) GROUP BY transaction.id_cart ORDER BY transaction.id DESC");
        $data['customers'] = $res_arr;
        $data['list'] = Helper::dbQuery("SELECT * FROM shopify_customers");
        $data['domain_url'] = env('APP_URL');
        // End Customers...
        $data['title'] = 'Customers';
        return view('all_customers', $data);
    }
    public function index2_customer()
    {
        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Customer Details';

        //Custom Query
        $id = $_GET['id'];
        $result_p = Helper::dbQuery("SELECT * FROM transaction WHERE id_customer = $id ORDER BY id DESC");

        $pr = 0;
        foreach ($result_p as $rows_p) {
            $ct = $rows_p['id_cart'];
            $result_w = Helper::dbQuery("SELECT * FROM transaction_wallet_info WHERE id_cart = $ct ORDER BY id DESC");

            if ($rows_p['payment_type'] == 'products') {
                $pr += $rows_p['paid_amount'];
            }
            foreach ($result_w as $rows_w) {
                if (!empty($rows_w['de_client'])) {
                    $pr -= (float) $rows_w['de_client'];
                }
                if (!empty($rows_w['re_client'])) {
                    $pr += (float) $rows_w['re_client'];
                }
            }
        }
        $data['pr'] = $pr;
        $cart = $_GET['cart'];
        $matchh_count = Helper::dbQuery("SELECT shopify_customers.firstname, shopify_customers.lastname, customer_product_wishlist.* FROM customer_product_wishlist INNER JOIN shopify_customers on (shopify_customers.id_customer = customer_product_wishlist.id_customer) INNER JOIN customer_cart on (customer_cart.id_customer = customer_product_wishlist.id_customer) WHERE customer_product_wishlist.status = 2 AND customer_product_wishlist.is_archived IS NULL AND customer_product_wishlist.parcel_number IS NULL AND customer_cart.id_cart=$cart GROUP BY customer_product_wishlist.id");
        $data['matchh_count'] = $matchh_count;

        $ready_count = Helper::dbQuery("SELECT shopify_customers.firstname, shopify_customers.lastname, customer_product_wishlist.* FROM customer_product_wishlist INNER JOIN shopify_customers on (shopify_customers.id_customer = customer_product_wishlist.id_customer) INNER JOIN customer_cart on (customer_cart.id_customer = customer_product_wishlist.id_customer) WHERE customer_product_wishlist.parcel_status = 2 AND customer_product_wishlist.is_archived IS NULL AND customer_cart.id_cart=$cart GROUP BY customer_product_wishlist.id");
        $data['ready_count'] = $ready_count;

        $ready_count2 = Helper::dbQuery("SELECT shopify_customers.firstname, shopify_customers.lastname, customer_product_wishlist.* FROM customer_product_wishlist INNER JOIN shopify_customers on (shopify_customers.id_customer = customer_product_wishlist.id_customer) INNER JOIN customer_cart on (customer_cart.id_customer = customer_product_wishlist.id_customer) WHERE customer_product_wishlist.parcel_number IS NOT NULL AND customer_product_wishlist.is_archived IS NULL AND customer_cart.id_cart=$cart GROUP BY customer_product_wishlist.id");
        $data['ready_count2'] = $ready_count2;

        // print_r($_GET['id']);die;
        $get_data = Helper::dbQuery('SELECT * FROM shopify_customers where id_customer="' . $_GET['id'] . '"');
        $data['get_data'] = $get_data;

        $get_count = Helper::dbQuery('SELECT COUNT(*) as total FROM customer_cart where id_cart="' . $_GET['cart'] . '"');
        $data['get_count'] = $get_count;

        $result3 = Helper::dbQuery('SELECT * FROM customer_product_wishlist where id_customer="' . $_GET['id'] . '" AND status = 1 and instock = 1 AND is_archived IS NULL');
        $data['result3'] = $result3;

        $wish_price_n = 0;
        $tax = 0;
        $exp = 0;
        foreach ($result3 as $res) {
            $wish_price_n += (float) $res['price'] * $res['qty'];

            $get_data_d = Helper::dbQuery('SELECT * FROM seller where seller_name LIKE  "%' . $res['source'] . '%"');

            // $discounted_price = 0;
            if (!empty($get_data_d)) {
                $get_data_d = $get_data_d[0];
                if ($get_data_d['discount_type'] == 'Percentage') {
                    $pro_price = ($res['price'] * $res['qty']);
                    $discounted_price = ($get_data_d['discount_value'] / 100) * $pro_price;
                    $dis_p = ($get_data_d['discount_value'] / 100) * $res['price'];
                } else {
                    $pro_price = ($res['price'] * $res['qty']);
                    $discounted_price = $get_data_d['discount_value'];
                }
            } else {
                $discounted_price = 0;
            }
            $tax += ((((float) $res['price'] * $res['qty']) + (((float) $res['price'] * $res['qty']) * 0.17)) - $discounted_price) - ((float) $res['price'] * $res['qty']);
            $exp += $res['selected_shipping_price'];
        }

        $data['tax'] = $tax;

        $cart = $_GET['cart'];
        $res_si = Helper::dbQuery("SELECT customer_product_wishlist.* FROM customer_product_wishlist INNER JOIN customer_cart on (customer_cart.id_customer = customer_product_wishlist.id_customer) WHERE customer_product_wishlist.is_archived IS NULL AND customer_product_wishlist.status = 1 and customer_product_wishlist.instock = 1  AND customer_cart.id_cart=$cart GROUP BY customer_product_wishlist.master_weight");

        $wgt = 0;
        foreach ($res_si as $res_s) {
            if (!empty($res_s['master_weight'])) {
                $wgt += (float) $res_s['master_weight'];
            } else {
                $wgt += (float) $res_s['weight'];
            }
        }
        //End Custom Query
        $data['wgt'] = $wgt;


        //Custom Query 2//
        $id = $_GET['id'];
        $result_pp = Helper::dbQuery("SELECT * FROM transaction WHERE id_customer = $id ORDER BY id DESC");

        $wallet_amount = 0;
        $wallet_amount_n = 0;
        $wallet_amt = 0;
        foreach ($result_pp as $rows) {
            $wallet_amount = (float) chop($rows['paid_amount'], '€');
            $wallet_amount_n += (float) chop($rows['paid_amount'], '€');
            $id_cart = $rows['id_cart'];
            $result_parcel = Helper::dbQuery("SELECT * FROM customer_product_wishlist INNER JOIN customer_cart on (customer_cart.id_product = customer_product_wishlist.id) where customer_cart.id_cart=$id_cart and customer_product_wishlist.is_archived IS NULL GROUP BY master_weight");

            $parcel_weight = 0;
            foreach ($result_parcel as $resss) {
                if ($resss['master_weight'] == '1') {
                    $parcel_weight += (float) $resss['master_weight'];
                } else {
                    $parcel_weight += (float) chop($resss['master_weight'], '(1)');
                }
            }
            //  print_r($parcel_weight);die;
            $result_n = Helper::dbQuery("SELECT * FROM customer_product_wishlist INNER JOIN customer_cart on (customer_cart.id_product = customer_product_wishlist.id) where customer_cart.id_cart=$id_cart and customer_product_wishlist.is_archived IS NULL");

            $count = 0;
            $wish_price = 0;
            $exp = 0;
            $titles = '';
            $discounted_price = 0;
            $discc = 0;
            foreach ($result_n as $ress) {
                $wish_price += (float) $ress['price'] * $ress['qty'];
                $titles .= str_replace('"', '', $ress['title']) . ' x ' . $ress['qty'] . ' - ' . (float) $ress['price'] * $ress['qty'] . '<br><br>';
                $get_result_d = Helper::dbQuery('SELECT * FROM seller where seller_name LIKE  "%' . $ress['source'] . '%"');

                if (!empty($get_data_d)) {
                    if ($get_data_d['discount_type'] == 'Percentage') {
                        $pro_price = ($ress['price'] * $ress['qty']);
                        $discounted_price += ($get_data_d['discount_value'] / 100) * $pro_price;
                        $dis_p = ($get_data_d['discount_value'] / 100) * $ress['price'];
                    } else {
                        $pro_price = ($ress['price'] * $ress['qty']);
                        $discounted_price += $get_data_d['discount_value'];
                    }
                } else {
                    $discounted_price += 0;
                }
                $pro_price2 = ($ress['price'] * $ress['qty']);
                $discc += number_format(($pro_price2 * 17) / 100, 2);
                // $tax += (($wish_price) - $discounted_price + ($wish_price * 0.17)) - ($wish_price);
                $exp += $ress['selected_shipping_price'];
                $count++;
            }

            $data['wish_price'] = $wish_price;
            $data['exp'] = $exp;
            $data['discc'] = $discc;
            $data['discounted_price'] = $discounted_price;

            $locked_status = $rows['locked_status'];
            if ($locked_status == '1') {
                $class = 'lockedd';
            } else {
                $class = '';
            }

            if ($ress['selected_shipping'] == 'colisrael_price') {
                //  $shipp_price = $piano;
                $selected_shippp = 'Piano';
            } else if ($ress['selected_shipping'] == 'dhl_price') {
                //  $shipp_price = $colisrael_price;
                $selected_shippp = 'Rapido';
            } else {
                //  $shipp_price = $dhl_price;
                $selected_shippp = 'Expresso';
            }

            $id_cart = $rows['id_cart'];
            $result_m = Helper::dbQuery("SELECT * FROM matching_cost WHERE id_cart = $id_cart ORDER BY id DESC");

            $achats = 0;
            foreach ($result_m as $rows_m) {
                $achats += (float) $rows_m['cost'];
            }


            $result_e = Helper::dbQuery("SELECT * FROM transaction_wallet_info WHERE id_cart = $id_cart ORDER BY id DESC");

            $pro_ids = [];
            foreach ($result_e as $rows_e) {
                if (!empty($rows_e['products'])) {
                    $pro_ids[] = $rows_e['products'];
                }
            }
            $product_ids = implode(',', $pro_ids);
            if (empty($product_ids)) {
                continue;
            }

            $result_c = Helper::dbQuery("SELECT * FROM customer_product_wishlist WHERE id IN ($product_ids) and is_archived IS NULL GROUP BY parcel_number ORDER BY id DESC");

            $parcels = '';
            $parcel_number = [];
            // $parcel_pro = '';
            $parcel_html = '';
            $wish_disc = 0;
            $wish_disc2 = 0;
            if (count($result_c) > 0) {
                foreach ($result_c as $rows_c) {
                    $seller = explode('.', $rows_c['source']);
                    $p_n = $rows_c['parcel_number'];
                    $result_p = Helper::dbQuery("SELECT * FROM customer_product_wishlist WHERE parcel_number = '$p_n' and is_archived IS NULL ORDER BY id ASC");

                    $parcel_pro = '';
                    $count = 0;
                    $parcel_tot = 0;
                    $titles = '';
                    $wish_price = 0;
                    $pro_price = 0;
                    $discounted_price = 0;
                    $discc = 0;
                    $pro_price2 = 0;
                    $dis_show = 0;
                    // $wish_disc = 0;
                    $pro_idd = [];
                    $discount_val = '';
                    foreach ($result_p as $rows_p) {
                        $pro_idd[] = $rows_p['id'];
                        $wish_price += (float) $rows_p['price'] * $rows_p['qty'];
                        $titles .= $rows_p['title'] . ' x ' . $rows_p['qty'] . ' - ' . (float) $rows_p['price'] * $rows_p['qty'] . '<br><br>';
                        $get_result_d = Helper::dbQuery('SELECT * FROM seller where seller_name LIKE  "%' . $rows_p['source'] . '%"');

                        if (!empty($get_data_d)) {
                            if ($get_data_d['discount_type'] == 'Percentage') {
                                $discount_val = 'Percentage';
                                $discount_value = $get_data_d['discount_value'];
                                $pro_price = ($rows_p['price'] * $rows_p['qty']);
                                $discounted_price += ($get_data_d['discount_value'] / 100) * $pro_price;
                                $dis_p = ($get_data_d['discount_value'] / 100) * $rows_p['price'];
                            } else {
                                $discount_val = 'Fixed';
                                $discount_value = $get_data_d['discount_value'];
                                $pro_price = ($rows_p['price'] * $rows_p['qty']);
                                $discounted_price += $get_data_d['discount_value'];
                            }
                        } else {
                            $discounted_price += 0;
                        }
                        $pro_price2 = ($rows_p['price'] * $rows_p['qty']);
                        $parcel_pro .= $rows_p['title'] . '<br><br>';
                        $count++;
                        $parcel_tot += (float) $rows_p['price'];
                    }

                    $pro_ids = implode(',', $pro_idd);
                    $get_data_pr = Helper::dbQuery('SELECT * FROM transaction_wallet_info where products = "' . $pro_ids . '"');

                    $show_pr = 0;
                    $gt_price = 0;
                    $discounted_amt = 0;
                    if (!empty($get_data_pr)) {
                        $get_data_pr = $get_data_pr[0];
                        $gt_price = (float) $get_data_pr['de_client'];
                        if ($discount_val == 'Percentage') {
                            $discounted_amt = ($discount_value / 100) * $gt_price;
                        } else if ($discount_val == 'Fixed') {
                            $discounted_amt = $discount_value;
                        }
                        $discc = number_format(($gt_price * 17) / 100, 2);
                        $dis_show = $discc - number_format($discounted_amt, 2);
                        $wish_disc = $gt_price + $dis_show;
                        $show_pr = $gt_price;
                        $wish_disc2 +=  (float) $gt_price +  (float) $dis_show;
                    }

                    $txt = "Valeur Ma'am";
                    if ($rows_c['parcel_number']) {
                        $parcels .= '<span class="parcel_no_click" amount="' . $achats . '" articles="' . $count . '" discount="' . number_format($discounted_price, 2) . '" discount2="' . $discc . '" articles_data="' . $titles . '">' . $rows_c['parcel_number'] . '</span><br><br>';
                        $parcel_html .= '<p><strong class="achat_show_tit" ids="' . $pro_ids . '" id_cart="' . $id_cart . '" style="cursor: pointer;text-decoration: underline" price="' . $wish_price . '" discount="' . $discounted_price . '">' . $rows_c['parcel_number'] . '</strong><br><table class="table-bordered"><thead><tr><th>Marchand</th><th>Montant</th><th>' . $txt . '</th><th>Total Colis</th></tr></thead><tbody><tr><td>' . $seller[0] . '</td><td>' . $show_pr . '€</td><td>' . $dis_show . '€</td><td>' . $wish_disc . '€</td></tr></tbody></table><span class="achat_tit" data_pro_ids="' . $pro_ids . '">' . $parcel_pro . '</span></p></p>';
                    }
                }
            }
            $wallet_amount -= (float) $wish_disc2;
            $wallet_amount_n -= (float) $wish_disc2;

            $id_cart = $rows['id_cart'];
            $result_e = Helper::dbQuery("SELECT * FROM customer_cart WHERE id_cart = $id_cart ORDER BY id DESC");

            $pro_ids = [];
            foreach ($result_e as $rows_e) {
                $pro_ids[] = $rows_e['id_product'];
            }

            $product_ids = implode(',', $pro_ids);

            $result_c = Helper::dbQuery("SELECT * FROM customer_product_wishlist WHERE id IN ($product_ids) and parcel_weight IS NOT NULL and parcel_weight != '' and parcel_weight != 0 GROUP BY parcel_weight ORDER BY id DESC");

            if (count($result_c) > 0) {
                foreach ($result_c as $rows_c) {
                    $wgt = $rows_c['parcel_weight'];
                    $vol_wgt = ((float) $rows_c['parcel_l'] * (float) $rows_c['parcel_b'] * (float)$rows_c['parcel_h']) / 5000;
                    if (round($vol_wgt) > round($wgt)) {
                        $show_wgt = $vol_wgt;
                    } else {
                        $show_wgt = $wgt;
                    }
                    $get_data_weight = Helper::dbQuery('SELECT dhl_price,colisrael_price, piano FROM shipping_weight_prices where weight="' . round($show_wgt) . '"');
                    if (count($get_data_weight) > 0) {
                        $get_data_weight = $get_data_weight[0];
                        $colisrael_price = $get_data_weight['colisrael_price'];
                        $dhl_price = $get_data_weight['dhl_price'];
                        if (!empty($get_data_weight['piano'])) {
                            $piano = $get_data_weight['piano'];
                        } else {
                            $piano = 0;
                        }

                        if ($rows_c['selected_shipping'] == 'colisrael_price') {
                            $shipp_price = $piano;
                            $selected_ship = 'Piano';
                        } else if ($rows_c['selected_shipping'] == 'dhl_price') {
                            $shipp_price = $colisrael_price;
                            $selected_ship = 'Rapido';
                        } else {
                            $shipp_price = $dhl_price;
                            $selected_ship = 'Expresso';
                        }

                        if ($rows_c['parcel_locked_price']) {
                            $shipp_price = $rows_c['parcel_locked_price'];
                        } else {
                            $shipp_price = 0;
                        }

                        $wallet_amount -= (float) $shipp_price;
                        $wallet_amount_n -= (float) $shipp_price;
                    }
                }
            }
            $result_m = Helper::dbQuery("SELECT * FROM transaction_wallet_info WHERE id_cart = $id_cart AND products IS NULL ORDER BY id DESC");

            $credit_value = 0;
            foreach ($result_m as $rows_m) {
                if ($rows_m['de_client'] != '') {
                    $credit_value -=  (float) number_format($rows_m['de_client'], 2);
                    $vll = number_format($rows_m['de_client'], 2);
                    $wallet_amount -= (float) number_format($rows_m['de_client'], 2);
                    $wallet_amount_n -= (float) number_format($rows_m['de_client'], 2);
                } else {
                    $credit_value +=  (float) number_format($rows_m['re_client'], 2);
                    $vll = number_format($rows_m['re_client'], 2);
                    $wallet_amount += (float) number_format($rows_m['re_client'], 2);
                    $wallet_amount_n += (float) number_format($rows_m['re_client'], 2);
                }
                $wallet_amount_new =  (float) $wallet_amount_n -  (float) $wallet_amount;
            }
            if ($locked_status == '1') {
                $wallet_amt +=  (float) $wallet_amount;
            }
        }
        //End Custom Query 2//

        $data['wallet_amt'] = $wallet_amt;

        return view('index2_customer', $data);
    }
    public function index_new()
    {
        $data['domain_url'] = env('APP_URL');
        // End Customers...
        $data['title'] = 'Index New';
        return view('index_new', $data);
    }
    public function index3()
    {
        $cookie_name = 'warehouse';
        $array_warehouse = [];
        if (isset($_COOKIE[$cookie_name])) {
            if ($_COOKIE[$cookie_name] != "") {
                $array_warehouse = explode(',', $_COOKIE[$cookie_name]);
            }
        }
        $data['array_warehouse'] = $array_warehouse;
        $data['cart'] = @$_GET['cart'];
        $cst = @$_GET['id'];
        $data['cst'] = @$_GET['id'];
        if ($cst) {
            $res = Helper::dbQuery("SELECT shopify_customers.firstname, shopify_customers.lastname, customer_product_wishlist.* FROM customer_product_wishlist INNER JOIN shopify_customers on (shopify_customers.id_customer = customer_product_wishlist.id_customer) INNER JOIN customer_cart on (customer_cart.id_customer = customer_product_wishlist.id_customer) WHERE customer_product_wishlist.status = 2 AND scan_status = 0 AND customer_product_wishlist.is_archived IS NULL AND customer_product_wishlist.parcel_number IS NULL AND customer_product_wishlist.id_customer=$cst GROUP BY customer_product_wishlist.id");
            $data['products'] = $res;

            $res = Helper::dbQuery("SELECT shopify_customers.firstname, shopify_customers.lastname, customer_product_wishlist.* FROM customer_product_wishlist INNER JOIN shopify_customers on (shopify_customers.id_customer = customer_product_wishlist.id_customer) INNER JOIN customer_cart on (customer_cart.id_customer = customer_product_wishlist.id_customer) WHERE customer_product_wishlist.status = 2 AND scan_status = 0 AND customer_product_wishlist.is_archived IS NULL AND customer_product_wishlist.id_customer=$cst GROUP BY customer_product_wishlist.id");
            $data['products1'] = $res;

            $res = Helper::dbQuery("SELECT shopify_customers.firstname, shopify_customers.lastname, customer_product_wishlist.* FROM customer_product_wishlist INNER JOIN shopify_customers on (shopify_customers.id_customer = customer_product_wishlist.id_customer) INNER JOIN customer_cart on (customer_cart.id_customer = customer_product_wishlist.id_customer) WHERE customer_product_wishlist.status = 2 AND scan_status = 1 AND customer_product_wishlist.is_archived IS NULL AND customer_product_wishlist.id_customer=$cst GROUP BY customer_product_wishlist.id");
            $data['products2'] = $res;
        } else {
            $data['products'] = [];
            $data['products1'] = [];
            $data['products2'] = [];
        }
        $res_arr = Helper::dbQuery("SELECT * FROM transaction INNER JOIN shopify_customers on (shopify_customers.id_customer = transaction.id_customer) GROUP BY transaction.id ORDER BY transaction.id DESC");
        $data['customers'] = Helper::getUniqueArrayByKey($res_arr, 'id_customer');
        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Index 3';
        return view('index3', $data);
    }
}
