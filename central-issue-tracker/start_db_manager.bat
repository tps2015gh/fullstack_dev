@echo off
REM =====================================================
REM Central Issue Tracker - Quick Start Script
REM =====================================================
REM This script launches the interactive CLI menu for
REM database management of the tps2015gh_issue_tracker
REM =====================================================

echo.
echo ========================================================
echo    Central Issue Tracker - Database Manager
echo ========================================================
echo.

REM Check if PHP is available
where php >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: PHP is not installed or not in PATH.
    echo.
    echo Please install PHP 8.1+ and add it to your system PATH.
    echo Download from: https://windows.php.net/download/
    echo.
    pause
    exit /b 1
)

REM Check PHP version
for /f "tokens=2" %%i in ('php -v 2^>nul ^| findstr /C:"PHP"') do set PHP_VERSION=%%i
echo PHP Version: %PHP_VERSION%
echo.

REM Navigate to project directory
cd /d "%~dp0"

echo Project Directory: %CD%
echo.

REM Check if .env file exists
if not exist ".env" (
    echo ERROR: .env file not found!
    echo.
    echo Please ensure the .env file exists in the project root.
    pause
    exit /b 1
)

echo Launching Database Manager...
echo.
echo ========================================================
echo.

REM Run the spark command
php spark db:manager

REM If the above command failed
if %ERRORLEVEL% NEQ 0 (
    echo.
    echo ========================================================
    echo ERROR: Failed to launch Database Manager!
    echo.
    echo Possible causes:
    echo   1. Dependencies not installed - Run: composer install
    echo   2. Command not registered - Run: php spark cache:clear
    echo   3. MySQL not running - Start MySQL service
    echo.
    pause
    exit /b 1
)

pause
