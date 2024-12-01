<?php

function is_prime($num) {
    if ($num <= 1) {
        return false;
    }
    for ($i = 2; $i <= sqrt($num); $i++) {
        if ($num % $i == 0) {
            return false;
        }
    }
    return true;
}

echo "Prosti brojevi manji od 100 su:\n";
for ($i = 2; $i < 100; $i++) {
    if (is_prime($i)) {
        echo $i . "\n";
    }
}

?>
