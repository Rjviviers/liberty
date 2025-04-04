@echo off
echo Starting Liberty application without Docker...
powershell.exe -ExecutionPolicy Bypass -File "%~dp0start-liberty.ps1"
pause
