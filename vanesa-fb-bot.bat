@echo off
echo %CD%

cd "C:\Users\bobkata\Games\VanesaAI-Laravel\"

git pull

c:/xamp-php81/php/php.exe artisan migrate
c:/xamp-php81/php/php.exe artisan dusk --filter FacebookBot