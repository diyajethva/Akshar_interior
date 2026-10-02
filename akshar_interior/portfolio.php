<?php

include("includes/db.php");

/* =====================================================
   GET PORTFOLIO DATA FROM DATABASE
===================================================== */

$portfolio_result = mysqli_query(
    $conn,
    "SELECT id, title, image, category, location, description
     FROM portfolio
     ORDER BY id DESC"
);

$portfolio_categories = mysqli_query(
    $conn,
    "SELECT DISTINCT category
     FROM portfolio
     WHERE category IS NOT NULL
       AND category <> ''
     ORDER BY category ASC"
);

function portfolio_slug($value)
{
    $value = strtolower(trim($value));
    $value = preg_replace('/[^a-z0-9]+/', '-', $value);
    return trim($value, '-');
}

include("includes/header.php");
?>


<!-- =====================================================
     PORTFOLIO PAGE BANNER
===================================================== -->

<section
    style="
        height:55vh !important;
        min-height:500px !important;
        position:relative !important;
        overflow:hidden !important;
        display:flex !important;
        align-items:center !important;
        width:100% !important;
    "
>

    <!-- BACKGROUND IMAGE -->

    <img
        src="assets/images/about_page.jpeg"
        alt="Akshar Interior Portfolio"
        style="
            position:absolute !important;
            top:0 !important;
            left:0 !important;
            width:100% !important;
            height:100% !important;
            object-fit:cover !important;
            object-position:center !important;
            z-index:1 !important;
        "
    >


    <!-- DARK OVERLAY -->

    <div
        style="
            position:absolute !important;
            top:0 !important;
            left:0 !important;
            width:100% !important;
            height:100% !important;
            background:rgba(0,0,0,0.55) !important;
            z-index:2 !important;
        "
    ></div>


    <!-- BANNER TEXT -->

    <div
        style="
            position:relative !important;
            z-index:10 !important;
            width:100% !important;
            max-width:1200px !important;
            margin:0 auto !important;
            padding:0 40px !important;
            box-sizing:border-box !important;
        "
    >

        <h1
            style="
                display:block !important;
                visibility:visible !important;
                opacity:1 !important;
                position:relative !important;
                z-index:20 !important;
                color:#ffffff !important;
                font-size:60px !important;
                line-height:1.1 !important;
                margin:0 0 20px 0 !important;
                font-weight:700 !important;
            "
        >

            Our

            <span
                style="
                    color:#D4AF37 !important;
                "
            >
                Portfolio
            </span>

        </h1>


        <p
            style="
                display:block !important;
                visibility:visible !important;
                opacity:1 !important;
                position:relative !important;
                z-index:20 !important;
                color:#ffffff !important;
                font-size:20px !important;
                line-height:1.7 !important;
                margin:0 !important;
                max-width:700px !important;
            "
        >

            Explore our premium interior projects crafted with
            creativity, luxury and attention to every detail.

        </p>

    </div>

</section>



<!-- =====================================================
     PORTFOLIO
===================================================== -->

<section class="gallery">

    <div class="container">


        <div class="section-title">

            <h2>
                Recent Projects
            </h2>

            <p>
                Luxury Interior Designs Crafted For Our Clients
            </p>

        </div>



        <!-- CATEGORY FILTER -->

        <div class="gallery-filter">

            <button class="active" data-filter="all">
                All Projects
            </button>

            <button data-filter="residential">
                Residential
            </button>

            <button data-filter="commercial">
                Commercial
            </button>

            <button data-filter="kitchen">
                Kitchen
            </button>

            <button data-filter="bedroom">
                Bedroom
            </button>

            <button data-filter="living">
                Living Room
            </button>

            <button data-filter="office">
                Office
            </button>

            <?php
            $shown_categories = array(
                'residential',
                'commercial',
                'kitchen',
                'bedroom',
                'living',
                'office'
            );

            if($portfolio_categories)
            {
                while($category_row = mysqli_fetch_assoc($portfolio_categories))
                {
                    $category_name = trim($category_row['category']);
                    $category_slug = portfolio_slug($category_name);

                    if($category_slug === '' || in_array($category_slug, $shown_categories))
                    {
                        continue;
                    }

                    $shown_categories[] = $category_slug;
                    ?>

                    <button data-filter="<?php echo htmlspecialchars($category_slug); ?>">
                        <?php echo htmlspecialchars($category_name); ?>
                    </button>

                    <?php
                }
            }
            ?>

        </div>


        <!-- =================================================
             PORTFOLIO GRID
        ================================================= -->

        <div class="gallery-grid">


            <!-- PROJECT 1 -->

            <div class="gallery-item residential living">

                <img
                    src="assets/images/portfolio/portfolio1.jpeg"
                    alt="Luxury Living Room"
                >


                <div class="gallery-overlay">

                    <h3>
                        Luxury Living Room
                    </h3>


                    <p>
                        <strong>Category :</strong>
                        Residential
                    </p>


                    <p>
                        <strong>Location :</strong>
                        Rajkot
                    </p>


                    <p>
                        Elegant living room with premium furniture
                        and pastel interiors.
                    </p>


                    <a
                        href="booking.php"
                        class="btn"
                    >
                        View Details
                    </a>

                </div>

            </div>



            <!-- PROJECT 2 -->

            <div class="gallery-item residential kitchen">

                <img
                    src="assets/images/portfolio/portfolio2.jpeg"
                    alt="Modern Kitchen"
                >


                <div class="gallery-overlay">

                    <h3>
                        Modern Kitchen
                    </h3>


                    <p>
                        <strong>Category :</strong>
                        Kitchen
                    </p>


                    <p>
                        <strong>Location :</strong>
                        Ahmedabad
                    </p>


                    <p>
                        Modern modular kitchen with luxurious
                        finishes and smart storage.
                    </p>


                    <a
                        href="booking.php"
                        class="btn"
                    >
                        View Details
                    </a>

                </div>

            </div>



            <!-- PROJECT 3 -->

            <div class="gallery-item commercial office">

                <img
                    src="assets/images/portfolio/portfolio3.jpeg"
                    alt="Office Interior"
                >


                <div class="gallery-overlay">

                    <h3>
                        Office Interior
                    </h3>


                    <p>
                        <strong>Category :</strong>
                        Commercial
                    </p>


                    <p>
                        <strong>Location :</strong>
                        Surat
                    </p>


                    <p>
                        Contemporary office design for productivity
                        and elegance.
                    </p>


                    <a
                        href="booking.php"
                        class="btn"
                    >
                        View Details
                    </a>

                </div>

            </div>



            <!-- PROJECT 4 -->

            <div class="gallery-item residential bedroom">

                <img
                    src="assets/images/gallery/gallery1.jpeg"
                    alt="Bedroom Design"
                >


                <div class="gallery-overlay">

                    <h3>
                        Bedroom Design
                    </h3>


                    <p>
                        <strong>Category :</strong>
                        Bedroom
                    </p>


                    <p>
                        <strong>Location :</strong>
                        Rajkot
                    </p>


                    <p>
                        Comfortable bedroom designed with warm colors
                        and modern style.
                    </p>


                    <a
                        href="booking.php"
                        class="btn"
                    >
                        View Details
                    </a>

                </div>

            </div>



            <!-- PROJECT 5 -->

            <div class="gallery-item residential living">

                <img
                    src="assets/images/gallery/gallery2.jpeg"
                    alt="TV Unit"
                >


                <div class="gallery-overlay">

                    <h3>
                        Designer TV Unit
                    </h3>


                    <p>
                        <strong>Category :</strong>
                        Living Room
                    </p>


                    <p>
                        <strong>Location :</strong>
                        Jamnagar
                    </p>


                    <p>
                        Stylish TV unit with wooden finish and
                        decorative storage.
                    </p>


                    <a
                        href="booking.php"
                        class="btn"
                    >
                        View Details
                    </a>

                </div>

            </div>



            <!-- PROJECT 6 -->

            <div class="gallery-item residential dining">

                <img
                    src="assets/images/gallery/gallery3.jpeg"
                    alt="Dining Area"
                >


                <div class="gallery-overlay">

                    <h3>
                        Dining Area
                    </h3>


                    <p>
                        <strong>Category :</strong>
                        Residential
                    </p>


                    <p>
                        <strong>Location :</strong>
                        Morbi
                    </p>


                    <p>
                        Luxury dining space with elegant lighting
                        and premium furniture.
                    </p>


                    <a
                        href="booking.php"
                        class="btn"
                    >
                        View Details
                    </a>

                </div>

            </div>



            <!-- =================================================
                 DYNAMIC PROJECTS FROM ADMIN PORTFOLIO
            ================================================= -->

            <?php
            if($portfolio_result && mysqli_num_rows($portfolio_result) > 0)
            {
                while($project = mysqli_fetch_assoc($portfolio_result))
                {
                    $project_title = trim($project['title']);
                    $project_image = trim($project['image']);
                    $project_category = trim($project['category']);
                    $project_location = trim($project['location']);
                    $project_description = trim($project['description']);
                    $project_slug = portfolio_slug($project_category);

                    if($project_slug === '')
                    {
                        $project_slug = 'other';
                    }
                    ?>

                    <div class="gallery-item <?php echo htmlspecialchars($project_slug); ?>">

                        <img
                            src="<?php echo htmlspecialchars($project_image); ?>"
                            alt="<?php echo htmlspecialchars($project_title); ?>"
                        >

                        <div class="gallery-overlay">

                            <h3>
                                <?php echo htmlspecialchars($project_title); ?>
                            </h3>

                            <?php if($project_category !== ''): ?>
                            <p>
                                <strong>Category :</strong>
                                <?php echo htmlspecialchars($project_category); ?>
                            </p>
                            <?php endif; ?>

                            <?php if($project_location !== ''): ?>
                            <p>
                                <strong>Location :</strong>
                                <?php echo htmlspecialchars($project_location); ?>
                            </p>
                            <?php endif; ?>

                            <?php if($project_description !== ''): ?>
                            <p>
                                <?php echo nl2br(htmlspecialchars($project_description)); ?>
                            </p>
                            <?php endif; ?>

                            <a
                                href="booking.php"
                                class="btn"
                            >
                                View Details
                            </a>

                        </div>

                    </div>

                    <?php
                }
            }
            ?>

        </div>

    </div>

</section>



<!-- =====================================================
     PROJECT STATISTICS
===================================================== -->

<section class="stats">

    <div class="container">


        <div class="section-title">

            <h2>
                Our Achievements
            </h2>


            <p>
                Creating Beautiful Interiors With Excellence
            </p>

        </div>



        <div class="stats-grid">


            <div class="stat-box">

                <h2>
                    500+
                </h2>

                <p>
                    Projects Completed
                </p>

            </div>



            <div class="stat-box">

                <h2>
                    350+
                </h2>

                <p>
                    Happy Clients
                </p>

            </div>



            <div class="stat-box">

                <h2>
                    10+
                </h2>

                <p>
                    Years Experience
                </p>

            </div>



            <div class="stat-box">

                <h2>
                    50+
                </h2>

                <p>
                    Interior Styles
                </p>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     TESTIMONIALS
===================================================== -->

<section class="testimonials">

    <div class="container">


        <div class="section-title">

            <h2>
                Client Reviews
            </h2>


            <p>
                What Our Clients Say About Us
            </p>

        </div>



        <div class="testimonial-grid">


            <!-- TESTIMONIAL 1 -->

            <div class="testimonial-card">

                <h3>
                    ⭐⭐⭐⭐⭐
                </h3>


                <p>
                    "Akshar Interior transformed our living room into a
                    luxurious and comfortable space. Excellent work!"
                </p>


                <h4>
                    - Mr. Patel, Rajkot
                </h4>

            </div>



            <!-- TESTIMONIAL 2 -->

            <div class="testimonial-card">

                <h3>
                    ⭐⭐⭐⭐⭐
                </h3>


                <p>
                    "Professional team, creative ideas and timely
                    project completion. Highly recommended."
                </p>


                <h4>
                    - Mrs. Shah, Ahmedabad
                </h4>

            </div>



            <!-- TESTIMONIAL 3 -->

            <div class="testimonial-card">

                <h3>
                    ⭐⭐⭐⭐⭐
                </h3>


                <p>
                    "Beautiful office interior with premium quality
                    finishing. Thank you Akshar Interior."
                </p>


                <h4>
                    - ABC Corporation, Surat
                </h4>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     CALL TO ACTION
===================================================== -->

<section
    style="
        height:45vh;
        min-height:400px;
        position:relative;
        overflow:hidden;
        display:flex;
        align-items:center;
    "
>


    <!-- SAME IMAGE -->

    <img
        src="assets/images/about_page.jpeg"
        alt="Luxury Interior"
        style="
            position:absolute;
            top:0;
            left:0;
            width:100%;
            height:100%;
            object-fit:cover;
            object-position:center;
            z-index:1;
        "
    >


    <!-- DARK OVERLAY -->

    <div
        style="
            position:absolute;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background:rgba(0,0,0,0.65);
            z-index:2;
        "
    ></div>


    <!-- CTA CONTENT -->

    <div
        class="container"
        style="
            position:relative;
            z-index:10;
            width:100%;
        "
    >

        <div
            class="hero-content"
            style="
                position:relative;
                z-index:20;
            "
        >

            <h1>

                Need A

                <span>
                    Luxury Interior?
                </span>

            </h1>


            <p>

                Contact Akshar Interior today and let us transform
                your dream space into reality.

            </p>


            <a
                href="booking.php"
                class="btn"
            >
                Book Consultation
            </a>

        </div>

    </div>

</section>



<!-- =====================================================
     CATEGORY FILTER SCRIPT
===================================================== -->

<script>

document.addEventListener(
    "DOMContentLoaded",
    function()
    {


        const filterButtons =
            document.querySelectorAll(
                ".gallery-filter button"
            );


        const galleryItems =
            document.querySelectorAll(
                ".gallery-item"
            );


        filterButtons.forEach(
            function(button)
            {


                button.addEventListener(
                    "click",
                    function()
                    {


                        filterButtons.forEach(
                            function(btn)
                            {

                                btn.classList.remove(
                                    "active"
                                );

                            }
                        );


                        this.classList.add(
                            "active"
                        );


                        const filter =
                            this.getAttribute(
                                "data-filter"
                            );


                        galleryItems.forEach(
                            function(item)
                            {


                                if(
                                    filter === "all"
                                    ||
                                    item.classList.contains(
                                        filter
                                    )
                                )
                                {

                                    item.style.display =
                                        "block";

                                }
                                else
                                {

                                    item.style.display =
                                        "none";

                                }

                            }
                        );


                    }
                );


            }
        );


    }
);

</script>



<?php include("includes/footer.php");?>