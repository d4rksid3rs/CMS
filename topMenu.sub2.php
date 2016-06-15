<?php
$pars = '';
if(!empty($fromDate) OR !empty($toDate))
{
    $pars .= "&fromDate=$fromDate&toDate=$toDate";
}
$pars .= isset($_REQUEST['nocache']) ? '&nocache' : '';

?>
<div class="topheader">
    <ul class="topMenus">
        Cache tại thời điểm: <?php echo date("Y-m-d H:i:s"); ?> |
		<a href="rev.php">Biến động doanh thu</a> |
        <a href="stat_sms.php?id=0<?php echo $pars; ?>">Sản lượng SMS</a> (<a href="stat_sms.php?sum&id=0">Tổng</a>) |
        <a href="stat_sms.php?id=1<?php echo $pars; ?>">Doanh thu SMS</a> (<a href="stat_sms.php?sum&id=1">Tổng</a>) |
        <a href="stat_os_sms.php?id=0<?php echo $pars; ?>">Doanh thu SMS theo OS</a> |
        <a href="stat_os_card.php?id=0<?php echo $pars; ?>">Doanh thu Card theo OS</a> |
        <a href="stat_card.php?<?php echo $pars; ?>">Doanh thu thẻ cào</a> (<a href="stat_card.php?sum">Tổng</a>) |
        <a href="stat_money.php">Chia sẻ doanh thu</a> |
        <a href="thongkesms.php">TK chi tiết tin nhắn</a> |
        <a href="tksmsdausodt.php">TK tin nhắn từ đầu số đối tác</a> | 
        <a href="thongkethecao.php">TK chi tiết thẻ cào</a> |
        <a href="koin_charge.php">Thống Kê Charging</a> |
        <a href="koin_hour.php">TK doanh thu theo giờ</a>
    </ul>
</div>
