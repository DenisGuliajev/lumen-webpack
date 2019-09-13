<?php


namespace App\Pseudomodels;


use Exception;

class Order
{
    /** in real world values can be provide by other class or fetched from DB...
     * @var $srcArray int[]
     * */
    private static $_srcArray = [
        250, 500, 1000, 2000, 5000,
    ];

    /**
     * @return Pack[]
     */
    public static function getSrcArray(): array
    {
        return self::$_srcArray;
    }

    /**
     * @param Pack[] $arr
     * @return array
     */
    public static function setSrcArray(array $arr): array
    {
        self::$_srcArray = $arr;
    }

    /**
     * @param int $val     number of widgets / items
     * @param int $roundTo numerical index of item in "packet sizes" / $srcArray array to which we will round order
     * @return Pack[]
     * @throws Exception
     */
    public static final function make(int $val, int $roundTo = 0): array
    {
        /**
         * Total number of items in array (used as array index)
         * @var $i int
         */
        $i = count(self::$_srcArray);
        // check that $roundTo value will not brake the function
        if ($roundTo > $i - 1) {
            throw new Exception('$roundTo value can not be greater than length of array of possible values($_srcArray) ');
        }
        // ensure that source array is in ascending order
        // array is passed by value so we can mutate it, it will not affect source array
        sort(self::$_srcArray);
        /**
         * Result array
         * @var $resultArr Pack[]
         */
        $resultArr = [];
        // Grab given value and start shrinking it down to 0 with the values given us in srcArray starting from the top.
        // Execute loop condition only if given value is greater than value retrieved from array
        // if loop condition met, mutate value provided into division reminder of how many times self::$_srcArray element fits into value provided
        while ($i > 0) {
            // reduce counter by 1
            $i--;
            // create Pack object instance that we will possibly will modify within current loop iteration
            $pack = new Pack(self::$_srcArray[$i]);
            // if value provided greater than current array value,
            // mutate value provided into
            // division reminder of (how many times self::$_srcArray element fits into value provided)
            // and set $pack count to the round down (floor()) value of this division
            if ($i > $roundTo && $val >= self::$_srcArray[$i]) {
                $pack->count = floor($val / self::$_srcArray[$i]);
                // slice and dice
                $val = $val % self::$_srcArray[$i];
            }
            // handling "edge" case of the pack flagged as $roundTo
            if ($i === $roundTo) {
                // tmp storage for last inserted $resultArr value, false if none
                $tmp = end($resultArr);
                // if
                //      value provided is greater than current array element
                //   and
                //      we already have at least 1 element in $resultArr
                if ($val > self::$_srcArray[$i] && false !== $tmp) {
                    // increase last inserted $resultArr element 'count' property by 1
                    // do not modify $pack->count in this section
                    // $tmp = end($resultArr);
                    $tmp->count = $tmp->count + 1;
                } else {
                    // ==================== The end of the rabbit hole==========================
                    // current $pack->count will be equal to round up
                    // rest of the operations will be skipped
                    $pack->count = ceil($val / self::$_srcArray[$i]);
                }

            }
            $resultArr[] = $pack;
        }
        $resultArr = array_filter(
            $resultArr,
            function (Pack $pack) {
                return $pack->count > 0;
            });
        return array_values($resultArr);
    }
}
