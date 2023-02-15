<?php

namespace App\Http\Controllers;

use Helper;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_supplier_track_number()
    {
        $id   =  @$_POST['id'];
        $supplier_track_number   =  @$_POST['supplier_track_number'];
        $sql = Helper::dbQuery("UPDATE customer_product_wishlist SET supplier_track_number = '$supplier_track_number' WHERE id = '$id'");
        if ($sql) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record";
        }
        exit;
    }

    public function update_invoice_number()
    {
        $id   =  @$_POST['id'];
        $inv   =  @$_POST['inv'];
        $sql = Helper::dbQuery("UPDATE customer_product_wishlist SET invoice_number='$inv'  WHERE id IN ($id)");

        if ($sql) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record";
        }
        exit;
    }

    public function update_parcel_weight()
    {
        // echo "update_parcel_weight";

        $id_customer = $_POST['iddb'];
        $wgt = $_POST['parcel_weight'];
        $wgt_type = $_POST['parcel_weight_type'];
        $l = $_POST['order_length'];
        $w = $_POST['order_width'];
        $h = $_POST['order_height'];
        $selected_shipping = $_POST['selected_shipping'];

        if (isset($_POST['supplier_tracking'])) {

            $weight = ceil($wgt);
            $get_data_weight = Helper::dbQuery('SELECT dhl_price,colisrael_price, piano FROM shipping_weight_prices where weight="' . round($weight) . '"');

            $colisrael_price = $get_data_weight['colisrael_price'];
            $dhl_price = $get_data_weight['dhl_price'];
            if (!empty($get_data_weight['piano'])) {
                $piano = $get_data_weight['piano'];
            } else {
                $piano = 0;
            }
            if ($selected_shipping == 'colisrael_price') {
                $shipp_price = $piano;
                $selected_ship = 'Colisrael';
            } else if ($selected_shipping == 'dhl_price') {
                $shipp_price = $colisrael_price;
                $selected_ship = 'DHL';
            } else {
                $shipp_price = $dhl_price;
                $selected_ship = 'Piano';
            }

            $supplier_tracking = $_POST['supplier_tracking'];
            $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET parcel_weight='$wgt', parcel_weight_type='$wgt_type', parcel_l='$l', parcel_b='$w', parcel_h='$h', supplier_track_number='$supplier_tracking', parcel_locked_price='$shipp_price' WHERE id  IN ($id_customer)");
        } else {
            $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET parcel_weight='$wgt', parcel_weight_type='$wgt_type', parcel_l='$l', parcel_b='$w', parcel_h='$h' WHERE id  IN ($id_customer)");
        }
        // print_r($sql);die;
        if ($res_arr) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: ";
        }
    }

    public function update_shipped_status()
    {
        $id_customer = $_POST['id'];
        $status = $_POST['status'];

        $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET shipped_status=$status WHERE id =$id_customer");

        if ($res_arr) {
            echo "Record updated successfully";
        } else {
            echo "Error deleting record: ";
        }
    }

    public function change_parcel_type()
    {
        $id = $_POST['id'];
        $status = $_POST['status'];
        // print_r($_POST['status']);die;

        $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET parcel_for=$status WHERE id IN ($id)");

        if ($res_arr) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: ";
        }
    }

    public function update_parcel_status_backend()
    {
        $id = $_POST['id'];
        $status = $_POST['status'];

        $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET parcel_status=$status WHERE id IN ($id)");

        if (isset($_POST['type'])) {
            $customer_id = $_POST['customer'];
            $get_data = Helper::dbQuery('SELECT * FROM shopify_customers where id_customer="' . $customer_id . '" ORDER BY id DESC');

            $email = $get_data[0]['email'];
            $parcel_number = $_POST['parcel_number'];
            $titles = $_POST['titles'];
            $weight = $_POST['weight'];
            $volume = $_POST['volume'];

            if ($_POST['shipping'] == 'colisrael') {
                $shipping = '25 jours';
            } else if ($_POST['shipping'] == 'dhl') {
                $shipping = '5 jours ouvrés';
            } else {
                $shipping = '5 jours ouvrés';
            }
            if ($weight != '') {
                $weight = $_POST['weight'] . ' kg';
            }
            $get_data = Helper::dbQuery("SELECT * FROM shopify_customers where id_customer='$customer_id' ORDER BY id DESC");
            $name = $get_data[0]['firstname'] . ' ' . $get_data[0]['lastname'];
            $headers = 'From:' . 'noreply@zouto.store';

            if ($_POST['status'] == '2') {
                $subject = 'On a réceptionné un colis pour vous!';
                $message = "Bonjour $name,\n\nVotre colis $parcel_number a bien été reçu en France pour vous.\n\nCe colis comporte :\n$titles\n\n. Il vas être pris en charge par notre réseau logistique très rapidement. Sauf incident, il est prévu d'arriver en Israel dans les $shipping (délai indicatif). Vous serez informé(e) par notification une fois votre colis arrivé en Israel. C'est encore un peu tôt mais pensez à vérifier que téléphone et adresse sont à jour incluant code d'entrée d'immeuble, étage et porte. \n\nCordialement,\nL’équipe Zouto\Pour suivre le statut de vos colis, rendez-vous sur la section Mes Expéditions \nContactez-nous sur suivi@zouto.store";
                // $message = wordwrap($message,70);
                // mail($email,$subject,$message);
                mail($email, $subject, $message, $headers);
            } else if ($_POST['status'] == '1') {
                $subject = 'Un colis a pris du retard';
                $message = "Bonjour $name,\n\nVotre vendeur ne nous a pas encore fait parvenir votre colis. Merci de prendre en compte qu'il a un peu de retard. \n\nCe colis comporte :\n$titles\n\nCet email est automatique. N'hésitez pas à nous contacter par mail pour obtenir des informations plus précises. Nous sommes en train de vérifier la meilleure solution pour que vous puissiez l’avoir au plus vite.\n\nCordialement,\nL’équipe Zouto\n\nDes questions ?\nContactez-nous sur suivi@zouto.store";
                // $message = wordwrap($message,70);
                // mail($email,$subject,$message);
                mail($email, $subject, $message, $headers);
            } else {
                $subject = 'Nous avons réceptionné un colis pour vous';
                if ($weight) {
                    $message = "Bonjour $name,\n\nVotre colis $parcel_number a été reçu à l’entrepôt et est en voie d’être réacheminé vers notre point de distribution en Israel.\n\nCe colis comporte :\n$titles\n\nSon poids est de $weight et son volume $volume.\n\nComme indiqué dans nos conditions de vente, votre colis arrivera en Israel dans un délai de $shipping. Vous serez informé(e) dès son arrivée à notre centre logistique de Modi’in, vous pourrez alors venir le chercher ou commander une livraison en Box-it ou à domicile.\n\nCordialement,\nL’équipe Zouto\n\nDes questions ?\nContactez-nous sur suivi@zouto.store";
                } else {
                    $message = "Bonjour $name,\n\nVotre colis $parcel_number a été reçu à l’entrepôt et est en voie d’être réacheminé vers notre point de distribution en Israel.\n\nCe colis comporte :\n$titles\n\nVotre colis est prévu d'arriver en Israel dans un délai de $shipping (délai indicatif). Vous serez informé(e) de son départ pour votre adresse dans les jours à venir. Si besoin, veuillez mettre votre adresse à jour dès à présent avec code d'entrée d'immeuble, étage, porte et téléphone portable. \nCordialement,\nL’équipe Zouto\n\nDes questions ?\nContactez-nous sur suivi@zouto.store";
                }
                // $message = wordwrap($message,70);
                // mail($email,$subject,$message);
                mail($email, $subject, $message, $headers);
            }
        }

        echo "Record updated successfully";
    }

    public function delete_parcel_backend()
    {
        $id = $_POST['id'];
        $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET parcel_number=NULL WHERE id IN ($id)");

        if ($res_arr) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: ";
        }
    }

    public function update_invoice_status()
    {

        $id = $_POST['id'];

        $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET invoiced='1' WHERE id IN ($id)");

        if ($res_arr) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: ";
        }
    }

    public function update_wishlist_products_backend()
    {
        // echo "update_wishlist_products_backend";
        $domain_url = env('APP_URL');
        $target_dir = "images/uploads/";
        $target_file = $target_dir . basename($_FILES["documents"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["documents"]["tmp_name"]);

        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        $product_image = $domain_url . '/' . $target_file;

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["documents"]["tmp_name"], $target_file)) {
                //echo "The file ". htmlspecialchars( basename( $_FILES["documents"]["name"])). " has been uploaded.";
                echo "updated data";
                $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET product_image='" . $product_image . "' WHERE id='" . $_POST['id'] . "'");

                if ($res_arr) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: ";
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET id_customer='" . $_POST['id_customer'] . "', title='" . $_POST['product_title'] . "', price='" . $_POST['price'] . "', qty='" . $_POST['product_qty'] . "', weight='" . $_POST['product_weight'] . "', product_url='" . $_POST['product_url'] . "', product_color='" . $_POST['product_col'] . "', product_size='" . $_POST['product_size'] . "', length='" . $_POST['order_length'] . "', width='" . $_POST['order_width'] . "', height='" . $_POST['order_height'] . "', weight_type='" . $_POST['product_weight_type'] . "', attributes='" . $_POST['product_attributes'] . "' WHERE id='" . $_POST['id'] . "'");
        if ($res_arr) {

            echo "Record updated successfully";
        } else {
            echo "Error updating record: ";
        }
    }

    public function delete_wishlist_products_backend()
    {
        $id_customer = $_POST['id_customer'];

        $res_arr = Helper::dbQuery("DELETE FROM customer_product_wishlist WHERE id =$id_customer");

        if ($res_arr) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: ";
        }
    }

    public function delete_wishlist_customer()
    {
        $id = $_POST['id'];
        $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET is_archived=1 WHERE status = 1 and instock = 1 and id_customer IN ($id)");
        // print_r($sql);die;
        if ($res_arr) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: ";
        }
    }

    public function update_customer_product_wishlist()
    {
        ///
    }

    public function supplier_tracking()
    {
        $id_customer = $_POST['id'];
        $prcl = $_POST['form_data'];

        if (is_array($id_customer)) {
            $id = implode(',', $id_customer);
            $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET supplier_track_number='$prcl' WHERE id IN ($id)");
        }

        if ($res_arr) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: ";
        }
    }

    public function update_hs_code()
    {
        $id_customer = $_POST['id'];
        $prcl = $_POST['form_data'];

        if (is_array($id_customer)) {
            $id = implode(',', $id_customer);
            $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET hs_code='$prcl' WHERE id IN ($id)");
        }

        if ($res_arr) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: ";
        }
    }

    public function join_parcel()
    {
        $id_customer = $_POST['id'];
        $prcl = $_POST['form_data'];

        if (is_array($id_customer)) {
            $id = implode(',', $id_customer);
            $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET parcel_number='$prcl' WHERE id IN ($id)");
        } else {
            //   $id = $id_customer;
            //   $sql = "DELETE FROM customer_product_wishlist WHERE id =$id";
        }

        if ($res_arr) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: ";
        }
    }

    public function update_wishlist_products()
    {
        $res_arr = Helper::dbQuery("SELECT * FROM customer_product_wishlist WHERE id='" . $_POST['iddbs'] . "'");

        $priceWithDiscount = $res_arr[0]['price'];
        $currentdate = date('Y-m-d H:i:s');

        $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET hs_code='" . $_POST['hs_code'] . "', product_color='" . $_POST['product_color'] . "', product_size='" . $_POST['product_size'] . "', price='" . $_POST['paid_price'] . "', qty='" . $_POST['quantity'] . "', net_price='" . $_POST['net_price'] . "', origin_good='" . $_POST['origin_good'] . "', limit_product='" . $_POST['limit'] . "', invoiced_weight='" . $_POST['invoiced_weight'] . "', days = '" . $currentdate . "',  tracked_number='" . $_POST['tracked_number'] . "', instock='" . $_POST['instock'] . "', status=2, supplier_track_number='" . $_POST['sup_track_number'] . "', warehouse_name='" . $_POST['warehouse_name'] . "', product_status='" . $_POST['status'] . "' WHERE id='" . $_POST['iddbs'] . "'");
        if ($res_arr) {
            echo json_encode(array('code' => 200, 'msg' => 'Record updated successfully', 'id' => $_POST['iddbs']));
        } else {
            echo json_encode(array('code' => 100, 'msg' => 'Something went wrong', 'id' => $_POST['iddbs']));
        }
    }

    public function archive_backend()
    {
        $id_customer = $_POST['id_customer'];
        $random = substr(md5(mt_rand()), 0, 7);
        $length = 6;

        if (is_array($id_customer)) {
            $id = implode(',', $id_customer);
            $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET is_archived='1' WHERE id IN ($id)");
        } else {
            $id = $id_customer;
            $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET is_archived='1' WHERE id =$id");
        }

        if ($res_arr) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: ";
        }
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
        $month = (int) date("m", strtotime($postdate));
        $month_array = [1 => 'Janvier', 2 => 'février', 3 => 'mars', 4 => 'avril', 5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'août', 9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre'];
        $selected_date = $date . ' ' . $month_array[$month];



        if (isset($_POST['cost'])) {
            $res_arr = Helper::dbQuery("INSERT INTO transaction_wallet_info (id_cart, transaction_date, ajouter, de_client, re_client, products) VALUES ('" . $_POST['id_cart'] . "', '" . date("d/m/Y") . "', 'articles', '" . $_POST['cost'] . "', '', '" . $_POST['id_customer'] . "')");
        }
        $id_customer = $_POST['id_customer'];
        $random = substr(md5(mt_rand()), 0, 7);

        $length = 6;

        if (is_array($id_customer)) {
            $id = implode(',', $id_customer);
            if (isset($_POST['parcel'])) {
                $prc = $_POST['parcel'];
                $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET parcel_number='$random', parcel_for=$prc, parcel_status=0 WHERE id IN ($id)");
            } else {
                $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET parcel_number='$random', parcel_status=0 WHERE id IN ($id)");
            }
            $titles = '';
            $paid_price = 0;
            $id = explode(',', $id);
            foreach ($id as $idd) {
                $get_data = Helper::dbQuery('SELECT * FROM customer_product_wishlist where id="' . $idd . '"');

                $tit = $get_data[0]['title'];
                $titles .= "$tit\n";
                $paid_price += $get_data['price'];
            }
            $cartt = $_POST['id_cart'];
            $get_data = $res_arr = Helper::dbQuery("SELECT * FROM customer_cart where id_cart='$cartt' ORDER BY id DESC");
            $customer_id = $get_data[0]['id_customer'];

            $get_data = $res_arr = Helper::dbQuery("SELECT * FROM shopify_customers where id_customer='$customer_id' ORDER BY id DESC");
            $name = $get_data[0]['firstname'] . ' ' . $get_data[0]['lastname'];
            $email = $get_data[0]['email'];

            $headers = 'From:' . 'noreply@zouto.store';
            if (isset($_POST['is_mail'])) {
            } else {
                $subject = 'Achats réalisés!';
                $message = "Bonjour $name,\n\n Nous confirmons avoir acheté les produits suivants :\n\n$titles\n\nVos articles sont enregistrés avec le numéro de suivi $random.\n\nLe montant déboursé pour l'achat de ces articles est de $paid_price € (livraison en France incluse, livraison en Israel exclue).\n\nVotre marchand indique que votre colis sera livré au plus tôt le $selected_date. Pour rappel, les délais de livraison annoncés sur Zouto sont à compter une fois la marchandise reçue (24h de délai sont nécessaires à la préparation de l'expédition). \n\nCordialement,\nL’équipe Zouto\n\nDes questions ?\nContactez-nous sur suivi@zouto.store";
                mail($email, $subject, $message, $headers);
            }
        } else {
            $id = explode(',', $id_customer);
            $titles = '';
            $paid_price = 0;
            foreach ($id as $idd) {
                $get_data = Helper::dbQuery('SELECT * FROM customer_product_wishlist where id="' . $idd . '"');

                $tit = $get_data[0]['title'];
                $titles .= "$tit\n";
                $paid_price += $get_data[0]['price'];
            }
            $id = implode(',', $id);
            if (isset($_POST['parcel'])) {
                $prc = $_POST['parcel'];
                Helper::dbQuery("UPDATE customer_product_wishlist SET parcel_number='$random', parcel_for=$prc, parcel_status=0 WHERE id IN ($id_customer)");
            } else {
                $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET parcel_number='$random', parcel_status=0 WHERE id IN ($id_customer)");
            }

            $cartt = $_POST['id_cart'];
            $get_data = Helper::dbQuery("SELECT * FROM customer_cart where id_cart='$cartt' ORDER BY id DESC");

            $customer_id = $get_data[0]['id_customer'];
            $get_data = Helper::dbQuery("SELECT * FROM shopify_customers where id_customer='$customer_id' ORDER BY id DESC");

            $name = $get_data[0]['firstname'] . ' ' . $get_data[0]['lastname'];
            $email = $get_data[0]['email'];
            $headers = 'From:' . 'noreply@zouto.store';

            if (isset($_POST['is_mail'])) {
            } else {
                $subject = 'Votre marchand prépare votre commande';
                $message = "Bonjour $name,\n\n Nous confirmons vous avoir acheté les produits suivants :\n\n$titles Vos articles sont enregistrés avec le numéro de suivi $random.\n\nLe montant déboursé pour l'achat de ces articles est de $paid_price € (livraison en France incluse, livraison en Israel exclue).\n\nVotre marchand indique que votre colis sera livré au plus tôt le $selected_date. Pour rappel, les délais de livraison annoncés sur Zouto sont à compter une fois la marchandise reçue (24h de délai sont nécessaires à la préparation de l'expédition). \n\nCordialement,\nL’équipe Zouto\n\nDes questions ?\nContactez-nous sur suivi@zouto.store";
                mail($email, $subject, $message, $headers);
            }
        }
        // if ($res_arr) {
        echo "Record updated successfully";
        // } else {
        //     echo "Error updating record: ";
        // }
        exit;
    }

    public function delete_instock_products_backend()
    {
        $id_customer = $_POST['id_customer'];
        if (is_array($id_customer)) {
            $id = implode(',', $id_customer);
            $res_arr = Helper::dbQuery("DELETE FROM customer_product_wishlist WHERE id  IN ($id)");
        } else {
            $id = $id_customer;
            $res_arr = Helper::dbQuery("DELETE FROM customer_product_wishlist WHERE id =$id");
        }

        if ($res_arr) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: ";
        }
    }

    public function paid_products_backend()
    {
        $id_customer = $_POST['id_customer'];
        if (is_array($id_customer)) {
            $id = implode(',', $id_customer);
            $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET product_status=1 WHERE id  IN ($id)");
        } else {
            $id = $id_customer;
            $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET product_status=1 WHERE id =$id");
        }

        if ($res_arr) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: ";
        }
    }

    public function update_track_number()
    {
        $id_customer = $_POST['id'];
        $trackid = $_POST['trackid'];

        $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET tracked_number=$trackid WHERE id =$id_customer");

        if ($res_arr) {
            echo "Record updated successfully";
        } else {
            echo "Error deleting record: ";
        }
    }

    public function scan_products()
    {
        $id_customer = $_POST['ids'];
        if (is_array($id_customer)) {
            $id = implode(',', $id_customer);
            $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET scan_status=1 WHERE id  IN ($id)");
        } else {
            $id = $id_customer;
            $res_arr = Helper::dbQuery("UPDATE customer_product_wishlist SET scan_status=1 WHERE id =$id");
        }

        if ($res_arr) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: ";
        }
    }
}
