<?php include("includes/header.php"); ?>


<!-- =====================================================
     PAGE BANNER
===================================================== -->

<section
    class="about-page-banner"
>

    <div class="about-banner-overlay"></div>

    <div class="container">

        <div
            class="about-banner-content"
            data-aos="fade-right"
        >

            <h1>
                About
                <span>Akshar Interior</span>
            </h1>

            <p>
                Luxury Interior Design Company Creating Elegant,
                Modern & Functional Spaces.
            </p>

        </div>

    </div>

</section>



<!-- =====================================================
     ABOUT SECTION
===================================================== -->

<section class="about">

    <div class="container">

        <div class="about-wrapper">


            <!-- ABOUT IMAGE -->

            <div
                class="about-image"
                data-aos="fade-right"
                style="
                    overflow:hidden;
                    border-radius:20px;
                "
            >

                <img
                    src="assets/images/about.jpeg"
                    alt="Akshar Interior"
                    style="
                        width:100%;
                        height:500px;
                        object-fit:cover;
                        display:block;
                        border-radius:20px;
                    "
                >

            </div>



            <!-- ABOUT CONTENT -->

            <div
                class="about-content"
                data-aos="fade-left"
            >

                <h2>
                    Creating Beautiful Interiors Since 2026
                </h2>


                <p>
                    Akshar Interior is one of the growing interior
                    design companies offering premium residential,
                    commercial and office interior solutions.
                </p>


                <p>
                    We believe every home deserves a luxurious look
                    with modern design, premium quality materials and
                    creative ideas.
                </p>



                <div class="about-boxes">


                    <div class="about-box">

                        <h3>
                            500+
                        </h3>

                        <span>
                            Projects Completed
                        </span>

                    </div>



                    <div class="about-box">

                        <h3>
                            350+
                        </h3>

                        <span>
                            Happy Clients
                        </span>

                    </div>



                    <div class="about-box">

                        <h3>
                            10+
                        </h3>

                        <span>
                            Years Experience
                        </span>

                    </div>


                </div>

            </div>

        </div>

    </div>

</section>



<!-- =====================================================
     MISSION & VISION
===================================================== -->

<section class="services">

    <div class="container">


        <div
            class="section-title"
            data-aos="fade-up"
        >

            <h2>
                Our Mission & Vision
            </h2>


            <p>
                Designing Elegant Spaces With Creativity & Quality
            </p>

        </div>



        <div class="service-grid">


            <!-- MISSION -->

            <div
                class="service-card"
                data-aos="zoom-in"
            >

                <i class="fa-solid fa-bullseye"></i>


                <h3>
                    Our Mission
                </h3>


                <p>
                    To provide premium interior design solutions that
                    combine creativity, functionality and customer
                    satisfaction.
                </p>

            </div>



            <!-- VISION -->

            <div
                class="service-card"
                data-aos="zoom-in"
                data-aos-delay="150"
            >

                <i class="fa-solid fa-eye"></i>


                <h3>
                    Our Vision
                </h3>


                <p>
                    To become one of the most trusted luxury interior
                    design companies by delivering world-class designs.
                </p>

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
                We Deliver Luxury, Quality & Customer Satisfaction
            </p>

        </div>



        <div class="service-grid">


            <!-- PREMIUM QUALITY -->

            <div
                class="service-card"
                data-aos="fade-up"
            >

                <i class="fa-solid fa-award"></i>


                <h3>
                    Premium Quality
                </h3>


                <p>
                    High-quality materials and excellent finishing
                    in every project.
                </p>

            </div>



            <!-- EXPERT TEAM -->

            <div
                class="service-card"
                data-aos="fade-up"
                data-aos-delay="100"
            >

                <i class="fa-solid fa-users"></i>


                <h3>
                    Expert Team
                </h3>


                <p>
                    Experienced designers with innovative and
                    modern ideas.
                </p>

            </div>



            <!-- ON TIME DELIVERY -->

            <div
                class="service-card"
                data-aos="fade-up"
                data-aos-delay="200"
            >

                <i class="fa-solid fa-clock"></i>


                <h3>
                    On-Time Delivery
                </h3>


                <p>
                    We complete every project within the
                    committed timeline.
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
        height:50vh;
        background:url('assets/images/banner2.jpg') center center/cover;
    "
>

    <div class="container">

        <div
            class="hero-content"
            data-aos="zoom-in"
        >

            <h1>
                Let's Design Your
                <span>Dream Space</span>
            </h1>


            <p>
                Contact Akshar Interior today for a free consultation
                and transform your home or office into a luxury space.
            </p>


            <a
                href="contact.php"
                class="btn"
            >
                Contact Us
            </a>

        </div>

    </div>

</section>



<!-- =====================================================
     ABOUT PAGE BANNER CSS
===================================================== -->

<style>

.about-page-banner {

    height: 55vh;
    min-height: 500px;

    position: relative;

    display: flex;

    align-items: center;

    overflow: hidden;

    background-image:
        url('assets/images/about_page.jpeg');

    background-position: center;

    background-size: cover;

    background-repeat: no-repeat;

}


/* DARK OVERLAY */

.about-banner-overlay {

    position: absolute;

    top: 0;
    left: 0;

    width: 100%;
    height: 100%;

    background:
        linear-gradient(
            90deg,
            rgba(0,0,0,0.78),
            rgba(0,0,0,0.48),
            rgba(0,0,0,0.25)
        );

}


/* TEXT */

.about-banner-content {

    position: relative;

    z-index: 2;

    max-width: 750px;

}


.about-banner-content h1 {

    color: #ffffff;

    font-size: 60px;

    line-height: 1.1;

    margin-bottom: 20px;

}


.about-banner-content h1 span {

    color: #d4af37;

}


.about-banner-content p {

    color: #eeeeee;

    font-size: 19px;

    line-height: 1.7;

    max-width: 650px;

}


/* MOBILE */

@media(max-width:768px) {

    .about-page-banner {

        height: 55vh;

        min-height: 450px;

    }


    .about-banner-content h1 {

        font-size: 42px;

    }


    .about-banner-content p {

        font-size: 16px;

    }

}

</style>



<!-- =====================================================
     AOS SCRIPT
===================================================== -->

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>


<script>

AOS.init({

    duration:1000,

    once:true

});

</script>



<?php include("includes/footer.php"); ?>