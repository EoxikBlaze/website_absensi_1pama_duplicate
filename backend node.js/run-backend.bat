@echo off
echo Menambahkan jalur khusus Node.js untuk terminal ini (agar NPM terdeteksi)...
set "PATH=%PATH%;C:\Program Files\nodejs\"
echo.
echo Menghidupkan Server Backend Node.js...
npm.cmd run dev
pause
