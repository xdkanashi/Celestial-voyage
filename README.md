# Setting Up Celestial Voyage Project

## Prerequisites
- [Visual Studio Code](https://code.visualstudio.com/)
- [Laragon](https://laragon.org/)

## Steps

1. **Download Visual Studio Code and Laragon**
   - Visit the respective websites and download the latest versions of Visual Studio Code and Laragon.

2. **Download PHP Server Extension in VSC**
   - Install the "PHP Server" extension in Visual Studio Code from the Extensions Marketplace.

3. **Download PHP from windows.php.net**
   - Download PHP for Windows from the official PHP website.

4. **Configure php.ini-development**
   - Open php.ini-development in Visual Studio Code.
   - Uncomment the lines for `extension=mysqli` and `extension=pdo_mysqli`.
   - Change `extension=mysqli` to `extension=<your_php_path>/ext/php_mysqli.dll`.
   - Change `extension=pdo_mysqli` to `extension=<your_php_path>/ext/php_pdo_mysqli.dll`.
   - Save the file and rename it to php.ini. (Run Visual Studio Code as Administrator to do this step)

5. **Configure Visual Studio Code Settings**
   - Go to File -> Preferences -> Settings -> Open Settings (JSON).
   - Add the following lines to the JSON:
     ```json
     "php.validate.executablePath": "<path_to_php.exe>",
     "phpserver.phpPath": "<path_to_php.exe>",
     ```
   - Replace `<path_to_php.exe>` with the path to your php.exe file.

6. **Download Files from GitHub Repository**
   - Clone or download the files from your GitHub repository.

7. **Set Up Laragon**
   - Open the SQL file in Laragon.
   - Start the Laragon server and turn on Virtual Host.

8. **Open and Run Project in Visual Studio Code**
   - Open the project folder in Visual Studio Code (File -> Open Folder -> celestial voyage).
   - Navigate to `/html/main.html` file and run it.
   
9. **Enjoy Your Site**
   - Your Celestial Voyage project should now be up and running! Enjoy exploring your site.


