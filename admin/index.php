<?php
require_once __DIR__ . '/../vendor/autoload.php';

$action = trim($_GET['action'] ?? 'index');

if (!in_array($action, ['login', 'index'], true)) {
    $reload = "<script type='text/javascript'>window.location = '/admin'</script>";
    exit($reload);
}

switch ($action) {
    case 'login':
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($username && $password) {
            $helper = new \App\Functions\Helper();
            $staus = $helper::login($username, $password);

            if ($staus) {
                exit(json_encode(['staus' => 200, 'message' => 'success']));
            } else {
                exit(json_encode(['staus' => 400, 'message' => 'failure']));
            }
        }
        break;
}

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
    <script>
        function login() {
            let username = $('#username').val();
            let password = $('#password').val();
            if (username.length && password.length) {
                $.ajax({
                    url: '?action=login',
                    type: 'POST',
                    cache: false,
                    data: {'username': username, 'password': password},
                    success: function (data) {
                        let result = JSON.parse(data)
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
                        if (result.staus === 200) {
                            window.location = '/admin/Views/Home.php';
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'Login failed.The username or password is wrong!'
                            })
                        }
                    }
                })
            }
        }
    </script>
</head>
<body>
<div class="login">
    <div class="container">
        <div class="login-box">
            <div class="login-box-title">
                <span>LOGIN</span>
            </div>
            <div class="login-box-form">
                <form autocomplete="off" onsubmit="return false">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" required>
                        <div id="username_tip" class="form-text">Enter the username after the system is installed.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary" onclick="login()">SUBMIT</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>