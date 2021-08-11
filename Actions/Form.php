<?php
if ($_GET['hashtext'] == null) {
    $_GET['hashtext'] = 0;
}
if ($_GET['wselect'] == null) {
    $_GET['wselect'] = 0;
}
if ($_GET['electext'] == null) {
    $_GET['electext'] = 0;
}
if ($_GET['endValue'] == null) {
    $_GET['endValue'] = 0;
}

if (is_numeric($_GET['hashtext'])
&& is_numeric($_GET['wselect'])
&& is_numeric($_GET['electext'])
&& is_numeric($_GET['endValue'])
&& is_numeric($_GET['BlockReward'])
&& is_numeric($_GET['BTC_TO_TOMAN'])
&& is_numeric($_GET['BTC_TO_USD_PRICE'])
&& is_numeric($_GET['BTC_NETWORK_DIFFICULTY'])) {
    $day=substr($_GET['wselect'] * $_GET['electext'] * 24, 0, -3);
    $week=substr($_GET['wselect'] * $_GET['electext'] * 24 * 7, 0, -3);
    $month=substr($_GET['wselect'] * $_GET['electext'] * 24 * 30, 0, -3);
    $year=substr($_GET['wselect'] * $_GET['electext'] * 24 * 365, 0, -3);

    if($day == false){
        $day = 0;
    }
    if($week == false){
        $week = 0;
    }
    if($month == false){
        $month = 0;
    }
    if($year == false){
        $year = 0;
    }

    $day2=(((($_GET['hashtext']*(10**12))*($_GET['BlockReward']*86400)))/(($_GET['BTC_NETWORK_DIFFICULTY'])*(2**32)));
    $dayp2 = $day2 * $_GET['endValue'] / 100 ;

    $dayo2 = number_format($day2 - $dayp2,8);
    $weeko2 = number_format($dayo2 * 7,8);
    $montho2 = number_format($dayo2 * 30,8);
    $yearo2 = number_format($dayo2 * 365,8);


    $day3=number_format($dayo2 * $_GET['BTC_TO_USD_PRICE'], 2);
    $week3=number_format($weeko2 * $_GET['BTC_TO_USD_PRICE'], 2);
    $month3=number_format($montho2 * $_GET['BTC_TO_USD_PRICE'], 2);
    $year3=number_format($yearo2 * $_GET['BTC_TO_USD_PRICE'], 2);


    $day4 = round((($dayo2 * $_GET['BTC_TO_TOMAN']) - $day), 0);
    $week4 = round((($weeko2 * $_GET['BTC_TO_TOMAN']) - $week), 0);
    $month4 = round((($montho2 * $_GET['BTC_TO_TOMAN']) - $month), 0);
    $year4 = round((($yearo2 * $_GET['BTC_TO_TOMAN']) - $year), 0);

    header('Content-Type: application/json');
    echo json_encode(array('elec' => array(
    'day'=> $day, "week"=>$week, "month"=> $month, "year"=> $year),
    'bitcoin' => array('day'=> substr($dayo2,0,8), "week"=>substr($weeko2,0,8), "month"=> substr($montho2,0,8), "year"=> substr($yearo2,0,8)),
    'dollar'=> array('day'=> $day3, "week"=>$week3, "month"=> $month3, "year"=> $year3),
    'toman'=> array('day'=> substr($day4, 0), "week"=>substr($week4, 0), "month"=> substr($month4, 0), "year"=> substr($year4, 0)),
      ));
    exit;
} else {
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'لطفا مقادیر را درست وارد نمایید'));
    exit;
}
