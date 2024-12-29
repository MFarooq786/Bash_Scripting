#!/bin/bash

# Exit immediately if a command exits with a non-zero status
set -e

# Remove the build directory if it exists
echo "Removing existing build directory..."
rm -rf build

# Create a new build directory
echo "Creating new build directory..."
mkdir build

# Navigate to the build directory
cd build

# Run cmake
echo "Running cmake..."
cmake ..

# Build the project using make
echo "Building the project..."
make

echo "Build process completed successfully."
./sim 

