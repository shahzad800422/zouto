// Stripe.setPublishableKey('pk_live_51IJyM5EyZ6v0AHKDkUva2mpmvMjIzma2wD94qrEWpGwmqUd4IvZ0OAXDo8J8hL9Hv5ImFXhoHW8LHYs6oisjCofJ00gCXZ5qyt');
$(document).ready(function () {
    // old code
    // $("#paymentForm").submit(function(event) {
    //     $('#makePayment').attr("disabled", "disabled");
    //     // create stripe token to make payment
    //     //console.log('test');
    //     Stripe.createToken({
    //         number: $('#cardNumber').val(),
    //         cvc: $('#cardCVC').val(),
    //         exp_month: $('#cardExpMonth').val(),
    //         exp_year: $('#cardExpYear').val()
    //     }, handleStripeResponse);
    //     return false;
    // });
    // old code

   // var stripe = Stripe("pk_test_XCdFmeLCT7XkNSC5lXtQpgwi");
    let payment_mode_cookie = getCookie('cookie_payment_mode');
    if (payment_mode_cookie) {
        $('.payment_mode_section').hide();
        $('.selected-mode-text').hide();
        $('.payment_mode_section[data-section="' + payment_mode_cookie + '"]').fadeIn();
        $('#payment_mode_' + payment_mode_cookie).prop("checked", true);
        $('#selected-mode-text-' + payment_mode_cookie).fadeIn();
    }
        var stripe = Stripe("pk_live_51IJyM5EyZ6v0AHKDkUva2mpmvMjIzma2wD94qrEWpGwmqUd4IvZ0OAXDo8J8hL9Hv5ImFXhoHW8LHYs6oisjCofJ00gCXZ5qyt");
    const elements = stripe.elements();
    const cardElement = elements.create('card',
        {
            classes: {
                base: 'form-control'
            }
        }
    );

    if ($('#card-element').length > 0) {
        cardElement.mount('#card-element');
    }

    var paymentProcessing = false;
    $("#paymentForm").submit(function (event) {
        event.preventDefault();
        $(".paymentErrors").html('');
        $('#makePayment').attr("disabled", "disabled");
        if (!paymentProcessing) {
            processPayment($(this));
        }
        return;
    });

    async function processPayment($form) {
        let payForm = $("#paymentForm");

        // remove duplicate data
        if (payForm.find('input[name="email"]').length > 0) {
            payForm.find('input[name="email"]').remove();
        }
        if (payForm.find('input[name="full_name"]').length > 0) {
            payForm.find('input[name="full_name"]').remove();
        }
        if (payForm.find('input[name="stripeToken"]').length > 0) {
            payForm.find('input[name="stripeToken"]').remove();
        }
        if (payForm.find('input[name="payment_method_id"]').length > 0) {
            payForm.find('input[name="payment_method_id"]').remove();
        }
        if (payForm.find('input[name="succeeded_data"]').length > 0) {
            payForm.find('input[name="succeeded_data"]').remove();
        }
        if (payForm.find('input[name="is_ajax"]').length > 0) {
            payForm.find('input[name="is_ajax"]').remove();
        }
        // remove duplicate data

        let formData = $form.serializeArray();
        formData.push(
            {
                name: 'full_name',
                value: $form.find('input[name="custName"]').val(),
            },
            {
                name: 'email',
                value: $form.find('input[name="custEmail"]').val(),
            },
            {
                name: 'is_ajax',
                value: true,
            },
        );

        payForm.append("<input type='hidden' name='is_ajax' value='true' />");
        payForm.append("<input type='hidden' name='email' value='" + ($form.find('input[name="custEmail"]').val()) + "' />");
        payForm.append("<input type='hidden' name='full_name' value='" + ($form.find('input[name="custName"]').val()) + "' />");

        paymentProcessing = true;
        const data = formData.reduce((acc, {
            name,
            value
        }) => ({
            ...acc,
            [name]: value
        }), {});

        const {
            paymentMethod,
            error
        } = await stripe.createPaymentMethod(
            'card', cardElement, {
            billing_details: {
                name: data.full_name,
                email: data.email,
            }
        }
        );

        const {
            token,
            token_error
        } = await stripe.createToken(cardElement);

        if (token_error) {
            display_payment_error(token_error);
            return false;
        } else if (error) {
            display_payment_error(error.message);
        } else {
            formData.push(
                {
                    name: 'stripeToken',
                    value: token.id,
                },
                {
                    name: 'payment_method_id',
                    value: paymentMethod.id,
                },
            );
            payForm.append("<input type='hidden' name='stripeToken' value='" + token.id + "' />");
            payForm.append("<input type='hidden' name='payment_method_id' value='" + paymentMethod.id + "' />");

            $.ajax({
                url: payForm.attr('action'),
                type: "POST",
                dataType: "json",
                data: ($.merge(formData, { name: 'is_ajax', value: true })),
                success: function (response) {
                    send_post_with_reload(response, payForm);
                },
                error: function (request, error) {
                    console.log(error);
                    display_payment_error("Can't do because: " + error);
                },
            });
            return false;
        }
    }


    function send_post_with_reload(response, payForm) {
        if (response.requires_action) {
            // Use Stripe.js to handle required card action
            stripe.handleCardAction(
                response.payment_intent_client_secret
            ).then(handle_stripe_3ds_js_result);
        } else if (response.succeeded) {
            if (payForm.find('input[name="is_ajax"]').length > 0) {
                payForm.find('input[name="is_ajax"]').remove();
            }
            payForm.append("<input type='hidden' name='succeeded_data' value='" + JSON.stringify(response.succeeded_data) + "' />");
            payForm.get(0).submit();
        } else if (response.error) {
            display_payment_error(response.error_msg);
        } else {
            display_payment_error("Something is wrong.");
        }
        return false;
    }

    function display_payment_error(msg = '') {
        paymentProcessing = false;
        $('#makePayment').removeAttr("disabled");
        $(".paymentErrors").html(msg);
        return false;
    }

    function handle_stripe_3ds_js_result(result) {


        if (result.error) {
            display_payment_error("Payment is cancelled");
        } else {
            let payForm = $("#paymentForm");
            let formData = payForm.serializeArray();
            formData.push(
                {
                    name: 'payment_intent_id',
                    value: result.paymentIntent.id,
                },
            );
            $.ajax({
                url: payForm.attr('action'),
                type: "POST",
                dataType: "json",
                data: formData,
                success: function (response) {
                    send_post_with_reload(response, payForm);
                },
                error: function (request, error) {
                    display_payment_error("Can't do because: " + error);
                },
            }); // ajax call closing
        }
    }

    // capture amount
    $("#matching_capture_amount_form").submit(function (event) {
        event.preventDefault();
        let payForm = $(this);
        payForm.find('input[type="submit"]').attr('disabled', true);
        payForm.find('input[name="paid_amount"]').attr('readonly', true);
        payForm.find('.matching_capture_process_info').html('<p>Processing, Please wait a moment...</p>');
        let formData = payForm.serializeArray();
        formData.push({ name: 'is_ajax', value: true });
        $.ajax({
            url: payForm.attr('action'),
            type: "POST",
            dataType: "json",
            data: formData,
            success: function (response) {

                console.log(response);
                if (response.error) {
                    payForm.find('input[type="submit"]').attr('disabled', false);
                    payForm.find('input[name="paid_amount"]').attr('readonly', false);
                    payForm.find('.matching_capture_process_info').html('<p data-type="error">' + response.error_msg + '</p>');
                } else if (response.succeeded) {
                    console.log(response.succeeded_data);
                    payForm.find('.matching_capture_process_info').html('<p data-type="succeeded">Captured Amount: <strong>' + response.amount_received + '</strong>, Refund Amount: <strong>' + response.amount_refunded + '</strong></p>');
                } else {
                    payForm.find('input[type="submit"]').attr('disabled', false);
                    payForm.find('input[name="paid_amount"]').attr('readonly', false);
                    payForm.find('.matching_capture_process_info').html('<p data-type="error">Something went wrong, try after sometime</p>');
                }
            },
            error: function (request, error) {
                console.log(error);
                payForm.find('input[type="submit"]').attr('disabled', false);
                payForm.find('input[name="paid_amount"]').attr('readonly', false);
                payForm.find('.matching_capture_process_info').html('<p data-type="error">Something went wrong, try after sometime</p>');
            }
        });
    });
    console.log($('#paypal-button-container').length);
    // paypal
    if ($('#paypal-button-container').length > 0) {

        if (typeof (paypal) !== 'undefined') {
            paypal.Buttons({
                style: {
                    color: 'blue',
                    size: 'mini',
                    shape: 'pill',
                    layout: 'vertical',

                },
                //set up the details of the transactons.
                createOrder: (data, actions) => {
                    var tot_amt = 0;
                    if ($('#wallet_credit').is(':checked')) {
                        tot_amt = parseFloat($('#total_payment').val());
                    } else {
                        tot_amt = parseFloat($('#total_payment').val());

                    }
                    return actions.order.create({
                        purchase_units: [
                            {
                                amount: {
                                    value: tot_amt
                                }
                            }
                        ]
                    });
                },
                //Finalize the transaction after approval
                //capture the fund from the transaction
                onApprove: (data, actions) => {
                    return actions.order.capture().then((orderDetails) => {
                        let order_details = JSON.stringify(orderDetails);
                        $('#paymentForm_paypal').append('<textarea style="display:none;" name="paypal_data">' + order_details + '</textarea>');
                        $('#paymentForm_paypal').submit();

                    });

                },
                //when the payers cancel the transactions
                onCancel: (data) => {
                    window.location.replace(window.location.href);
                },
                onError: function (err) {
                    if (err) {
                        $('.paymentErrors').append('<span class="error_message">Erreur de transaction</span>');
                    }
                }
            }).render('#paypal-button-container');
        }
    }
    // paypal ends
    //set cookie function
    function setCookie(name, value, days) {
        let expires = '';
        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    //get cookie
    function getCookie(name) {
        let checkName = name + "=";
        let nameCookie = document.cookie.split(';');
        for (var i = 0; i < nameCookie.length; i++) {
            var individualCookie = nameCookie[i];
            while (individualCookie.charAt(0) == ' ') individualCookie = individualCookie.substring(1, individualCookie.length)
            if (individualCookie.indexOf(checkName) == 0) return individualCookie.substring(checkName.length, individualCookie.length)
        }
        return null;
    }
    // on change payment mode start
    function select_payment_method() {
        // remove error msg
        $('.paymentErrors').html('');
        let selected_mode = $('input[name="payment_mode"]:checked').val();
        if (typeof (selected_mode) != 'undefined' && selected_mode != '') {
            // console.log( 'eeeeeeeeee' );
            $('.payment_mode_section').hide();
            $('.selected-mode-text').hide();
            setCookie("cookie_payment_mode", selected_mode, 1);


            $(".zoutoPaymentOptionModal").modal('hide');
            $('.payment_mode_section[data-section="' + selected_mode + '"]').fadeIn();
            $('#selected-mode-text-' + selected_mode).fadeIn();
        }
        // console.log( selected_mode );
    }

    $('input:radio[name="payment_mode"]').change(function () {
        select_payment_method();
    });
    select_payment_method();

    $("#wire-payment-done").on('click', function (e) {
        e.preventDefault();
        var policyDialog = bootbox.dialog(
            {
                title: '',
                message: "Total de la commande" + "</br>" +
                    "17% de Ma'am acquittés" + "</br>" +
                    "En passant une commande, vous confirmez avoir lu et accepté nos Conditions Générales de Vente, notre Politique d'Annulation ainsi que notre Politique de Protection des Données.",
                buttons: {
                    cancel: {
                        label: "No",
                        className: "btn-danger",
                        callback: function () {
                            return true
                        }
                    },
                    ok: {
                        label: "Yes",
                        className: "btn-info",
                        callback: function () {
                            $form = $('#paymentForm_wire');
                            $form.get(0).submit();
                        }
                    }
                }
            }
        )
    })
    $('.zoutoPaymentOptionModal').on('shown.bs.modal', function () {
        let customername = $('input[name="custName"]').val();
        let cardNo = $('input[name="cardnumber"]').val();
        let expirationDate = $('input[name="exp-date"]').val();
        $('td.user_name').html(customername);
        $('td .card-no').html(cardNo);
        $('td.expiration_date').html(expirationDate);

    })
    // on change payment mode ends
});




// handle the response from stripe
function handleStripeResponse(status, response) {
    console.log(JSON.stringify(response));
    if (response.error) {
        $('#makePayment').removeAttr("disabled");
        $(".paymentErrors").html(response.error.message);
    } else {
        var payForm = $("#paymentForm");
        //get stripe token id from response
        var stripeToken = response['id'];
        //set the token into the form hidden input to make payment
        payForm.append("<input type='hidden' name='stripeToken' value='" + stripeToken + "' />");
        payForm.get(0).submit();
    }

}
