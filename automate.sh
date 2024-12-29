#!/bin/bash

# Infinite loop to execute the script every 2 minutes
while true; do
    echo "Running build_project.sh at $(date)"
    /home/mfarooq/Geant4Projects/MyGeant4Project/circular_beam/V2/sim/build_project.sh >> /home/mfarooq/Geant4Projects/MyGeant4Project/circular_beam/V2/sim/log/build_project.log 2>&1  # Run your script and log output
    sleep 120  # Wait for 120 seconds (2 minutes)
done

