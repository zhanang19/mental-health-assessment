<?php

namespace App\Util;

class CalculationHelper
{
    /**
     * Find the standard deviation from an array of numbers.
     *
     * @ref [https://www.tutorialspoint.com/php-program-to-find-standard-deviation-of-values-within-an-array]
     * @param array $numbers
     * @return float
     */
    public function findStandardDeviation(array $numbers)
    {
        $no_element = count($numbers);
        $avg = array_sum($numbers) / $no_element;
        $var = 0.0;

        foreach ($numbers as $i) {
            $var += pow(($i - $avg), 2);
        }

        return (float) sqrt($var / $no_element);
    }

    /**
     * Find the mean of an array of numbers.
     *
     * @ref [https://stackoverflow.com/questions/33461430/how-to-find-average-from-array-in-php/43725454]
     * @param array $numbers
     * @return float|int
     */
    public function findMean(array $numbers)
    {
        $numbers = array_filter($numbers);

        if(!count($numbers)) {
            return 0;
        }

        return array_sum($numbers) / count($numbers);
    }
}
