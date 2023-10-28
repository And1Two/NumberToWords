/**
 * Generate Words from an Integer
 * 
 * Copyright 2023 by Andrea Stancato
 */
((undef) => {
    "use strict";

    /**
     * Wording for Natural Numbers
     */
    const natural = [ "zero", "one", "two", "tree", "four", "five", "six", "seven", "eight", "nine" ];

    /**
     * Wording for the Ten/Teens
     */
    const teens = [ "ten", "eleven", "twelve", "thirteen", "fourteen", "fifteen", "sixteen", "seventeen", "eighteen", "nineteen" ];

    /**
     * Wording for the low Digits
     */
    const lowDigits = [ undef, undef, "twenty", "thirty", "forty", "fifty", "sixty", "seventy", "eighty", "ninety" ];

    /**
     * Wording for the high Digits
     * Values = [ Zero Digits, Word ]
     */
    const highDigits = [ [ 2, "hundred" ], [ 3, "thousand" ], [ 6, "million" ], [ 9, "billion" ], [ 12, "trillion" ] ];

    /**
     * Generate the low Digits (0-999)
     */
    function generateLower(n) {
        let str = "";

        if(n.length >= 3 && n[0] !== "0") {
            str = natural[n[0]] + " " + highDigits[0][1] + " ";
        }

        if(n.length >= 2 && n[n.length - 2] !== "0") {
            if(n[n.length - 2] === "1") {
                return str + teens[ n[n.length - 1] ] + " ";
            } else {
                return str + lowDigits[ n[n.length - 2] ] + (n[n.length - 1] === "0" ? "" : "-" +  natural[ n[n.length - 1] ]) + " ";
            }
        }

        // Prevent to output zero
        if(n.length > 1 && n[n.length - 1] === "0") return str;

        return str + natural[ n[n.length - 1] ] + " ";
    }

    /**
     * Generate the high Digits 1000 and up
     */
    function generateHigher(n) {
        let str = "",
            i = 0;

        highDigits.filter((v) =>  v[0] <= n.length && v[0] > 2).reverse().forEach(d => {
            let c = Number(d[0])

            if(c + 3 >= n.length) {
                i = n.length - c;

                if(i == 0) i = 3;

                str += generateLower(n.substring(0, i));
            } else {
                str += generateLower(n.substring(i, i + 3));

                i += 3;
            }

            str += d[1] + " ";
        });

        return str + generateLower(n.substr(n.length - 3));
    }

    /**
     * Global Function
     * Returns the generated String
     */
    window.numberToWords = (n) => {
        if(typeof n != "number") return "Dead end, not supported Argument \\(x_x)/";

        let minus = "",
            str = n.toFixed(0).toString();

        if(n < 0) {
            minus = "minus ";

            str = str.substring(1);
        }

        if(str.length > 3) {
            return generateHigher(str).trim();
        } else {
            return generateLower(str).trim();
        }
    };

})(undefined);