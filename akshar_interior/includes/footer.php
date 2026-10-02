<style>

/* =========================================================
   AKSHAR INTERIOR FOOTER
========================================================= */

.ak-footer {
    width: 100%;
    background: #0b0b0b;
    color: #ffffff;
    margin-top: 70px;
    border-top: 2px solid #d4af37;
    font-family: Arial, sans-serif;
    box-sizing: border-box;
}

.ak-footer *,
.ak-footer *::before,
.ak-footer *::after {
    box-sizing: border-box;
}


/* =========================================================
   MAIN FOOTER
========================================================= */

.ak-footer-main {
    width: 90%;
    max-width: 1250px;
    margin: 0 auto;
    padding: 65px 0 50px;

    display: grid;
    grid-template-columns: 1.4fr 1fr 1.1fr 1.25fr;
    gap: 50px;
}


/* =========================================================
   BRAND
========================================================= */

.ak-brand-logo {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 25px;
}

.ak-logo-box {
    width: 58px;
    height: 58px;
    border: 2px solid #d4af37;

    display: flex;
    align-items: center;
    justify-content: center;

    color: #d4af37;
    font-size: 25px;
}

.ak-brand-name {
    margin: 0 !important;
    padding: 0 !important;

    color: #ffffff !important;
    font-size: 28px !important;
    font-weight: 700 !important;
    letter-spacing: 2px;
}

.ak-brand-name span {
    color: #d4af37 !important;
}

.ak-brand-subtitle {
    display: block;
    color: #d4af37 !important;
    font-size: 12px !important;
    letter-spacing: 6px;
    margin-top: 5px;
}

.ak-gold-line {
    width: 100%;
    height: 1px;
    background: #51451f;
    margin: 25px 0;
}

.ak-brand-text {
    color: #bdbdbd !important;
    font-size: 14px !important;
    line-height: 1.8 !important;
    margin: 0 0 12px !important;
}


/* =========================================================
   CONSULTATION BUTTON
========================================================= */

.ak-consult-btn {
    display: inline-flex !important;
    align-items: center;
    gap: 10px;

    margin-top: 20px;
    padding: 14px 24px;

    background: #d4af37 !important;
    color: #111111 !important;

    text-decoration: none !important;

    border-radius: 30px;

    font-size: 14px !important;
    font-weight: 600 !important;

    transition: all 0.3s ease;
}

.ak-consult-btn:hover {
    background: #ffffff !important;
    color: #111111 !important;
    transform: translateY(-3px);
}


/* =========================================================
   HEADINGS
========================================================= */

.ak-footer-title {
    margin: 0 !important;
    padding: 0 !important;

    color: #ffffff !important;

    font-size: 18px !important;
    font-weight: 600 !important;
    letter-spacing: 1px;
}

.ak-heading-line {
    width: 45px;
    height: 2px;
    background: #d4af37;
    margin: 13px 0 25px;
}


/* =========================================================
   QUICK LINKS
========================================================= */

.ak-quick-links a {
    display: block;

    color: #bdbdbd !important;

    text-decoration: none !important;

    font-size: 14px !important;

    margin-bottom: 16px;

    transition: 0.3s;
}

.ak-quick-links a::before {
    content: "›";
    color: #d4af37;
    font-size: 19px;
    margin-right: 9px;
}

.ak-quick-links a:hover {
    color: #d4af37 !important;
    padding-left: 5px;
}


/* =========================================================
   SERVICES
========================================================= */

.ak-services a {
    display: flex;
    align-items: center;
    gap: 12px;

    color: #bdbdbd !important;

    text-decoration: none !important;

    font-size: 14px !important;

    padding: 11px 0;

    border-bottom: 1px solid #252525;

    transition: 0.3s;
}

.ak-services a span {
    color: #d4af37;
    font-size: 15px;
}

.ak-services a:hover {
    color: #d4af37 !important;
    padding-left: 5px;
}


/* =========================================================
   CONTACT
========================================================= */

.ak-contact-row {
    display: flex;
    align-items: flex-start;
    gap: 13px;

    margin-bottom: 18px;
}

.ak-contact-icon {
    width: 36px;
    min-width: 36px;
    height: 36px;

    border-radius: 50%;

    background: #d4af37;

    color: #111111;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 14px;
}

.ak-contact-row p {
    margin: 0 !important;

    color: #bdbdbd !important;

    font-size: 14px !important;

    line-height: 1.6 !important;
}


/* =========================================================
   SOCIAL ICONS
   INSTAGRAM + WHATSAPP + YOUTUBE
========================================================= */

.ak-follow {
    margin-top: 27px !important;
}

.ak-social {
    display: flex;
    gap: 12px;
    margin-top: 16px;
}

.ak-social a {
    width: 42px;
    height: 42px;

    border: 1px solid #d4af37;

    border-radius: 50%;

    display: flex;
    align-items: center;
    justify-content: center;

    color: #d4af37;

    text-decoration: none;

    font-size: 18px;

    transition: all 0.3s ease;
}

.ak-social a:hover {
    background: #d4af37;
    color: #111111;
    transform: translateY(-4px);
}


/* =========================================================
   NEWSLETTER
========================================================= */

.ak-newsletter {
    width: 90%;
    max-width: 1250px;

    margin: 0 auto;

    padding: 24px 28px;

    border: 1px solid #51451f;

    border-radius: 15px;

    background: #111111;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 30px;
}

.ak-newsletter-left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.ak-newsletter-icon {
    width: 55px;
    min-width: 55px;
    height: 55px;

    border-radius: 50%;

    background: rgba(212,175,55,0.12);

    color: #d4af37;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 20px;
}

.ak-newsletter h2 {
    margin: 0 0 5px !important;

    color: #ffffff !important;

    font-size: 20px !important;
}

.ak-newsletter p {
    margin: 0 !important;

    color: #999999 !important;

    font-size: 13px !important;
}

.ak-newsletter-form {
    display: flex;
    width: 48%;
}

.ak-newsletter-form input {
    flex: 1;

    height: 50px;

    background: #080808;

    border: 1px solid #51451f;

    outline: none;

    color: #ffffff;

    padding: 0 16px;

    font-size: 14px;

    border-radius: 7px 0 0 7px;
}

.ak-newsletter-form input::placeholder {
    color: #777777;
}

.ak-newsletter-form button {
    height: 50px;

    border: none;

    background: #d4af37;

    color: #111111;

    padding: 0 23px;

    font-weight: 600;

    cursor: pointer;

    border-radius: 0 7px 7px 0;
}

.ak-newsletter-form button:hover {
    background: #ffffff;
}


/* =========================================================
   BOTTOM
========================================================= */

.ak-footer-bottom {
    width: 90%;
    max-width: 1250px;

    margin: 35px auto 0;

    padding: 22px 0;

    border-top: 1px solid #292929;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;
}

.ak-footer-bottom p {
    margin: 0 !important;

    color: #888888 !important;

    font-size: 13px !important;
}

.ak-footer-bottom .gold-text {
    color: #d4af37 !important;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1000px) {

    .ak-footer-main {
        grid-template-columns: 1fr 1fr;
    }

    .ak-newsletter {
        flex-direction: column;
        align-items: stretch;
    }

    .ak-newsletter-form {
        width: 100%;
    }

}


@media (max-width: 600px) {

    .ak-footer-main {
        grid-template-columns: 1fr;
        gap: 40px;
    }

    .ak-newsletter {
        width: 88%;
        padding: 20px;
    }

    .ak-newsletter-left {
        align-items: flex-start;
    }

    .ak-newsletter-form {
        width: 100%;
        flex-direction: column;
        gap: 10px;
    }

    .ak-newsletter-form input {
        border-radius: 7px;
    }

    .ak-newsletter-form button {
        border-radius: 7px;
        height: 48px;
    }

    .ak-footer-bottom {
        flex-direction: column;
        text-align: center;
    }

}

</style>


<!-- =====================================================
     FOOTER
===================================================== -->

<footer class="ak-footer">


    <!-- MAIN FOOTER -->

    <div class="ak-footer-main">


        <!-- BRAND -->

        <div class="ak-brand">

            <div class="ak-brand-logo">

                <div class="ak-logo-box">
                    🏠
                </div>

                <div>

                    <h2 class="ak-brand-name">
                        AKSHAR <span>INTERIOR</span>
                    </h2>

                    <span class="ak-brand-subtitle">
                        INTERIOR DESIGN
                    </span>

                </div>

            </div>


            <div class="ak-gold-line"></div>


            <p class="ak-brand-text">
                We create beautiful, functional and inspiring
                spaces that reflect your personality and lifestyle.
            </p>


            <p class="ak-brand-text">
                Contact Akshar Interior today and let us transform
                your dream space into reality.
            </p>


            <a
                href="booking.php"
                class="ak-consult-btn"
            >
                📅
                Book Consultation
                →
            </a>

        </div>


        <!-- QUICK LINKS -->

        <div class="ak-quick-links">

            <h3 class="ak-footer-title">
                QUICK LINKS
            </h3>

            <div class="ak-heading-line"></div>


            <a href="index.php">
                Home
            </a>

            <a href="about.php">
                About Us
            </a>

            <a href="services.php">
                Services
            </a>

            <a href="gallery.php">
                Gallery
            </a>

            <a href="portfolio.php">
                Portfolio
            </a>

            <a href="booking.php">
                Booking
            </a>

            <a href="contact.php">
                Contact Us
            </a>

        </div>


        <!-- SERVICES -->

        <div class="ak-services">

            <h3 class="ak-footer-title">
                OUR SERVICES
            </h3>

            <div class="ak-heading-line"></div>


            <a href="services.php">
                <span>◆</span>
                Residential Interior
            </a>

            <a href="services.php">
                <span>◆</span>
                Commercial Interior
            </a>

            <a href="services.php">
                <span>◆</span>
                Modular Kitchen
            </a>

            <a href="services.php">
                <span>◆</span>
                False Ceiling
            </a>

            <a href="services.php">
                <span>◆</span>
                Renovation
            </a>

            <a href="services.php">
                <span>◆</span>
                Turnkey Projects
            </a>

        </div>


        <!-- CONTACT -->

        <div class="ak-contact">

            <h3 class="ak-footer-title">
                CONTACT US
            </h3>

            <div class="ak-heading-line"></div>


            <div class="ak-contact-row">

                <div class="ak-contact-icon">
                    📍
                </div>

                <p>
                    123, Design Street,<br>
                    Near City Center,<br>
                    Rajkot, Gujarat 360001
                </p>

            </div>


            <div class="ak-contact-row">

                <div class="ak-contact-icon">
                    ☎
                </div>

                <p>
                    +91 98765 43210
                </p>

            </div>


            <div class="ak-contact-row">

                <div class="ak-contact-icon">
                    ✉
                </div>

                <p>
                    info@aksharinterior.com
                </p>

            </div>


            <div class="ak-contact-row">

                <div class="ak-contact-icon">
                    🌐
                </div>

                <p>
                    www.aksharinterior.com
                </p>

            </div>


            <!-- SOCIAL TITLE -->

            <h3 class="ak-footer-title ak-follow">
                FOLLOW US
            </h3>


            <!-- =================================================
                 INSTAGRAM + WHATSAPP + YOUTUBE
            ================================================== -->

            <div class="ak-social">


                <!-- INSTAGRAM -->

                <a
                    href="https://www.instagram.com/atuljethva_/"
                    target="_blank"
                    rel="noopener noreferrer"
                    title="Instagram"
                    aria-label="Instagram"
                >

                    <i class="fab fa-instagram"></i>

                </a>


                <!-- WHATSAPP -->

                <a
                    href="https://wa.me/918140184408"
                    target="_blank"
                    rel="noopener noreferrer"
                    title="WhatsApp"
                    aria-label="WhatsApp"
                >

                    <i class="fab fa-whatsapp"></i>

                </a>


                <!-- YOUTUBE -->

                <a
                    href="https://www.youtube.com/@Atuljethva_1985"
                    target="_blank"
                    rel="noopener noreferrer"
                    title="YouTube"
                    aria-label="YouTube"
                >

                    <i class="fab fa-youtube"></i>

                </a>


            </div>

        </div>


    </div>


    <!-- =====================================================
         NEWSLETTER
    ====================================================== -->

    <div class="ak-newsletter">


        <div class="ak-newsletter-left">

            <div class="ak-newsletter-icon">
                ✉
            </div>


            <div>

                <h2>
                    Stay Updated
                </h2>

                <p>
                    Get the latest interior design ideas and updates.
                </p>

            </div>

        </div>


        <form class="ak-newsletter-form">

            <input
                type="email"
                placeholder="Enter your email address"
                required
            >

            <button type="submit">
                Subscribe
            </button>

        </form>


    </div>


    <!-- =====================================================
         BOTTOM
    ====================================================== -->

    <div class="ak-footer-bottom">

        <p>
            © <?php echo date("Y"); ?>
            Akshar Interior. All Rights Reserved.
        </p>


        <p>

            <span class="gold-text">
                ♥
            </span>

            Designing Spaces, Creating Memories.

        </p>

    </div>


</footer>


<!-- =====================================================
     FONT AWESOME
===================================================== -->

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
>