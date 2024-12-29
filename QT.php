<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// File name for the CSV
$filename = 'data_record_2024-11-15.csv';

// Load the CSV file to get the header
$file = new SplFileObject($filename);
$file->setFlags(SplFileObject::READ_CSV);
$columns = $file->fgetcsv(); // Read the first row (header)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the posted start and end event timestamps, and selected columns
    $startEvent = $_POST['startEvent'];
    $endEvent = $_POST['endEvent'];
    $selectedColumns = $_POST['columns'] ?? [];

    $header = [];
    $data = [];

    // Open the CSV file for reading
    if (($handle = fopen($filename, "r")) !== FALSE) {
        // Get the header row
        $header = fgetcsv($handle);

        // Loop through the file and filter rows based on the timestamps
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Compare timestamps after converting to UNIX timestamps for better handling
            if (strtotime($row[0]) >= strtotime($startEvent) && strtotime($row[0]) <= strtotime($endEvent)) {
                foreach ($selectedColumns as $column) {
                    $index = array_search($column, $header);
                    if ($index !== FALSE) {
                        $data[$column][] = [$row[0], $row[$index]];
                    }
                }
            }
        }
        fclose($handle); // Close the file after processing
    }

    // Debug output to check the filtered data in the browser console
    echo "<script>console.log(" . json_encode($data) . ");</script>";

    // Convert the filtered data to JSON for JavaScript
    $jsonData = json_encode($data);

    // Pass the data to the chart creation function in JavaScript
    echo "<script>
            var plotData = $jsonData;
            window.onload = function() { createChart(plotData); };
         </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Data Plotter</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- Form to input start timestamp, end timestamp, and column selection -->
    <form method="post">
        Start Timestamp: <input type="text" name="startEvent" placeholder="YYYY-MM-DD HH:MM:SS" value="<?php echo $_POST['startEvent'] ?? ''; ?>"><br>
        End Timestamp: <input type="text" name="endEvent" placeholder="YYYY-MM-DD HH:MM:SS" value="<?php echo $_POST['endEvent'] ?? ''; ?>"><br>
        
        <!-- Dynamic column selection based on CSV header -->
        Select Columns: <br><div style="display: flex; flex-wrap: wrap;">
        <?php
            // Loop through the CSV columns and create a checkbox for each
            foreach ($columns as $column) {
                if ($column != 'timestamp') { // Skip 'timestamp' column for the Y-axis
                    $checked = in_array($column, $_POST['columns'] ?? []) ? 'checked' : '';
                    echo "<div style='margin-right: 20px;'><input type='checkbox' name='columns[]' value='$column' $checked> $column</div>";
                }
            }
        ?>
        </div>
        <input type="submit" value="Generate Plot">
    </form>

    <!-- Canvas for the chart -->
    <canvas id="chartCanvas" width="350" height="130"></canvas>

    <!-- JavaScript code to generate the chart using Chart.js -->
    <script>
        function createChart(plotData) {
            console.log("Chart function called");  // Check if the function is called
            console.log(plotData);  // Check the content of plotData

            var ctx = document.getElementById('chartCanvas').getContext('2d');
            var datasets = [];
            var colorIndex = 0;

            // Loop through the plot data and create datasets for each selected column
            for (var key in plotData) {
                datasets.push({
                    label: key,  // Column name
                    data: plotData[key].map(function(e) { return e[1]; }),  // Extract the values for the column
                    borderColor: getRandomColor(colorIndex++),  // Assign a random color
                    fill: false,
                });
            }

            // Create the chart using Chart.js
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: plotData[Object.keys(plotData)[0]].map(function(e) { return e[0]; }),  // Timestamps for the x-axis
                    datasets: datasets  // The data for each selected column
                },
                options: {
                    scales: {
                        y: { beginAtZero: false }  // Y-axis settings
                    }
                }
            });
        }

        // Helper function to generate random colors for the datasets
        function getRandomColor(index) {
            var colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#C9CBCF', '#7C4DFF', '#D4E157', '#66BB6A'];
            return colors[index % colors.length];
        }
    </script>
</body>
</html>
