#script to automate the start of the servers for windows

Set-Location "D:\WorkSpace\Code\PFE-locationVenteVoiture\front-end-vue" 

# Launch server
Start-Process npm -ArgumentList "run serve" -NoNewWindow

Start-Sleep -Seconds 5

# Change directory to frontend folder 
Set-Location "D:\WorkSpace\Code\PFE-locationVenteVoiture\front-end-vue"

# Launch frontend watcher
Start-Process npm -ArgumentList "run watch" -NoNewWindow

# Change directory to backend folder 
Set-Location "D:\WorkSpace\Code\PFE-locationVenteVoiture\back-end"

# Launch backend server
Start-Process php -ArgumentList "artisan serve" -NoNewWindow