<?php
$pars = '';
if(!empty($fromDate) OR !empty($toDate))
{
    $pars .= "&fromDate=$fromDate&toDate=$toDate";
}
$pars .= isset($_REQUEST['nocache']) ? '&nocache' : '';

?>
<ul class="top-filter">
    <li><a href="koin.php<?php // echo $pars; ?>">Xu trên thị trường</a> |</li>
    <li><a href="koin_fee.php">Tổng tiền fee</a> |</li>
    <!--
    <a href="koin_nap.php<?php echo $pars; ?>">Lượng koin nạp từ thẻ</a> |
    <a href="koin_nap_sms.php<?php echo $pars; ?>">Lượng koin nạp từ SMS</a> |
    <a href="koin_dk.php<?php echo $pars; ?>">Lượng koin cộng đăng ký</a> |
    -->
    <li><a href="koin_charge.php">Tra Cứu Sản Lượng xu</a> |</li>
    <!--<li><a href="koin_daily.php">Tổng tiền xu cộng hàng ngày</a> |</li>-->
    <li><a href="koin_admin.php">Lượng tiền nạp từ amdin</a></li>
</ul>