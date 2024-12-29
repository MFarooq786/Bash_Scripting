@echo off

REM Exit immediately if a command fails
setlocal enableextensions enabledelayedexpansion
echo "Accessing the External Drive"
F:

REM Get the current date in YYYY-MM-DD format
for /f "tokens=2 delims==" %%I in ('"wmic os get localdatetime /value | findstr LocalDateTime"') do set datetime=%%I
set year=!datetime:~0,4!
set month=!datetime:~4,2!
set day=!datetime:~6,2!
set current_date=!year!-!month!-!day!

REM Create a directory with the current date
echo "Creating Directory based on Current Date"
mkdir "!current_date!"
cd "!current_date!"

REM Copy files from C:\Users\polta\Box Sync\UNH Poltarg to the new directory
echo "Copying Files"
xcopy "C:\Users\polta\Box Sync\UNH Poltarg" "F:!current_date!" /E /I /Y

echo "Operation Completed Successfully!"
