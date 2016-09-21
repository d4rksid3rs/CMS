<?php
$today = date('Y-m-d', time());
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Người chơi</title>
        <?php require('header.php'); ?>
        <script src="js/highcharts.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/themes/grid.js"></script> 
        <script>                        
            function getExchange() {
                var fromDate = $("#koin_vip_exchange input[name=fromDate]").val();
                var toDate = $("#koin_vip_exchange input[name=toDate]").val();

                $("#btnFindListUser").attr("disabled", true);
                $.ajax({
                    type: "GET",
                    url: "API/getListExchange.php",
                    data: {
                        "fromDate": fromDate,
                        "toDate": toDate,
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#exchangeUserList").html(msg);
                        $("#exchangeUserList").show();
                    },
                    failure: function () {
                        $("#exchangeUserList").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindListUser").attr("disabled", false);
                    }
                });

            }
            $(document).ready(function () {
                $(".datepicker").datepicker();
            });

        </script>
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            <div class="box grid">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Thống kê Danh sách User đổi thưởng</a></div>
                <div class="box_body">
                    <form id="koin_vip_exchange">
                        Từ Ngày
                        <input type="text" class="datepicker" name="fromDate" value="<?= $today?>" style="text-align: center; width: 100px;" />
                        Tới Ngày
                        <input type="text" class="datepicker" name="toDate" value="<?= $today?>" style="text-align: center; width: 100px;" />
                        <input type="button" name="add" value="Thống kê" onclick="getExchange();"/>

                    </form>
                </div>
                <div id="exchangeUserList" style="display: none;">

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
