<?php

session_start();

include("../includes/db.php");


// =====================================================
// LOGIN PROCESS
// =====================================================

if(isset($_POST['login']))
{

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);


    $username = mysqli_real_escape_string(
        $conn,
        $username
    );


    $password = mysqli_real_escape_string(
        $conn,
        $password
    );


    $query = "
        SELECT *
        FROM admin
        WHERE username='$username'
        AND password='$password'
    ";


    $result = mysqli_query(
        $conn,
        $query
    );


    if(
        $result &&
        mysqli_num_rows($result) > 0
    )
    {

        $_SESSION['admin'] = $username;


        header(
            "Location: dashboard.php"
        );

        exit();

    }
    else
    {

        $msg =
            "Invalid Username or Password";

    }

}

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
    Admin Login | Akshar Interior
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


/* =====================================================
   BODY
===================================================== */

body {

    min-height: 100vh;

    font-family:
        Arial,
        Helvetica,
        sans-serif;

    background:
        radial-gradient(
            circle at top right,
            rgba(212,175,55,0.15),
            transparent 35%
        ),
        radial-gradient(
            circle at bottom left,
            rgba(212,175,55,0.08),
            transparent 35%
        ),
        #080808;

    color: #ffffff;

    display: flex;

    align-items: center;

    justify-content: center;

    overflow: hidden;

}


/* =====================================================
   BACKGROUND GOLD CIRCLES
===================================================== */

body::before {

    content: "";

    position: fixed;

    width: 420px;

    height: 420px;

    border-radius: 50%;

    border:
        1px solid
        rgba(212,175,55,0.18);

    top: -180px;

    right: -120px;

}


body::after {

    content: "";

    position: fixed;

    width: 350px;

    height: 350px;

    border-radius: 50%;

    border:
        1px solid
        rgba(212,175,55,0.12);

    bottom: -160px;

    left: -100px;

}


/* =====================================================
   LOGIN WRAPPER
===================================================== */

.login-wrapper {

    width: 100%;

    max-width: 470px;

    padding: 25px;

    position: relative;

    z-index: 2;

}


/* =====================================================
   BRAND
===================================================== */

.brand {

    text-align: center;

    margin-bottom: 25px;

}


.brand h1 {

    font-size: 31px;

    letter-spacing: 1px;

    margin-bottom: 7px;

}


.brand h1 span {

    color: #D4AF37;

}


.brand p {

    color: #888888;

    font-size: 13px;

    letter-spacing: 2px;

    text-transform: uppercase;

}


/* =====================================================
   LOGIN CARD
===================================================== */

.login-container {

    background:
        linear-gradient(
            145deg,
            #171717,
            #0e0e0e
        );

    border:
        1px solid
        rgba(212,175,55,0.28);

    border-radius: 22px;

    padding: 42px;

    box-shadow:
        0 25px 70px
        rgba(0,0,0,0.65),
        0 0 40px
        rgba(212,175,55,0.05);

    position: relative;

    overflow: hidden;

}


/* GOLD TOP LINE */

.login-container::before {

    content: "";

    position: absolute;

    top: 0;

    left: 0;

    width: 100%;

    height: 4px;

    background:
        linear-gradient(
            90deg,
            transparent,
            #D4AF37,
            transparent
        );

}


/* =====================================================
   LOGIN ICON
===================================================== */

.login-icon {

    width: 75px;

    height: 75px;

    border-radius: 50%;

    margin:
        0 auto 22px;

    display: flex;

    align-items: center;

    justify-content: center;

    background:
        rgba(212,175,55,0.10);

    border:
        1px solid
        rgba(212,175,55,0.45);

    color: #D4AF37;

    font-size: 30px;

    box-shadow:
        0 0 25px
        rgba(212,175,55,0.08);

}


/* =====================================================
   HEADING
===================================================== */

.login-box h2 {

    text-align: center;

    font-size: 27px;

    margin-bottom: 8px;

    color: #ffffff;

}


.login-box .subtitle {

    text-align: center;

    color: #999999;

    font-size: 14px;

    margin-bottom: 30px;

}


/* =====================================================
   ERROR
===================================================== */

.error {

    background:
        rgba(220,53,69,0.12);

    border:
        1px solid
        rgba(220,53,69,0.30);

    color: #ff8a8a;

    padding: 12px 15px;

    border-radius: 8px;

    margin-bottom: 20px;

    font-size: 13px;

    text-align: center;

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

    font-size: 13px;

    font-weight: 600;

    margin-bottom: 8px;

}


/* =====================================================
   INPUT WRAPPER
===================================================== */

.input-wrapper {

    position: relative;

}


.input-wrapper i {

    position: absolute;

    left: 16px;

    top: 50%;

    transform: translateY(-50%);

    color: #D4AF37;

    font-size: 15px;

}


.input-wrapper input {

    width: 100%;

    height: 52px;

    padding:
        0 16px 0 45px;

    background: #0a0a0a;

    color: #ffffff;

    border:
        1px solid
        rgba(255,255,255,0.12);

    border-radius: 10px;

    outline: none;

    font-size: 14px;

    transition: 0.3s;

}


.input-wrapper input::placeholder {

    color: #666666;

}


.input-wrapper input:focus {

    border-color: #D4AF37;

    box-shadow:
        0 0 0 3px
        rgba(212,175,55,0.08);

}


/* =====================================================
   LOGIN BUTTON
===================================================== */

.login-btn {

    width: 100%;

    height: 52px;

    margin-top: 8px;

    border: none;

    border-radius: 10px;

    background:
        linear-gradient(
            135deg,
            #D4AF37,
            #b8941f
        );

    color: #111111;

    font-size: 15px;

    font-weight: 700;

    cursor: pointer;

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 10px;

    transition: 0.3s;

}


.login-btn:hover {

    transform:
        translateY(-2px);

    background:
        linear-gradient(
            135deg,
            #e6c34f,
            #c9a52e
        );

    box-shadow:
        0 10px 25px
        rgba(212,175,55,0.20);

}


.login-btn:active {

    transform:
        translateY(0);

}


/* =====================================================
   FOOTER
===================================================== */

.login-footer {

    text-align: center;

    margin-top: 25px;

    color: #666666;

    font-size: 12px;

}


.login-footer span {

    color: #D4AF37;

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media(max-width:600px) {

    .login-wrapper {

        padding: 20px;

    }


    .login-container {

        padding: 30px 25px;

    }


    .brand h1 {

        font-size: 26px;

    }

}

</style>

</head>


<body>


<div class="login-wrapper">


    <!-- =================================================
         BRAND
    ================================================= -->

    <div class="brand">

        <h1>

            <span>AKSHAR</span>
            INTERIOR

        </h1>

        <p>
            Luxury Interior Design
        </p>

    </div>


    <!-- =================================================
         LOGIN CARD
    ================================================= -->

    <div class="login-container">


        <div class="login-box">


            <!-- ICON -->

            <div class="login-icon">

                <i
                    class="fa-solid fa-user-shield"
                ></i>

            </div>


            <!-- HEADING -->

            <h2>
                Admin Login
            </h2>


            <p class="subtitle">
                Welcome back! Please login to continue.
            </p>


            <!-- =================================================
                 ERROR MESSAGE
            ================================================= -->

            <?php

            if(isset($msg))
            {

                echo '

                <div class="error">

                    <i class="fa-solid fa-circle-exclamation"></i>

                    &nbsp;

                    '
                    .
                    htmlspecialchars($msg)
                    .

                    '

                </div>

                ';

            }

            ?>


            <!-- =================================================
                 LOGIN FORM
            ================================================= -->

            <form
                method="POST"
            >


                <!-- USERNAME -->

                <div class="form-group">

                    <label>
                        Username
                    </label>


                    <div class="input-wrapper">

                        <i
                            class="fa-solid fa-user"
                        ></i>


                        <input
                            type="text"
                            name="username"
                            placeholder="Enter your username"
                            autocomplete="username"
                            required
                        >

                    </div>

                </div>


                <!-- PASSWORD -->

                <div class="form-group">

                    <label>
                        Password
                    </label>


                    <div class="input-wrapper">

                        <i
                            class="fa-solid fa-lock"
                        ></i>


                        <input
                            type="password"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >

                    </div>

                </div>


                <!-- LOGIN BUTTON -->

                <button
                    type="submit"
                    name="login"
                    class="login-btn"
                >

                    <i
                        class="fa-solid fa-right-to-bracket"
                    ></i>

                    Login to Admin Panel

                </button>


            </form>


        </div>


    </div>


    <!-- =================================================
         FOOTER
    ================================================= -->

    <div class="login-footer">

        © 2026
        <span>Akshar Interior</span>
        — Admin Panel

    </div>


</div>


</body>

</html>