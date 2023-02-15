<?php

namespace App\Http\Controllers;

use Helper;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index()
    {
        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Seller Index';
        return view('seller.index', $data);
    }

    public function create()
    {
        $seller_name = $discount_type = $discount_value = "";
        $seller_name_err = $discount_type_err = $discount_value_err = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $input_seller_name = trim($_POST["seller_name"]);
            if (empty($input_seller_name)) {
                $seller_name_err = "Please enter a name.";
            } elseif (!filter_var($input_seller_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
                $seller_name_err = "Please enter a valid name.";
            } else {
                $seller_name = $input_seller_name;
            }

            $input_discount_type = trim($_POST["discount_type"]);
            if (empty($input_discount_type)) {
                $discount_type_err = "Please enter an discount.";
            } else {
                $discount_type = $input_discount_type;
            }

            $input_discount_value = trim($_POST["discount_value"]);
            if (empty($input_discount_value)) {
                $discount_value_err = "Please enter the amount.";
            } elseif (!ctype_digit($input_discount_value)) {
                $discount_value_err = "Please enter a positive integer value.";
            } else {
                $discount_value = $input_discount_value;
            }

            if (empty($Seller_name_err) && empty($discount_type_err) && empty($discount_value_err)) {
                $param_name = $_POST["seller_name"];
                $param_type = $discount_type;
                $param_value = $discount_value;
                $sql = Helper::dbQuery("INSERT INTO seller (seller_name, discount_type, discount_value) VALUES ('$param_name', '$param_type', '$param_value')");
                if ($sql) {
                    header("location: /seller");
                    exit();
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
        }
        $data['seller_name'] = $seller_name;
        $data['discount_type'] = $discount_type;
        $data['discount_value'] = $discount_value;
        $data['seller_name_err'] = $seller_name_err;
        $data['discount_type_err'] = $discount_type_err;
        $data['discount_value_err'] = $discount_value_err;
        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Seller Create';
        return view('seller.create', $data);
    }

    public function delete()
    {
        if (isset($_POST["id"]) && !empty($_POST["id"])) {
            $param_id = trim($_POST["id"]);
            $sql = Helper::dbQuery("DELETE FROM seller WHERE id = $param_id");
            if ($sql) {
                header("location: /seller");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        } else {
            if (empty(trim($_GET["id"]))) {
                header("location: error");
                exit();
            }
        }
        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Seller Delete';
        return view('seller.delete', $data);
    }

    public function error()
    {
        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Seller Error';
        return view('seller.error', $data);
    }
    public function update()
    {

        $seller_name = $discount_type = $discount_value = "";
        $seller_name_err = $discount_type_err = $discount_value_err = "";

        if (isset($_POST["id"]) && !empty($_POST["id"])) {

            $id = $_POST["id"];

            $input_seller_name = trim($_POST["seller_name"]);
            if (empty($input_seller_name)) {
                $seller_name_err = "Please enter a name.";
            } elseif (!filter_var($input_seller_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
                $seller_name_err = "Please enter a valid name.";
            } else {
                $seller_name = $input_seller_name;
            }

            $input_discount_type = trim($_POST["discount_type"]);
            if (empty($input_discount_type)) {
                $discount_type_err = "Please enter an discount_type.";
            } else {
                $discount_type = $input_discount_type;
            }

            $input_discount_value = trim($_POST["discount_value"]);
            if (empty($input_discount_value)) {
                $discount_value_err = "Please enter the discount amount.";
            } elseif (!ctype_digit($input_discount_value)) {
                $discount_value_err = "Please enter a positive integer value.";
            } else {
                $discount_value = $input_discount_value;
            }

            if (empty($Seller_name_err) && empty($discount_type_err) && empty($discount_value_err)) {

                $param_name = $_POST["seller_name"];
                $param_type = $discount_type;
                $param_value = $discount_value;
                $param_id = $id;
                $sql = Helper::dbQuery("UPDATE seller SET seller_name='$param_name', discount_type='$param_type', discount_value='$param_value' WHERE id=$param_id");
                if ($sql) {
                    header("location: /seller");
                    exit();
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                    header("location: /seller");
                    exit();
                }
            }
        } else {
            if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
                $id =  trim($_GET["id"]);
                $param_id = $id;
                $result = Helper::dbQuery("SELECT * FROM seller WHERE id = $param_id");
                if (count($result) == 1) {
                    $row = $result[0];
                    $data['row'] = $row;
                    $data['id'] = $id;
                    $seller_name = $row["seller_name"];
                    $discount_type = $row["discount_type"];
                    $discount_value = $row["discount_value"];
                } else {
                    header("location: error");
                    exit();
                }
            } else {
                header("location: error");
                exit();
            }
        }
        $data['seller_name'] = $seller_name;
        $data['discount_type'] = $discount_type;
        $data['discount_value'] = $discount_value;
        $data['seller_name_err'] = $seller_name_err;
        $data['discount_type_err'] = $discount_type_err;
        $data['discount_value_err'] = $discount_value_err;
        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Seller Update';
        return view('seller.update', $data);
    }

    public function read()
    {
        $data['domain_url'] = env('APP_URL');
        $data['title'] = 'Seller Read';
        return view('seller.read', $data);
    }
}
