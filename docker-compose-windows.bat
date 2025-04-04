@echo off
setlocal enabledelayedexpansion

REM Get the command from the first argument
set "command=%1"

REM Shift arguments to remove the first one
shift

REM Combine remaining arguments
set "args="
:loop
if "%1"=="" goto endloop
set "args=!args! %1"
shift
goto loop
:endloop

REM Execute docker-compose with the Windows-specific file
if "%command%"=="up" (
    echo Starting Liberty containers with Windows configuration...
    docker-compose -f docker-compose.windows.yml up %args%
) else if "%command%"=="down" (
    echo Stopping Liberty containers...
    docker-compose -f docker-compose.windows.yml down %args%
) else if "%command%"=="build" (
    echo Building Liberty containers with Windows configuration...
    docker-compose -f docker-compose.windows.yml build %args%
) else if "%command%"=="logs" (
    echo Showing logs for Liberty containers...
    docker-compose -f docker-compose.windows.yml logs %args%
) else if "%command%"=="ps" (
    echo Listing Liberty containers...
    docker-compose -f docker-compose.windows.yml ps %args%
) else if "%command%"=="exec" (
    echo Executing command in Liberty container...
    docker-compose -f docker-compose.windows.yml exec %args%
) else (
    echo Executing docker-compose command: %command% %args%
    docker-compose -f docker-compose.windows.yml %command% %args%
)

endlocal
