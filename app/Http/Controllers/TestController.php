<?php

namespace App\Http\Controllers;

use Helper;
use Stripe;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function awb_archive()
    {

        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Awb Archive';
        return view('test.awb_archive', $data);
    }

    public function awb()
    {

        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Awb';
        return view('test.awb', $data);
    }

    public function create()
    {

        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'create';
        return view('test.create', $data);
    }

    public function delete()
    {

        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'delete';
        return view('test.delete', $data);
    }

    public function error()
    {

        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'error';
        return view('test.error', $data);
    }

    public function keyword()
    {

        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Keyword';
        return view('test.keyword', $data);
    }

    public function matching_rajat()
    {

        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Matching Rajat';
        return view('test.matching_rajat', $data);
    }

    public function matching()
    {

        $cookie_name = 'warehouse';
        $array_warehouse = [];
        if (isset($_COOKIE[$cookie_name])) {
            if ($_COOKIE[$cookie_name] != "") {
                $array_warehouse = explode(',', $_COOKIE[$cookie_name]);
            }
        }
        // capture amount
        if (isset($_POST['matching_capture_max_amount']) && (isset($_POST['is_ajax']))) {
            $id = (isset($_POST['id'])) ? $_POST['id'] : '';
            $pi_id = (isset($_POST['pi_id'])) ? $_POST['pi_id'] : '';
            $paid_amount = (isset($_POST['paid_amount'])) ? $_POST['paid_amount'] : 0;
            $matching_capture_max_amount = (isset($_POST['matching_capture_max_amount'])) ? $_POST['matching_capture_max_amount'] : 0;
            $paid_amount = ($paid_amount > $matching_capture_max_amount) ? $matching_capture_max_amount : $paid_amount;

            //set stripe secret key and publishable key
            $stripe = array(
                "secret_key" => "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",
                "publishable_key" => "pk_live_51IJyM5EyZ6v0AHKDkUva2mpmvMjIzma2wD94qrEWpGwmqUd4IvZ0OAXDo8J8hL9Hv5ImFXhoHW8LHYs6oisjCofJ00gCXZ5qyt"
            );

            // for localhost
            if ($_SERVER['SERVER_NAME'] == 'localhost') {
                $stripe = array(
                    "secret_key" => "sk_test_39dKrhpTK1xhgFjroapGN7P6",
                    "publishable_key" => "pk_test_XCdFmeLCT7XkNSC5lXtQpgwi"
                );
            }
            Stripe\Stripe::setApiKey($stripe['secret_key']);
            try {

                $intent = Stripe\PaymentIntent::retrieve($pi_id);
                $intent->capture(['amount_to_capture' => ($paid_amount * 100)]);

                if (isset($intent->id)) {

                    $paid_amount = ($intent->status == 'succeeded') ? $paid_amount : $matching_capture_max_amount;
                    $txn_id = (isset($intent->charges->data[0]->balance_transaction)) ? ($intent->charges->data[0]->balance_transaction) : '';
                    $amount_refunded = (isset($intent->charges->data[0]->amount_refunded)) ? (($intent->charges->data[0]->amount_refunded)) / 100 : 0;

                    Helper::dbQuery("UPDATE transaction SET
                                    paid_amount = '$paid_amount',
                                    payment_status = '{$intent->status}',
                                    txn_id = '{$txn_id}',
                                    amount_refunded = '{$amount_refunded}'
                                    WHERE `transaction`.`id` = '{$id}'");
                    echo json_encode([
                        'succeeded' => true,
                        'succeeded_data' => $intent,
                        'amount_received' => ($intent->amount_received / 100),
                        'amount_refunded' => $amount_refunded,
                    ]);
                } else {
                    echo json_encode([
                        'error' => true,
                        'error_msg' => 'Something went wrong.',
                    ]);
                }
            } catch (Exception $ex) {
                echo json_encode([
                    'error' => true,
                    'error_msg' => $ex->getMessage(),
                ]);
            }
            exit;
        }
        $data['array_warehouse'] = $array_warehouse;
        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Matching';
        return view('test.matching', $data);
    }

    public function read()
    {

        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Read';
        return view('test.read', $data);
    }

    public function shipment_archive()
    {

        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Shipment Archive';
        return view('test.shipment_archive', $data);
    }

    public function shipment_new_with_user()
    {

        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Shipment New With User';
        return view('test.shipment_new_with_user', $data);
    }

    public function shipment_new()
    {

        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Shipment New';
        return view('test.shipment_new', $data);
    }

    public function shipment_with_user()
    {

        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Shipment with user';
        return view('test.shipment_with_user', $data);
    }

    public function shipment()
    {

        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'shipment';
        return view('test.shipment', $data);
    }

    public function test1()
    {

        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Test1';
        return view('test.test1', $data);
    }

    public function wallet_new()
    {

        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Wallet New';
        return view('test.wallet_new', $data);
    }

    public function wallet_page_backup()
    {

        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Wallet Page Backup';
        return view('test.wallet_page_backup', $data);
    }

    public function wallet_page_new()
    {

        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'wallet_page_new';
        return view('test.wallet_page_new', $data);
    }

    public function wallet_page()
    {

        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Wallet Page';
        return view('test.wallet_page', $data);
    }

    public function walletpage()
    {

        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Walletpage';
        return view('test.walletpage', $data);
    }

    public function wishlist()
    {

        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Wishlist';
        return view('test.wishlist', $data);
    }

    // Matching apis...
    public function add_matching_cost()
    {
        Helper::dbQuery("INSERT INTO matching_cost (id_cart, id_customer, cost) VALUES ('" . $_POST['id_cart'] . "', '" . $_POST['id_customer'] . "', '" . $_POST['cost'] . "')");
        $data = array('status' => '1');
        echo json_encode($data);
        exit;
    }
    public function supplier_tracking()
    {
        $id_customer   =  $_POST['id'];
        $prcl   =  $_POST['form_data'];
        // print_r($prcl);die;
        if (is_array($id_customer)) {
            $id = implode(',', $id_customer);
            //   print_r($_POST['form_data']);die;
            $sql =  Helper::dbQuery("UPDATE customer_product_wishlist SET supplier_track_number='$prcl' WHERE id IN ($id)");
        } else {
            //   $id = $id_customer;
            //   $sql = Helper::dbQuery("DELETE FROM customer_product_wishlist WHERE id =$id");
        }
        if ($sql) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: ";
        }
        exit;
    }
    public function update_hs_code()
    {
        $id_customer   =  $_POST['id'];
        $prcl   =  $_POST['form_data'];
        // print_r($prcl);die;
        if (is_array($id_customer)) {
            $id = implode(',', $id_customer);
            //   print_r($_POST['form_data']);die;
            $sql = Helper::dbQuery("UPDATE customer_product_wishlist SET hs_code='$prcl' WHERE id IN ($id)");
        } else {
            //   $id = $id_customer;
            //   $sql = Helper::dbQuery("DELETE FROM customer_product_wishlist WHERE id =$id");
        }
        if ($sql) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: ";
        }
        exit;
    }
    public function join_parcel()
    {
        $id_customer   =  $_POST['id'];
        $prcl   =  $_POST['form_data'];
        // print_r($prcl);die;
        if (is_array($id_customer)) {
            $id = implode(',', $id_customer);
            //   print_r($_POST['form_data']);die;
            $sql = Helper::dbQuery("UPDATE customer_product_wishlist SET parcel_number='$prcl' WHERE id IN ($id)");
        } else {
            //   $id = $id_customer;
            //   $sql = Helper::dbQuery("DELETE FROM customer_product_wishlist WHERE id =$id");
        }
        if ($sql) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: ";
        }
        exit;
    }
    public function update_wishlist_products()
    {
        //echo"<pre>"; print_r($_POST);	die;
        $query = Helper::dbQuery("SELECT * FROM customer_product_wishlist WHERE id='" . $_POST['iddbs'] . "'");
        $result = @$query[0];
        //$price = $result['price'] * 0.20;
        //$priceWithDiscount = $result['price'] - $price;
        $priceWithDiscount = $result['price'];
        $currentdate = date('Y-m-d H:i:s');
        // if(isset($_POST['instock'])){
        //     $_POST['instock'] = 1;
        // }else{
        //     $_POST['instock'] = 0;
        // }
        $sql =  Helper::dbQuery("UPDATE customer_product_wishlist SET hs_code='" . $_POST['hs_code'] . "', product_color='" . @$_POST['product_color'] . "', product_size='" . $_POST['product_size'] . "', price='" . $_POST['paid_price'] . "', qty='" . $_POST['quantity'] . "', net_price='" . $_POST['net_price'] . "', origin_good='" . $_POST['origin_good'] . "', limit_product='" . $_POST['limit'] . "', invoiced_weight='" . $_POST['invoiced_weight'] . "', days = '" . $currentdate . "',  tracked_number='" . $_POST['tracked_number'] . "', instock='" . $_POST['instock'] . "', status=2, supplier_track_number='" . $_POST['sup_track_number'] . "', warehouse_name='" . $_POST['warehouse_name'] . "', product_status='" . $_POST['status'] . "' WHERE id='" . $_POST['iddbs'] . "'");
        if ($sql) {
            echo json_encode(array('code' => 200, 'msg' => 'Record updated successfully', 'id' => $_POST['iddbs']));
        } else {
            // echo "Error updating record: " . $conn->error;
            echo json_encode(array('code' => 100, 'msg' => 'Something went wrong', 'id' => $_POST['iddbs']));
        }
        exit;
    }
    public function archive_backend()
    {
        $id_customer   =  $_POST['id_customer'];
        $random = substr(md5(mt_rand()), 0, 7);
        // echo $random;
        // print_r($str);
        // die;
        $length = 6;
        // $str = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
        // print_r($str);
        // die;
        if (is_array($id_customer)) {
            $id = implode(',', $id_customer);
            //   print_r($id);die;
            $sql = Helper::dbQuery("UPDATE customer_product_wishlist SET is_archived='1' WHERE id IN ($id)");
        } else {
            $id = $id_customer;
            $sql = Helper::dbQuery("UPDATE customer_product_wishlist SET is_archived='1' WHERE id =$id");
        }

        if ($sql) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: ";
        }
        exit;
    }
    public function create_parcel_backend()
    {

        $warehouse = (isset($_POST['warehouse'])) ? $_POST['warehouse'] : array();
        $cookie_name = 'warehouse';
        if (!empty($warehouse)) {
            $warehouse_string = implode(',', $warehouse);
            setcookie($cookie_name, $warehouse_string, time() + (86400 * 30), "/");
        } else {
            setcookie($cookie_name, '');
        }

        $date = $_POST['date'];
        $postdate = date("Y-m-d", strtotime($date));
        $date = date("d", strtotime($postdate));
        $month = (int)date("m", strtotime($postdate));
        $month_array = [1 => 'Janvier', 2 => 'février', 3 => 'mars', 4 => 'avril', 5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'août', 9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre'];
        $selected_date = $date . ' ' . $month_array[$month];

        if (isset($_POST['cost'])) {
            $sql = Helper::dbQuery("INSERT INTO transaction_wallet_info (id_cart, transaction_date, ajouter, de_client, re_client, products) VALUES ('" . $_POST['id_cart'] . "', '" . date("d/m/Y") . "', 'articles', '" . $_POST['cost'] . "', '', '" . $_POST['id_customer'] . "')");
        }
        $id_customer   =  (string) $_POST['id_customer'];
        $random = substr(md5(mt_rand()), 0, 7);

        $length = 6;

        if (is_array($id_customer)) {
            $id = implode(',', $id_customer);
            if (isset($_POST['parcel'])) {
                $prc = $_POST['parcel'];
                $sql = Helper::dbQuery("UPDATE customer_product_wishlist SET parcel_number='$random', parcel_for=$prc, parcel_status=0 WHERE id IN ($id)");
            } else {
                $sql = Helper::dbQuery("UPDATE customer_product_wishlist SET parcel_number='$random', parcel_status=0 WHERE id IN ($id)");
            }
            $titles = '';
            $paid_price = 0;
            $id = explode(',', $id_customer);
            foreach ($id as $idd) {
                $result_i = Helper::dbQuery('SELECT * FROM customer_product_wishlist where id="' . $idd . '"');
                $get_data = @$result_i[0];
                $tit = $get_data['title'];
                $titles .= "$tit\n";
                $paid_price += $get_data['price'];
            }
            $cartt = $_POST['id_cart'];
            $result_c = Helper::dbQuery("SELECT * FROM customer_cart where id_cart='$cartt' ORDER BY id DESC");
            $get_data = @$result_c[0];
            $customer_id = $get_data['id_customer'];
            $result_c = Helper::dbQuery("SELECT * FROM shopify_customers where id_customer='$customer_id' ORDER BY id DESC");
            $get_data = @$result_c[0];

            $name = $get_data['firstname'] . ' ' . $get_data['lastname'];
            $email = $get_data['email'];
            $headers = 'From:' . 'noreply@zouto.store';
            if (isset($_POST['is_mail'])) {
            } else {
                $subject = 'Achats réalisés!';
                $message = "Bonjour $name,\n\n Nous confirmons avoir acheté les produits suivants :\n\n$titles\n\nVos articles sont enregistrés avec le numéro de suivi $random.\n\nLe montant déboursé pour l'achat de ces articles est de $paid_price € (livraison en France incluse, livraison en Israel exclue).\n\nVotre marchand indique que votre colis sera livré au plus tôt le $selected_date. Pour rappel, les délais de livraison annoncés sur Zouto sont à compter une fois la marchandise reçue (24h de délai sont nécessaires à la préparation de l'expédition). \n\nCordialement,\nL’équipe Zouto\n\nDes questions ?\nContactez-nous sur suivi@zouto.store";
                mail($email, $subject, $message, $headers);
            }
        } else {
            // print_r($id_customer);die;
            //   $id = $id_customer;
            $id = explode(',', $id_customer);
            //   print_r($id_customer);die;
            $titles = '';
            $paid_price = 0;
            foreach ($id as $idd) {
                // print_r($idd);die;
                $result_i = Helper::dbQuery('SELECT * FROM customer_product_wishlist where id="' . $idd . '"');
                $get_data = @$result_i[0];
                $tit = $get_data['title'];
                $titles .= "$tit\n";
                $paid_price += (float) $get_data['price'];
            }
            //   $sql_i = 'SELECT * FROM customer_product_wishlist where id="'.$id.'"';
            //     $result_i = $con->query($sql_i);
            //     $get_data = mysqli_fetch_assoc($result_i);
            //     $titles = $get_data['title'].'\n';
            //     $paid_price = $get_data['price'];
            $id = $id_customer; //implode(',', $id_customer);
            if (isset($_POST['parcel'])) {
                $prc = $_POST['parcel'];
                $sql = Helper::dbQuery("UPDATE customer_product_wishlist SET parcel_number='$random', parcel_for=$prc, parcel_status=0 WHERE id IN ($id_customer)");
            } else {
                $sql = Helper::dbQuery("UPDATE customer_product_wishlist SET parcel_number='$random', parcel_status=0 WHERE id IN ($id_customer)");
            }

            // $idd = $id_customer;
            //     $result_i = Helper::dbQuery('SELECT * FROM customer_product_wishlist where id="'.$idd.'"');
            //     $get_data = $result_i[0];
            //     $titles = $get_data['title'].'\n';
            $cartt = $_POST['id_cart'];
            $result_c = Helper::dbQuery("SELECT * FROM customer_cart where id_cart='$cartt' ORDER BY id DESC");
            $get_data = @$result_c[0];
            $customer_id = $get_data['id_customer'];
            $result_c = Helper::dbQuery("SELECT * FROM shopify_customers where id_customer='$customer_id' ORDER BY id DESC");
            $get_data = @$result_c[0];

            $name = $get_data['firstname'] . ' ' . $get_data['lastname'];
            $email = $get_data['email'];
            $headers = 'From:' . 'noreply@zouto.store';
            if (isset($_POST['is_mail'])) {
            } else {
                $subject = 'Votre marchand prépare votre commande';
                $message = "Bonjour $name,\n\n Nous confirmons vous avoir acheté les produits suivants :\n\n$titles Vos articles sont enregistrés avec le numéro de suivi $random.\n\nLe montant déboursé pour l'achat de ces articles est de $paid_price € (livraison en France incluse, livraison en Israel exclue).\n\nVotre marchand indique que votre colis sera livré au plus tôt le $selected_date. Pour rappel, les délais de livraison annoncés sur Zouto sont à compter une fois la marchandise reçue (24h de délai sont nécessaires à la préparation de l'expédition). \n\nCordialement,\nL’équipe Zouto\n\nDes questions ?\nContactez-nous sur suivi@zouto.store";
                mail($email, $subject, $message, $headers);
            }
        }

        if ($sql) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: ";
        }
        exit;
    }
    public function delete_instock_products_backend()
    {
        $id_customer   =  $_POST['id_customer'];
        if (is_array($id_customer)) {
            $id = implode(',', $id_customer);
            $sql = Helper::dbQuery("DELETE FROM customer_product_wishlist WHERE id  IN ($id)");
        } else {
            $id = $id_customer;
            $sql = Helper::dbQuery("DELETE FROM customer_product_wishlist WHERE id =$id");
        }
        if ($sql) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: ";
        }
        exit;
    }
    public function paid_products_backend()
    {
        $id_customer   =  $_POST['id_customer'];
        if (is_array($id_customer)) {
            $id = implode(',', $id_customer);
            $sql = Helper::dbQuery("UPDATE customer_product_wishlist SET product_status=1 WHERE id  IN ($id)");
        } else {
            $id = $id_customer;
            $sql = Helper::dbQuery("UPDATE customer_product_wishlist SET product_status=1 WHERE id =$id");
        }
        if ($sql) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: ";
        }
        exit;
    }
    public function update_track_number()
    {
        $id_customer   =  $_POST['id'];
        $trackid   =  $_POST['trackid'];

        $sql = Helper::dbQuery("UPDATE customer_product_wishlist SET tracked_number=$trackid WHERE id =$id_customer");
        if ($sql) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: ";
        }
        exit;
    }
    // End matching apis...
}
