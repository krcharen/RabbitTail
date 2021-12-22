<?php
require_once __DIR__ . '/vendor/autoload.php';

$uri = $_SERVER['REQUEST_URI'];
$domain = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
$request_uri = explode('/', $uri);

switch ($request_uri[1]) {
    case 'api':
        $loader = new \App\Handle\Loader();
        $result = $loader->api($request_uri[2] ?? '');
        exit(json_encode($result, 64));
        break;
    default:
        $loader = new \App\Handle\Loader();
        $loader->load($uri);
        break;
}

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

        .main .content-show {
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

        .api {
            cursor: pointer;
        }

        .api-doc-show {
            width: 500px;
        }

        .api-doc {
            font-size: 12px;
            list-style-type: none;
        }

        .api-doc > li {
            display: flex;
        }

        .api-doc > li > p:first-child {
            flex: 0.2;
        }

        .api-doc > li > p:last-child {
            flex: 0.8;
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
    <div class="shadow p-3 mb-5 bg-body rounded content-show">
        <span id="content"></span>
    </div>
    <div class="offcanvas offcanvas-end api-doc-show" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">API Doc</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="api-doc">
                <li>
                    <p>URL</p>
                    <p><code><?php echo $domain; ?>/api/shorter</code></p>
                </li>
                <li>
                    <p>Method</p>
                    <p><code>POST</code></p>
                </li>
                <li>
                    <p>Headers</p>
                    <p><code>Content-Type:application/json</code></p>
                </li>
                <li>
                    <p>Format</p>
                    <p><code>JSON</code></p>
                </li>
                <li>
                    <p></p>
                    <p><code>Field:url Type:string</code></p>
                </li>
                <li>
                    <p>Request Demo</p>
                    <p><code>{"url":"http://www.demo.com"}</code></p>
                </li>
                <li>
                    <p>Response Demo</p>
                    <p><code>{"staus":200,"message":"success","data":{"url":"..."}}</code></p>
                </li>
                <li>
                    <p>Call Restriction</p>
                    <p><span style="font-weight: bold;">Unlimited</span></p>
                </li>
            </ul>
        </div>
    </div>
    <div class="footer">
        <p>©<?php echo date('Y'); ?>&nbsp;&nbsp;Rabbit Tail's Shorter URL&nbsp;&nbsp;|&nbsp;&nbsp;<a class="api" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">API</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="https://github.com/krcharen/RabbitTail" target='_blank'>GitHub</a></p>
    </div>
</div>
</body>
</html>