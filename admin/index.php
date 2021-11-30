<?php

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="../resource/js/jquery-3.6.0.min.js"></script>
    <script src="../resource/js/bootstrap.min.js"></script>
    <script src="../resource/js/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../resource/css/sweetalert2.min.css">
    <link rel="icon" type="image/png" href="../resource/images/favicon_32x32.png">
    <link rel="stylesheet" type="text/css" href="../resource/css/bootstrap.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            height: 100vh;
            background-color: #ebebeb;
        }

        .login {
            width: 100%;
            height: 100%;
        }

        .login .container {
            width: 100%;
            height: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 15px;
        }

        .login .container .login-box {
            height: 340px;
            width: 450px;
            padding: 15px;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            background-color: #fff;
        }

        .login .container .login-box .login-box-title {
            flex: 0.1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
        }

        .login .container .login-box .login-box-form {
            flex: 0.9;
        }
    </style>
</head>
<body>
<div class="login">
    <div class="container">
        <div class="login-box">
            <div class="login-box-title">
                <span>LOGIN</span>
            </div>
            <div class="login-box-form">
                <form autocomplete="off">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" required>
                        <div id="username_tip" class="form-text">Enter the username after the system is installed.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">SUBMIT</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>