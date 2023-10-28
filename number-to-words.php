<?php
/**
 * Generate Words from an Integer
 * 
 * Copyright 2023 by Andrea Stancato
 */
final class NumberToWords {

    /**
     * Wording for Natural Numbers
     */
    private static array $natural = [ "zero", "one", "two", "tree", "four", "five", "six", "seven", "eight", "nine" ];

    /**
     * Wording for the Ten/Teens
     */
    private static array $teens = [ "ten", "eleven", "twelve", "thirteen", "fourteen", "fifteen", "sixteen", "seventeen", "eighteen", "nineteen" ];

    /**
     * Wording for the low Digits
     */
    private static array $lowDigits = [ 2 => "twenty", "thirty", "forty", "fifty", "sixty", "seventy", "eighty", "ninety" ];

    /**
     * Wording for the high Digits
     * [key] = Zero Digits
     */
    private static array $highDigits = [ 2 => "hundred", "thousand", 6 => "million", 9 => "billion", 12 => "trillion" ];

    /**
     * Returns the generated String
     */
    public static function getText(int $number) : string {
        $minus = "";
        $str = (string)$number;

        if($number < 0) {
            $minus = "minus ";

            $str = substr($str, 1);
        }

        $digits = strlen($str);

        if($digits > 3) {
            return $minus . trim(static::generateHigher($str, $digits));
        } else {
            return $minus . trim(static::generateLower($str, $digits));
        }
    }

    /**
     * Generate the low Digits (0-999)
     */
    private static function generateLower(string $number, int $digits) : string {
        $str = "";

        if($digits == 3 && $number[0] !== "0") {
            $str = static::$natural[$number[0]] . " " . static::$highDigits[2] . " ";
        }

        if($digits >= 2 && $number[-2] !== "0") { 
            if($number[-2] === "1") {
                return $str . static::$teens[ (int)$number[-1] ] . " ";
            } else {
                return $str . static::$lowDigits[ (int)$number[-2] ] . ($number[-1] === "0" ? "" : "-" .  static::$natural[ (int)$number[-1] ]) . " ";
            }
        }

        // Prevent to output zero
        if($digits > 1 && $number[-1] === "0") return $str;

        return $str . static::$natural[ (int)$number[-1] ] . " ";
    }

    /**
     * Generate the high Digits 1000 and up
     */
    private static function generateHigher(string &$number, int &$digits) : string {
        $high = array_keys(
            array_reverse(
                array_filter(
                    static::$highDigits, 
                    function($k) use($digits) { return $k <= $digits && $k > 2; }, 
                    ARRAY_FILTER_USE_KEY
                ),
                true
            )
        );

        if($digits > $high[0] + 3) return "Dead end, the number is not supported \\(x_x)/";

        $str = "";
        $i = 0;

        // Loop trought the Digits
        foreach($high as $d) {
            $n = (int)$d;

            if($n + 3 >= $digits) {
                $i = $digits - $n;

                if($i == 0) $i = 3;

                $str .= static::generateLower(substr($number, 0, $i), $i);
            } else {
                $str .= static::generateLower(substr($number, $i, 3), 3);

                $i += 3;
            }
        
            $str .= static::$highDigits[$n] . " ";
        }

        return $str . static::generateLower(substr($number, -3), 3);
    }
}

?>