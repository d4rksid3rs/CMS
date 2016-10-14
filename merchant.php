<?php
$today = date('Y-m-d', time());
require('API/db.class.php');
require('./_login_users.php');
$user_list = array_keys($users);
$sql_merchants = "SELECT merchants.*, auth_user.koin, auth_user.koin_vip FROM `merchants` JOIN auth_user ON merchants.username = auth_user.username";
$i = 0;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Đại lý</title>
        <?php require('header.php'); ?>
        <script src="js/highcharts.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/themes/grid.js"></script> 
        <script>
            function addMerchantKoin() {
                var user = $("#addKoin select[name=user]").val();
                var pass = $("#addKoin input[name=pass]").val();
                var vnd = $("#addKoin input[name=koin]").val();
                $.ajax({
                    type: "POST",
                    url: "API/addMerchantKoin.php",
                    data: {
                        "user": user,
                        "pass": pass,
                        "vnd": vnd
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#addKoin #message").html("Cập nhật thành công");
                                $(this).oneTime(5000, function () {
                                    $("#addKoin #message").html("");
                                });
                            } else {
                                $("#addKoin #message").html(data.message);
                                $(this).oneTime(5000, function () {
                                    $("#addKoin #message").html("");
                                });
                            }
                        } else {
                            $("#addKoin #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#addKoin #message").html("");
                            });
                        }
                    },
                    failure: function () {
                        $("#addKoin #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function () {
                            $("#addKoin #message").html("");
                        });
                    }
                });

            }

            function getLogAddKoinByMerchant() {
                var user = $("#logKoinByMerchant select[name=user]").val();
                var from = $("#logKoinByMerchant input[name=fromDate]").val();
                var to = $("#logKoinByMerchant input[name=toDate]").val();
                $.ajax({
                    type: "GET",
                    url: "API/logMerchantAddKoin1.php",
                    data: {
                        "user": user,
                        "from": from,
                        "to": to
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#logKoin1").html(msg);
                        $("#logKoin1").show();
                    },
                    failure: function () {
                        $("#logKoin1").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindListUser").attr("disabled", false);
                    }
                });
            }
            $("a.pagination-link-1").live("click", function (e) {
                e.preventDefault();
                var page = $(this).attr('page');
                var user = $("#logKoinByMerchant select[name=user]").val();
                var from = $("#logKoinByMerchant input[name=fromDate]").val();
                var to = $("#logKoinByMerchant input[name=toDate]").val();                
                $.ajax({
                    type: "GET",
                    url: "API/logMerchantAddKoin1.php",
                    data: {
                        "page": page,
                        "user": user,
                        "from": from,
                        "to": to
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#logKoin1").html(msg);
                        $("#logKoin1").show();
                    },
                    failure: function () {
                        $("#logKoin1").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindListUser").attr("disabled", false);
                    }
                });                        
            });
            
            function getLogAddKoinByUser() {
                var user = $("#logKoinByUser select[name=user]").val();
                var from = $("#logKoinByUser input[name=fromDate]").val();
                var to = $("#logKoinByUser input[name=toDate]").val();
                $.ajax({
                    type: "GET",
                    url: "API/logMerchantAddKoin2.php",
                    data: {
                        "user": user,
                        "from": from,
                        "to": to
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#logKoin2").html(msg);
                        $("#logKoin2").show();
                    },
                    failure: function () {
                        $("#logKoin2").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindListUser").attr("disabled", false);
                    }
                });
            }
            $("a.pagination-link-2").live("click", function (e) {
                e.preventDefault();
                var page = $(this).attr('page');
                var user = $("#logKoinByUser select[name=user]").val();
                var from = $("#logKoinByUser input[name=fromDate]").val();
                var to = $("#logKoinByUser input[name=toDate]").val();                
                $.ajax({
                    type: "GET",
                    url: "API/logMerchantAddKoin2.php",
                    data: {
                        "page": page,
                        "user": user,
                        "from": from,
                        "to": to
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#logKoin2").html(msg);
                        $("#logKoin2").show();
                    },
                    failure: function () {
                        $("#logKoin2").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindListUser").attr("disabled", false);
                    }
                });                        
            });
            $(document).ready(function () {
                $(".datepicker").datepicker();
            });

        </script>
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            <div class="box grid">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Danh sách Đại lý</a></div>
                <div class="box_body">
                    <table width='100%'>
                        <tr style='background-color: rgb(255, 255, 255);text-align:center;'>
                            <td>Username</td>
                            <td>Tên đại lý</td>
                            <td>Tên hiển thị</td>
                            <td>SĐT</td>
                            <td>Khu vực</td>
                            <td>Facebook</td>
                            <td>Xu</td>
                            <td>Chip</td>
                        </tr>
                        <?php foreach ($db->query($sql_merchants) as $row) : ?>
                            <?php $i+=1; ?>
                            <tr style='background-color: rgb(<?php ($i % 2 > 0) ? '204,204,204' : '255, 255, 255' ?>);text-align:center;'>
                                <td><?= $row['username'] ?></td>
                                <td><?= $row['merchant_name'] ?></td>
                                <td><?= $row['screen_name'] ?></td>
                                <td><?= $row['mobile'] ?></td>
                                <td><?= $row['address'] ?></td>
                                <td><?= $row['facebook'] ?></td>
                                <td><?= $row['koin'] ?></td>
                                <td><?= $row['koin_vip'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>     
            <div class="box">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Cộng Xu</a></div>
                <div class="box_body">
                    <form id="addKoin">
                        Merchant
                        <select name="user">
                            <option></option>
                            <?php foreach ($db->query($sql_merchants) as $row) : ?>
                                <option value="<?= $row['username'] ?>"><?= $row['merchant_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        Password <input type="password" name="pass" style="width: 100px"/>
                        VNĐ <input type="text" name="koin" style="width: 100px"/>
                        <input type="button" name="add" value="Thêm" onclick="addMerchantKoin();"/>
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                </div>
            </div>
            <div class="box grid">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Thống Kê theo Đại lý</a></div>
                <div class="box_body"  style="display: none">
                    <form id="logKoinByMerchant">
                        Merchant
                        <select name="user">
                            <option></option>
                            <?php foreach ($db->query($sql_merchants) as $row) : ?>
                                <option value="<?= $row['username'] ?>"><?= $row['merchant_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        Từ Ngày
                        <input type="text" class="datepicker" name="fromDate" value="<?= $today ?>" style="text-align: center; width: 100px;" />
                        Tới Ngày
                        <input type="text" class="datepicker" name="toDate" value="<?= $today ?>" style="text-align: center; width: 100px;" />
                        <input type="button" name="add" value="Thống kê" onclick="getLogAddKoinByMerchant();"/>

                    </form>
                </div>
                <div id="logKoin1" style="display: none;">

                </div>
            </div>
            <div class="box grid">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Thống Kê theo Người nạp</a></div>
                <div class="box_body"  style="display: none">
                    <form id="logKoinByUser">
                        Người nạp
                        <select name="user">
                            <option></option>
                            <?php foreach ($user_list as $key => $user) : ?>
                                <option value="<?= $user_list[$key] ?>"><?= $user_list[$key] ?></option>
                            <?php endforeach; ?>
                        </select>
                        Từ Ngày
                        <input type="text" class="datepicker" name="fromDate" value="<?= $today ?>" style="text-align: center; width: 100px;" />
                        Tới Ngày
                        <input type="text" class="datepicker" name="toDate" value="<?= $today ?>" style="text-align: center; width: 100px;" />
                        <input type="button" name="add" value="Thống kê" onclick="getLogAddKoinByUser();"/>

                    </form>
                </div>
                <div id="logKoin2" style="display: none;">

                </div>
            </div>
        </div>
        <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">×</span>
                <pre class="logKoin">
                    
                </pre>
            </div>

        </div>
    </body>
</html>
