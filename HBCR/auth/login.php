<?php
session_start();

if(isset($_SESSION['user_id'])){
    header("Location: ../dashboard/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>HBCR Portal</title>

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
>

<style>

/* =========================================================
   RESET
========================================================= */

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}


/* =========================================================
   BODY
========================================================= */

body {
    min-height: 100vh;

    font-family:
        "Segoe UI",
        Arial,
        sans-serif;

    background:
        linear-gradient(
            rgba(22, 78, 74, 0.45),
            rgba(22, 78, 74, 0.45)
        ),
        url("../assets/images/hospital-bg.jpg") center center / cover no-repeat;

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 25px;
}


/* =========================================================
   MAIN LOGIN CONTAINER
========================================================= */

.login-wrapper {
    width: 100%;
    max-width: 1050px;

    min-height: 610px;

    display: grid;

    grid-template-columns: 1fr 1fr;

    background: #ffffff;

    border-radius: 18px;

    overflow: hidden;

    border: 1px solid #dce7e5;

    box-shadow:
        0 18px 45px rgba(22, 78, 74, 0.14);
}


/* =========================================================
   LEFT BRANDING PANEL
========================================================= */

.login-brand {
    position: relative;

    background:
        linear-gradient(
            145deg,
            #164e4a,
            #1d625d
        );

    padding: 55px 50px;

    display: flex;

    flex-direction: column;

    justify-content: center;

    color: #ffffff;

    overflow: hidden;
}


/* =========================================================
   DECORATIVE CIRCLES
========================================================= */

.login-brand::before {
    content: "";

    position: absolute;

    width: 330px;
    height: 330px;

    right: -150px;
    top: -120px;

    border-radius: 50%;

    background:
        rgba(255,255,255,0.055);
}


.login-brand::after {
    content: "";

    position: absolute;

    width: 240px;
    height: 240px;

    left: -125px;
    bottom: -115px;

    border-radius: 50%;

    background:
        rgba(255,255,255,0.045);
}


/* =========================================================
   LOGO
========================================================= */

/* =========================================================
   HBCR BRAND LOGO
========================================================= */

.brand-logo {
    position: relative;
    z-index: 2;

    width: 180px;
    height: 100px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-bottom: 28px;

    /* WHITE BACKGROUND TO SEPARATE LOGO FROM TEAL */
    background: #ffffff;

    border: 1px solid #e2e9e7;

    border-radius: 14px;

    box-shadow:
        0 8px 22px rgba(0,0,0,0.12);

    overflow: hidden;
}


/* Actual HBCR image */

.brand-logo img {
    display: block;

    width: 100%;
    height: 100%;

    padding: 10px 16px;

    object-fit: contain;
}


/* =========================================================
   BRAND TITLE
========================================================= */

.login-brand h1 {
    position: relative;

    z-index: 2;

    font-size: 35px;

    font-weight: 700;

    letter-spacing: 0.3px;

    margin-bottom: 8px;
}


.login-brand h2 {
    position: relative;

    z-index: 2;

    font-size: 16px;

    font-weight: 500;

    color:
        rgba(255,255,255,0.86);

    margin-bottom: 22px;
}


.login-brand p {
    position: relative;

    z-index: 2;

    max-width: 410px;

    font-size: 13px;

    line-height: 1.7;

    color:
        rgba(255,255,255,0.73);
}


/* =========================================================
   FEATURES
========================================================= */

.brand-features {
    position: relative;

    z-index: 2;

    margin-top: 32px;

    display: flex;

    flex-direction: column;

    gap: 14px;
}


.brand-feature {
    display: flex;

    align-items: center;

    font-size: 12px;

    color:
        rgba(255,255,255,0.84);
}


.brand-feature i {
    width: 28px;

    margin-right: 10px;

    color: #ffffff;

    font-size: 13px;
}


/* =========================================================
   RIGHT LOGIN AREA
========================================================= */

.login-panel {
    padding: 55px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #ffffff;
}


.login-card {
    width: 100%;

    max-width: 390px;
}


/* =========================================================
   LOGIN HEADING
========================================================= */

.login-heading {
    margin-bottom: 30px;
}


.login-heading h2 {
    color: #164e4a;

    font-size: 28px;

    font-weight: 700;

    margin-bottom: 7px;
}


.login-heading p {
    color: #7a8987;

    font-size: 13px;

    line-height: 1.5;
}


/* =========================================================
   FORM GROUP
========================================================= */

.form-group {
    margin-bottom: 21px;
}


.form-group label {
    display: block;

    margin-bottom: 8px;

    color: #344545;

    font-size: 13px;

    font-weight: 600;
}


/* =========================================================
   INPUT WRAPPER
========================================================= */

.input-wrapper {
    position: relative;
}


.input-wrapper > i {
    position: absolute;

    left: 14px;
    top: 50%;

    transform: translateY(-50%);

    color: #82918f;

    font-size: 14px;

    pointer-events: none;
}


.input-wrapper input {
    width: 100%;

    height: 46px;

    padding:
        10px 43px;

    border:
        1px solid
        #cfdad8;

    border-radius: 8px;

    background: #ffffff;

    color: #263635;

    font-size: 13px;

    outline: none;

    transition:
        border-color .2s ease,
        box-shadow .2s ease;
}


.input-wrapper input:hover {
    border-color: #aebfbc;
}


.input-wrapper input:focus {
    border-color: #164e4a;

    box-shadow:
        0 0 0 3px
        rgba(22,78,74,0.10);
}


.input-wrapper input::placeholder {
    color: #9aa6a4;

    font-size: 12px;
}


/* =========================================================
   PASSWORD TOGGLE
========================================================= */

.password-toggle {
    position: absolute;

    right: 12px;
    top: 50%;

    transform: translateY(-50%);

    border: none;

    background: transparent;

    color: #81908e;

    cursor: pointer;

    font-size: 14px;

    padding: 6px;
}


.password-toggle:hover {
    color: #164e4a;
}


/* =========================================================
   REMEMBER ME
========================================================= */

.login-options {
    display: flex;

    justify-content: space-between;

    align-items: center;

    margin:
        2px 0 24px;
}


.remember-me {
    display: flex;

    align-items: center;

    gap: 7px;

    color: #687775;

    font-size: 12px;

    cursor: pointer;
}


.remember-me input {
    width: 14px;
    height: 14px;

    accent-color: #164e4a;

    cursor: pointer;
}


/* =========================================================
   LOGIN BUTTON
========================================================= */

.login-button {
    width: 100%;

    height: 47px;

    border: none;

    border-radius: 8px;

    background:
        linear-gradient(
            135deg,
            #164e4a,
            #1d625d
        );

    color: #ffffff;

    font-size: 13px;

    font-weight: 600;

    cursor: pointer;

    box-shadow:
        0 5px 12px
        rgba(22,78,74,0.18);

    transition:
        transform .18s ease,
        box-shadow .18s ease,
        background .18s ease;
}


.login-button:hover {
    transform: translateY(-1px);

    box-shadow:
        0 7px 16px
        rgba(22,78,74,0.24);

    background:
        linear-gradient(
            135deg,
            #123f3c,
            #185550
        );
}


.login-button:active {
    transform: translateY(0);
}


.login-button i {
    margin-right: 8px;
}


/* =========================================================
   SECURITY NOTE
========================================================= */

.security-note {
    display: flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    margin-top: 24px;

    color: #879391;

    font-size: 11px;

    text-align: center;
}


.security-note i {
    color: #164e4a;
}


/* =========================================================
   FOOTER
========================================================= */

.login-footer {
    margin-top: 35px;

    padding-top: 18px;

    border-top:
        1px solid
        #edf1f0;

    text-align: center;

    color: #9aa5a3;

    font-size: 10px;

    line-height: 1.6;
}


/* =========================================================
   ERROR MESSAGE
========================================================= */

.login-error {
    margin-bottom: 20px;

    padding: 11px 13px;

    border-radius: 7px;

    background: #fff4f4;

    border: 1px solid #f1d1d1;

    color: #b42318;

    font-size: 12px;
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 850px) {

    .login-wrapper {
        grid-template-columns: 1fr;

        max-width: 480px;
    }


    .login-brand {
        padding: 38px 35px;

        min-height: 300px;
    }


    .login-brand h1 {
        font-size: 29px;
    }


    .brand-features {
        display: none;
    }


    .login-panel {
        padding: 40px 35px;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 500px) {

    body {
        padding: 15px;
    }


    .login-wrapper {
        border-radius: 13px;
    }


    .login-brand {
        padding: 30px 25px;
    }


    .login-panel {
        padding: 35px 25px;
    }


    .login-heading h2 {
        font-size: 24px;
    }

}

</style>

</head>


<body>


<div class="login-wrapper">


    <!-- =================================================
         LEFT BRANDING
    ================================================== -->

    <div class="login-brand">


        <div class="brand-logo">

            <img
                src="../assets/images/hbcr-final.png"
                alt="HBCR Logo"
            >

        </div>


        <h1>HBCR</h1>


        <h2>
            Hospital Based Cancer Registry
        </h2>


        <p>
            Secure hospital cancer registry management
            system for maintaining patient records,
            diagnosis information and clinical data.
        </p>


        <div class="brand-features">


            <div class="brand-feature">

                <i class="fa fa-shield-halved"></i>

                Secure Patient Information

            </div>


            <div class="brand-feature">

                <i class="fa fa-user-doctor"></i>

                Clinical Record Management

            </div>


            <div class="brand-feature">

                <i class="fa fa-chart-line"></i>

                Cancer Registry Tracking

            </div>


        </div>


    </div>



    <!-- =================================================
         RIGHT LOGIN
    ================================================== -->

    <div class="login-panel">


        <div class="login-card">


            <div class="login-heading">

                <h2>
                    Welcome Back
                </h2>


                <p>
                    Sign in to access the HBCR management system.
                </p>

            </div>



            <!-- =================================================
                 LOGIN FORM
                 IMPORTANT:
                 KEEP authenticate.php
            ================================================== -->

            <form
                action="authenticate.php"
                method="POST"
            >


                <!-- USERNAME -->

                <div class="form-group">

                    <label for="username">
                        Username
                    </label>


                    <div class="input-wrapper">

                        <i class="fa fa-user"></i>


                        <input
                            type="text"
                            id="username"
                            name="username"
                            placeholder="Enter your username"
                            autocomplete="username"
                            required
                        >

                    </div>

                </div>



                <!-- PASSWORD -->

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>


                    <div class="input-wrapper">

                        <i class="fa fa-lock"></i>


                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >


                        <button
                            type="button"
                            class="password-toggle"
                            id="togglePassword"
                            aria-label="Show password"
                        >

                            <i class="fa fa-eye"></i>

                        </button>

                    </div>

                </div>



                <!-- REMEMBER ME -->

                <div class="login-options">

                    <label class="remember-me">

                        <input
                            type="checkbox"
                            name="remember"
                        >

                        Remember me

                    </label>

                </div>



                <!-- LOGIN BUTTON -->

                <button
                    type="submit"
                    name="login"
                    class="login-button"
                >

                    <i class="fa fa-right-to-bracket"></i>

                    Sign In

                </button>


            </form>



            <!-- SECURITY -->

            <div class="security-note">

                <i class="fa fa-shield-halved"></i>

                Authorized hospital personnel only

            </div>



            <!-- FOOTER -->

            <div class="login-footer">

                Hospital Based Cancer Registry System<br>

                Secure Clinical Data Management

            </div>


        </div>

    </div>


</div>



<script>

/* =========================================================
   SHOW / HIDE PASSWORD
========================================================= */

const togglePassword =
    document.getElementById("togglePassword");

const password =
    document.getElementById("password");


togglePassword.addEventListener(
    "click",
    function () {

        const isPassword =
            password.type === "password";


        password.type =
            isPassword
                ? "text"
                : "password";


        const icon =
            this.querySelector("i");


        icon.classList.toggle(
            "fa-eye"
        );


        icon.classList.toggle(
            "fa-eye-slash"
        );

    }
);

</script>


</body>
</html>