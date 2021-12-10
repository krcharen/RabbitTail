<?php

require_once '../Actions/Actions.php';

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Home</title>
    <link rel="icon" type="image/png" href="../../resource/images/favicon_32x32.png">
    <link rel="stylesheet" type="text/css" href="../../resource/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../../resource/css/fontawesome.min.css">
    <link rel="stylesheet" type="text/css" href="../../resource/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../resource/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="../../resource/css/bootstrap-table.min.css">
    <link rel="stylesheet" type="text/css" href="../../resource/css/sweetalert2.min.css">
    <script src="../../resource/js/jquery-3.6.0.min.js"></script>
    <script src="../../resource/js/bootstrap.min.js"></script>
    <script src="../../resource/js/bootstrap-datepicker.min.js"></script>
    <script src="../../resource/js/bootstrap-datepicker.zh-CN.min.js"></script>
    <script src="../../resource/js/bootstrap-table.min.js"></script>
    <script src="../../resource/js/bootstrap-table-zh-CN.min.js"></script>
    <script src="../../resource/js/sweetalert2.all.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            height: 100vh;
            background-color: #ebebeb;
        }

        .main {
            width: 100%;
            height: 100%;
        }

        .main .container {
            width: 60%;
            height: 758px;
            margin: auto;
            position: relative;
            top: 50%;
            transform: translateY(-50%);
        }

        .main .container .header {
            width: 100%;
            height: 6%;
            display: flex;
            justify-content: right;
            align-items: center;
        }

        .main .container .header > p {
            font-size: 14px;
            padding-right: 20px;
        }

        .main .container .header > p > .admin {
            font-weight: bold;
        }

        .main .container .header > p > .separate {
            margin: 0 10px;
        }

        .main .container .content {
            width: 100%;
            height: 90%;
            background-color: #fff;
            display: flex;
        }

        .main .container .content > .content-left {
            flex: 0.1;
            padding: 10px 15px;
            border-right: 1px solid #ebebeb;
            background-color: #fdfdfd;
        }

        .main .container .content > .content-left > div > button {
            width: 160px;
        }

        .main .container .content > .content-right {
            flex: 0.9;
            padding: 10px 0;
        }

        .main .container .footer {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #666;
            font-size: 12px;
        }

        .main .container .footer > p > a {
            color: #666;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="main">
    <div class="container">
        <div class="header">
            <p>
                <span class="admin">Admin</span>
                <span class="separate">|</span>
                <span class="operate" style="cursor: pointer;">[退出]</span>
            </p>
        </div>
        <div class="content">
            <div class="d-flex align-items-start content-left">
                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">首页</button>
                    <button class="nav-link" id="v-pills-setting-tab" data-bs-toggle="pill" data-bs-target="#v-pills-setting" type="button" role="tab" aria-controls="v-pills-setting" aria-selected="false">设置</button>
                </div>
            </div>
            <div class="tab-content content-right">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    111
                </div>
                <div class="tab-pane fade" id="v-pills-setting" role="tabpanel" aria-labelledby="v-pills-setting-tab">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="account-password-tab" data-bs-toggle="tab" data-bs-target="#account-password" type="button" role="tab" aria-controls="account-password" aria-selected="true">账号密码</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="api-tab" data-bs-toggle="tab" data-bs-target="#api" type="button" role="tab" aria-controls="api" aria-selected="false">API管理</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="account-password" role="tabpanel" aria-labelledby="account-password-tab" style="width: 500px;margin-top: 65px;margin-left: 150px;">
                            <div class="manage-account-password">
                                <div class="mb-3 row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">账号</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="Admin">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">旧密码</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="old_password" aria-label="old_password">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">新密码</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="new_password" aria-label="new_password">
                                    </div>
                                </div>
                                <div class="mb-3 row" style="display: contents;">
                                    <button type="submit" class="btn btn-primary" style="width: 100px;margin-top: 20px;float: right;">确定更改</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="api" role="tabpanel" aria-labelledby="api-tab">
                            <div class="token-create"
                                 style="display: flex;margin: 10px;border-radius: 4px;background-color: #efefef">
                                <div class="input-group input-daterange"
                                     style="margin: 15px 20px 15px 210px;width: 400px;" data-provide="datepicker">
                                    <span class="input-group-text" style="height: 30px;">FROM</span>
                                    <input type="text" class="form-control" aria-label="start_date" id="start_date" value="" style="height: 30px;">
                                    <span class="input-group-text" style="height: 30px;">TO</span>
                                    <input type="text" class="form-control" aria-label="end_date" id="end_date" value="" style="height: 30px;">
                                </div>
                                <div class="token-create-confirm" style="margin-top: 15px;">
                                    <button type="submit" class="btn btn-primary btn-sm" style="width: 60px;height: 30px;" onclick="_generate()">生成</button>
                                </div>
                            </div>
                            <div class="token-show" style="margin: 0 10px;font-size: 12px;">
                                <table id="table" data-toggle="table" data-search="true" data-pagination="true">
                                    <thead>
                                        <tr>
                                            <th data-field="id" data-halign="center">序号</th>
                                            <th data-field="token" data-halign="center" data-width="320">Token</th>
                                            <th data-field="start_date" data-halign="center" data-sortable="true">起始日期</th>
                                            <th data-field="end_date" data-halign="center" data-sortable="true">终止日期</th>
                                            <th data-field="operate" data-halign="center">操作</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <p>
                ©<?php echo date('Y'); ?>&nbsp;&nbsp;Rabbit Tail's Shorter URL&nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="https://github.com/krcharen/RabbitTail" target='_blank'>GitHub</a>
            </p>
        </div>
    </div>
</div>
</body>
</html>
<script>
    $(function () {
        $('.page-list').remove();
        _reload();
    });

    $('.input-daterange').datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
    });

    $('#table').bootstrapTable({
        onPageChange: function (arg1, arg2) {
            $('.page-list').remove();
        },
    });

    function _generate() {
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();

        $.ajax({
            url: '?action=token',
            type: 'POST',
            cache: false,
            data: {'start_date': start_date, 'end_date': end_date},
            success: function (data) {
                let result = JSON.parse(data);
                console.log(result)
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                if (result.staus === 200) {
                    Toast.fire({
                        icon: 'success',
                        title: '创建成功！'
                    })
                    _reload();
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: '创建失败！'
                    })
                }
            }
        });
    }

    function _delete(number) {
        console.log(number);
    }

    function _reload() {
        $.ajax({
            url: '?action=reload.json',
            type: 'POST',
            cache: false,
            success: function (data) {
                let result = JSON.parse(data);
                let table = '';
                if (result.staus === 200) {
                    let data = result.data;
                    for (const key in data) {
                        let token = data[key]['token'];
                        let start_date = data[key]['start_date'];
                        let end_date = data[key]['end_date'];

                        table += '<tr>';
                        table += `<td>${key}</td>`;
                        table += `<td>${token}</td>`;
                        table += `<td>${start_date}</td>`;
                        table += `<td>${end_date}</td>`;
                        table += `<td style="text-align:center;"><i class="fas fa-trash-alt" style="cursor: pointer;font-size: 16px;color: #dc3545;" onclick="_delete(1)"></i></td>`;
                        table += '</tr>';
                    }
                    $('#tbody-token').html(table)
                }
            }
        });
    }
</script>