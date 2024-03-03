#!/bin/bash

# Display the header for the magnet filling efficiency calculation
echo "------------------------ Magnet Filling Efficiency ----------------"

# Enter the Dewar Initial Level
read -p "Enter Dewar Initial Level: " di 

# Enter the Dewar Final Level
read -p "Enter Dewar Final Level:   " df 

# Calculate the Dewar Level difference
Dewar_level=$(echo "scale=2; $di - $df" | bc)

# Enter the Magnet Initial Level
read -p "Enter Magnet Initial Level: " mi 

# Enter the Magnet Final Level
read -p "Enter Magnet Final Level:   " mf 

# Calculate the Magnet Level difference
Magnet_level=$(echo "scale=2; $mf - $mi" | bc)

# Calculate the efficiency with a higher precision and round off the result
Efficiency=$(echo "scale=4; ($Magnet_level / $Dewar_level) * 100" | bc)
# Round the Efficiency up to 2nd decimal point
Efficiency_Rounded=$(printf "%.2f" $Efficiency)

# Output the efficiency result
echo "Magnet Filling Efficiency = $Efficiency_Rounded%"
# End of script
