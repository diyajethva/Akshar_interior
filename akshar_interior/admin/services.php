<?php

include("auth.php");
include("../includes/db.php");


// =====================================================
// ADD SERVICE
// =====================================================

if(isset($_POST['add_service']))
{
    $service_name = mysqli_real_escape_string(
        $conn,
        $_POST['service_name']
    );

    $icon = mysqli_real_escape_string(
        $conn,
        $_POST['icon']
    );

    $description = mysqli_real_escape_string(
        $conn,
        $_POST['description']
    );


    $sql = "INSERT INTO services
            (service_name, icon, description)
            VALUES
            ('$service_name', '$icon', '$description')";


    if(mysqli_query($conn, $sql))
    {
        header("Location: services.php?success=added");
        exit();
    }
    else
    {
        $error = "Service could not be added.";
    }
}


// =====================================================
// DELETE SERVICE
// =====================================================

if(isset($_GET['delete']))
{
    $id = intval($_GET['delete']);

    mysqli_query(
        $conn,
        "DELETE FROM services WHERE id=$id"
    );

    header("Location: services.php?success=deleted");
    exit();
}


// =====================================================
// EDIT SERVICE
// =====================================================

if(isset($_POST['update_service']))
{
    $id = intval($_POST['id']);

    $service_name = mysqli_real_escape_string(
        $conn,
        $_POST['service_name']
    );

    $icon = mysqli_real_escape_string(
        $conn,
        $_POST['icon']
    );

    $description = mysqli_real_escape_string(
        $conn,
        $_POST['description']
    );


    $sql = "UPDATE services SET
            service_name='$service_name',
            icon='$icon',
            description='$description'
            WHERE id=$id";


    if(mysqli_query($conn, $sql))
    {
        header("Location: services.php?success=updated");
        exit();
    }
    else
    {
        $error = "Service could not be updated.";
    }
}


// =====================================================
// GET SERVICE FOR EDIT
// =====================================================

$edit_service = null;


if(isset($_GET['edit']))
{
    $id = intval($_GET['edit']);

    $result = mysqli_query(
        $conn,
        "SELECT * FROM services WHERE id=$id"
    );

    $edit_service = mysqli_fetch_assoc($result);
}


// =====================================================
// GET ALL SERVICES
// =====================================================

$services = mysqli_query(
    $conn,
    "SELECT * FROM services ORDER BY id DESC"
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
        Services | Akshar Interior Admin
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
           MAIN ADMIN CONTAINER
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

            font-size: 16px;

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


        .topbar p strong {

            color: #D4AF37;

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
           MESSAGES
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

        .service-form {

            background:
                linear-gradient(
                    145deg,
                    #181818,
                    #101010
                );

            border:
                1px solid
                rgba(212,175,55,0.20);

            padding: 30px;

            border-radius: 17px;

            margin-bottom: 30px;

            box-shadow:
                0 12px 35px
                rgba(0,0,0,0.30);

        }


        .service-form h3 {

            color: #D4AF37;

            font-size: 21px;

            margin-bottom: 25px;

        }


        .service-form h3 i {

            margin-right: 8px;

        }


        /* =====================================================
           FORM GROUP
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

            transition: 0.3s;

        }


        .form-group textarea {

            min-height: 130px;

            resize: vertical;

        }


        .form-group input::placeholder,
        .form-group textarea::placeholder {

            color: #777777;

        }


        .form-group input:focus,
        .form-group textarea:focus {

            border-color: #D4AF37;

            box-shadow:
                0 0 0 3px
                rgba(212,175,55,0.08);

        }


        /* =====================================================
           BUTTONS
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
           TABLE BOX
        ===================================================== */

        .service-table-box {

            background:
                linear-gradient(
                    145deg,
                    #181818,
                    #101010
                );

            border:
                1px solid
                rgba(212,175,55,0.20);

            padding: 30px;

            border-radius: 17px;

            box-shadow:
                0 12px 35px
                rgba(0,0,0,0.30);

            overflow-x: auto;

        }


        .service-table-box h3 {

            color: #D4AF37;

            font-size: 21px;

            margin-bottom: 20px;

        }


        .service-table-box h3 i {

            margin-right: 8px;

        }


        /* =====================================================
           TABLE
        ===================================================== */

        .service-table {

            width: 100%;

            border-collapse: collapse;

            min-width: 750px;

        }


        .service-table th {

            background: #D4AF37;

            color: #111111;

            padding: 15px;

            text-align: left;

            font-size: 14px;

        }


        .service-table th:first-child {

            border-radius: 8px 0 0 8px;

        }


        .service-table th:last-child {

            border-radius: 0 8px 8px 0;

        }


        .service-table td {

            padding: 16px 15px;

            border-bottom:
                1px solid
                rgba(255,255,255,0.07);

            color: #cccccc;

            font-size: 14px;

        }


        .service-table tr {

            transition: 0.2s;

        }


        .service-table tbody tr:hover {

            background:
                rgba(212,175,55,0.05);

        }


        .service-table td strong {

            color: #ffffff;

        }


        /* =====================================================
           SERVICE ICON
        ===================================================== */

        .service-icon {

            color: #D4AF37;

            font-size: 22px;

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

            color: #ffffff;

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
           EMPTY TABLE
        ===================================================== */

        .empty-row {

            text-align: center;

            padding: 35px !important;

            color: #777777 !important;

        }


        /* =====================================================
           MOBILE
        ===================================================== */

        @media(max-width: 900px) {

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
                    repeat(2, 1fr);

                gap: 5px;

            }


            .sidebar li {

                margin: 0;

            }

        }


        @media(max-width: 600px) {

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


            .service-form,
            .service-table-box {

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


            <li class="active">

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


        <!-- TOP BAR -->

        <div class="topbar">

            <div>

                <h2>
                    Services Management
                </h2>

                <p>
                    Manage your interior design services
                </p>

            </div>


            <div class="admin-profile">

                <i class="fas fa-user-circle"></i>

            </div>

        </div>


        <!-- =================================================
             SUCCESS MESSAGE
        ================================================= -->

        <?php

        if(isset($_GET['success']))
        {

            if($_GET['success'] == "added")
            {

                echo '
                <div class="success-message">
                    <i class="fas fa-circle-check"></i>
                    &nbsp; Service added successfully.
                </div>
                ';

            }


            if($_GET['success'] == "updated")
            {

                echo '
                <div class="success-message">
                    <i class="fas fa-circle-check"></i>
                    &nbsp; Service updated successfully.
                </div>
                ';

            }


            if($_GET['success'] == "deleted")
            {

                echo '
                <div class="success-message">
                    <i class="fas fa-circle-check"></i>
                    &nbsp; Service deleted successfully.
                </div>
                ';

            }

        }

        ?>


        <!-- ERROR -->

        <?php

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
             ADD / EDIT SERVICE
        ================================================= -->

        <div class="service-form">


            <?php if($edit_service): ?>


                <!-- EDIT -->

                <h3>

                    <i class="fas fa-pen-to-square"></i>

                    Edit Service

                </h3>


                <form method="POST">


                    <input
                        type="hidden"
                        name="id"
                        value="<?php
                        echo $edit_service['id'];
                        ?>"
                    >


                    <div class="form-group">

                        <label>
                            Service Name
                        </label>

                        <input
                            type="text"
                            name="service_name"
                            value="<?php
                            echo htmlspecialchars(
                                $edit_service['service_name']
                            );
                            ?>"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Font Awesome Icon
                        </label>

                        <input
                            type="text"
                            name="icon"
                            value="<?php
                            echo htmlspecialchars(
                                $edit_service['icon']
                            );
                            ?>"
                            placeholder="Example: fa-solid fa-house"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Description
                        </label>

                        <textarea
                            name="description"
                            required
                        ><?php
                        echo htmlspecialchars(
                            $edit_service['description']
                        );
                        ?></textarea>

                    </div>


                    <button
                        type="submit"
                        name="update_service"
                        class="admin-btn"
                    >

                        <i class="fas fa-save"></i>

                        Update Service

                    </button>


                    <a
                        href="services.php"
                        class="admin-btn cancel-btn"
                    >

                        <i class="fas fa-xmark"></i>

                        Cancel

                    </a>


                </form>


            <?php else: ?>


                <!-- ADD -->

                <h3>

                    <i class="fas fa-plus-circle"></i>

                    Add New Service

                </h3>


                <form method="POST">


                    <div class="form-group">

                        <label>
                            Service Name
                        </label>

                        <input
                            type="text"
                            name="service_name"
                            placeholder="Example: Living Room Interior"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Font Awesome Icon
                        </label>

                        <input
                            type="text"
                            name="icon"
                            placeholder="Example: fa-solid fa-house"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Description
                        </label>

                        <textarea
                            name="description"
                            placeholder="Enter service description..."
                            required
                        ></textarea>

                    </div>


                    <button
                        type="submit"
                        name="add_service"
                        class="admin-btn"
                    >

                        <i class="fas fa-plus"></i>

                        Add Service

                    </button>


                </form>


            <?php endif; ?>


        </div>


        <!-- =================================================
             ALL SERVICES
        ================================================= -->

        <div class="service-table-box">


            <h3>

                <i class="fas fa-list"></i>

                All Services

            </h3>


            <table class="service-table">


                <thead>

                    <tr>

                        <th>
                            ID
                        </th>

                        <th>
                            Icon
                        </th>

                        <th>
                            Service Name
                        </th>

                        <th>
                            Description
                        </th>

                        <th>
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>


                <?php

                if(mysqli_num_rows($services) > 0)
                {

                    while($row = mysqli_fetch_assoc($services))
                    {

                ?>


                    <tr>


                        <td>

                            <?php
                            echo $row['id'];
                            ?>

                        </td>


                        <td>

                            <i
                                class="<?php
                                echo htmlspecialchars(
                                    $row['icon']
                                );
                                ?> service-icon"
                            ></i>

                        </td>


                        <td>

                            <strong>

                                <?php
                                echo htmlspecialchars(
                                    $row['service_name']
                                );
                                ?>

                            </strong>

                        </td>


                        <td>

                            <?php
                            echo htmlspecialchars(
                                $row['description']
                            );
                            ?>

                        </td>


                        <td>


                            <a
                                href="services.php?edit=<?php
                                echo $row['id'];
                                ?>"
                                class="edit-btn"
                                title="Edit"
                            >

                                <i class="fas fa-pen"></i>

                            </a>


                            <a
                                href="services.php?delete=<?php
                                echo $row['id'];
                                ?>"
                                class="delete-btn"
                                title="Delete"
                                onclick="return confirm('Are you sure you want to delete this service?');"
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
                            colspan="5"
                            class="empty-row"
                        >

                            <i
                                class="fas fa-folder-open"
                                style="
                                    font-size:30px;
                                    color:#D4AF37;
                                    display:block;
                                    margin-bottom:10px;
                                "
                            ></i>

                            No services found.

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