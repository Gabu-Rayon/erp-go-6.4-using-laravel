<?php
function convertToNumeric($string)
{
    $mapping = array(
        'zero' => 0,
        'one' => 1,
        'two' => 2,
        'three' => 3,
        'four' => 4,
        'five' => 5,
        'six' => 6,
        'seven' => 7,
        'eight' => 8,
        'nine' => 9,
        'ten' => 10,
        'eleven' => 11,
        'twelve' => 12,
        'thirteen' => 13,
        'fourteen' => 14,
        'fifteen' => 15,
        'sixteen' => 16,
        'seventeen' => 17,
        'eighteen' => 18,
        'nineteen' => 19,
        'twenty' => 20,
        'thirty' => 30,
        'forty' => 40,
        'fifty' => 50,
        'sixty' => 60,
        'seventy' => 70,
        'eighty' => 80,
        'ninety' => 90,
        'hundred' => 100,
        'thousand' => 1000,
        'million' => 1000000,
    );

    $words = explode(' ', strtolower($string));
    $total = 0;
    $currentValue = 0;

    foreach ($words as $word) {
        if (isset($mapping[$word])) {
            $currentValue += $mapping[$word];
        } else {
            if ($currentValue == 0) {
                $currentValue = $mapping[$word];
            } else {
                $currentValue *= $mapping[$word];
            }
        }
    }

    $total += $currentValue;

    return $total;
}
$quantity = "Six hundred";
$unitprice = "ten thousand";

$quantityNumeric = convertToNumeric($quantity);
$unitpriceNumeric = convertToNumeric($unitprice);

$result = $quantityNumeric * $unitpriceNumeric;

// Output the result
echo "Result: " . number_format($result);
?>
