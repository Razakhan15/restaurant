<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign in & Sign up Form</title>
    <link rel="stylesheet" href="sign.css" />
</head>

<body>
    <main>
        <div class="box">
            <div class="inner-box">
                <div class="forms-wrap">
                    <form action="/resturant/components/handleLogin.php" method="post" autocomplete="off" class="sign-in-form">

                        <div class="heading">
                            <h2>Welcome Back</h2>
                            <h6>Not registred yet?</h6>
                            <a href="#" class="toggle">Sign up</a>
                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="text" minlength="4" name="nameLog" class="input-field" autocomplete="off" required />
                                <label>Name</label>
                            </div>

                            <div class="input-wrap">
                                <input type="password" minlength="4" name="passwordLog" class="input-field" autocomplete="off" required />
                                <label>Password</label>
                            </div>

                            <button type="submit" value="Login" class="sign-btn">Login</button>

                            <p class="text">
                                Forgotten your password or you login datails?
                                <a href="#">Get help</a> signing in
                            </p>
                        </div>
                    </form>

                    <form action="/resturant/components/handleSignin.php" method="post" autocomplete="off" class="sign-up-form">

                        <div class="heading">
                            <h2>Get Started</h2>
                            <h6>Already have an account?</h6>
                            <a href="#" class="toggle">Sign in</a>
                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="text" minlength="4" class="input-field" name="name" autocomplete="off" required />
                                <label>Name</label>
                            </div>

                            <div class="input-wrap">
                                <input type="email" class="input-field" autocomplete="off" name="email" required />
                                <label>Email</label>
                            </div>

                            <div class="input-wrap">
                                <input type="password" minlength="4" name="password" class="input-field" autocomplete="off" required />
                                <label>Password</label>
                            </div>
                            <div class="input-wrap">
                                <input type="password" minlength="4" name="cpassword" class="input-field" autocomplete="off" required />
                                <label>Confirm Password</label>
                            </div>
                            <button type="submit" value="Sign Up" class="sign-btn">Sign Up</button>
                            <p class="text">
                                By signing up, I agree to the
                                <a href="#">Terms of Services</a> and
                                <a href="#">Privacy Policy</a>
                            </p>
                        </div>
                    </form>
                </div>

                <div class="carousel">
                    <div class="images-wrapper">
                        <img src="./img/image1.png" class="image img-1 show" alt="" />
                        <img src="./img/image2.png" class="image img-2" alt="" />
                        <img src="./img/image3.png" class="image img-3" alt="" />
                    </div>

                    <div class="text-slider">
                        <div class="text-wrap">
                            <div class="text-group">
                                <h1>Welcome</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    $url =  $_SERVER['REQUEST_URI'];
    $url_components = parse_url($url);
    parse_str($url_components['query'], $params);
    if($params['signupsuccess']== 'false'){
        echo '<script type ="text/JavaScript">
    alert("'.$params['error'].'")
    </script>';
    }
    if($params['loginsuccess']== 'false'){
        echo '<script type ="text/JavaScript">
    alert("'.$params['error'].'")
    </script>';
    }
    ?>
    
    <!-- stops user to navigate back to login page once logged in -->
    <script type="text/javascript">
        
        function preventBack() {
            window.history.forward();
        }

        setTimeout("preventBack()", 0);

        window.onunload = function() {
            null
        };
    </script>

    <script src="sign.js"></script>
</body>

</html>