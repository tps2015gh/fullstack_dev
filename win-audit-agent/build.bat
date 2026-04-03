@echo off
echo ========================================
echo    WinAudit Agent Build Script
echo ========================================
echo.

REM Check if Go is installed
where go >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Go is not installed or not in PATH.
    echo Please install Go from https://go.dev/dl/
    pause
    exit /b 1
)

echo [INFO] Go version:
go version
echo.

REM Clean previous build
if exist win-audit-agent.exe (
    echo [INFO] Removing previous build...
    del win-audit-agent.exe
    echo.
)

REM Build the executable
echo [INFO] Building win-audit-agent.exe...
go build -o win-audit-agent.exe -ldflags="-s -w"

if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Build failed!
    pause
    exit /b 1
)

echo.
echo [SUCCESS] Build completed!
echo [INFO] Output: win-audit-agent.exe
echo.

REM Show file size
for %%A in (win-audit-agent.exe) do (
    echo [INFO] File size: %%~zA bytes
)

echo.
echo [INFO] To run the agent:
echo        .\win-audit-agent.exe
echo.
pause
