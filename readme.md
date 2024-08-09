⚽ Football Club Player Management System
This Football Club Player Management System is a PHP-based web application designed to manage and display a football club's player roster. The system reads player data from a JSON file, allowing users to view player profiles, including their name, positions, and goal statistics, as well as add new players to the club's database.

Key Features:
Player Data Display:

The application reads and parses player data from a JSON file.
Players are displayed on individual cards, showing their name, picture, and positions.
Player positions are displayed as badges, with the primary position highlighted using a badge-primary class and secondary positions using the badge-outline class.
The application also displays the player's goal statistics for the current and previous seasons, calculating and showing the difference in performance. If goals have decreased, it displays "Less than last season," if they have increased, the percentage difference is shown, and if they remain the same, it shows "Same as last season."
Adding New Players:

A form allows users to add new players to the club's roster.
The form includes validation checks for the player's name, positions, and goal statistics:
Names must be at least 4 characters long, without leading or trailing spaces.
Positions must be entered as a comma-separated list and validated using a regular expression.
Goal statistics for the current season must be integers, validated using the filter_var function.
If the input data is valid, the system automatically assigns '0' goals for the previous season and saves the player's data and image to the JSON file.
Error messages are displayed for invalid inputs, and the form's state is preserved (except for dropdown fields) to aid in correction.
This project demonstrates my proficiency in PHP development, JSON data handling, form validation, and dynamic web page creation.
