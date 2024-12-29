@echo off
echo "Starting the automated script execution..."
:start
echo "Running copy_files.bat at %date% %time%"
call copy_files.bat
echo "Waiting for 2 minutes before the next execution..."
timeout /t 86400 /nobreak >nul
goto start
