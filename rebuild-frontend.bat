@echo off
echo ========================================
echo Helply - Frontend Rebuild com Cache Clear
echo ========================================
echo.

echo [1/5] Limpando cache do Laravel...
"C:\Users\joaop\.config\herd\bin\php.bat" artisan optimize:clear
"C:\Users\joaop\.config\herd\bin\php.bat" artisan view:clear
"C:\Users\joaop\.config\herd\bin\php.bat" artisan route:clear
"C:\Users\joaop\.config\herd\bin\php.bat" artisan config:clear
echo.

echo [2/5] Removendo assets antigos...
if exist "public\build" (
    rmdir /s /q "public\build"
    echo Assets antigos removidos
) else (
    echo Nenhum asset antigo encontrado
)
echo.

echo [3/5] Limpando node_modules/.vite...
if exist "node_modules\.vite" (
    rmdir /s /q "node_modules\.vite"
    echo Cache do Vite removido
)
echo.

echo [4/5] Compilando novos assets...
call npm run build
echo.

echo [5/5] Concluido!
echo.
echo ========================================
echo Assets compilados com sucesso!
echo Pressione Ctrl+F5 no browser para forcar refresh
echo ========================================
pause
