<?php

/* =====================================================
   CONTACT PAGE
===================================================== */

include("includes/db.php");

$success = "";
$error = "";


/* =====================================================
   CONTACT FORM
===================================================== */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $subject = trim($_POST["subject"] ?? "");
    $message = trim($_POST["message"] ?? "");


    if (
        empty($name) ||
        empty($phone) ||
        empty($email) ||
        empty($message)
    ) {

        $error = "Please fill all the required fields.";

    }
    elseif (!preg_match("/^[0-9]{10}$/", $phone)) {

        $error = "Please enter a valid 10 digit phone number.";

    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    }
    else {

        /* =================================================
           SAVE MESSAGE IN DATABASE
        ================================================= */

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO contact
            (name, phone, email, subject, message)
            VALUES (?, ?, ?, ?, ?)"
        );

        if (!$stmt) {

            $error = "Unable to prepare contact message: " . mysqli_error($conn);

        }
        else {

            mysqli_stmt_bind_param(
                $stmt,
                "sssss",
                $name,
                $phone,
                $email,
                $subject,
                $message
            );

            if (mysqli_stmt_execute($stmt)) {

                $success = "Thank you! Your message has been submitted successfully.";

            }
            else {

                $error = "Unable to save your message: " . mysqli_stmt_error($stmt);

            }

            mysqli_stmt_close($stmt);
        }
    }
}

?>

<?php include("includes/header.php"); ?>


<!-- =====================================================
     CONTACT PAGE
===================================================== -->

<section class="contact-page">


    <!-- BACKGROUND -->

    <div class="contact-background"></div>


    <!-- DARK OVERLAY -->

    <div class="contact-overlay"></div>


    <div class="contact-container">


        <!-- =================================================
             LEFT SIDE
        ================================================= -->

        <div class="contact-info">


            <div class="small-title">
                AKSHAR INTERIOR
            </div>


            <h1>

                Let's Talk About Your

                <span>
                    Dream Space
                </span>

            </h1>


            <p class="contact-description">

                Have a project in mind? We'd love to hear about it.
                Get in touch with Akshar Interior and let's create
                a beautiful, luxurious and functional space together.

            </p>


            <!-- =================================================
                 CONTACT INFORMATION
            ================================================= -->

            <div class="contact-details">


                <!-- PHONE -->

                <div class="contact-detail">

                    <div class="contact-icon">

                        <i class="fa-solid fa-phone"></i>

                    </div>

                    <div>

                        <h3>
                            Call Us
                        </h3>

                        <p>
                            +91 81401 84408
                        </p>

                    </div>

                </div>



                <!-- EMAIL -->

                <div class="contact-detail">

                    <div class="contact-icon">

                        <i class="fa-solid fa-envelope"></i>

                    </div>

                    <div>

                        <h3>
                            Email Us
                        </h3>

                        <p>
                            info@aksharinterior.com
                        </p>

                    </div>

                </div>



                <!-- LOCATION -->

                <div class="contact-detail">

                    <div class="contact-icon">

                        <i class="fa-solid fa-location-dot"></i>

                    </div>

                    <div>

                        <h3>
                            Visit Us
                        </h3>

                        <p>
                            Rajkot, Gujarat, India
                        </p>

                    </div>

                </div>


            </div>



            <!-- SOCIAL MEDIA -->

            <div class="contact-social">

                <h3>
                    Follow Us
                </h3>


                <div class="social-icons">

                    <a
                        href="https://www.instagram.com/atuljethva_/"
                        target="_blank"
                    >
                        <i class="fa-brands fa-instagram"></i>
                    </a>


                    <a
                        href="https://wa.me/918140184408"
                        target="_blank"
                    >
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>


                    <a
                        href="#"
                    >
                        <i class="fa-brands fa-youtube"></i>
                    </a>

                </div>

            </div>


        </div>



        <!-- =================================================
             RIGHT SIDE
        ================================================= -->

        <div class="contact-right">


            <!-- CONTACT FORM -->

            <div class="contact-card">


                <div class="form-heading">


                    <div class="form-heading-icon">

                        <i class="fa-solid fa-paper-plane"></i>

                    </div>


                    <div>

                        <h2>
                            Send Us a Message
                        </h2>

                        <p>
                            We'd love to hear from you
                        </p>

                    </div>


                </div>



                <!-- SUCCESS -->

                <?php if (!empty($success)) { ?>

                    <div class="success-message">

                        <i class="fa-solid fa-circle-check"></i>

                        <?php echo $success; ?>

                    </div>

                <?php } ?>



                <!-- ERROR -->

                <?php if (!empty($error)) { ?>

                    <div class="error-message">

                        <i class="fa-solid fa-circle-exclamation"></i>

                        <?php echo $error; ?>

                    </div>

                <?php } ?>



                <form
                    method="POST"
                    action=""
                >


                    <!-- NAME -->

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



                    <!-- PHONE -->

                    <div class="form-group">

                        <label>
                            Phone Number
                        </label>

                        <div class="input-box">

                            <i class="fa-solid fa-phone"></i>

                            <input
                                type="tel"
                                name="phone"
                                placeholder="Enter your phone number"
                                maxlength="10"
                                pattern="[0-9]{10}"
                                required
                            >

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



                    <!-- SUBJECT -->

                    <div class="form-group">

                        <label>
                            Subject
                        </label>

                        <div class="input-box">

                            <i class="fa-solid fa-pen"></i>

                            <input
                                type="text"
                                name="subject"
                                placeholder="What would you like to discuss?"
                                required
                            >

                        </div>

                    </div>



                    <!-- MESSAGE -->

                    <div class="form-group">

                        <label>
                            Your Message
                        </label>

                        <div class="textarea-box">

                            <i class="fa-solid fa-message"></i>

                            <textarea
                                name="message"
                                rows="5"
                                placeholder="Write your message here..."
                                required
                            ></textarea>

                        </div>

                    </div>



                    <!-- BUTTON -->

                    <button
                        type="submit"
                        class="contact-btn"
                    >

                        <span>
                            Send Message
                        </span>

                        <i class="fa-solid fa-arrow-right"></i>

                    </button>


                    <p class="secure-text">

                        <i class="fa-solid fa-shield-halved"></i>

                        We respect your privacy and keep your
                        information secure.

                    </p>


                </form>


            </div>


        </div>


    </div>


</section>



<!-- =====================================================
     MAP SECTION
===================================================== -->

<section class="contact-map-section">


    <div class="container">


        <div class="section-title">

            <h2>
                Find Us
            </h2>

            <p>
                Visit Akshar Interior in Rajkot, Gujarat
            </p>

        </div>


        <div class="map-wrapper">


            <iframe
                src="https://www.google.com/maps?q=Rajkot,Gujarat,India&output=embed"
                width="100%"
                height="450"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
            >
            </iframe>


        </div>


    </div>

</section>



<!-- =====================================================
     CONTACT CSS
===================================================== -->

<style>


/* =====================================================
   CONTACT MAIN PAGE
===================================================== */

.contact-page {

    position: relative;

    min-height: 720px;

    padding: 90px 0;

    overflow: hidden;

    background: #0b0b0b;

}



/* BACKGROUND */

.contact-background {

    position: absolute;

    top: 0;
    left: 0;

    width: 100%;
    height: 100%;

    background-image:
        url('assets/images/about_page.jpeg');

    background-size: cover;

    background-position: center;

    opacity: 0.18;

}



/* OVERLAY */

.contact-overlay {

    position: absolute;

    top: 0;
    left: 0;

    width: 100%;
    height: 100%;

    background:
        linear-gradient(
            90deg,
            rgba(0,0,0,0.97),
            rgba(0,0,0,0.90),
            rgba(0,0,0,0.95)
        );

}



/* CONTAINER */

.contact-container {

    position: relative;

    z-index: 2;

    width: 90%;

    max-width: 1200px;

    margin: auto;

    display: grid;

    grid-template-columns:
        0.9fr 1.1fr;

    gap: 70px;

    align-items: start;

}



/* =====================================================
   LEFT SIDE
===================================================== */

.contact-info {

    padding-top: 20px;

}



.small-title {

    color: #D4AF37;

    font-size: 14px;

    font-weight: 700;

    letter-spacing: 3px;

    margin-bottom: 18px;

}



.contact-info h1 {

    color: #ffffff;

    font-size: 56px;

    line-height: 1.08;

    margin: 0 0 25px;

    font-weight: 700;

}



.contact-info h1 span {

    display: block;

    color: #D4AF37;

}



.contact-description {

    color: #cfcfcf;

    font-size: 17px;

    line-height: 1.8;

    max-width: 520px;

    margin-bottom: 35px;

}



/* =====================================================
   CONTACT DETAILS
===================================================== */

.contact-details {

    display: flex;

    flex-direction: column;

    gap: 16px;

}



.contact-detail {

    display: flex;

    align-items: center;

    gap: 18px;

    max-width: 480px;

    padding: 16px;

    border-radius: 14px;

    background: rgba(255,255,255,0.04);

    border: 1px solid rgba(212,175,55,0.18);

    transition: 0.3s;

}



.contact-detail:hover {

    transform: translateX(8px);

    border-color: rgba(212,175,55,0.55);

    background: rgba(212,175,55,0.06);

}



.contact-icon {

    width: 48px;

    min-width: 48px;

    height: 48px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: #D4AF37;

    color: #111;

    font-size: 18px;

}



.contact-detail h3 {

    color: #ffffff;

    font-size: 16px;

    margin: 0 0 4px;

}



.contact-detail p {

    color: #aaa;

    font-size: 14px;

    margin: 0;

}



/* =====================================================
   SOCIAL
===================================================== */

.contact-social {

    margin-top: 32px;

}



.contact-social h3 {

    color: #ffffff;

    font-size: 15px;

    margin-bottom: 12px;

}



.social-icons {

    display: flex;

    gap: 12px;

}



.social-icons a {

    width: 42px;

    height: 42px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: rgba(255,255,255,0.06);

    border: 1px solid rgba(212,175,55,0.30);

    color: #D4AF37;

    font-size: 18px;

    text-decoration: none;

    transition: 0.3s;

}



.social-icons a:hover {

    background: #D4AF37;

    color: #111;

    transform: translateY(-4px);

}



/* =====================================================
   CONTACT CARD
===================================================== */

.contact-card {

    background: rgba(20,20,20,0.97);

    border: 1px solid rgba(212,175,55,0.25);

    border-radius: 24px;

    padding: 38px;

    box-shadow:
        0 25px 70px rgba(0,0,0,0.55);

}



/* FORM HEADING */

.form-heading {

    display: flex;

    align-items: center;

    gap: 15px;

    padding-bottom: 25px;

    margin-bottom: 25px;

    border-bottom:
        1px solid rgba(255,255,255,0.08);

}



.form-heading-icon {

    width: 52px;

    height: 52px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 14px;

    background: #D4AF37;

    color: #111;

    font-size: 20px;

}



.form-heading h2 {

    color: #ffffff;

    font-size: 27px;

    margin: 0 0 4px;

}



.form-heading p {

    color: #999;

    margin: 0;

    font-size: 14px;

}



/* =====================================================
   SUCCESS
===================================================== */

.success-message {

    display: flex;

    align-items: center;

    gap: 10px;

    padding: 14px 16px;

    margin-bottom: 20px;

    border-radius: 10px;

    background: rgba(46,204,113,0.12);

    border: 1px solid rgba(46,204,113,0.35);

    color: #65e6a0;

}



/* ERROR */

.error-message {

    display: flex;

    align-items: center;

    gap: 10px;

    padding: 14px 16px;

    margin-bottom: 20px;

    border-radius: 10px;

    background: rgba(231,76,60,0.12);

    border: 1px solid rgba(231,76,60,0.35);

    color: #ff8c80;

}



/* =====================================================
   FORM
===================================================== */

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



.input-box i {

    position: absolute;

    left: 15px;

    top: 50%;

    transform: translateY(-50%);

    color: #D4AF37;

    font-size: 14px;

}



.input-box input {

    width: 100%;

    height: 52px;

    box-sizing: border-box;

    padding: 0 15px 0 43px;

    border-radius: 10px;

    border: 1px solid #333;

    outline: none;

    background: #111;

    color: #ffffff;

    font-size: 14px;

    transition: 0.3s;

}



.input-box input:focus {

    border-color: #D4AF37;

    box-shadow:
        0 0 0 3px rgba(212,175,55,0.08);

}



.input-box input::placeholder {

    color: #777;

}



/* TEXTAREA */

.textarea-box {

    position: relative;

}



.textarea-box i {

    position: absolute;

    left: 15px;

    top: 17px;

    color: #D4AF37;

}



.textarea-box textarea {

    width: 100%;

    min-height: 130px;

    box-sizing: border-box;

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

    box-shadow:
        0 0 0 3px rgba(212,175,55,0.08);

}



.textarea-box textarea::placeholder {

    color: #777;

}



/* =====================================================
   BUTTON
===================================================== */

.contact-btn {

    width: 100%;

    height: 55px;

    border: none;

    border-radius: 12px;

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 12px;

    background: #D4AF37;

    color: #111;

    font-size: 16px;

    font-weight: 700;

    cursor: pointer;

    transition: 0.3s;

}



.contact-btn:hover {

    background: #e4c04b;

    transform: translateY(-2px);

    box-shadow:
        0 10px 30px rgba(212,175,55,0.20);

}



.secure-text {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    color: #777;

    font-size: 12px;

    margin: 15px 0 0;

}



.secure-text i {

    color: #D4AF37;

}



/* =====================================================
   MAP
===================================================== */

.contact-map-section {

    padding: 80px 0;

    background: #0d0d0d;

}



.map-wrapper {

    width: 90%;

    max-width: 1200px;

    margin: auto;

    overflow: hidden;

    border-radius: 20px;

    border: 1px solid rgba(212,175,55,0.25);

    box-shadow:
        0 20px 50px rgba(0,0,0,0.40);

}



.map-wrapper iframe {

    display: block;

    filter: grayscale(20%);

}



/* =====================================================
   RESPONSIVE
===================================================== */

@media(max-width:1000px) {

    .contact-container {

        grid-template-columns: 1fr;

        max-width: 750px;

        gap: 45px;

    }


    .contact-info {

        text-align: center;

    }


    .contact-description {

        margin-left: auto;

        margin-right: auto;

    }


    .contact-details {

        text-align: left;

    }


    .contact-social {

        text-align: center;

    }


    .social-icons {

        justify-content: center;

    }


    .contact-info h1 {

        font-size: 48px;

    }

}



@media(max-width:600px) {

    .contact-page {

        padding: 55px 0;

    }


    .contact-container {

        width: 92%;

    }


    .contact-info h1 {

        font-size: 38px;

    }


    .contact-card {

        padding: 25px 18px;

        border-radius: 18px;

    }


    .form-heading h2 {

        font-size: 22px;

    }


    .map-wrapper {

        width: 92%;

    }

}

</style>



<?php include("includes/footer.php"); ?>