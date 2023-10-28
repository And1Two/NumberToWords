<?php
    //Handle CLI Arguments
    if(array_key_exists("argv", $_SERVER)) {
        echo NumberToWords::getText(((int)$_SERVER["argv"][1]) ?? null);
        
        exit(0);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Number To Words</title>
    <meta charset="utf-8">
    <script src="number-to-words.js"></script>
    <style>
        html, body {
            font-size: 14px;
        }

        form, label, h1, p {
            box-sizing: border-box;
            display: block;
            width: 100%;
            max-width: 480px;
            margin: auto;
        }

        input {
            width: 100%;
            margin-bottom: 22px;
        }

        input[type=checkbox] {
            width: auto;
        }

        input, p {
            box-sizing: border-box;
            padding: 12px;
            border: 1px solid #000;
            border-radius: 12px;
        }

        label, h1, p {
            margin-bottom: 12px;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
    <script>
        function generate(ev) {
            if(document.getElementById("js").checked) {
                ev.preventDefault();

                let e = document.querySelector("p");

                if(!e) {
                    e = document.createElement("p");

                    let h = document.createElement("h1");
                    
                    h.innerText = "Output:";

                    document.body.appendChild(h);
                    document.body.appendChild(e);
                }

                e.innerText = numberToWords(Number(document.querySelector('#number').value));

                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <form method="post" onsubmit="generate(event);">
        <label for="number">Input:</label>
        <input id="number" type="number" name="number" value="<?php echo $_POST["number"] ?? "314159265358"; ?>" required>
        <script>document.write('<input id="js" type="checkbox" value="1" checked> Generate with JavaScript');</script>
        <input type="submit" name="send" value="Generate">
    </form>

<?php
    include_once(__DIR__ . "/number-to-words.php");

    if(array_key_exists("number", $_POST)) {
        echo "<h1>Output:</h2><p>" . NumberToWords::getText((int)$_POST["number"]) . "</p>";
    }
?>
</body>