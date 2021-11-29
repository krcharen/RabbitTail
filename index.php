<?php
require_once __DIR__ . '/vendor/autoload.php';

$uri = $_SERVER['REQUEST_URI'];
$loader = new \App\Handle\Loader();
$loader->load($uri);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rabbit Tail's Shorter URL</title>
    <link rel="icon" href="./resource/images/favicon_32x32.png" sizes="32x32" type="image/png">
    <link rel="stylesheet" href="./resource/css/bootstrap.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .main {
            width: 100%;
            height: 850px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .main .header {
            margin-bottom: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .main .header .logo > img {
            height: 187px;
            width: 200px;
        }

        .main .enter {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .main .enter > input {
            width: 450px;
        }

        .main .enter > button {
            margin-left: 30px;
        }

        .main .show {
            background-color: #f8f9fa !important;
            margin-top: 40px;
            width: 30%;
            height: 200px;
            border-radius: 6px;
            padding: 5px 10px;
        }

        .main .footer {
            margin-top: 100px;
            color: #666;
            font-size: 12px;
        }

        .main .footer > p > a {
            color: #666;
            text-decoration: none;
        }

    </style>
    <script src="./resource/js/jquery-3.6.0.min.js"></script>
    <script src="./resource/js/bootstrap.min.js"></script>
    <script>
        function generate() {
            let url = $('#url').val();
            let reg = /^(?:http(s)?:\/\/)[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/;
            if (reg.test(decodeURIComponent(url))) {
                let content = '';
                $('#url').removeClass('is-invalid').addClass('is-valid');
                $.ajax({
                    url: '/handle.php',
                    type: 'POST',
                    cache: false,
                    data: {'url': url},
                    success: function (data) {
                        let result = JSON.parse(data)
                        if (result.status_code === 200) {
                            content = `<a href='${result.data.url}' target='_blank' class='link-success'>${result.data.url}</a>`;
                            $('#content').html(content);
                        } else {
                            content = `<span class='text-danger'>${result.text}</span>`;
                            $('#content').html(content);
                        }
                    }
                })
            } else {
                $('#url').addClass('is-invalid');
                $('#content').html('');
            }
        }
    </script>
</head>
<body>
<div class="main">
    <div class="header">
        <div class="logo">
            <img src="./resource/images/logo.png" alt="Rabbit Tail">
        </div>
        <div class="title">
            <span class="fw-bold fs-3">Rabbit Tail's Shorter URL</span>
        </div>
    </div>
    <div class="enter">
        <input type="text" id="url" value="" class="form-control" placeholder="长连接网址（必须包含http(s)）" required>
        <button type="button" class="btn btn-primary" onclick="generate();">缩短网址</button>
    </div>
    <div class="shadow p-3 mb-5 bg-body rounded show">
        <span id="content"></span>
    </div>
    <div class="footer">
        <p>©<?php echo date('Y'); ?>&nbsp;&nbsp;Rabbit Tail's Shorter URL&nbsp;&nbsp;|&nbsp;&nbsp;<a href="https://github.com/krcharen/RabbitTail" target='_blank'>GitHub</a></p>
    </div>
</div>
</body>
</html>