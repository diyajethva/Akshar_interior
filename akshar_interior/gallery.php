<?php

include("includes/db.php");

/* =====================================================
   DATABASE CATEGORIES
   Admin-added categories will appear on the client side.
===================================================== */

$category_result = mysqli_query(
    $conn,
    "SELECT category_name
     FROM gallery_category
     ORDER BY category_name ASC"
);

$db_categories = array();

if($category_result)
{
    while($row = mysqli_fetch_assoc($category_result))
    {
        $db_categories[] = trim($row['category_name']);
    }
}


/* =====================================================
   DATABASE GALLERY IMAGES
   Keep old default images below AND also show
   images added through Admin Panel.
===================================================== */

$gallery_result = mysqli_query(
    $conn,
    "SELECT title, category, image
     FROM gallery
     ORDER BY id DESC"
);

$db_gallery = array();

if($gallery_result)
{
    while($row = mysqli_fetch_assoc($gallery_result))
    {
        $db_gallery[] = $row;
    }
}


/* =====================================================
   DEFAULT CLIENT CATEGORIES
   These are the original categories already used
   by the existing six gallery images.
===================================================== */

$default_categories = array(
    "Living Room" => "living",
    "Kitchen" => "kitchen",
    "Bedroom" => "bedroom",
    "Office" => "office",
    "Dining Area" => "dining",
    "TV Unit" => "tv"
);

include("includes/header.php");

?>


<!-- =====================================================
     GALLERY PAGE BANNER
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
        alt="Akshar Interior Gallery"
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
                Gallery
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
                max-width:720px !important;
            "
        >

            Explore our premium interior design collection,
            crafted to bring elegance, comfort and luxury
            to every space.

        </p>

    </div>

</section>



<!-- =====================================================
     GALLERY SECTION
===================================================== -->

<section class="gallery">

    <div class="container">


        <!-- SECTION TITLE -->

        <div class="section-title">

            <h2>
                Interior Gallery
            </h2>

            <p>
                Luxury Designs That Inspire
            </p>

        </div>



        <!-- =================================================
             CATEGORY FILTER
        ================================================= -->

        <div class="gallery-filter">

            <button
                class="filter-btn active"
                data-filter="all"
            >
                All
            </button>

<?php
/* Original categories */
foreach($default_categories as $category_name => $category_slug)
{
?>
            <button
                class="filter-btn"
                data-filter="<?php echo htmlspecialchars($category_slug); ?>"
            >
                <?php echo htmlspecialchars($category_name); ?>
            </button>
<?php
}

/* Admin-added categories that are not already present */
foreach($db_categories as $category_name)
{
    $already_exists = false;

    foreach($default_categories as $default_name => $default_slug)
    {
        if(strtolower(trim($default_name)) === strtolower(trim($category_name)))
        {
            $already_exists = true;
            break;
        }
    }

    if($already_exists)
    {
        continue;
    }

    $category_slug = preg_replace(
        '/[^a-z0-9]+/i',
        '-',
        strtolower(trim($category_name))
    );

    $category_slug = trim($category_slug, '-');

    if($category_slug === '')
    {
        continue;
    }
?>
            <button
                class="filter-btn"
                data-filter="<?php echo htmlspecialchars($category_slug); ?>"
            >
                <?php echo htmlspecialchars($category_name); ?>
            </button>
<?php
}
?>

        </div>



        <!-- =================================================
             GALLERY GRID
        ================================================= -->

        <div class="gallery-grid">


            <!-- =============================================
                 LIVING ROOM
            ============================================== -->

            <div class="gallery-item living">

                <img
                    src="assets/images/gallery/gallery1.jpeg"
                    alt="Living Room Interior"
                >


                <div class="gallery-overlay">

                    <h3>
                        Living Room
                    </h3>

                </div>

            </div>



            <!-- =============================================
                 KITCHEN
            ============================================== -->

            <div class="gallery-item kitchen">

                <img
                    src="assets/images/gallery/gallery2.jpeg"
                    alt="Kitchen Interior"
                >


                <div class="gallery-overlay">

                    <h3>
                        Kitchen
                    </h3>

                </div>

            </div>



            <!-- =============================================
                 BEDROOM
            ============================================== -->

            <div class="gallery-item bedroom">

                <img
                    src="assets/images/gallery/gallery3.jpeg"
                    alt="Bedroom Interior"
                >


                <div class="gallery-overlay">

                    <h3>
                        Bedroom
                    </h3>

                </div>

            </div>



            <!-- =============================================
                 OFFICE
            ============================================== -->

            <div class="gallery-item office">

                <img
                    src="assets/images/gallery/gallery4.jpeg"
                    alt="Office Interior"
                >


                <div class="gallery-overlay">

                    <h3>
                        Office
                    </h3>

                </div>

            </div>



            <!-- =============================================
                 DINING
            ============================================== -->

            <div class="gallery-item dining">

                <img
                    src="assets/images/gallery/gallery5.jpeg"
                    alt="Dining Area Interior"
                >


                <div class="gallery-overlay">

                    <h3>
                        Dining Area
                    </h3>

                </div>

            </div>



            <!-- =============================================
                 TV UNIT
            ============================================== -->

            <div class="gallery-item tv">

                <img
                    src="assets/images/gallery/gallery6.jpeg"
                    alt="TV Unit Interior"
                >


                <div class="gallery-overlay">

                    <h3>
                        TV Unit
                    </h3>

                </div>

            </div>




<?php
/* =====================================================
   ADMIN-ADDED GALLERY IMAGES
===================================================== */

if(count($db_gallery) > 0)
{
    foreach($db_gallery as $db_item)
    {
        $db_category = trim($db_item['category'] ?? '');

        /*
           Match the original six categories with their
           existing filter classes. This keeps an admin-added
           image under "Living Room" when that category is used.
        */
        $db_slug = '';

        foreach($default_categories as $default_name => $default_slug)
        {
            if(
                strtolower(trim($default_name))
                ===
                strtolower(trim($db_category))
            )
            {
                $db_slug = $default_slug;
                break;
            }
        }

        if($db_slug === '')
        {
            $db_slug = preg_replace(
                '/[^a-z0-9]+/i',
                '-',
                strtolower($db_category)
            );

            $db_slug = trim($db_slug, '-');
        }

        $db_title = trim($db_item['title'] ?? '');
        $db_image = trim($db_item['image'] ?? '');

        if($db_image === '')
        {
            continue;
        }

        /*
           Admin gallery.php normally stores:
           assets/images/gallery/filename.ext
        */
        if(strpos($db_image, 'assets/') !== 0)
        {
            $db_image = 'assets/images/gallery/' . ltrim($db_image, '/');
        }
?>
            <div
                class="gallery-item <?php echo htmlspecialchars($db_slug); ?>"
            >

                <img
                    src="<?php echo htmlspecialchars($db_image); ?>"
                    alt="<?php echo htmlspecialchars(
                        $db_title !== '' ? $db_title : $db_category
                    ); ?>"
                >

                <div class="gallery-overlay">

                    <h3>
                        <?php echo htmlspecialchars(
                            $db_title !== '' ? $db_title : $db_category
                        ); ?>
                    </h3>

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
     CTA SECTION
===================================================== -->

<section
    style="
        height:45vh;
        min-height:400px;
        position:relative;
        overflow:hidden;
        display:flex;
        align-items:center;
        width:100%;
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

                Design Your

                <span>
                    Dream Home
                </span>

            </h1>


            <p>

                Contact Akshar Interior today and
                transform your dream into reality.

            </p>


            <a
                href="booking.php"
                class="btn"
            >
                Book Now
            </a>

        </div>

    </div>

</section>



<!-- =====================================================
     GALLERY FILTER JAVASCRIPT
===================================================== -->

<script>

document.addEventListener(
    "DOMContentLoaded",
    function()
    {


        const filterButtons =
            document.querySelectorAll(
                ".filter-btn"
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


                        /*
                         * Remove active class
                         */

                        filterButtons.forEach(
                            function(btn)
                            {

                                btn.classList.remove(
                                    "active"
                                );

                            }
                        );


                        /*
                         * Add active class
                         */

                        this.classList.add(
                            "active"
                        );


                        /*
                         * Get selected filter
                         */

                        const filter =
                            this.getAttribute(
                                "data-filter"
                            );


                        /*
                         * Show / Hide gallery items
                         */

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



<?php include("includes/footer.php"); ?>