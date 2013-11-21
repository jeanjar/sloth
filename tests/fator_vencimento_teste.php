<?php

$now = strtotime('2000-07-04');

$your_date = strtotime('1997-10-07');

$datediff = abs($now - $your_date);

echo floor($datediff / (60*60*24));
