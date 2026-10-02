<?php include("includes/header.php"); ?>

<style>

/* =====================================================
   HOME PAGE HERO BACKGROUND
===================================================== */

.hero {
    height: auto;
    min-height: calc(100vh - 90px);

    display: flex;
    align-items: center;

    position: relative;
    overflow: hidden;

    background: #000 !important;

    box-sizing: border-box;
    padding: 110px 0 100px;
}


/* BACKGROUND IMAGE */

.hero::after {

    content: "";

    position: absolute;

    top: -15px;
    left: -15px;

    width: calc(100% + 30px);
    height: calc(100% + 30px);

    background-image:
        url("assets/images/blurred_interior.jpeg");

    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;

    filter: blur(7px);

    transform: scale(1.03);

    z-index: 0;
}


/* DARK OVERLAY */

.hero::before {

    content: "";

    position: absolute;

    top: 0;
    left: 0;

    width: 100%;
    height: 100%;

    background: rgba(0, 0, 0, 0.62);

    z-index: 1;
}


/* HERO CONTENT */

.hero .container {

    position: relative;

    z-index: 2;
}


.hero-content {

    position: relative;

    z-index: 3;

    max-width: 700px;
}


.hero-content h4 {

    color: #D4AF37;

    font-size: 18px;

    letter-spacing: 3px;

    margin-bottom: 20px;

}


.hero-content h1 {

    color: #ffffff;

}


.hero-content h1 span {

    color: #D4AF37;

}


.hero-content p {

    color: #eeeeee;

}


/* MOBILE */

@media(max-width:768px) {

    .hero {

        min-height: 650px;

    }

    .hero-content h1 {

        font-size: 42px !important;

        line-height: 1.2 !important;

    }

}



/* =====================================================
   FINAL HERO CONTENT / BUTTON VISIBILITY FIX
===================================================== */

.hero-content {
    position: relative;
    z-index: 3;
    max-width: 760px;
    width: 100%;
}

.hero-content h1 {
    margin-bottom: 24px;
}

.hero-content p {
    margin-bottom: 0;
}

.hero-btn {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 16px;
    flex-wrap: nowrap;
    width: 100%;
    margin-top: 28px;
    position: relative;
    z-index: 10;
}

.hero-btn .btn {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    flex: 0 0 auto !important;
    width: 220px !important;
    min-width: 220px !important;
    height: 54px !important;
    padding: 0 22px !important;
    margin: 0 !important;
    box-sizing: border-box !important;
    border-radius: 999px !important;
    line-height: 1 !important;
    white-space: nowrap !important;
    text-align: center;
}

.hero-btn .btn-outline {
    background: rgba(0,0,0,0.18) !important;
    color: #ffffff !important;
    border: 2px solid #D4AF37 !important;
}

@media (max-width: 900px) {
    .hero {
        min-height: auto;
        padding: 90px 0 80px;
    }

    .hero-content {
        max-width: 680px;
    }
}

@media (max-width: 600px) {
    .hero {
        min-height: auto;
        padding: 80px 0 70px;
    }

    .hero-btn {
        flex-direction: column;
        align-items: stretch;
        gap: 12px;
    }

    .hero-btn .btn {
        width: 100% !important;
        min-width: 0 !important;
        max-width: 320px;
        height: 52px !important;
    }
}

</style>


<!-- =====================================================
     HERO SECTION
===================================================== -->

<section class="hero">

    <div class="container">

        <div class="hero-content" data-aos="fade-right">

            <h4>
                WELCOME TO AKSHAR INTERIOR
            </h4>


            <h1>

                Luxury
                <span>Interior Design</span>
                <br>

                For Your Dream Home

            </h1>


            <p>

                We create elegant, modern and luxurious interiors
                for homes, offices and commercial spaces with
                premium quality workmanship.

            </p>


            <div class="hero-btn">


                <a
                    href="booking.php"
                    class="btn"
                >

                    Book Consultation

                </a>


                <a
                    href="portfolio.php"
                    class="btn btn-outline"
                >

                    View Portfolio

                </a>


            </div>

        </div>

    </div>

</section>



<!-- =====================================================
     ABOUT PREVIEW
===================================================== -->

<section class="about">

    <div class="container">


        <div
            class="section-title"
            data-aos="fade-up"
        >

            <h2>
                About Akshar Interior
            </h2>


            <p>
                Turning Your Dream Space Into Reality
            </p>

        </div>



        <div class="about-wrapper">


            <!-- ABOUT IMAGE -->

            <div
                class="about-image"
                data-aos="fade-right"
            >

                <img
                    src="assets/images/about.jpeg"
                    alt="About Akshar Interior"
                >

            </div>



            <!-- ABOUT CONTENT -->

            <div
                class="about-content"
                data-aos="fade-left"
            >

                <h2>
                    Luxury Interior Experts
                </h2>


                <p>

                    Akshar Interior specializes in luxurious interior
                    design solutions for homes, offices and commercial
                    spaces with creative concepts and premium quality.

                </p>


                <p>

                    We believe every space should reflect beauty,
                    comfort and functionality.

                </p>



                <!-- ABOUT BOXES -->

                <div class="about-boxes">


                    <div class="about-box">

                        <h3>
                            10+
                        </h3>

                        <span>
                            Years Experience
                        </span>

                    </div>



                    <div class="about-box">

                        <h3>
                            500+
                        </h3>

                        <span>
                            Projects
                        </span>

                    </div>



                    <div class="about-box">

                        <h3>
                            100%
                        </h3>

                        <span>
                            Happy Clients
                        </span>

                    </div>


                </div>


                <br>


                <a
                    href="about.php"
                    class="btn"
                >

                    Read More

                </a>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     SERVICES SECTION
===================================================== -->

<section class="services">

    <div class="container">


        <div
            class="section-title"
            data-aos="fade-up"
        >

            <h2>
                Our Premium Services
            </h2>


            <p>
                Elegant Interior Solutions Designed For Every Space
            </p>

        </div>



        <div class="service-grid">


            <!-- SERVICE 1 -->

            <div
                class="service-card"
                data-aos="zoom-in"
            >

                <i class="fa-solid fa-house"></i>


                <h3>
                    Home Interior
                </h3>


                <p>

                    Complete luxury home interior with modern design
                    and premium finishing.

                </p>

            </div>



            <!-- SERVICE 2 -->

            <div
                class="service-card"
                data-aos="zoom-in"
                data-aos-delay="100"
            >

                <i class="fa-solid fa-kitchen-set"></i>


                <h3>
                    Modular Kitchen
                </h3>


                <p>

                    Stylish modular kitchens with smart storage
                    and elegant layouts.

                </p>

            </div>



            <!-- SERVICE 3 -->

            <div
                class="service-card"
                data-aos="zoom-in"
                data-aos-delay="200"
            >

                <i class="fa-solid fa-couch"></i>


                <h3>
                    Living Room
                </h3>


                <p>

                    Luxury living room concepts that combine
                    comfort with style.

                </p>

            </div>



            <!-- SERVICE 4 -->

            <div
                class="service-card"
                data-aos="zoom-in"
                data-aos-delay="300"
            >

                <i class="fa-solid fa-building"></i>


                <h3>
                    Office Interior
                </h3>


                <p>

                    Professional office interiors designed
                    for productivity and elegance.

                </p>

            </div>



            <!-- SERVICE 5 -->

            <div
                class="service-card"
                data-aos="zoom-in"
                data-aos-delay="400"
            >

                <i class="fa-solid fa-bed"></i>


                <h3>
                    Bedroom Design
                </h3>


                <p>

                    Relaxing and luxurious bedroom interiors
                    tailored to your lifestyle.

                </p>

            </div>



            <!-- SERVICE 6 -->

            <div
                class="service-card"
                data-aos="zoom-in"
                data-aos-delay="500"
            >

                <i class="fa-solid fa-tv"></i>


                <h3>
                    TV Unit & Wardrobe
                </h3>


                <p>

                    Modern TV units and wardrobes with premium
                    materials and finishes.

                </p>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     COUNTER SECTION
===================================================== -->

<section class="counter">

    <div class="container">


        <div class="counter-grid">


            <div
                class="counter-box"
                data-aos="fade-up"
            >

                <h2>
                    500+
                </h2>

                <p>
                    Projects Completed
                </p>

            </div>



            <div
                class="counter-box"
                data-aos="fade-up"
                data-aos-delay="150"
            >

                <h2>
                    350+
                </h2>

                <p>
                    Happy Clients
                </p>

            </div>



            <div
                class="counter-box"
                data-aos="fade-up"
                data-aos-delay="300"
            >

                <h2>
                    10+
                </h2>

                <p>
                    Years Experience
                </p>

            </div>



            <div
                class="counter-box"
                data-aos="fade-up"
                data-aos-delay="450"
            >

                <h2>
                    25+
                </h2>

                <p>
                    Expert Designers
                </p>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     PORTFOLIO SECTION
===================================================== -->

<section class="portfolio">

    <div class="container">


        <div
            class="section-title"
            data-aos="fade-up"
        >

            <h2>
                Our Recent Projects
            </h2>


            <p>
                Luxury Interior Designs Crafted With Perfection
            </p>

        </div>



        <div class="gallery-grid">


            <div
                class="gallery-item"
                data-aos="zoom-in"
            >

                <img
                    src="assets/images/portfolio/portfolio1.jpeg"
                    alt="Luxury Living Room"
                >


                <div class="gallery-overlay">

                    <h3>
                        Luxury Living Room
                    </h3>

                </div>

            </div>



            <div
                class="gallery-item"
                data-aos="zoom-in"
                data-aos-delay="100"
            >

                <img
                    src="assets/images/portfolio/portfolio2.jpeg"
                    alt="Modern Kitchen"
                >


                <div class="gallery-overlay">

                    <h3>
                        Modern Kitchen
                    </h3>

                </div>

            </div>



            <div
                class="gallery-item"
                data-aos="zoom-in"
                data-aos-delay="200"
            >

                <img
                    src="assets/images/portfolio/portfolio3.jpeg"
                    alt="Office Interior"
                >


                <div class="gallery-overlay">

                    <h3>
                        Office Interior
                    </h3>

                </div>

            </div>


        </div>


        <br>
        <br>


        <center>

            <a
                href="portfolio.php"
                class="btn"
            >

                View All Projects

            </a>

        </center>

    </div>

</section>



<!-- =====================================================
     GALLERY PREVIEW
===================================================== -->

<section class="gallery">

    <div class="container">


        <div
            class="section-title"
            data-aos="fade-up"
        >

            <h2>
                Interior Gallery
            </h2>


            <p>
                Explore Our Beautiful Interior Collections
            </p>

        </div>



        <div class="gallery-grid">


            <div
                class="gallery-item"
                data-aos="fade-up"
            >

                <img
                    src="assets/images/gallery/gallery1.jpeg"
                    alt="Interior Gallery"
                >

            </div>



            <div
                class="gallery-item"
                data-aos="fade-up"
                data-aos-delay="100"
            >

                <img
                    src="assets/images/gallery/gallery2.jpeg"
                    alt="Interior Gallery"
                >

            </div>



            <div
                class="gallery-item"
                data-aos="fade-up"
                data-aos-delay="200"
            >

                <img
                    src="assets/images/gallery/gallery3.jpeg"
                    alt="Interior Gallery"
                >

            </div>



            <div
                class="gallery-item"
                data-aos="fade-up"
                data-aos-delay="300"
            >

                <img
                    src="assets/images/gallery/gallery4.jpeg"
                    alt="Interior Gallery"
                >

            </div>



            <div
                class="gallery-item"
                data-aos="fade-up"
                data-aos-delay="400"
            >

                <img
                    src="assets/images/gallery/gallery5.jpeg"
                    alt="Interior Gallery"
                >

            </div>



            <div
                class="gallery-item"
                data-aos="fade-up"
                data-aos-delay="500"
            >

                <img
                    src="assets/images/gallery/gallery6.jpeg"
                    alt="Interior Gallery"
                >

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     TESTIMONIAL SECTION
===================================================== -->

<section class="testimonial">

    <div class="container">


        <div
            class="section-title"
            data-aos="fade-up"
        >

            <h2>
                What Our Clients Say
            </h2>


            <p>
                Trusted By Hundreds Of Happy Customers
            </p>

        </div>



        <div class="service-grid">


            <div
                class="service-card"
                data-aos="fade-up"
            >

                <i class="fa-solid fa-quote-left"></i>


                <p>

                    Excellent quality work and professional team.
                    My home looks amazing.

                </p>


                <h3>
                    Rahul Patel
                </h3>

            </div>



            <div
                class="service-card"
                data-aos="fade-up"
                data-aos-delay="150"
            >

                <i class="fa-solid fa-quote-left"></i>


                <p>

                    Beautiful modular kitchen with premium finishing.
                    Highly recommended.

                </p>


                <h3>
                    Priya Shah
                </h3>

            </div>



            <div
                class="service-card"
                data-aos="fade-up"
                data-aos-delay="300"
            >

                <i class="fa-solid fa-quote-left"></i>


                <p>

                    Affordable pricing and luxury interior design.
                    Outstanding service.

                </p>


                <h3>
                    Jay Mehta
                </h3>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     WHY CHOOSE US
===================================================== -->

<section class="about">

    <div class="container">


        <div
            class="section-title"
            data-aos="fade-up"
        >

            <h2>
                Why Choose Akshar Interior?
            </h2>


            <p>
                We Transform Spaces Into Luxury Living Experiences
            </p>

        </div>



        <div class="service-grid">


            <div
                class="service-card"
                data-aos="zoom-in"
            >

                <i class="fa-solid fa-award"></i>


                <h3>
                    Premium Quality
                </h3>


                <p>

                    We use high-quality materials and premium
                    finishing for every project.

                </p>

            </div>



            <div
                class="service-card"
                data-aos="zoom-in"
                data-aos-delay="100"
            >

                <i class="fa-solid fa-lightbulb"></i>


                <h3>
                    Creative Designs
                </h3>


                <p>

                    Unique and modern interior concepts designed
                    for your lifestyle.

                </p>

            </div>



            <div
                class="service-card"
                data-aos="zoom-in"
                data-aos-delay="200"
            >

                <i class="fa-solid fa-user-check"></i>


                <h3>
                    Expert Team
                </h3>


                <p>

                    Experienced designers delivering beautiful
                    and functional interiors.

                </p>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     CONTACT CTA
===================================================== -->

<section
    class="hero"
    style="
        height:60vh;
        background:url('assets/images/banner2.jpg') center/cover;
    "
>

    <div class="container">

        <div
            class="hero-content"
            data-aos="zoom-in"
        >

            <h1>

                Let's Build Your
                <span>Dream Interior</span>

            </h1>


            <p>

                Contact us today and get a free consultation for your
                dream home, office or commercial interior project.

            </p>


            <a
                href="booking.php"
                class="btn"
            >

                Book Free Consultation

            </a>

        </div>

    </div>

</section>



<!-- =====================================================
     AOS SCRIPT
===================================================== -->

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>


<script>

AOS.init({

    duration: 1000,

    once: true

});

</script>



<?php include("includes/footer.php"); ?>

</body>

</html>