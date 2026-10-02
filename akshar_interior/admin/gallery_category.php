<?php

include("auth.php");
include("../includes/db.php");


// =====================================================
// ADD CATEGORY
// =====================================================

if(isset($_POST['add_category']))
{
    $category_name = trim($_POST['category_name']);

    if($category_name != "")
    {
        $category_name = mysqli_real_escape_string(
            $conn,
            $category_name
        );

        $sql = "INSERT INTO gallery_category (category_name)
                VALUES ('$category_name')";

        if(mysqli_query($conn, $sql))
        {
            header("Location: gallery_category.php?success=added");
            exit();
        }
        else
        {
            $error = "Category could not be added.";
        }
    }
}


// =====================================================
// DELETE CATEGORY
// =====================================================

if(isset($_GET['delete']))
{
    $id = intval($_GET['delete']);

    mysqli_query(
        $conn,
        "DELETE FROM gallery_category WHERE id=$id"
    );

    header("Location: gallery_category.php?success=deleted");
    exit();
}


// =====================================================
// EDIT CATEGORY
// =====================================================

if(isset($_POST['update_category']))
{
    $id = intval($_POST['id']);

    $category_name = trim($_POST['category_name']);

    $category_name = mysqli_real_escape_string(
        $conn,
        $category_name
    );

    $sql = "UPDATE gallery_category
            SET category_name='$category_name'
            WHERE id=$id";

    if(mysqli_query($conn, $sql))
    {
        header("Location: gallery_category.php?success=updated");
        exit();
    }
    else
    {
        $error = "Category could not be updated.";
    }
}


// =====================================================
// GET EDIT CATEGORY
// =====================================================

$edit_category = null;

if(isset($_GET['edit']))
{
    $id = intval($_GET['edit']);

    $result = mysqli_query(
        $conn,
        "SELECT * FROM gallery_category WHERE id=$id"
    );

    if($result)
    {
        $edit_category = mysqli_fetch_assoc($result);
    }
}


// =====================================================
// GET ALL CATEGORIES
// =====================================================

$categories = mysqli_query(
    $conn,
    "SELECT * FROM gallery_category ORDER BY id DESC"
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
        Gallery Category | Akshar Interior Admin
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

            font-weight: 700;

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

            transition: all 0.3s ease;

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


        /* LOGOUT */

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

        .category-form-box {

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


        .category-form-box h3 {

            color: #D4AF37;

            font-size: 21px;

            margin-bottom: 25px;

        }


        .category-form-box h3 i {

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

            font-weight: 600;

            font-size: 14px;

            margin-bottom: 9px;

        }


        .form-group input {

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

            transition: 0.3s;

        }


        .form-group input::placeholder {

            color: #777777;

        }


        .form-group input:focus {

            border-color: #D4AF37;

            box-shadow:
                0 0 0 3px
                rgba(212,175,55,0.08);

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
           CATEGORY LIST
        ===================================================== */

        .category-list-box {

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


        .category-list-box h3 {

            color: #D4AF37;

            font-size: 21px;

            margin-bottom: 20px;

        }


        .category-list-box h3 i {

            margin-right: 8px;

        }


        /* =====================================================
           TABLE
        ===================================================== */

        .category-table {

            width: 100%;

            border-collapse: collapse;

            min-width: 650px;

        }


        .category-table th {

            background: #D4AF37;

            color: #111111;

            padding: 15px;

            text-align: left;

            font-size: 14px;

        }


        .category-table td {

            padding: 16px 15px;

            color: #cccccc;

            border-bottom:
                1px solid
                rgba(255,255,255,0.07);

            font-size: 14px;

        }


        .category-table td strong {

            color: #ffffff;

        }


        .category-table tbody tr {

            transition: 0.2s;

        }


        .category-table tbody tr:hover {

            background:
                rgba(212,175,55,0.05);

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

            padding: 35px !important;

            color: #777777 !important;

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


            .admin-container {

                display: block;

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


            .category-form-box,
            .category-list-box {

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


            <li class="active">

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


            <li>

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
                    Gallery Categories
                </h2>

                <p>
                    Manage your interior gallery categories
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
                    &nbsp; Category added successfully.
                </div>
                ';

            }


            if($_GET['success'] == "updated")
            {

                echo '
                <div class="success-message">
                    <i class="fas fa-circle-check"></i>
                    &nbsp; Category updated successfully.
                </div>
                ';

            }


            if($_GET['success'] == "deleted")
            {

                echo '
                <div class="success-message">
                    <i class="fas fa-circle-check"></i>
                    &nbsp; Category deleted successfully.
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
             ADD / EDIT CATEGORY
        ================================================= -->

        <div class="category-form-box">


            <?php if($edit_category): ?>


                <!-- EDIT CATEGORY -->

                <h3>

                    <i class="fas fa-pen-to-square"></i>

                    Edit Category

                </h3>


                <form method="POST">


                    <input
                        type="hidden"
                        name="id"
                        value="<?php
                        echo $edit_category['id'];
                        ?>"
                    >


                    <div class="form-group">

                        <label>
                            Category Name
                        </label>


                        <input
                            type="text"
                            name="category_name"
                            value="<?php
                            echo htmlspecialchars(
                                $edit_category['category_name']
                            );
                            ?>"
                            required
                        >

                    </div>


                    <button
                        type="submit"
                        name="update_category"
                        class="admin-btn"
                    >

                        <i class="fas fa-save"></i>

                        Update Category

                    </button>


                    <a
                        href="gallery_category.php"
                        class="admin-btn cancel-btn"
                    >

                        <i class="fas fa-xmark"></i>

                        Cancel

                    </a>


                </form>


            <?php else: ?>


                <!-- ADD CATEGORY -->

                <h3>

                    <i class="fas fa-plus-circle"></i>

                    Add New Gallery Category

                </h3>


                <form method="POST">


                    <div class="form-group">

                        <label>
                            Category Name
                        </label>


                        <input
                            type="text"
                            name="category_name"
                            placeholder="Example: Living Room"
                            required
                        >

                    </div>


                    <button
                        type="submit"
                        name="add_category"
                        class="admin-btn"
                    >

                        <i class="fas fa-plus"></i>

                        Add Category

                    </button>


                </form>


            <?php endif; ?>


        </div>


        <!-- =================================================
             CATEGORY LIST
        ================================================= -->

        <div class="category-list-box">


            <h3>

                <i class="fas fa-list"></i>

                All Gallery Categories

            </h3>


            <table class="category-table">


                <thead>

                    <tr>

                        <th>
                            ID
                        </th>

                        <th>
                            Category Name
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
                    $categories &&
                    mysqli_num_rows($categories) > 0
                )
                {

                    while(
                        $row =
                        mysqli_fetch_assoc($categories)
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

                            <strong>

                                <?php

                                echo htmlspecialchars(
                                    $row['category_name']
                                );

                                ?>

                            </strong>

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
                                href="gallery_category.php?edit=<?php
                                echo $row['id'];
                                ?>"
                                class="edit-btn"
                                title="Edit"
                            >

                                <i class="fas fa-pen"></i>

                            </a>


                            <a
                                href="gallery_category.php?delete=<?php
                                echo $row['id'];
                                ?>"
                                class="delete-btn"
                                title="Delete"
                                onclick="return confirm('Are you sure you want to delete this category?');"
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
                            colspan="4"
                            class="empty-row"
                        >

                            <i
                                class="fas fa-folder-open"
                                style="
                                    display:block;
                                    font-size:30px;
                                    color:#D4AF37;
                                    margin-bottom:10px;
                                "
                            ></i>

                            No categories found.

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