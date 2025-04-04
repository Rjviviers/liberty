@echo off
echo Stopping Liberty application servers...
powershell.exe -ExecutionPolicy Bypass -File "%~dp0stop-liberty.ps1"
pause
