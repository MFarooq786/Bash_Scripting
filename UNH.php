<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Combined Calculators</title>
    <style>
        .container {
            display: flex;
            justify-content: space-around; /* Space the calculators evenly */
        }
        .calculator {
            flex: 1; /* Each calculator will take equal width */
            padding: 5px;
            box-sizing: border-box; /* Includes padding in the width */
        }
        p.equation {
            font-style: italic;
            color: #555;
        }
        p.result {
            background-color: yellow; 
            color: red;
        }
        .fraction {
            display: inline-block;
            text-align: center;
            vertical-align: middle;
        }
        .fraction > span {
            display: block;
        }
        .fraction > span:not(:last-child) {
            border-bottom: 1px solid black;
            margin-bottom: 0.5em; /* Increased bottom margin */
        }
        .fraction > span:last-child {
            margin-top: 0.5em; /* Increased top margin */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="calculator">
            <h2>Production Rate of Liq A/B Calculator</h2>
            <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Fi'], $_POST['Fo'])) {
                $Fi = floatval($_POST['Fi']);
                $Fo = floatval($_POST['Fo']);
                $Flow_Diff = round($Fi - $Fo, 2);
                // Calculate the Production Rate
                // Equation: Production_Rate = (Flow_Diff / 700) * 60
                $Production_Rate = ($Flow_Diff / 754) * 60;
                $Production_Rate_Rounded = number_format($Production_Rate, 2, '.', '');
                echo "<p class='result'>Production Rate of Liq A/B in L/h = $Production_Rate_Rounded L/h</p>";
            } ?>
            <form method="post">
                <label for="Fi">Enter Liq A/B Inlet Flow:LiqA/B FC501I:</label>
                <input type="number" id="Fi" name="Fi" step="0.01" required><br><br>
                <label for="Fo">Enter Liq A/B Outlet Flow:LiqA/B FCI:</label>
                <input type="number" id="Fo" name="Fo" step="0.01" required><br><br>
                <input type="submit" value="Calculate Production Rate of Liq A/B">
            </form>
            <p class="equation">Production_Rate = <span class="fraction">
                <span>(Inlet Flow - Outlet Flow)</span>
                <span>(754)</span>
            </span> &times; 60</p>
        </div>
        <div class="calculator">
            <h2>Magnet Filling Efficiency Calculator</h2>
            <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['di'], $_POST['df'], $_POST['mi'], $_POST['mf'])) {
                $di = floatval($_POST['di']);
                $df = floatval($_POST['df']);
                $mi = floatval($_POST['mi']);
                $mf = floatval($_POST['mf']);
                $Dewar_level = round($di - $df, 2);
                $Magnet_level = round($mf - $mi, 2);
                // Calculate the Efficiency of Magnet Filling
                // Equation: Efficiency = (Magnet_level / Dewar_level) * 100
                $Efficiency = ($Magnet_level / $Dewar_level) * 100;
                $Efficiency_Rounded = number_format($Efficiency, 2, '.', '');
                echo "<p class='result'>Magnet Filling Efficiency = $Efficiency_Rounded%</p>";
            } ?>
            <form method="post">
                <label for="di">Enter Dewar Initial Level:</label>
                <input type="number" id="di" name="di" step="0.01" required><br><br>
                <label for="df">Enter Dewar Final Level:</label>
                <input type="number" id="df" name="df" step="0.01" required><br><br>
                <label for="mi">Enter Magnet Initial Level:</label>
                <input type="number" id="mi" name="mi" step="0.01" required><br><br>
                <label for="mf">Enter Magnet Final Level:</label>
                <input type="number" id="mf" name="mf" step="0.01" required><br><br>
                <input type="submit" value="Calculate Efficiency">
            </form>
            <p class="equation">Efficiency = <span class="fraction">
                <span>(magnet final level - magnet initial level)</span>
                <span>(dewar initial level - dewar final level)</span>
            </span> &times; 100</p>
        </div>
        <div class="calculator">
            <h2>Consumption Rate from SLM to L/h Calculator</h2>
            <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['SLM'])) {
                $SLM = floatval($_POST['SLM']);
                // Calculate the Consumption Rate in Liters per hour
                // Equation: Consumption_Rate = (SLM / 700) * 60
                $Consumption_Rate = ($SLM / 754) * 60;
                $Consumption_Rate_Rounded = number_format($Consumption_Rate, 2, '.', '');
                echo "<p class='result'>Calculate Consumption Rate in L/h = $Consumption_Rate_Rounded L/h</p>";
            } ?>
            <form method="post">
                <label for="SLM">Enter Consumption Rate in SLM:</label>
                <input type="number" id="SLM" name="SLM" step="0.01" required><br><br>
                <input type="submit" value="Calculate Consumption Rate in L/h">
            </form>
            <p class="equation">Efficiency = <span class="fraction">
                <span>(Consumption in SLM)</span>
                <span>(754)</span>
            </span> &times; 60</p>
        </div>



        </div>
    </div>
    
</body>
</html>
