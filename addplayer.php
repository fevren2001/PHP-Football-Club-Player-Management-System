<!DOCTYPE html>
<html lang="en" data-theme="forest">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Addplayer</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="header w-full bg-neutral p-4 md:p-5 text-neutral-content">
    <div class="container mx-auto flex flex-col md:flex-row items-center justify-center md:justify-between">

        Roaster of Team Webprog
        <a class="btn btn-primary font-bold ml-10 mt-1" href="index.php">Main Page</a>
    </div>
    </div>

    <div class="container mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row">

        <form action="addplayer.php" method="get" class="w-full md:w-1/2 lg:w-5/12 mx-auto md:mx-0 mb-8 md:mb-0">
            <h1 class="text-3xl  p-5 font-bold">Add a new player</h1>




            <label class="form-control w-full max-w-xs">
                <div class="label">
                    <span class="label-text">Name</span>
                </div>
                <input type="text" name="name" placeholder="Type here" class="input input-bordered w-full max-w-xs" />
            </label>

            <label class="form-control w-full max-w-xs">
                <div class="label">
                    <span class="label-text">Goals</span>
                </div>
                <input type="number" name="goals2024" placeholder="Type here"
                    class="input input-bordered w-full max-w-xs" />
            </label>

            <label class="form-control w-full max-w-xs">
                <div class="label">
                    <span class="label-text">Positions</span>
                </div>
                <input type="text" name="positions" placeholder="Type here"
                    class="input input-bordered w-full max-w-xs" />
                <div class="label">
                    <span class="label-text-alt">Write down the positions separated with a coma! ','</span>
                </div>
            </label>

            <select class="select w-full max-w-xs mb-3 select-bordered" name="img">
                <option disabled selected>Select the picture</option>
                <option value="batorini">Batorini</option>
                <option value="benke">Benke</option>
                <option value="carlaise">Carlaise</option>
                <option value="cher">Cher</option>
                <option value="dace">Dace</option>
                <option value="kiss">Kiss</option>
            </select>
            <input type="submit" value="Add new player" class="btn btn-primary font-bold">
        </form>

        <?php
        if ($_SERVER['SERVER_NAME'] == 'localhost') {
            // Local environment (XAMPP)
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "soccer_team"; // Replace with your local DB name
            // $port = 3307; // New port number
            $conn = new mysqli($servername, $username, $password, $dbname);

        } else {
            // Live hosting (InfinityFree)
            $servername = "sql303.infinityfree.com";
            $username = "if0_38575461"; // Your InfinityFree database username
            $password = "EdWf4NY93CR"; // Your InfinityFree database password
            $dbname = "if0_38575461_soccer_team_db"; // Your InfinityFree database name
        
            // Create connection
        
            $conn = new mysqli($servername, $username, $password, $dbname);

        }



        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }



        $errors = [];
        $input = $_GET;

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($input['name'])) {
            if (!isset($input['name']) || trim($input['name']) === "") {
                $errors[] = "Enter a name!";
            } else if (strlen(trim($input['name'])) < 4) {
                $errors[] = "Enter a name that is at least 4 characters long!";
            }



            if (!isset($input['positions']) || trim($input['positions']) === "") {
                $errors[] = "Enter the positions!";
            }
        }

        if (count($errors) === 0 && $_SERVER["REQUEST_METHOD"] == "GET" && isset($input['name']) && isset($input['positions'])) {
            // Prepare the SQL query
            $sql = "INSERT INTO players (name, goals2024, positions, img) VALUES (?, ?, ?, ?)";

            // Prepare statement
            $stmt = $conn->prepare($sql); // Now directly assign it
        
            if ($stmt) {
                // Bind parameters
                $stmt->bind_param("siss", $input['name'], $input['goals2024'], $input['positions'], $input['img']);

                // // Execute query
                // if ($stmt->execute()) {
                //     echo "New player added successfully.";
                // } else {
                //     echo "Error: " . $stmt->error;
                // }

                // Close statement after checking if $stmt is prepared
                $stmt->close();
            } else {
                echo "Error: Could not prepare the SQL statement. " . $conn->error;
            }
        }

        // Close the statement
        // $stmt->close();
        
        ?>




        <?php if (count($errors) > 0): ?>
            <div class="results w-full md:w-1/2 lg:w-7/12 md:pl-8">
                <div class="errors">
                    <h2 class="text-3xl mb-5 font-bold">Failed addition</h2>
                    <?php foreach ($errors as $error): ?>
                        <div role="alert" class="alert alert-error mb-2">
                            <span>Error: <?php echo $error; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (count($errors) === 0 && $_SERVER["REQUEST_METHOD"] == "GET" && isset($input['name']) && isset($input['positions'])): ?>

                <div class="success">
                    <h2 class="text-3xl mb-2 font-bold">Successful addition</h2>
                    <a class="btn btn-primary font-bold mt-1" href="index.php">Go back to Main Page</a>
                </div>
            </div>
        <?php endif;



            ?>

    </div>
</body>

</html>