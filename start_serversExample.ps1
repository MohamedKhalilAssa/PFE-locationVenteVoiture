#script to automate the start of the servers for windows

Set-Location "path to front" 

# Launch server
Start-Process npm -ArgumentList "run serve" 
Start-Sleep -Seconds 5

# Change directory to frontend folder 
Set-Location "path to front"

# Launch frontend watcher
Start-Process npm -ArgumentList "run watch" 
# Change directory to backend folder 
Set-Location "Path to back"

# Launch backend server
Start-Process php -ArgumentList "artisan serve" 