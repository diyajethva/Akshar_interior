<?php

include("auth.php");
include("../includes/db.php");


// =====================================================
// CREATE PORTFOLIO IMAGE FOLDER
// =====================================================

$upload_dir = "../assets/images/portfolio/";

if(!is_dir($upload_dir))
{
    mkdir($upload_dir, 0777, true);
}


// =====================================================
// ADD PORTFOLIO
// =====================================================

if(isset($_POST['add_portfolio']))
{
    $title = trim($_POST['title']);
    $category = trim($_POST['category']);
    $location = trim($_POST['location']);
    $description = trim($_POST['description']);


    $title = mysqli_real_escape_string($conn, $title);
    $category = mysqli_real_escape_string($conn, $category);
    $location = mysqli_real_escape_string($conn, $location);
    $description = mysqli_real_escape_string($conn, $description);


    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0)
    {
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_size = $_FILES['image']['size'];


        $extension = strtolower(
            pathinfo($file_name, PATHINFO_EXTENSION)
        );


        $allowed = array(
            "jpg",
            "jpeg",
            "png",
            "webp"
        );


        if(!in_array($extension, $allowed))
        {
            $error =
                "Only JPG, JPEG, PNG and WEBP images are allowed.";
        }
        elseif($file_size > 5 * 1024 * 1024)
        {
            $error =
                "Image size must be less than 5 MB.";
        }
        else
        {
            $new_name =
                time() . "_" . uniqid() . "." . $extension;


            $destination =
                $upload_dir . $new_name;


            if(move_uploaded_file($file_tmp, $destination))
            {
                $image_path =
                    "assets/images/portfolio/" . $new_name;


                $image_path =
                    mysqli_real_escape_string(
                        $conn,
                        $image_path
                    );


                $sql =
                    "INSERT INTO portfolio
                    (title, image, category, location, description)
                    VALUES
                    ('$title',
                     '$image_path',
                     '$category',
                     '$location',
                     '$description')";


                if(mysqli_query($conn, $sql))
                {
                    header(
                        "Location: portfolio.php?success=added"
                    );

                    exit();
                }
                else
                {
                    unlink($destination);

                    $error =
                        "Portfolio project could not be saved.";
                }
            }
            else
            {
                $error =
                    "Image upload failed.";
            }
        }
    }
    else
    {
        $error =
            "Please select a project image.";
    }
}


// =====================================================
// DELETE PORTFOLIO
// =====================================================

if(isset($_GET['delete']))
{
    $id = intval($_GET['delete']);


    $result = mysqli_query(
        $conn,
        "SELECT image FROM portfolio WHERE id=$id"
    );


    if($result && mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);


        $image_file =
            "../" . $row['image'];


        if(file_exists($image_file))
        {
            unlink($image_file);
        }
    }


    mysqli_query(
        $conn,
        "DELETE FROM portfolio WHERE id=$id"
    );


    header(
        "Location: portfolio.php?success=deleted"
    );

    exit();
}


// =====================================================
// GET PORTFOLIO FOR EDIT
// =====================================================

$edit_portfolio = null;


if(isset($_GET['edit']))
{
    $id = intval($_GET['edit']);


    $result = mysqli_query(
        $conn,
        "SELECT * FROM portfolio WHERE id=$id"
    );


    if($result)
    {
        $edit_portfolio =
            mysqli_fetch_assoc($result);
    }
}


// =====================================================
// UPDATE PORTFOLIO
// =====================================================

if(isset($_POST['update_portfolio']))
{
    $id = intval($_POST['id']);


    $title = trim($_POST['title']);
    $category = trim($_POST['category']);
    $location = trim($_POST['location']);
    $description = trim($_POST['description']);


    $title = mysqli_real_escape_string(
        $conn,
        $title
    );


    $category = mysqli_real_escape_string(
        $conn,
        $category
    );


    $location = mysqli_real_escape_string(
        $conn,
        $location
    );


    $description = mysqli_real_escape_string(
        $conn,
        $description
    );


    // =================================================
    // NEW IMAGE SELECTED
    // =================================================

    if(
        isset($_FILES['image']) &&
        $_FILES['image']['error'] == 0
    )
    {
        $file_name =
            $_FILES['image']['name'];


        $file_tmp =
            $_FILES['image']['tmp_name'];


        $file_size =
            $_FILES['image']['size'];


        $extension =
            strtolower(
                pathinfo(
                    $file_name,
                    PATHINFO_EXTENSION
                )
            );


        $allowed = array(
            "jpg",
            "jpeg",
            "png",
            "webp"
        );


        if(!in_array($extension, $allowed))
        {
            $error =
                "Only JPG, JPEG, PNG and WEBP images are allowed.";
        }
        elseif($file_size > 5 * 1024 * 1024)
        {
            $error =
                "Image size must be less than 5 MB.";
        }
        else
        {
            $new_name =
                time() . "_" . uniqid() . "." . $extension;


            $destination =
                $upload_dir . $new_name;


            if(move_uploaded_file(
                $file_tmp,
                $destination
            ))
            {
                $new_image =
                    "assets/images/portfolio/" . $new_name;


                $new_image =
                    mysqli_real_escape_string(
                        $conn,
                        $new_image
                    );


                // GET OLD IMAGE

                $old_result =
                    mysqli_query(
                        $conn,
                        "SELECT image FROM portfolio WHERE id=$id"
                    );


                if(
                    $old_result &&
                    mysqli_num_rows($old_result) > 0
                )
                {
                    $old_row =
                        mysqli_fetch_assoc(
                            $old_result
                        );


                    $old_image =
                        "../" . $old_row['image'];


                    if(file_exists($old_image))
                    {
                        unlink($old_image);
                    }
                }


                $sql =
                    "UPDATE portfolio SET

                    title='$title',

                    category='$category',

                    location='$location',

                    description='$description',

                    image='$new_image'

                    WHERE id=$id";


                if(mysqli_query($conn, $sql))
                {
                    header(
                        "Location: portfolio.php?success=updated"
                    );

                    exit();
                }
                else
                {
                    unlink($destination);

                    $error =
                        "Portfolio project could not be updated.";
                }
            }
            else
            {
                $error =
                    "New image upload failed.";
            }
        }
    }
    else
    {
        // =================================================
        // UPDATE WITHOUT CHANGING IMAGE
        // =================================================

        $sql =
            "UPDATE portfolio SET

            title='$title',

            category='$category',

            location='$location',

            description='$description'

            WHERE id=$id";


        if(mysqli_query($conn, $sql))
        {
            header(
                "Location: portfolio.php?success=updated"
            );

            exit();
        }
        else
        {
            $error =
                "Portfolio project could not be updated.";
        }
    }
}


// =====================================================
// GET ALL PORTFOLIO
// =====================================================

$portfolio = mysqli_query(
    $conn,
    "SELECT * FROM portfolio
     ORDER BY id DESC"
);

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
    Portfolio | Akshar Interior Admin
</title>


<!-- FONT AWESOME -->

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
>


<style>

/* =====================================================
   RESET
===================================================== */

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


a {

    text-decoration: none;

}


/* =====================================================
   ADMIN CONTAINER
===================================================== */

.admin-container {

    min-height: 100vh;

    background: #0b0b0b;

}


/* =====================================================
   SIDEBAR
===================================================== */

.sidebar {

    position: fixed;

    top: 0;

    left: 0;

    width: 260px;

    height: 100vh;

    background: #111111;

    border-right:
        1px solid
        rgba(212,175,55,0.25);

    box-shadow:
        8px 0 30px
        rgba(0,0,0,0.40);

    z-index: 1000;

}


/* =====================================================
   LOGO
===================================================== */

.logo {

    text-align: center;

    padding: 30px 15px;

    border-bottom:
        1px solid
        rgba(255,255,255,0.08);

}


.logo h2 {

    color: #D4AF37;

    font-size: 23px;

    letter-spacing: 1px;

    margin-bottom: 8px;

}


.logo p {

    color: #888888;

    font-size: 13px;

    text-transform: uppercase;

    letter-spacing: 2px;

}


/* =====================================================
   SIDEBAR MENU
===================================================== */

.sidebar ul {

    list-style: none;

    padding: 20px 14px;

}


.sidebar li {

    margin-bottom: 6px;

}


.sidebar li a {

    display: flex;

    align-items: center;

    gap: 14px;

    padding: 14px 16px;

    color: #cccccc;

    border-radius: 10px;

    font-size: 14px;

    font-weight: 600;

    transition: 0.3s;

}


.sidebar li a i {

    width: 22px;

    text-align: center;

    color: #D4AF37;

}


.sidebar li a:hover {

    background:
        rgba(212,175,55,0.10);

    color: #ffffff;

    transform:
        translateX(4px);

}


.sidebar li.active a {

    background: #D4AF37;

    color: #111111;

    box-shadow:
        0 8px 25px
        rgba(212,175,55,0.18);

}


.sidebar li.active a i {

    color: #111111;

}


/* =====================================================
   LOGOUT
===================================================== */

.sidebar li:last-child {

    margin-top: 20px;

    padding-top: 20px;

    border-top:
        1px solid
        rgba(255,255,255,0.08);

}


.sidebar li:last-child a {

    color: #ff7777;

}


.sidebar li:last-child a i {

    color: #ff7777;

}


/* =====================================================
   MAIN CONTENT
===================================================== */

.main-content {

    margin-left: 260px;

    min-height: 100vh;

    padding: 30px;

    background: #0b0b0b;

}


/* =====================================================
   TOP BAR
===================================================== */

.topbar {

    display: flex;

    align-items: center;

    justify-content: space-between;

    padding: 25px 28px;

    margin-bottom: 30px;

    background: #111111;

    border:
        1px solid
        rgba(212,175,55,0.20);

    border-radius: 16px;

    box-shadow:
        0 15px 35px
        rgba(0,0,0,0.30);

}


.topbar h2 {

    color: #ffffff;

    font-size: 27px;

    margin-bottom: 7px;

}


.topbar p {

    color: #999999;

    font-size: 14px;

}


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
        1px solid #D4AF37;

    color: #D4AF37;

    font-size: 25px;

}


/* =====================================================
   MESSAGE
===================================================== */

.success-message {

    padding: 15px 18px;

    margin-bottom: 22px;

    border-radius: 10px;

    background:
        rgba(46,125,50,0.15);

    border:
        1px solid
        rgba(76,175,80,0.35);

    color: #81c784;

}


.error-message {

    padding: 15px 18px;

    margin-bottom: 22px;

    border-radius: 10px;

    background:
        rgba(198,40,40,0.15);

    border:
        1px solid
        rgba(239,83,80,0.35);

    color: #ef9a9a;

}


/* =====================================================
   FORM BOX
===================================================== */

.portfolio-form-box {

    background:
        linear-gradient(
            145deg,
            #181818,
            #101010
        );

    padding: 30px;

    border-radius: 17px;

    border:
        1px solid
        rgba(212,175,55,0.20);

    box-shadow:
        0 12px 35px
        rgba(0,0,0,0.30);

    margin-bottom: 30px;

}


.portfolio-form-box h3 {

    color: #D4AF37;

    font-size: 21px;

    margin-bottom: 25px;

}


.portfolio-form-box h3 i {

    margin-right: 8px;

}


/* =====================================================
   FORM
===================================================== */

.form-group {

    margin-bottom: 20px;

}


.form-group label {

    display: block;

    color: #dddddd;

    font-size: 14px;

    font-weight: 600;

    margin-bottom: 9px;

}


.form-group input,
.form-group select,
.form-group textarea {

    width: 100%;

    padding: 14px 15px;

    background: #0d0d0d;

    color: #ffffff;

    border:
        1px solid
        rgba(255,255,255,0.12);

    border-radius: 9px;

    outline: none;

    font-size: 15px;

    font-family: Arial, Helvetica, sans-serif;

}


.form-group textarea {

    min-height: 130px;

    resize: vertical;

}


.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {

    border-color: #D4AF37;

    box-shadow:
        0 0 0 3px
        rgba(212,175,55,0.08);

}


.form-group select option {

    background: #111111;

    color: #ffffff;

}


.form-group input[type="file"] {

    padding: 11px;

    cursor: pointer;

}


.form-group small {

    display: block;

    color: #777777;

    margin-top: 8px;

}


/* =====================================================
   CURRENT IMAGE
===================================================== */

.current-image {

    margin-top: 15px;

}


.current-image p {

    color: #999999;

    font-size: 13px;

    margin-bottom: 8px;

}


.current-image img {

    width: 140px;

    height: 95px;

    object-fit: cover;

    border-radius: 10px;

    border:
        2px solid
        rgba(212,175,55,0.50);

}


/* =====================================================
   BUTTON
===================================================== */

.admin-btn {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 12px 23px;

    background: #D4AF37;

    color: #111111;

    border: none;

    border-radius: 9px;

    font-size: 14px;

    font-weight: 700;

    cursor: pointer;

    transition: 0.3s;

}


.admin-btn:hover {

    background: #e6c34f;

    transform:
        translateY(-2px);

    box-shadow:
        0 8px 20px
        rgba(212,175,55,0.18);

}


.cancel-btn {

    background: #333333;

    color: #ffffff;

    margin-left: 8px;

}


.cancel-btn:hover {

    background: #444444;

}


/* =====================================================
   PORTFOLIO LIST
===================================================== */

.portfolio-list-box {

    background:
        linear-gradient(
            145deg,
            #181818,
            #101010
        );

    padding: 30px;

    border-radius: 17px;

    border:
        1px solid
        rgba(212,175,55,0.20);

    box-shadow:
        0 12px 35px
        rgba(0,0,0,0.30);

    overflow-x: auto;

}


.portfolio-list-box h3 {

    color: #D4AF37;

    font-size: 21px;

    margin-bottom: 20px;

}


.portfolio-list-box h3 i {

    margin-right: 8px;

}


/* =====================================================
   TABLE
===================================================== */

.portfolio-table {

    width: 100%;

    border-collapse: collapse;

    min-width: 1100px;

}


.portfolio-table th {

    background: #D4AF37;

    color: #111111;

    padding: 15px;

    text-align: left;

    font-size: 14px;

}


.portfolio-table td {

    padding: 15px;

    color: #cccccc;

    border-bottom:
        1px solid
        rgba(255,255,255,0.07);

    vertical-align: middle;

}


.portfolio-table tbody tr {

    transition: 0.2s;

}


.portfolio-table tbody tr:hover {

    background:
        rgba(212,175,55,0.05);

}


.portfolio-table td strong {

    color: #ffffff;

}


/* =====================================================
   PORTFOLIO IMAGE
===================================================== */

.portfolio-thumb {

    width: 110px;

    height: 75px;

    object-fit: cover;

    border-radius: 9px;

    border:
        2px solid
        rgba(212,175,55,0.35);

    display: block;

}


/* =====================================================
   CATEGORY
===================================================== */

.category-badge {

    display: inline-block;

    background:
        rgba(212,175,55,0.12);

    color: #D4AF37;

    padding: 7px 13px;

    border-radius: 20px;

    font-size: 13px;

    font-weight: 600;

    border:
        1px solid
        rgba(212,175,55,0.20);

}


/* =====================================================
   DESCRIPTION
===================================================== */

.description-cell {

    max-width: 300px;

    line-height: 1.5;

    color: #999999;

}


/* =====================================================
   ACTION BUTTONS
===================================================== */

.edit-btn,
.delete-btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    width: 36px;

    height: 36px;

    border-radius: 8px;

    transition: 0.3s;

}


.edit-btn {

    background:
        rgba(212,175,55,0.15);

    color: #D4AF37;

    margin-right: 5px;

}


.edit-btn:hover {

    background: #D4AF37;

    color: #111111;

}


.delete-btn {

    background:
        rgba(220,53,69,0.15);

    color: #ff7777;

}


.delete-btn:hover {

    background: #dc3545;

    color: #ffffff;

}


/* =====================================================
   EMPTY
===================================================== */

.empty-row {

    text-align: center;

    padding: 50px !important;

    color: #777777 !important;

}


.empty-row i {

    display: block;

    font-size: 45px;

    color: #D4AF37;

    margin-bottom: 15px;

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media(max-width:900px) {

    .sidebar {

        position: relative;

        width: 100%;

        height: auto;

    }


    .main-content {

        margin-left: 0;

        padding: 20px;

    }


    .sidebar ul {

        display: grid;

        grid-template-columns:
            repeat(2,1fr);

        gap: 5px;

    }


    .sidebar li {

        margin: 0;

    }

}


@media(max-width:600px) {

    .sidebar ul {

        grid-template-columns: 1fr;

    }


    .main-content {

        padding: 15px;

    }


    .topbar {

        padding: 20px;

    }


    .topbar h2 {

        font-size: 22px;

    }


    .portfolio-form-box,
    .portfolio-list-box {

        padding: 20px;

    }

}

</style>

</head>


<body>


<div class="admin-container">


<!-- =====================================================
     SIDEBAR
===================================================== -->

<div class="sidebar">


    <div class="logo">

        <h2>
            AKSHAR INTERIOR
        </h2>

        <p>
            Admin Panel
        </p>

    </div>


    <ul>


        <li>

            <a href="dashboard.php">

                <i class="fas fa-home"></i>

                Dashboard

            </a>

        </li>


        <li>

            <a href="services.php">

                <i class="fas fa-tools"></i>

                Services

            </a>

        </li>


        <li>

            <a href="gallery_category.php">

                <i class="fas fa-layer-group"></i>

                Gallery Category

            </a>

        </li>


        <li>

            <a href="gallery.php">

                <i class="fas fa-image"></i>

                Gallery

            </a>

        </li>


        <li class="active">

            <a href="portfolio.php">

                <i class="fas fa-briefcase"></i>

                Portfolio

            </a>

        </li>


        <li>

            <a href="bookings.php">

                <i class="fas fa-calendar-check"></i>

                Bookings

            </a>

        </li>


        <li>

            <a href="contact_messages.php">

                <i class="fas fa-envelope"></i>

                Contact

            </a>

        </li>


        <li>

            <a href="testimonials.php">

                <i class="fas fa-star"></i>

                Testimonials

            </a>

        </li>


        <li>

            <a href="logout.php">

                <i class="fas fa-right-from-bracket"></i>

                Logout

            </a>

        </li>


    </ul>

</div>


<!-- =====================================================
     MAIN CONTENT
===================================================== -->

<div class="main-content">


    <!-- TOPBAR -->

    <div class="topbar">


        <div>

            <h2>
                Portfolio Management
            </h2>

            <p>
                Manage your interior design projects
            </p>

        </div>


        <div class="admin-profile">

            <i class="fas fa-user-circle"></i>

        </div>


    </div>


    <!-- =================================================
         SUCCESS / ERROR
    ================================================= -->

    <?php

    if(isset($_GET['success']))
    {

        if($_GET['success'] == "added")
        {

            echo '
            <div class="success-message">

                <i class="fas fa-circle-check"></i>

                &nbsp;

                Portfolio project added successfully.

            </div>
            ';

        }


        if($_GET['success'] == "updated")
        {

            echo '
            <div class="success-message">

                <i class="fas fa-circle-check"></i>

                &nbsp;

                Portfolio project updated successfully.

            </div>
            ';

        }


        if($_GET['success'] == "deleted")
        {

            echo '
            <div class="success-message">

                <i class="fas fa-circle-check"></i>

                &nbsp;

                Portfolio project deleted successfully.

            </div>
            ';

        }

    }


    if(isset($error))
    {

        echo '
        <div class="error-message">

            <i class="fas fa-circle-exclamation"></i>

            &nbsp;

            '.htmlspecialchars($error).'

        </div>
        ';

    }

    ?>


    <!-- =================================================
         ADD / EDIT FORM
    ================================================= -->

    <div class="portfolio-form-box">


    <?php if($edit_portfolio): ?>


        <!-- EDIT PROJECT -->

        <h3>

            <i class="fas fa-pen-to-square"></i>

            Edit Portfolio Project

        </h3>


        <form
            method="POST"
            enctype="multipart/form-data"
        >


            <input
                type="hidden"
                name="id"
                value="<?php
                echo $edit_portfolio['id'];
                ?>"
            >


            <div class="form-group">

                <label>
                    Project Title
                </label>


                <input
                    type="text"
                    name="title"
                    value="<?php
                    echo htmlspecialchars(
                        $edit_portfolio['title']
                    );
                    ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Category
                </label>


                <select
                    name="category"
                    required
                >

                    <option value="">
                        Select Category
                    </option>

                    <option
                        value="Residential"

                        <?php

                        if(
                            $edit_portfolio['category']
                            == "Residential"
                        )
                        {
                            echo "selected";
                        }

                        ?>
                    >
                        Residential
                    </option>


                    <option
                        value="Commercial"

                        <?php

                        if(
                            $edit_portfolio['category']
                            == "Commercial"
                        )
                        {
                            echo "selected";
                        }

                        ?>
                    >
                        Commercial
                    </option>


                    <option
                        value="Kitchen"

                        <?php

                        if(
                            $edit_portfolio['category']
                            == "Kitchen"
                        )
                        {
                            echo "selected";
                        }

                        ?>
                    >
                        Kitchen
                    </option>


                    <option
                        value="Bedroom"

                        <?php

                        if(
                            $edit_portfolio['category']
                            == "Bedroom"
                        )
                        {
                            echo "selected";
                        }

                        ?>
                    >
                        Bedroom
                    </option>


                    <option
                        value="Living Room"

                        <?php

                        if(
                            $edit_portfolio['category']
                            == "Living Room"
                        )
                        {
                            echo "selected";
                        }

                        ?>
                    >
                        Living Room
                    </option>


                    <option
                        value="Office"

                        <?php

                        if(
                            $edit_portfolio['category']
                            == "Office"
                        )
                        {
                            echo "selected";
                        }

                        ?>
                    >
                        Office
                    </option>


                </select>

            </div>


            <div class="form-group">

                <label>
                    Location
                </label>


                <input
                    type="text"
                    name="location"
                    value="<?php
                    echo htmlspecialchars(
                        $edit_portfolio['location']
                    );
                    ?>"
                    placeholder="Example: Rajkot"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Project Description
                </label>


                <textarea
                    name="description"
                    placeholder="Enter project description..."
                    required
                ><?php
                echo htmlspecialchars(
                    $edit_portfolio['description']
                );
                ?></textarea>

            </div>


            <div class="form-group">

                <label>
                    New Project Image
                </label>


                <input
                    type="file"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                >


                <div class="current-image">

                    <p>
                        Current Image:
                    </p>


                    <img
                        src="../<?php
                        echo htmlspecialchars(
                            $edit_portfolio['image']
                        );
                        ?>"
                        alt="Current Project"
                    >

                </div>

            </div>


            <button
                type="submit"
                name="update_portfolio"
                class="admin-btn"
            >

                <i class="fas fa-save"></i>

                Update Project

            </button>


            <a
                href="portfolio.php"
                class="admin-btn cancel-btn"
            >

                <i class="fas fa-xmark"></i>

                Cancel

            </a>


        </form>


    <?php else: ?>


        <!-- ADD PROJECT -->

        <h3>

            <i class="fas fa-plus-circle"></i>

            Add New Portfolio Project

        </h3>


        <form
            method="POST"
            enctype="multipart/form-data"
        >


            <div class="form-group">

                <label>
                    Project Title
                </label>


                <input
                    type="text"
                    name="title"
                    placeholder="Example: Luxury Living Room"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Category
                </label>


                <select
                    name="category"
                    required
                >

                    <option value="">
                        Select Category
                    </option>

                    <option value="Residential">
                        Residential
                    </option>

                    <option value="Commercial">
                        Commercial
                    </option>

                    <option value="Kitchen">
                        Kitchen
                    </option>

                    <option value="Bedroom">
                        Bedroom
                    </option>

                    <option value="Living Room">
                        Living Room
                    </option>

                    <option value="Office">
                        Office
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label>
                    Location
                </label>


                <input
                    type="text"
                    name="location"
                    placeholder="Example: Rajkot"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Project Description
                </label>


                <textarea
                    name="description"
                    placeholder="Enter project description..."
                    required
                ></textarea>

            </div>


            <div class="form-group">

                <label>
                    Select Project Image
                </label>


                <input
                    type="file"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                    required
                >


                <small>
                    JPG, JPEG, PNG or WEBP | Maximum 5 MB
                </small>

            </div>


            <button
                type="submit"
                name="add_portfolio"
                class="admin-btn"
            >

                <i class="fas fa-upload"></i>

                Add Project

            </button>


        </form>


    <?php endif; ?>


    </div>


    <!-- =================================================
         PORTFOLIO LIST
    ================================================= -->

    <div class="portfolio-list-box">


        <h3>

            <i class="fas fa-briefcase"></i>

            All Portfolio Projects

        </h3>


        <table class="portfolio-table">


            <thead>

                <tr>

                    <th>
                        ID
                    </th>

                    <th>
                        Image
                    </th>

                    <th>
                        Project
                    </th>

                    <th>
                        Category
                    </th>

                    <th>
                        Location
                    </th>

                    <th>
                        Description
                    </th>

                    <th>
                        Created At
                    </th>

                    <th>
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody>


            <?php

            if(
                $portfolio &&
                mysqli_num_rows($portfolio) > 0
            )
            {

                while(
                    $row =
                    mysqli_fetch_assoc($portfolio)
                )
                {

            ?>


                <tr>


                    <td>

                        <?php
                        echo $row['id'];
                        ?>

                    </td>


                    <td>

                        <img
                            src="../<?php
                            echo htmlspecialchars(
                                $row['image']
                            );
                            ?>"
                            class="portfolio-thumb"
                            alt="Portfolio Image"
                        >

                    </td>


                    <td>

                        <strong>

                            <?php
                            echo htmlspecialchars(
                                $row['title']
                            );
                            ?>

                        </strong>

                    </td>


                    <td>

                        <span
                            class="category-badge"
                        >

                            <?php
                            echo htmlspecialchars(
                                $row['category']
                            );
                            ?>

                        </span>

                    </td>


                    <td>

                        <?php
                        echo htmlspecialchars(
                            $row['location']
                        );
                        ?>

                    </td>


                    <td
                        class="description-cell"
                    >

                        <?php
                        echo htmlspecialchars(
                            $row['description']
                        );
                        ?>

                    </td>


                    <td>

                        <?php
                        echo htmlspecialchars(
                            $row['created_at']
                        );
                        ?>

                    </td>


                    <td>


                        <a
                            href="portfolio.php?edit=<?php
                            echo $row['id'];
                            ?>"
                            class="edit-btn"
                            title="Edit"
                        >

                            <i class="fas fa-pen"></i>

                        </a>


                        <a
                            href="portfolio.php?delete=<?php
                            echo $row['id'];
                            ?>"
                            class="delete-btn"
                            title="Delete"

                            onclick="return confirm(
                                'Are you sure you want to delete this project?'
                            );"
                        >

                            <i class="fas fa-trash"></i>

                        </a>


                    </td>


                </tr>


            <?php

                }

            }
            else
            {

            ?>


                <tr>

                    <td
                        colspan="8"
                        class="empty-row"
                    >

                        <i class="fas fa-briefcase"></i>

                        No portfolio projects found.

                    </td>

                </tr>


            <?php

            }

            ?>


            </tbody>


        </table>


    </div>


</div>


</div>


</body>

</html>