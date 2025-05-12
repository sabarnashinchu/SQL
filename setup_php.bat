@echo off
echo Setting up PHP with SQLite support...

set PHP_PATH=C:\Program Files\php-8.3.2
set PHP_INI=%PHP_PATH%\php.ini

if not exist "%PHP_PATH%\php.ini" (
    echo Creating php.ini from development template...
    copy "%PHP_PATH%\php.ini-development" "%PHP_INI%"
    if errorlevel 1 (
        echo Error: Unable to copy php.ini file. Please run as administrator.
        exit /b 1
    )
)

echo Enabling SQLite extensions...
powershell -Command "(Get-Content '%PHP_INI%') -replace ';extension=pdo_sqlite', 'extension=pdo_sqlite' -replace ';extension=sqlite3', 'extension=sqlite3' | Set-Content '%PHP_INI%'"

echo Creating database directory...
if not exist "database" mkdir database

echo Setup complete! You can now run the server with:
echo "%PHP_PATH%\php.exe" -S localhost:8000
echo.
echo Then visit http://localhost:8000/index.php in your browser

pause 