<?php


include("auth.php");
include("../includes/db.php");


$table = "booking";

$check = mysqli_query(
    $conn,
    "SHOW TABLES LIKE 'booking'"
);


// If booking table does not exist,
// check bookings table

if(!$check || mysqli_num_rows($check) == 0)
{
    $check2 = mysqli_query(
        $conn,
        "SHOW TABLES LIKE 'bookings'"
    );

    if(
        $check2 &&
        mysqli_num_rows($check2) > 0
    )
    {
        $table = "bookings";
    }
}

$table_check = mysqli_query(
    $conn,
    "SHOW COLUMNS FROM `$table`"
);


if(!$table_check)
{
    die(
        "
        <div style='
            font-family:Arial;
            padding:30px;
            background:#111;
            color:white;
        '>

            <h2 style='color:#D4AF37;'>
                Booking Table Not Found
            </h2>

            <p>
                Please check whether your database
                contains a <b>booking</b> table.
            </p>

        </div>
        "
    );
}


$columns = array();


while(
    $column = mysqli_fetch_assoc($table_check)
)
{
    $columns[] = $column['Field'];
}


$id_column = "id";


if(!in_array("id", $columns))
{
    $id_column = $columns[0];
}

if(isset($_GET['delete']))
{
    $delete_id = intval(
        $_GET['delete']
    );


    $delete_sql = "
        DELETE FROM `$table`
        WHERE `$id_column` = $delete_id
    ";


    if(
        mysqli_query(
            $conn,
            $delete_sql
        )
    )
    {
        header(
            "Location: bookings.php?success=deleted"
        );

        exit();
    }
    else
    {
        $error =
            "Booking could not be deleted.";
    }
}


$booking_sql = "
    SELECT *
    FROM `$table`
    ORDER BY `$id_column` DESC
";


$booking_result = mysqli_query(
    $conn,
    $booking_sql
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
    Bookings | Akshar Interior Admin
</title>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>


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

.admin-container {

    min-height: 100vh;

    background: #0b0b0b;

}

.sidebar {

    position: fixed;

    top: 0;

    left: 0;

    width: 255px;

    height: 100vh;

    background: #111111;

    border-right:
        1px solid
        rgba(212,175,55,0.25);

    box-shadow:
        5px 0 25px
        rgba(0,0,0,0.40);

    z-index: 1000;

}

.logo {

    padding: 30px 15px;

    text-align: center;

    border-bottom:
        1px solid
        rgba(255,255,255,0.08);

}


.logo h2 {

    color: #D4AF37;

    font-size: 22px;

    margin-bottom: 8px;

    letter-spacing: 1px;

}

.logo p {

    color: #999999;

    font-size: 13px;

    letter-spacing: 1px;

}


.sidebar ul {

    list-style: none;

    padding: 20px 12px;

}

.sidebar li {

    margin-bottom: 5px;

}

.sidebar li a {

    display: flex;

    align-items: center;

    gap: 14px;

    padding: 14px 15px;

    color: #dddddd;

    text-decoration: none;

    border-radius: 9px;

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
        translateX(3px);

}



.sidebar li.active a {

    background: #D4AF37;

    color: #111111;

}


.sidebar li.active a i {

    color: #111111;

}


.sidebar li:last-child {

    margin-top: 20px;

    padding-top: 15px;

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


.main-content {

    margin-left: 255px;

    min-height: 100vh;

    padding: 30px;

}

.topbar {

    display: flex;

    align-items: center;

    justify-content: space-between;

    background: #151515;

    padding: 25px 30px;

    border-radius: 16px;

    border:
        1px solid
        rgba(212,175,55,0.20);

    box-shadow:
        0 10px 30px
        rgba(0,0,0,0.30);

}


.topbar h2 {

    color: #D4AF37;

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

    border-radius: 50%;

    background:
        rgba(212,175,55,0.12);

    border:
        1px solid
        #D4AF37;

    display: flex;

    align-items: center;

    justify-content: center;

    color: #D4AF37;

    font-size: 25px;

}

.success-message {

    margin-top: 20px;

    padding: 14px 18px;

    border-radius: 9px;

    background:
        rgba(46,125,50,0.15);

    border:
        1px solid
        rgba(76,175,80,0.30);

    color: #81c784;

}


.error-message {

    margin-top: 20px;

    padding: 14px 18px;

    border-radius: 9px;

    background:
        rgba(198,40,40,0.15);

    border:
        1px solid
        rgba(239,83,80,0.30);

    color: #ef9a9a;

}


.booking-list-box {

    margin-top: 25px;

    padding: 30px;

    background:
        linear-gradient(
            145deg,
            #181818,
            #101010
        );

    border-radius: 16px;

    border:
        1px solid
        rgba(212,175,55,0.20);

    box-shadow:
        0 10px 30px
        rgba(0,0,0,0.30);

    overflow-x: auto;

}

.booking-list-box h3 {

    color: #D4AF37;

    font-size: 20px;

    margin-bottom: 25px;

}

.booking-list-box h3 i {

    margin-right: 8px;

}


.booking-list-box {
    margin-top: 25px;
    padding: 30px;
    background: linear-gradient(145deg, #181818, #101010);
    border-radius: 18px;
    border: 1px solid rgba(212,175,55,0.20);
    box-shadow: 0 12px 35px rgba(0,0,0,0.35);
    overflow: hidden;
}

.booking-list-box h3 {
    color: #D4AF37;
    font-size: 20px;
    margin-bottom: 22px;
}

.booking-list-box h3 i {
    margin-right: 8px;
}

.table-wrapper {
    width: 100%;
    overflow-x: auto;
    border-radius: 12px;
}

.booking-table {
    width: 100%;
    min-width: 1250px;
    border-collapse: separate;
    border-spacing: 0;
    table-layout: fixed;
}

.booking-table th {
    background: #D4AF37;
    color: #111111;
    padding: 15px 14px;
    text-align: left;
    font-size: 13px;
    font-weight: 800;
    white-space: nowrap;
    position: sticky;
    top: 0;
    z-index: 2;
}

.booking-table th:first-child {
    border-top-left-radius: 10px;
}

.booking-table th:last-child {
    border-top-right-radius: 10px;
}

.booking-table td {
    padding: 15px 14px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
    color: #d7d7d7;
    vertical-align: middle;
    line-height: 1.5;
    background: #141414;
}

.booking-table tbody tr:hover td {
    background: rgba(212,175,55,0.055);
}

.booking-table .col-id {
    width: 65px;
}

.booking-table .col-name {
    width: 150px;
}

.booking-table .col-phone {
    width: 125px;
}

.booking-table .col-email {
    width: 220px;
}

.booking-table .col-service {
    width: 150px;
}

.booking-table .col-date {
    width: 125px;
}

.booking-table .col-message {
    width: 240px;
}

.booking-table .col-created {
    width: 150px;
}

.booking-table .col-status {
    width: 145px;
}

.booking-table .col-action {
    width: 110px;
}

.booking-id {
    font-weight: 800;
    color: #D4AF37;
}

.cell-text {
    word-break: normal;
    overflow-wrap: anywhere;
}

.email-cell {
    overflow-wrap: anywhere;
    color: #cfcfcf;
}

.message-cell {
    white-space: normal;
    max-height: 72px;
    overflow: hidden;
}

.service-name {
    color: #ffffff;
    font-weight: 700;
}

.date-cell {
    white-space: nowrap;
    color: #d7d7d7;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-width: 118px;
    padding: 8px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 800;
    white-space: nowrap;
}

.status-badge.confirmed {
    color: #111111;
    background: #D4AF37;
}

.status-badge.pending {
    color: #f4c95d;
    background: rgba(212,175,55,0.12);
    border: 1px solid rgba(212,175,55,0.30);
}

.status-badge.other {
    color: #d7d7d7;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
}

.delete-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-width: 88px;
    padding: 9px 13px;
    border-radius: 8px;
    background: rgba(220,53,69,0.13);
    border: 1px solid rgba(220,53,69,0.28);
    color: #ff7777;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    transition: 0.25s;
}

.delete-btn:hover {
    background: #dc3545;
    color: #ffffff;
    transform: translateY(-1px);
}


.empty-booking {

    text-align: center;

    padding: 70px 20px;

    color: #888888;

}

.empty-booking i {

    display: block;

    font-size: 55px;

    color: #D4AF37;

    margin-bottom: 20px;

}

.empty-booking h3 {

    color: #D4AF37;

    font-size: 20px;

    margin-bottom: 10px;

}

.empty-booking p {

    color: #888888;

}

@media(max-width:900px) {

    .sidebar {

        position: relative;

        width: 100%;

        height: auto;

    }

    .main-content {

        margin-left: 0;

    }

    .sidebar ul {

        display: grid;

        grid-template-columns:
            repeat(2,1fr);

        gap: 5px;

    }

}

.table-wrapper {
    border-radius: 10px;
}

.booking-table {
    min-width: 1150px;
}

.status-badge {
    min-width: 105px;
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

        font-size: 21px;

    }


    .booking-list-box {

        padding: 20px;

    }

}

</style>

</head>

<body>

<div class="admin-container">


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

        <li>

            <a href="portfolio.php">

                <i class="fas fa-briefcase"></i>

                Portfolio

            </a>

        </li>

        <li class="active">

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

<div class="main-content">

    <div class="topbar">

        <div>

            <h2>
                Booking Management
            </h2>

            <p>
                View and manage customer bookings
            </p>

        </div>

        <div class="admin-profile">

            <i class="fas fa-user-circle"></i>

        </div>

    </div>

    <?php

    if(isset($_GET['success']))
    {

        if(
            $_GET['success']
            == "deleted"
        )
        {
            echo '

            <div class="success-message">

                <i class="fas fa-circle-check"></i>

                &nbsp;

                Booking deleted successfully.

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

            ' .
            htmlspecialchars($error)
            .

            '

        </div>

        ';

    }

    ?>

    <div class="booking-list-box">


        <h3>

            <i class="fas fa-calendar-check"></i>

            All Customer Bookings

        </h3>
        <?php

        if(
            $booking_result &&
            mysqli_num_rows(
                $booking_result
            ) > 0
        )
        {

        ?>
        <div class="table-wrapper">

    <table class="booking-table">

        <colgroup>
            <col class="col-id">
            <col class="col-name">
            <col class="col-phone">
            <col class="col-email">
            <col class="col-service">
            <col class="col-date">
            <col class="col-message">
            <col class="col-created">
            <col class="col-status">
            <col class="col-action">
        </colgroup>

        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Service</th>
                <th>Booking Date</th>
                <th>Message</th>
                <th>Created At</th>
                <th>Payment / Booking Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

        <?php
        while($row = mysqli_fetch_assoc($booking_result))
        {
            $status = isset($row['booking_status'])
                ? trim($row['booking_status'])
                : 'Pending Payment';

            $status_class = 'other';

            if(strtolower($status) === 'confirmed')
            {
                $status_class = 'confirmed';
            }
            elseif(strtolower($status) === 'pending payment')
            {
                $status_class = 'pending';
            }

            $booking_date_value =
                isset($row['booking_date']) &&
                $row['booking_date'] !== null &&
                $row['booking_date'] !== ''
                    ? $row['booking_date']
                    : (isset($row['date']) ? $row['date'] : '-');

            $created_at_value =
                isset($row['created_at']) &&
                $row['created_at'] !== null &&
                $row['created_at'] !== ''
                    ? $row['created_at']
                    : '-';
        ?>

            <tr>

                <td>
                    <span class="booking-id">
                        #<?php
                        echo intval($row[$id_column]);
                        ?>
                    </span>
                </td>

                <td>
                    <div class="cell-text">
                        <?php
                        echo htmlspecialchars(
                            $row['name'] ?? '-'
                        );
                        ?>
                    </div>
                </td>

                <td>
                    <div class="cell-text">
                        <?php
                        echo htmlspecialchars(
                            $row['phone'] ?? '-'
                        );
                        ?>
                    </div>
                </td>

                <td>
                    <div class="email-cell">
                        <?php
                        echo htmlspecialchars(
                            $row['email'] ?? '-'
                        );
                        ?>
                    </div>
                </td>

                <td>
                    <div class="service-name">
                        <?php
                        echo htmlspecialchars(
                            $row['service'] ?? '-'
                        );
                        ?>
                    </div>
                </td>

                <td>
                    <div class="date-cell">
                        <?php
                        echo htmlspecialchars(
                            $booking_date_value
                        );
                        ?>
                    </div>
                </td>

                <td>
                    <div class="message-cell">
                        <?php
                        echo nl2br(
                            htmlspecialchars(
                                $row['message'] ?? '-'
                            )
                        );
                        ?>
                    </div>
                </td>

                <td>
                    <div class="date-cell">
                        <?php
                        echo htmlspecialchars(
                            $created_at_value
                        );
                        ?>
                    </div>
                </td>

                <td>
                    <span class="status-badge <?php echo $status_class; ?>">

                        <?php
                        if($status_class === 'confirmed')
                        {
                            echo '<i class="fas fa-circle-check"></i>';
                        }
                        elseif($status_class === 'pending')
                        {
                            echo '<i class="fas fa-clock"></i>';
                        }
                        else
                        {
                            echo '<i class="fas fa-info-circle"></i>';
                        }
                        ?>
                        <?php
                        echo htmlspecialchars($status);
                        ?>

                    </span>
                </td>

                <td>
                    <a
                        href="bookings.php?delete=<?php
                        echo intval(
                            $row[$id_column]
                        );
                        ?>"
                        class="delete-btn"
                        onclick="
                            return confirm(
                                'Are you sure you want to delete this booking?'
                            );
                        "
                    >
                        <i class="fas fa-trash"></i>
                        Delete
                    </a>
                </td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
</div>
        <?php
        }
        else
        {
        ?>
            <div class="empty-booking">
                <i
                    class="fas fa-calendar-xmark"
                ></i>
                <h3>
                    No Bookings Found
                </h3>
                <p>
                    Customer bookings will appear here.
                </p>
            </div>
        <?php
        }
        ?>
    </div>
</div>
</div>
</body>
</html>