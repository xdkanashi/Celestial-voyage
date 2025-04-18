# ✨ Celestial Voyage ✨

![Space](https://pngfre.com/wp-content/uploads/Astronaut-4.png)

Welcome to Celestial Voyage, an exhilarating journey through the cosmos right from your browser! 🚀✨

## About the Project

Celestial Voyage is a mesmerizing web project that invites you to explore the captivating wonders of space, planets, and stars. Embark on an immersive experience where you can dive deep into the mysteries of the universe, all from the comfort of your own device.

## Features

- **Stunning Visuals**: Prepare to be mesmerized by breathtaking images of celestial bodies, rendered in high definition for an immersive experience.
- **Interactive Exploration**: Navigate through our interactive interface to discover fascinating facts about planets, stars, and cosmic phenomena.
- **Educational Content**: Learn about the latest discoveries in space exploration and expand your knowledge of the cosmos with our curated collection of articles and resources.
- **Personalized Experience**: Customize your journey through space by selecting specific topics or areas of interest to explore further.

## Get Involved

We welcome contributions from the community to enhance Celestial Voyage further. Whether you're a seasoned developer, a space enthusiast, or someone eager to learn, there are plenty of ways to get involved:

- **Submit Issues**: Encountered a bug or have a feature request? Let us know by submitting an issue.
- **Pull Requests**: Contribute your code improvements, new features, or bug fixes by submitting a pull request.
- **Spread the Word**: Share Celestial Voyage with your friends and fellow space enthusiasts. The more, the merrier!

## Let the Journey Begin

Are you ready to embark on a celestial journey like no other? Clone the repository, launch the project, and prepare to be awestruck by the wonders of the universe.

Happy exploring!

# Setting Up Celestial Voyage Project

## Prerequisites
- [Visual Studio Code](https://code.visualstudio.com/)
- [Laragon](https://laragon.org/)
- [PHP](https://windows.php.net/)

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
   - Clone or download the files from GitHub repository.

7. **Set Up Laragon**
   - Open the SQL file in Laragon.
   - Start the Laragon server and turn on Virtual Host.

8. **Open and Run Project in Visual Studio Code**
   - Open the project folder in Visual Studio Code (File -> Open Folder -> celestial voyage).
   - Navigate to `/html/main.html` file and run it.
   
9. **Enjoy Site**
   - Celestial Voyage project should now be up and running! Enjoy exploring site.


