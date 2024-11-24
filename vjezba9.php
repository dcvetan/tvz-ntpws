<?php
date_default_timezone_set('Europe/Zagreb');

$current_day = date('l');  // (Monday)
$current_time = date('H:i');  // (08:00)
$current_date = date('Y-m-d');  // (2024-11-23)

$holidays = [
    '2024-01-01', // Nova godina
    '2024-05-01', // Praznik rada
    '2024-06-22', // Dan antifašističke borbe
    '2024-08-15', // Velika Gospa
    '2024-10-08', // Dan neovisnosti
    '2024-12-25', // Božić
    '2024-12-26'  // Sv. Stjepan
];

if (in_array($current_date, $holidays)) {
    echo "Dućan je zatvoren zbog državnog praznika.";
} else {
    if ($current_day == 'Saturday') {
        if ($current_time >= '09:00' && $current_time <= '14:00') {
            echo "Dućan je otvoren (subota, 9:00 - 14:00).";
        } else {
            echo "Dućan je zatvoren (subota, radno vrijeme je 9:00 - 14:00).";
        }
    } elseif ($current_day == 'Sunday') {
        echo "Dućan je zatvoren (nedjelja).";
    } elseif ($current_day == 'Monday' || $current_day == 'Tuesday' || $current_day == 'Wednesday' || $current_day == 'Thursday' || $current_day == 'Friday') {
        if ($current_time >= '08:00' && $current_time <= '20:00') {
            echo "Dućan je otvoren (radno vrijeme 8:00 - 20:00).";
        } else {
            echo "Dućan je zatvoren (radno vrijeme je 8:00 - 20:00).";
        }
    }
}
?>