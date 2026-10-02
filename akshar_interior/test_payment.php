<?php

include("includes/db.php");


// =====================================================
// GET DATA
// =====================================================

$booking_id = isset($_GET["booking_id"])
    ? intval($_GET["booking_id"])
    : 0;

$service = isset($_GET["service"])
    ? trim($_GET["service"])
    : "";

$amount = isset($_GET["amount"])
    ? (float)$_GET["amount"]
    : 0;


// =====================================================
// VALIDATION
// =====================================================

if ($booking_id <= 0 || empty($service) || $amount <= 0)
{
    die("
        <div style='
            font-family:Arial;
            text-align:center;
            padding:50px;
        '>
            <h2>Invalid Payment Details</h2>
            <p>Please go back and try booking again.</p>
        </div>
    ");
}


// =====================================================
// PAYMENT PROCESS
// =====================================================

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["confirm_payment"])
) {

    $booking_id = intval($_POST["booking_id"]);
    $service = trim($_POST["service"]);
    $amount = (float)$_POST["amount"];


    // -------------------------------------------------
    // UPDATE PAYMENT
    // -------------------------------------------------

    $payment_status = "Paid";


    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO payments
        (
            booking_id,
            service_name,
            token_amount,
            payment_status
        )
        VALUES (?, ?, ?, ?)"
    );


    mysqli_stmt_bind_param(
        $stmt,
        "isds",
        $booking_id,
        $service,
        $amount,
        $payment_status
    );


    if (!mysqli_stmt_execute($stmt))
    {
        die(
            "Payment record could not be saved."
        );
    }


    mysqli_stmt_close($stmt);


    // -------------------------------------------------
    // CONFIRM BOOKING
    // -------------------------------------------------

    $booking_status = "Confirmed";


    $booking_stmt = mysqli_prepare(
        $conn,
        "UPDATE booking
         SET booking_status = ?
         WHERE id = ?"
    );


    mysqli_stmt_bind_param(
        $booking_stmt,
        "si",
        $booking_status,
        $booking_id
    );


    mysqli_stmt_execute($booking_stmt);


    mysqli_stmt_close($booking_stmt);


    // -------------------------------------------------
    // SUCCESS PAGE
    // -------------------------------------------------

    ?>

    <!DOCTYPE html>

    <html>

    <head>

        <meta charset="UTF-8">

        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0"
        >

        <title>
            Payment Successful | Akshar Interior
        </title>


        <style>

            * {
                box-sizing: border-box;
            }


            body {

                margin: 0;

                min-height: 100vh;

                display: flex;

                align-items: center;

                justify-content: center;

                font-family:
                    Arial,
                    Helvetica,
                    sans-serif;

                background: #0b0b0b;

                color: #ffffff;

            }


            .success-card {

                width: 90%;

                max-width: 550px;

                padding: 45px 35px;

                text-align: center;

                background: #151515;

                border:
                    1px solid
                    rgba(212,175,55,0.30);

                border-radius: 22px;

                box-shadow:
                    0 20px 60px
                    rgba(0,0,0,0.50);

            }


            .success-icon {

                width: 80px;

                height: 80px;

                margin: 0 auto 22px;

                display: flex;

                align-items: center;

                justify-content: center;

                border-radius: 50%;

                background: #D4AF37;

                color: #111111;

                font-size: 38px;

                font-weight: bold;

            }


            h1 {

                color: #D4AF37;

                margin-bottom: 12px;

            }


            p {

                color: #cccccc;

                line-height: 1.7;

            }


            .details {

                margin-top: 25px;

                padding: 20px;

                background: #0d0d0d;

                border-radius: 12px;

                text-align: left;

            }


            .details div {

                display: flex;

                justify-content: space-between;

                gap: 20px;

                padding: 10px 0;

                border-bottom:
                    1px solid
                    rgba(255,255,255,0.08);

            }


            .details div:last-child {

                border-bottom: none;

            }


            .label {

                color: #999999;

            }


            .value {

                color: #ffffff;

                text-align: right;

                font-weight: 600;

            }


            .amount {

                color: #D4AF37;

                font-size: 20px;

            }


            .home-btn {

                display: inline-block;

                margin-top: 25px;

                padding: 13px 25px;

                border-radius: 10px;

                background: #D4AF37;

                color: #111111;

                text-decoration: none;

                font-weight: 700;

            }


        </style>

    </head>


    <body>


        <div class="success-card">


            <div class="success-icon">

                ✓

            </div>


            <h1>
                Payment Successful
            </h1>


            <p>
                Your token payment has been recorded
                and your booking is now confirmed.
            </p>


            <div class="details">


                <div>

                    <span class="label">
                        Booking ID
                    </span>

                    <span class="value">
                        #<?php echo $booking_id; ?>
                    </span>

                </div>


                <div>

                    <span class="label">
                        Service
                    </span>

                    <span class="value">
                        <?php
                        echo htmlspecialchars($service);
                        ?>
                    </span>

                </div>


                <div>

                    <span class="label">
                        Token Amount
                    </span>

                    <span class="value amount">
                        ₹<?php
                        echo number_format(
                            $amount,
                            0
                        );
                        ?>
                    </span>

                </div>


                <div>

                    <span class="label">
                        Payment Status
                    </span>

                    <span
                        class="value"
                        style="color:#72e6a4;"
                    >
                        Paid
                    </span>

                </div>


                <div>

                    <span class="label">
                        Booking Status
                    </span>

                    <span
                        class="value"
                        style="color:#72e6a4;"
                    >
                        Confirmed
                    </span>

                </div>


            </div>


            <a
                href="index.php"
                class="home-btn"
            >
                Back to Home
            </a>


        </div>


    </body>

    </html>

    <?php

    exit();
}

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Token Payment | Akshar Interior
    </title>


    <style>

        * {
            box-sizing: border-box;
        }


        body {

            margin: 0;

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background:
                radial-gradient(
                    circle at top right,
                    rgba(212,175,55,0.12),
                    transparent 35%
                ),
                #0b0b0b;

            color: #ffffff;

        }


        .payment-card {

            width: 92%;

            max-width: 550px;

            padding: 38px;

            background: #151515;

            border:
                1px solid
                rgba(212,175,55,0.25);

            border-radius: 22px;

            box-shadow:
                0 20px 60px
                rgba(0,0,0,0.50);

        }


        .brand {

            text-align: center;

            margin-bottom: 25px;

        }


        .brand h1 {

            margin: 0;

            font-size: 28px;

            color: #D4AF37;

        }


        .brand p {

            margin-top: 7px;

            color: #888888;

        }


        .payment-heading {

            text-align: center;

            margin-bottom: 28px;

        }


        .payment-heading h2 {

            margin-bottom: 8px;

        }


        .payment-heading p {

            color: #999999;

        }


        .payment-details {

            background: #0d0d0d;

            border-radius: 14px;

            padding: 20px;

            margin-bottom: 25px;

        }


        .detail-row {

            display: flex;

            justify-content: space-between;

            gap: 20px;

            padding: 13px 0;

            border-bottom:
                1px solid
                rgba(255,255,255,0.08);

        }


        .detail-row:last-child {

            border-bottom: none;

        }


        .detail-label {

            color: #999999;

        }


        .detail-value {

            text-align: right;

            color: #ffffff;

            font-weight: 600;

        }


        .token-amount {

            color: #D4AF37;

            font-size: 24px;

        }


        .test-note {

            padding: 13px 15px;

            margin-bottom: 20px;

            border-radius: 9px;

            background:
                rgba(212,175,55,0.08);

            border:
                1px solid
                rgba(212,175,55,0.20);

            color: #D4AF37;

            font-size: 13px;

            text-align: center;

        }


        .pay-btn {

            width: 100%;

            height: 54px;

            border: none;

            border-radius: 10px;

            background: #D4AF37;

            color: #111111;

            font-size: 16px;

            font-weight: 700;

            cursor: pointer;

        }


        .pay-btn:hover {

            background: #e4c04b;

        }


        .cancel-btn {

            display: block;

            text-align: center;

            margin-top: 15px;

            color: #888888;

            text-decoration: none;

            font-size: 13px;

        }


    </style>

</head>


<body>


<div class="payment-card">


    <div class="brand">

        <h1>
            AKSHAR INTERIOR
        </h1>

        <p>
            Luxury Interior Design
        </p>

    </div>


    <div class="payment-heading">

        <h2>
            Token Payment
        </h2>

        <p>
            Complete the token payment to confirm your booking.
        </p>

    </div>


    <div class="payment-details">


        <div class="detail-row">

            <span class="detail-label">
                Booking ID
            </span>

            <span class="detail-value">
                #<?php
                echo $booking_id;
                ?>
            </span>

        </div>


        <div class="detail-row">

            <span class="detail-label">
                Service
            </span>

            <span class="detail-value">
                <?php
                echo htmlspecialchars($service);
                ?>
            </span>

        </div>


        <div class="detail-row">

            <span class="detail-label">
                Token Amount
            </span>

            <span
                class="detail-value token-amount"
            >
                ₹<?php
                echo number_format(
                    $amount,
                    0
                );
                ?>
            </span>

        </div>


    </div>


    <div class="test-note">

        🧪 College Project Test Payment

        <br>

        No real money will be deducted.

    </div>


    <form method="POST">


        <input
            type="hidden"
            name="booking_id"
            value="<?php
            echo $booking_id;
            ?>"
        >


        <input
            type="hidden"
            name="service"
            value="<?php
            echo htmlspecialchars(
                $service
            );
            ?>"
        >


        <input
            type="hidden"
            name="amount"
            value="<?php
            echo $amount;
            ?>"
        >


        <button
            type="submit"
            name="confirm_payment"
            class="pay-btn"
        >

            Pay Token & Confirm Booking

        </button>


    </form>


    <a
        href="booking.php"
        class="cancel-btn"
    >
        ← Back to Booking
    </a>


</div>


</body>

</html>