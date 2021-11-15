<?php
require_once __DIR__ . '/vendor/autoload.php';

$uri = $_SERVER['REQUEST_URI'];
$loader = new \App\Handle\Loader();
$loader->load($uri);

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="#">
    <title>Shorter URL</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .main {
            width: 100%;
            height: 560px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .main .show {
            background-color: #ececec;
            margin-top: 40px;
            width: 30%;
            height: 90px;
            border-radius: 6px;
            padding: 5px 10px;
        }
    </style>
    <script src="resource/js/jquery-3.6.0.min.js"></script>
    <script>
        function generate() {
            let url = $('#url').val();
            $.ajax({
                url: '/handle.php',
                type: 'POST',
                cache: false,
                data: {'url': url},
                success: function (data) {
                    let result = JSON.parse(data)
                    if (result.status_code === 200) {
                        $('#content').html(result.data.url);
                    }
                }
            })

        }
    </script>
</head>
<body>
<div class="main">
    <div class="enter">
        <input type="text" id="url" value="" placeholder="填写网址" style="width: 400px;height:30px;">
        <button style="width:90px;height:30px;margin-left: 10px;cursor: pointer;" onclick="generate();">点击生成</button>
    </div>
    <div class="show">
        <span id="content"></span>
    </div>
</div>
</body>
</html>