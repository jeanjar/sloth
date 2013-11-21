<?php

$numero = '3840298';

$numero_reverso = str_split(strrev($numero));


foreach($numero_reverso as $numeral)
{
    echo $numeral;
}
