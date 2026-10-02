<?php

include("includes/db.php");


// =====================================================
// AJAX BOOKING CREATION
// =====================================================

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["action"]) &&
    $_POST["action"] === "create_booking"
) {

    header("Content-Type: application/json");


    // -------------------------------------------------
    // GET FORM DATA
    // -------------------------------------------------

    $name = trim($_POST["name"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $service = trim($_POST["service"] ?? "");
    $booking_date = trim($_POST["booking_date"] ?? "");
    $message = trim($_POST["message"] ?? "");


    // -------------------------------------------------
    // VALIDATION
    // -------------------------------------------------

    if (
        empty($name) ||
        empty($phone) ||
        empty($email) ||
        empty($service) ||
        empty($booking_date)
    ) {

        echo json_encode([
            "success" => false,
            "message" => "Please fill all required fields."
        ]);

        exit();
    }


    // -------------------------------------------------
    // PHONE VALIDATION
    // -------------------------------------------------

    if (!preg_match("/^[0-9]{10}$/", $phone)) {

        echo json_encode([
            "success" => false,
            "message" => "Please enter a valid 10 digit phone number."
        ]);

        exit();
    }


    // -------------------------------------------------
    // DATE VALIDATION
    // -------------------------------------------------

    if ($booking_date < date("Y-m-d")) {

        echo json_encode([
            "success" => false,
            "message" => "Please select a valid future date."
        ]);

        exit();
    }


    // -------------------------------------------------
    // CHECK SERVICE TOKEN PRICE
    // -------------------------------------------------

    $price_stmt = mysqli_prepare(
        $conn,
        "SELECT token_amount
         FROM token_prices
         WHERE service_name = ?
         AND status = 1
         LIMIT 1"
    );

    if (!$price_stmt) {

        echo json_encode([
            "success" => false,
            "message" => "Unable to prepare token price query: " . mysqli_error($conn)
        ]);

        exit();
    }

    mysqli_stmt_bind_param(
        $price_stmt,
        "s",
        $service
    );

    if (!mysqli_stmt_execute($price_stmt)) {

        echo json_encode([
            "success" => false,
            "message" => "Unable to check token price: " . mysqli_stmt_error($price_stmt)
        ]);

        mysqli_stmt_close($price_stmt);
        exit();
    }

    mysqli_stmt_bind_result(
        $price_stmt,
        $token_amount
    );

    if (!mysqli_stmt_fetch($price_stmt)) {

        mysqli_stmt_close($price_stmt);

        echo json_encode([
            "success" => false,
            "message" => "Token price not found for selected service."
        ]);

        exit();
    }

    $token_amount = (float)$token_amount;

    mysqli_stmt_close($price_stmt);


    // -------------------------------------------------
    // INSERT BOOKING
    // -------------------------------------------------

    $booking_status = "Pending Payment";


    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO booking
        (
            name,
            phone,
            email,
            service,
            booking_date,
            message,
            booking_status
        )
        VALUES (?, ?, ?, ?, ?, ?, ?)"
    );

    if (!$stmt) {

        echo json_encode([
            "success" => false,
            "message" => "Unable to prepare booking query: " . mysqli_error($conn)
        ]);

        exit();
    }

    mysqli_stmt_bind_param(
        $stmt,
        "sssssss",
        $name,
        $phone,
        $email,
        $service,
        $booking_date,
        $message,
        $booking_status
    );

    if (!mysqli_stmt_execute($stmt)) {

        $error_message = mysqli_stmt_error($stmt);

        mysqli_stmt_close($stmt);

        echo json_encode([
            "success" => false,
            "message" => "Unable to create booking: " . $error_message
        ]);

        exit();
    }


    // -------------------------------------------------
    // GET BOOKING ID
    // -------------------------------------------------

    $booking_id = mysqli_insert_id($conn);

    mysqli_stmt_close($stmt);


    // -------------------------------------------------
    // SUCCESS
    // -------------------------------------------------

    header(
        "Location: test_payment.php"
        . "?booking_id=" . urlencode($booking_id)
        . "&service=" . urlencode($service)
        . "&amount=" . urlencode($token_amount)
    );

    exit();
}

?>

<?php include("includes/header.php"); ?>




<!-- =====================================================
     BOOKING PAGE
===================================================== -->

<section class="booking-page">


    <!-- BACKGROUND -->

    <div class="booking-background"></div>


    <!-- OVERLAY -->

    <div class="booking-overlay"></div>


    <div class="booking-container">


        <!-- =================================================
             LEFT CONTENT
        ================================================= -->

        <div class="booking-info">


            <div class="small-title">
                AKSHAR INTERIOR
            </div>


            <h1>

                Let's Create Your

                <span>
                    Dream Space
                </span>

            </h1>


            <p class="booking-description">

                Book a consultation with our interior design
                experts and turn your ideas into a beautiful,
                luxurious and functional space.

            </p>


            <div class="booking-features">


                <div class="feature-box">

                    <div class="feature-icon">
                        <i class="fa-solid fa-house"></i>
                    </div>

                    <div>

                        <h3>
                            Luxury Design
                        </h3>

                        <p>
                            Elegant interiors designed specially for you.
                        </p>

                    </div>

                </div>


                <div class="feature-box">

                    <div class="feature-icon">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>

                    <div>

                        <h3>
                            Expert Consultation
                        </h3>

                        <p>
                            Discuss your ideas with our design experts.
                        </p>

                    </div>

                </div>


                <div class="feature-box">

                    <div class="feature-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>

                    <div>

                        <h3>
                            Secure Token Payment
                        </h3>

                        <p>
                            Pay the required service token to confirm your booking.
                        </p>

                    </div>

                </div>


            </div>


        </div>


        <!-- =================================================
             BOOKING CARD
        ================================================= -->

        <div class="booking-card">


            <div class="form-heading">

                <span>
                    <i class="fa-solid fa-calendar-days"></i>
                </span>

                <div>

                    <h2>
                        Book Appointment
                    </h2>

                    <p>
                        Complete your details to continue
                    </p>

                </div>

            </div>


            <!-- MESSAGE -->

            <div
                id="formMessage"
                style="display:none;"
            ></div>


            <form
                id="bookingForm"
                method="POST"
                action="booking.php"
            >

                <input
                    type="hidden"
                    name="action"
                    value="create_booking"
                >


                <!-- NAME + PHONE -->

                <div class="form-row">


                    <div class="form-group">

                        <label>
                            Full Name
                        </label>

                        <div class="input-box">

                            <i class="fa-solid fa-user"></i>

                            <input
                                type="text"
                                name="name"
                                placeholder="Enter your full name"
                                required
                            >

                        </div>

                    </div>


                    <div class="form-group">

                        <label>
                            Phone Number
                        </label>

                        <div class="input-box">

                            <i class="fa-solid fa-phone"></i>

                            <input
                                type="tel"
                                name="phone"
                                placeholder="Enter 10 digit phone number"
                                pattern="[0-9]{10}"
                                maxlength="10"
                                required
                            >

                        </div>

                    </div>


                </div>


                <!-- EMAIL -->

                <div class="form-group">

                    <label>
                        Email Address
                    </label>

                    <div class="input-box">

                        <i class="fa-solid fa-envelope"></i>

                        <input
                            type="email"
                            name="email"
                            placeholder="Enter your email address"
                            required
                        >

                    </div>

                </div>


                <!-- SERVICE -->

                <div class="form-group">

                    <label>
                        Select Service
                    </label>

                    <div class="input-box">

                        <i class="fa-solid fa-paint-roller"></i>

                        <select
                            name="service"
                            id="service"
                            required
                        >

                            <option value="">
                                Select a service
                            </option>

                            <option value="Home Interior">
                                Home Interior - Token ₹5000
                            </option>

                            <option value="Modular Kitchen">
                                Modular Kitchen - Token ₹3000
                            </option>

                            <option value="Bedroom Design">
                                Bedroom Design - Token ₹2000
                            </option>

                            <option value="Living Room">
                                Living Room - Token ₹2500
                            </option>

                            <option value="Office Interior">
                                Office Interior - Token ₹7000
                            </option>

                            <option value="TV Unit & Wardrobe">
                                TV Unit & Wardrobe - Token ₹2000
                            </option>

                        </select>

                    </div>

                </div>


                <!-- TOKEN DISPLAY -->

                <div
                    id="tokenBox"
                    class="token-box"
                    style="display:none;"
                >

                    <div class="token-icon">

                        <i class="fa-solid fa-indian-rupee-sign"></i>

                    </div>

                    <div>

                        <span>
                            Required Token Amount
                        </span>

                        <strong id="tokenAmount">
                            ₹0
                        </strong>

                    </div>

                </div>


                <!-- DATE -->

                <div class="form-group">

                    <label>
                        Preferred Date
                    </label>

                    <div class="input-box">

                        <i class="fa-solid fa-calendar"></i>

                        <input
                            type="date"
                            name="booking_date"
                            min="<?php echo date('Y-m-d'); ?>"
                            required
                        >

                    </div>

                </div>


                <!-- MESSAGE -->

                <div class="form-group">

                    <label>
                        Message
                    </label>

                    <div class="textarea-box">

                        <i class="fa-solid fa-message"></i>

                        <textarea
                            name="message"
                            placeholder="Tell us about your interior project..."
                            rows="5"
                        ></textarea>

                    </div>

                </div>


                <!-- PAYMENT BUTTON -->

                <button
                    type="submit"
                    class="booking-btn"
                    id="bookingButton"
                >

                    <span id="buttonText">
                        Continue to Payment
                    </span>

                    <i class="fa-solid fa-arrow-right"></i>

                </button>


                <p class="form-note">

                    <i class="fa-solid fa-lock"></i>

                    Your information is safe and secure.

                </p>


            </form>


        </div>


    </div>

</section>


<!-- =====================================================
     CSS
===================================================== -->

<style>


.booking-page {

    position: relative;

    min-height: calc(100vh - 90px);

    padding: 80px 0;

    overflow: hidden;

    background: #0b0b0b;

}


.booking-background {

    position: absolute;

    inset: 0;

    width: 100%;
    height: 100%;

    background-image:
        url('assets/images/about_page.jpeg');

    background-size: cover;

    background-position: center;

    opacity: 0.20;

}


.booking-overlay {

    position: absolute;

    inset: 0;

    background:
        linear-gradient(
            90deg,
            rgba(0,0,0,0.97),
            rgba(0,0,0,0.88),
            rgba(0,0,0,0.94)
        );

}


.booking-container {

    position: relative;

    z-index: 2;

    width: 90%;

    max-width: 1200px;

    margin: auto;

    display: grid;

    grid-template-columns: 0.9fr 1.1fr;

    gap: 70px;

    align-items: center;

}


.booking-info {

    padding: 20px 0;

}


.small-title {

    color: #D4AF37;

    font-size: 14px;

    font-weight: 700;

    letter-spacing: 3px;

    margin-bottom: 18px;

}


.booking-info h1 {

    color: #ffffff;

    font-size: 58px;

    line-height: 1.08;

    margin: 0 0 25px;

    font-weight: 700;

}


.booking-info h1 span {

    display: block;

    color: #D4AF37;

}


.booking-description {

    color: #cfcfcf;

    font-size: 17px;

    line-height: 1.8;

    max-width: 540px;

    margin-bottom: 35px;

}


.booking-features {

    display: flex;

    flex-direction: column;

    gap: 18px;

}


.feature-box {

    display: flex;

    align-items: center;

    gap: 18px;

    padding: 16px 18px;

    max-width: 500px;

    background: rgba(255,255,255,0.04);

    border: 1px solid rgba(212,175,55,0.18);

    border-radius: 14px;

    transition: 0.3s;

}


.feature-box:hover {

    transform: translateX(8px);

    border-color: rgba(212,175,55,0.55);

    background: rgba(212,175,55,0.06);

}


.feature-icon {

    min-width: 48px;

    width: 48px;

    height: 48px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: #D4AF37;

    color: #111;

    font-size: 18px;

}


.feature-box h3 {

    margin: 0 0 4px;

    color: #ffffff;

    font-size: 16px;

}


.feature-box p {

    margin: 0;

    color: #aaa;

    font-size: 13px;

    line-height: 1.5;

}


.booking-card {

    background: rgba(20,20,20,0.96);

    border: 1px solid rgba(212,175,55,0.25);

    border-radius: 24px;

    padding: 38px;

    box-shadow:
        0 25px 70px rgba(0,0,0,0.55);

}


.form-heading {

    display: flex;

    align-items: center;

    gap: 15px;

    padding-bottom: 25px;

    margin-bottom: 25px;

    border-bottom:
        1px solid rgba(255,255,255,0.08);

}


.form-heading > span {

    width: 52px;

    height: 52px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 14px;

    background: #D4AF37;

    color: #111;

    font-size: 21px;

}


.form-heading h2 {

    color: #ffffff;

    font-size: 28px;

    margin: 0 0 4px;

}


.form-heading p {

    color: #999;

    margin: 0;

    font-size: 14px;

}


.form-row {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 18px;

}


.form-group {

    margin-bottom: 20px;

}


.form-group label {

    display: block;

    color: #eeeeee;

    font-size: 13px;

    font-weight: 600;

    margin-bottom: 8px;

}


.input-box {

    position: relative;

}


.input-box > i {

    position: absolute;

    left: 15px;

    top: 50%;

    transform: translateY(-50%);

    color: #D4AF37;

    font-size: 14px;

    z-index: 2;

}


.input-box input,

.input-box select {

    width: 100%;

    height: 50px;

    box-sizing: border-box;

    padding: 0 15px 0 43px;

    border-radius: 10px;

    border: 1px solid #333;

    outline: none;

    background: #111;

    color: #ffffff;

    font-family: inherit;

    font-size: 14px;

    transition: 0.3s;

}


.input-box input:focus,

.input-box select:focus {

    border-color: #D4AF37;

    box-shadow:
        0 0 0 3px rgba(212,175,55,0.08);

}


.input-box input::placeholder {

    color: #777;

}


.input-box input[type="date"] {

    color-scheme: dark;

}


.textarea-box {

    position: relative;

}


.textarea-box > i {

    position: absolute;

    left: 15px;

    top: 17px;

    color: #D4AF37;

    font-size: 14px;

}


.textarea-box textarea {

    width: 100%;

    box-sizing: border-box;

    min-height: 120px;

    resize: vertical;

    padding: 14px 15px 14px 43px;

    border-radius: 10px;

    border: 1px solid #333;

    outline: none;

    background: #111;

    color: #ffffff;

    font-family: inherit;

    font-size: 14px;

}


.textarea-box textarea:focus {

    border-color: #D4AF37;

}


.textarea-box textarea::placeholder {

    color: #777;

}


/* TOKEN BOX */

.token-box {

    display: flex;

    align-items: center;

    gap: 15px;

    padding: 16px 18px;

    margin: 5px 0 22px;

    border-radius: 14px;

    background: rgba(212,175,55,0.08);

    border: 1px solid rgba(212,175,55,0.35);

}


.token-icon {

    width: 45px;

    height: 45px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: #D4AF37;

    color: #111;

}


.token-box span {

    display: block;

    color: #aaa;

    font-size: 12px;

    margin-bottom: 3px;

}


.token-box strong {

    color: #D4AF37;

    font-size: 22px;

}


.booking-btn {

    width: 100%;

    height: 55px;

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 12px;

    border: none;

    border-radius: 12px;

    background: #D4AF37;

    color: #111;

    font-size: 16px;

    font-weight: 700;

    cursor: pointer;

    transition: 0.3s;

}


.booking-btn:hover {

    background: #e4c04b;

    transform: translateY(-2px);

}


.booking-btn:disabled {

    opacity: 0.6;

    cursor: not-allowed;

    transform: none;

}


.form-note {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    color: #777;

    font-size: 12px;

    margin: 16px 0 0;

}


.form-note i {

    color: #D4AF37;

}


/* MESSAGE */

.form-message {

    padding: 14px 16px;

    border-radius: 10px;

    margin-bottom: 20px;

    font-size: 14px;

}


.form-message.error {

    color: #ff9c91;

    background: rgba(231,76,60,0.12);

    border: 1px solid rgba(231,76,60,0.35);

}


.form-message.success {

    color: #71e6a4;

    background: rgba(46,204,113,0.12);

    border: 1px solid rgba(46,204,113,0.35);

}


@media(max-width:1000px) {

    .booking-container {

        grid-template-columns: 1fr;

        gap: 40px;

        max-width: 750px;

    }


    .booking-info {

        text-align: center;

    }


    .booking-description {

        margin-left: auto;

        margin-right: auto;

    }


    .booking-features {

        max-width: 550px;

        margin: auto;

        text-align: left;

    }


    .booking-info h1 {

        font-size: 48px;

    }

}


@media(max-width:600px) {

    .booking-page {

        padding: 50px 0;

    }


    .booking-container {

        width: 92%;

    }


    .booking-info h1 {

        font-size: 38px;

    }


    .booking-card {

        padding: 25px 18px;

        border-radius: 18px;

    }


    .form-row {

        grid-template-columns: 1fr;

        gap: 0;

    }


    .form-heading h2 {

        font-size: 23px;

    }

}

</style>


<!-- =====================================================
     TEST PAYMENT JAVASCRIPT
===================================================== -->

<script>

document.addEventListener(
    "DOMContentLoaded",
    function()
    {

        const form =
            document.getElementById("bookingForm");

        const service =
            document.getElementById("service");

        const tokenBox =
            document.getElementById("tokenBox");

        const tokenAmount =
            document.getElementById("tokenAmount");

        const button =
            document.getElementById("bookingButton");

        const buttonText =
            document.getElementById("buttonText");

        const formMessage =
            document.getElementById("formMessage");


        // =============================================
        // TOKEN PRICES
        // =============================================

        const tokenPrices = {

            "Home Interior": 5000,

            "Modular Kitchen": 3000,

            "Bedroom Design": 2000,

            "Living Room": 2500,

            "Office Interior": 7000,

            "TV Unit & Wardrobe": 2000

        };


        // =============================================
        // SHOW TOKEN PRICE
        // =============================================

        service.addEventListener(
            "change",
            function()
            {

                const selectedService =
                    this.value;


                if (
                    tokenPrices[selectedService] !== undefined
                ) {

                    tokenAmount.innerText =
                        "₹" +
                        tokenPrices[selectedService].toLocaleString("en-IN");

                    tokenBox.style.display =
                        "flex";

                }
                else {

                    tokenAmount.innerText = "₹0";

                    tokenBox.style.display =
                        "none";

                }

            }
        );


        // =============================================
        // SHOW MESSAGE
        // =============================================

        function showMessage(
            message,
            type
        ) {

            formMessage.className =
                "form-message " + type;

            formMessage.innerHTML =
                message;

            formMessage.style.display =
                "block";

        }


    }
);

</script>


<?php include("includes/footer.php"); ?>
