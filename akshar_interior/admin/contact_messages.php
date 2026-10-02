<?php

include("auth.php");
include("../includes/db.php");

$table = "contact";

$check = mysqli_query(
    $conn,
    "SHOW TABLES LIKE 'contact'"
);

if(!$check || mysqli_num_rows($check) == 0)
{
    $check2 = mysqli_query(
        $conn,
        "SHOW TABLES LIKE 'contacts'"
    );

    if(
        $check2 &&
        mysqli_num_rows($check2) > 0
    )
    {
        $table = "contacts";
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
            padding:40px;
            background:#0b0b0b;
            color:white;
            min-height:100vh;
        '>

            <h2 style='color:#D4AF37;'>
                Contact Table Not Found
            </h2>

            <p>
                Please check whether your database
                contains a <b>contact</b> table.
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
            "Location: contact_messages.php?success=deleted"
        );

        exit();
    }
    else
    {
        $error =
            "Contact message could not be deleted.";
    }
}


$contact_sql = "
    SELECT *
    FROM `$table`
    ORDER BY `$id_column` DESC
";


$contact_result = mysqli_query(
    $conn,
    $contact_sql
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
    Contact Messages | Akshar Interior Admin
</title>


<!-- FONT AWESOME -->

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
>


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


.message-box {

    margin-top: 25px;

    background:
        linear-gradient(
            145deg,
            #181818,
            #101010
        );

    border:
        1px solid
        rgba(212,175,55,0.20);

    border-radius: 16px;

    padding: 30px;

    box-shadow:
        0 10px 30px
        rgba(0,0,0,0.30);

    overflow-x: auto;

}


.message-box h3 {

    color: #D4AF37;

    font-size: 20px;

    margin-bottom: 25px;

}


.message-box h3 i {

    margin-right: 8px;

}

.contact-table {

    width: 100%;

    min-width: 1000px;

    border-collapse: collapse;

}


.contact-table th {

    background: #D4AF37;

    color: #111111;

    padding: 15px;

    text-align: left;

    font-size: 14px;

    white-space: nowrap;

}


/* DATA */

.contact-table td {

    padding: 15px;

    color: #cccccc;

    border-bottom:
        1px solid
        rgba(255,255,255,0.08);

    vertical-align: top;

}


.contact-table tr:hover {

    background:
        rgba(212,175,55,0.05);

}


.contact-value {

    max-width: 280px;

    word-break: break-word;

    line-height: 1.5;

    color: #cccccc;

}


.contact-id {

    color: #D4AF37;

    font-weight: bold;

}


.delete-btn {

    display: inline-flex;

    align-items: center;

    gap: 7px;

    padding: 9px 14px;

    border-radius: 7px;

    background:
        rgba(220,53,69,0.15);

    border:
        1px solid
        rgba(220,53,69,0.30);

    color: #ff7777;

    text-decoration: none;

    font-size: 13px;

    transition: 0.3s;

}


.delete-btn:hover {

    background: #dc3545;

    color: #ffffff;

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

.empty-contact {

    text-align: center;

    padding: 70px 20px;

    color: #888888;

}


.empty-contact i {

    display: block;

    font-size: 55px;

    color: #D4AF37;

    margin-bottom: 20px;

}


.empty-contact h3 {

    color: #D4AF37;

    font-size: 21px;

    margin-bottom: 10px;

}


.empty-contact p {

    color: #888888;

    font-size: 14px;

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


    .message-box {

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


        <li>

            <a href="bookings.php">

                <i class="fas fa-calendar-check"></i>

                Bookings

            </a>

        </li>


        <li class="active">

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


    <!-- TOPBAR -->

    <div class="topbar">


        <div>

            <h2>
                Contact Management
            </h2>

            <p>
                View and manage customer contact messages
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

                Contact message deleted successfully.

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

    <div class="message-box">


        <h3>

            <i class="fas fa-envelope-open-text"></i>

            All Contact Messages

        </h3>

        <?php

        if(
            $contact_result &&
            mysqli_num_rows(
                $contact_result
            ) > 0
        )
        {

        ?>

        <table class="contact-table">

            <thead>

                <tr>

                <?php

                foreach(
                    $columns
                    as $column_name
                )
                {

                ?>

                    <th>

                        <?php

                        echo htmlspecialchars(

                            ucwords(

                                str_replace(
                                    "_",
                                    " ",
                                    $column_name
                                )

                            )

                        );

                        ?>

                    </th>

                <?php

                }

                ?>

                    <th>
                        Action
                    </th>

                </tr>

            </thead>

            <tbody>

            <?php

            while(
                $row =
                mysqli_fetch_assoc(
                    $contact_result
                )
            )
            {

            ?>

                <tr>

                <?php

                foreach(
                    $columns
                    as $column_name
                )
                {

                ?>


                    <td>

                        <div
                            class="contact-value"
                        >

                            <?php

                            if(
                                isset(
                                    $row[$column_name]
                                )
                            )
                            {

                                echo nl2br(

                                    htmlspecialchars(
                                        $row[$column_name]
                                    )

                                );

                            }
                            else
                            {

                                echo "-";

                            }

                            ?>

                        </div>

                    </td>


                <?php

                }

                ?>


                    <td>


                        <a
                            href="
                            contact_messages.php?delete=<?php
                            echo intval(
                                $row[$id_column]
                            );
                            ?>
                            "
                            class="delete-btn"

                            onclick="
                            return confirm(
                                'Are you sure you want to delete this contact message?'
                            );
                            "
                        >

                            <i
                                class="fas fa-trash"
                            ></i>

                            Delete

                        </a>

                    </td>

                </tr>

            <?php

            }

            ?>

            </tbody>

        </table>

        <?php

        }
        else
        {

        ?>

            <div class="empty-contact">

                <i
                    class="fas fa-envelope-open"
                ></i>

                <h3>
                    No Contact Messages Found
                </h3>

                <p>
                    Customer contact messages will appear here.
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