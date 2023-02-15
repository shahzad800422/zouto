@extends('layouts.app')

@section('content')

<?php
$ris =Helper::dbQuery( "SELECT transaction.created, transaction.id_customer, transaction.paid_amount FROM transaction INNER JOIN shopify_customers ON transaction.id_customer = shopify_customers.id_customer GROUP BY transaction.id_cart ");
$result = Helper::dbQuery("SELECT * FROM shopify_customers where firstname IS NOT NULL AND firstname <> '' GROUP BY firstname "); ?>
<section>
    <table>
        <tr>
            <th>Customers</th>
        </tr>
        <?php

        foreach($result as $rows){ ?>
            <tr>
                <td>+<?php echo $rows['firstname'];?>
                </td>
            </tr><?php
        }?>
    </table>
</section>
<section>
    <table>
        <tr>
            <th>created</th>&nbsp;&nbsp;
            <th>id customer</th>&nbsp;&nbsp;
            <th>Amount</th>
        </tr>
        <?php
        foreach($ris as row)  {  ?>
            <tr>

                <td><?php echo $row['created'];?></td>&nbsp;&nbsp;
                <td><?php echo $row['id_customer'];?></td>&nbsp;&nbsp;
                <td><?php echo $row['paid_amount'];?></td>
            </tr><?php
        }?>
    </table>
</section>
<section>
    <table>
        <?php
        foreach($result as $rows)
        {
            while($ris as $row)
            {
                if ( $rows['id_customer'] ==  $row['id_customer']){
                    echo $rows['firstname'].'</br>';
                    echo $row['created'].'</br>';
                    echo $row['id_customer'].'</br>';
                    echo $row['paid_amount'];
                }
            }
        } ?>
    </table>
</section>
@endsection

