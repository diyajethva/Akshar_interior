<?php

include("auth.php");
include("../includes/db.php");


// =====================================================
// DASHBOARD COUNTS
// =====================================================

$service = 0;
$gallery = 0;
$portfolio = 0;
$booking = 0;
$contact = 0;
$testimonial = 0;


// SERVICES
$result = mysqli_query($conn, "SELECT * FROM services");

if ($result) {
    $service = mysqli_num_rows($result);
}


// GALLERY
$result = mysqli_query($conn, "SELECT * FROM gallery");

if ($result) {
    $gallery = mysqli_num_rows($result);
}


// PORTFOLIO
$result = mysqli_query($conn, "SELECT * FROM portfolio");

if ($result) {
    $portfolio = mysqli_num_rows($result);
}


// BOOKINGS
$result = mysqli_query($conn, "SELECT * FROM booking");

if ($result) {
    $booking = mysqli_num_rows($result);
}


// CONTACT
$result = mysqli_query($conn, "SELECT * FROM contact");

if ($result) {
    $contact = mysqli_num_rows($result);
}


// TESTIMONIAL
$result = mysqli_query($conn, "SELECT * FROM testimonial");

if ($result) {
    $testimonial = mysqli_num_rows($result);
}

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard | Akshar Interior</title>


    <!-- ADMIN CSS -->

    <link
        rel="stylesheet"
        href="/AKSHAR_INTERIOR/admin/css/style.css?v=100"
    >


    <!-- FONT AWESOME -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


    <style>

        /* =================================================
           BASIC ADMIN LAYOUT
        ================================================= */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background: #0b0b0b;

            color: #ffffff;

        }


        /* =================================================
           ADMIN CONTAINER
        ================================================= */

        .admin-container {

            min-height: 100vh;

            display: flex;

            background: #0b0b0b;

        }


        /* =================================================
           SIDEBAR
        ================================================= */

        .sidebar {

            position: fixed;

            left: 0;

            top: 0;

            width: 260px;

            height: 100vh;

            background: #111111;

            border-right:
                1px solid
                rgba(212,175,55,0.35);

            box-shadow:
                5px 0 30px
                rgba(0,0,0,0.4);

            z-index: 1000;

        }


        /* =================================================
           LOGO
        ================================================= */

        .logo {

            padding: 30px 20px;

            text-align: center;

            border-bottom:
                1px solid
                rgba(255,255,255,0.08);

        }


        .logo h2 {

            color: #D4AF37;

            font-size: 24px;

            letter-spacing: 1px;

            margin-bottom: 7px;

        }


        .logo p {

            color: #999999;

            font-size: 13px;

            letter-spacing: 1px;

        }


        /* =================================================
           SIDEBAR MENU
        ================================================= */

        .sidebar ul {

            list-style: none;

            padding: 20px 14px;

        }


        .sidebar ul li {

            margin-bottom: 7px;

        }


        .sidebar ul li a {

            display: flex;

            align-items: center;

            gap: 14px;

            padding: 14px 16px;

            color: #cccccc;

            text-decoration: none;

            border-radius: 9px;

            font-size: 14px;

            font-weight: 600;

            transition: 0.3s;

        }


        .sidebar ul li a i {

            width: 22px;

            text-align: center;

            color: #D4AF37;

        }


        .sidebar ul li a:hover {

            background:
                rgba(212,175,55,0.10);

            color: #ffffff;

            transform:
                translateX(4px);

        }


        .sidebar ul li.active a {

            background: #D4AF37;

            color: #111111;

            box-shadow:
                0 8px 25px
                rgba(212,175,55,0.20);

        }


        .sidebar ul li.active a i {

            color: #111111;

        }


        /* =================================================
           LOGOUT
        ================================================= */

        .sidebar ul li:last-child {

            margin-top: 20px;

            padding-top: 20px;

            border-top:
                1px solid
                rgba(255,255,255,0.08);

        }


        .sidebar ul li:last-child a {

            color: #ff7777;

        }


        .sidebar ul li:last-child a i {

            color: #ff7777;

        }


        /* =================================================
           MAIN CONTENT
        ================================================= */

        .main-content {

            width:
                calc(100% - 260px);

            margin-left: 260px;

            min-height: 100vh;

            padding: 30px;

            background: #0b0b0b;

        }


        /* =================================================
           TOPBAR
        ================================================= */

        .topbar {

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 25px 28px;

            margin-bottom: 30px;

            background: #111111;

            border:
                1px solid
                rgba(212,175,55,0.22);

            border-radius: 16px;

            box-shadow:
                0 15px 35px
                rgba(0,0,0,0.30);

        }


        .topbar h2 {

            font-size: 28px;

            color: #ffffff;

            margin-bottom: 7px;

        }


        .topbar p {

            color: #999999;

            font-size: 14px;

        }


        .topbar strong {

            color: #D4AF37;

        }


        /* =================================================
           PROFILE
        ================================================= */

        .admin-profile {

            width: 52px;

            height: 52px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            background:
                rgba(212,175,55,0.10);

            border:
                1px solid
                #D4AF37;

            color: #D4AF37;

            font-size: 25px;


        }


        /* =================================================
           DASHBOARD CARDS
        ================================================= */

        .dashboard-cards {

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 22px;

        }


        .card {

            min-height: 175px;

            padding: 27px;

            background:
                linear-gradient(
                    145deg,
                    #181818,
                    #101010
                );

            border:
                1px solid
                rgba(212,175,55,0.18);

            border-radius: 17px;

            box-shadow:
                0 12px 35px
                rgba(0,0,0,0.25);

            transition: 0.3s;

        }


        .card:hover {

            transform:
                translateY(-6px);

            border-color:
                rgba(212,175,55,0.55);

            box-shadow:
                0 18px 40px
                rgba(212,175,55,0.08);

        }


        .card i {

            width: 52px;

            height: 52px;

            display: flex;

            align-items: center;

            justify-content: center;

            margin-bottom: 18px;

            border-radius: 13px;

            background:
                rgba(212,175,55,0.10);

            border:
                1px solid
                rgba(212,175,55,0.22);

            color: #D4AF37;

            font-size: 21px;

        }


        .card h3 {

            font-size: 32px;

            color: #ffffff;

            margin-bottom: 7px;

        }


        .card p {

            color: #999999;

            font-size: 14px;

        }


        /* =================================================
           RESPONSIVE
        ================================================= */

        @media(max-width:1000px) {

            .dashboard-cards {

                grid-template-columns:
                    repeat(2, 1fr);

            }

        }


        @media(max-width:750px) {

            .sidebar {

                position: relative;

                width: 100%;

                height: auto;

            }


            .admin-container {

                display: block;

            }


            .main-content {

                width: 100%;

                margin-left: 0;

                padding: 20px;

            }


            .dashboard-cards {

                grid-template-columns: 1fr;

            }

        }


    </style>

</head>


<body>


<div class="admin-container">


    <!-- =================================================
         SIDEBAR
    ================================================= -->

    <div class="sidebar">


        <!-- LOGO -->

        <div class="logo">

            <h2>AKSHAR INTERIOR</h2>

            <p>ADMIN PANEL</p>

        </div>


        <!-- MENU -->

        <ul>


            <!-- DASHBOARD -->

            <li class="active">

                <a href="dashboard.php">

                    <i class="fas fa-home"></i>

                    <span>Dashboard</span>

                </a>

            </li>


            <!-- SERVICES -->

            <li>

                <a href="services.php">

                    <i class="fas fa-tools"></i>

                    <span>Services</span>

                </a>

            </li>


            <!-- GALLERY CATEGORY -->

            <li>

                <a href="gallery_category.php">

                    <i class="fas fa-layer-group"></i>

                    <span>Gallery Category</span>

                </a>

            </li>


            <!-- GALLERY -->

            <li>

                <a href="gallery.php">

                    <i class="fas fa-image"></i>

                    <span>Gallery</span>

                </a>

            </li>


            <!-- PORTFOLIO -->

            <li>

                <a href="portfolio.php">

                    <i class="fas fa-briefcase"></i>

                    <span>Portfolio</span>

                </a>

            </li>


            <!-- BOOKINGS -->

            <li>

                <a href="bookings.php">

                    <i class="fas fa-calendar-check"></i>

                    <span>Bookings</span>

                </a>

            </li>


            <!-- CONTACT -->

            <li>

                <a href="contact_messages.php">

                    <i class="fas fa-envelope"></i>

                    <span>Contact Messages</span>

                </a>

            </li>


            <!-- LOGOUT -->

            <li>

                <a href="logout.php">

                    <i class="fas fa-right-from-bracket"></i>

                    <span>Logout</span>

                </a>

            </li>


        </ul>

    </div>


    <!-- =================================================
         MAIN CONTENT
    ================================================= -->

    <div class="main-content">


        <!-- TOP BAR -->

        <div class="topbar">


            <div>

                <h2>
                    Dashboard
                </h2>

                <p>
                    Welcome,
                    <strong>
                        <?php
                        echo htmlspecialchars($_SESSION['admin']);
                        ?>
                    </strong>
                </p>

            </div>


            <div class="admin-profile">

                <i class="fas fa-user-circle"></i>

            </div>

        </div>

        <!-- =================================================
             DASHBOARD CARDS
        ================================================= -->

        <div class="dashboard-cards">


            <!-- SERVICES -->

            <div class="card">

                <i class="fas fa-tools"></i>

                <h3>
                    <?php echo $service; ?>
                </h3>

                <p>
                    Total Services
                </p>

            </div>


            <!-- GALLERY -->

            <div class="card">

                <i class="fas fa-image"></i>

                <h3>
                    <?php echo $gallery; ?>
                </h3>

                <p>
                    Gallery Images
                </p>

            </div>


            <!-- PORTFOLIO -->

            <div class="card">

                <i class="fas fa-briefcase"></i>

                <h3>
                    <?php echo $portfolio; ?>
                </h3>

                <p>
                    Portfolio Projects
                </p>

            </div>


            <!-- BOOKINGS -->

            <div class="card">

                <i class="fas fa-calendar-check"></i>

                <h3>
                    <?php echo $booking; ?>
                </h3>

                <p>
                    Total Bookings
                </p>

            </div>


            <!-- CONTACT -->

            <div class="card">

                <i class="fas fa-envelope"></i>

                <h3>
                    <?php echo $contact; ?>
                </h3>

                <p>
                    Contact Messages
                </p>

            </div>

        </div>


    </div>


</div>

</body>

</html>