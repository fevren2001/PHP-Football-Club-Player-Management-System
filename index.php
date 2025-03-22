<?php
$data = file_get_contents('players.json');
$players_json = json_decode($data, true);
// var_dump($players);

if ($_SERVER['SERVER_NAME'] == 'localhost') {
    // Local environment (XAMPP)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "soccer_team"; // Replace with your local DB name
    // $port = 3307; // New port number
    // $conn = new mysqli($servername, $username, $password, $dbname);

} else {
    // Live hosting (InfinityFree)
    $servername = "sql303.infinityfree.com";
    $username = "if0_38575461"; // Your InfinityFree database username
    $password = "EdWf4NY93CR"; // Your InfinityFree database password
    $dbname = "if0_38575461_soccer_team_db"; // Your InfinityFree database name

    // Create connection

    // $conn = new mysqli($servername, $username, $password, $dbname);

}
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch new players from the database
$sql = "SELECT * FROM players";
$result = $conn->query($sql);

// Store the new players in an array
$players_db = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $players_db[] = $row;
    }
}

$conn->close();

foreach ($players_db as &$player) {
    // Convert positions from string to array if needed
    if (isset($player['positions']) && !is_array($player['positions'])) {
        $player['positions'] = explode(',', $player['positions']); // Assuming positions are comma-separated
    }

    // Set default values for missing fields
    if (!isset($player['positions'])) {
        $player['positions'] = []; // Empty array if no positions
    }

    if (!isset($player['goals2023'])) {
        $player['goals2023'] = 0; // Default to 0 if not set
    }

    if (!isset($player['goals2024'])) {
        $player['goals2024'] = 0; // Default to 0 if not set
    }

    if (!isset($player['img'])) {
        $player['img'] = 'default'; // Default image if not set
    }
}
unset($player); // Break the reference
// Merge the existing players with the new ones from the database
$players = array_merge($players_json, $players_db);


?>


<!DOCTYPE html>
<html lang="en" data-theme="forest">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body class="p-0">
    <div class="header w-full text-3xl bg-neutral p-5 font-bold text-neutral-content text-center ">
        Roaster of Soccer Team
        <a class="btn btn-primary font-bold ml-10 mt-1" href="addplayer.php">Add player</a>
    </div>
    <div
        class="w-[80vw] mx-auto mt-5 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[80vh] overflow-y-scroll ">
        <!-- Beginning of the cards -->
        <?php foreach ($players as $key => $player): ?>
            <div class="card card-side bg-base-300 shadow-xl">
                <!-- <figure class="h-full"><img src=<?php echo '/img/' . $player['img'] . '.jpg'; ?> class="h-full w-48 object-cover" /> -->
                <figure class="h-full"><img src="img/<?php echo $player['img']; ?>.jpg" class="h-full w-48 object-cover" />
                    <!-- class="h-full w-48 object-cover" /> -->

                </figure>
                <div class="card-body mx-auto text-center w-full p-3 my-auto">
                    <h2 class="card-title text-center block"><?php echo $player['name'] ?></h2>
                    <div class="card-actions mx-auto text-center block">
                        <?php foreach ($player['positions'] as $key1 => $position): ?>
                            <?php if ($key1 === 0): ?>
                                <div class="badge badge-primary"><?php echo $position; ?></div>
                            <?php else: ?>
                                <div class="badge badge-outline"><?php echo $position; ?></div>
                            <?php endif; ?>
                        <?php endforeach ?>


                        <!-- <div class="badge badge-primary">Striker</div>
                    <div class="badge badge-outline">Winger</div> -->


                        <!-- for the goals  -->
                        <?php




                        $goal_diff = $player['goals2024'] - $player['goals2023'];

                        if ($player['goals2023'] === 0) {
                            $goal_message = "New Player";
                            $arrow = ''; // No arrow for new players
                        } else {
                            $percantage_more = round($goal_diff / $player['goals2023'] * 100);
                            $goal_message = "";
                        if ($goal_diff < 0) {
                            $percantage_less = round(abs($goal_diff) / $player['goals2023'] * 100);
                            $goal_message = $percantage_less . "% less than last season";
                            // $arrow = '<span style="color: red;">&#8595;</span>';  // Downward red arrow
                            $arrow = '<i class="fas fa-arrow-down" style="color: red; font-size: 1.5rem;"></i>';  // Red downward arrow with size
                    
                        } else if ($goal_diff > 0) {
                            if ($player['goals2023'] !== 0) {
                                $goal_message = $percantage_more . "% more than last season";
                                // $arrow = '<span style="color: green;">&#8593;</span>';  // Upward green arrow
                                $arrow = '<i class="fas fa-arrow-up" style="color: green; font-size: 1.5rem;"></i>';  // Green upward arrow with size
                    
                            }

                        } else {
                            $goal_message = "Same as last season";

                        }
                        }
                        

                        ?>

                        <div class="stat">
                            <div class="stat-title">Goals this season</div>
                            <div class="stat-value"><?php echo $player['goals2024']; ?></div>
                            <div class="stat-desc"><?php echo $goal_message . ' ' . $arrow; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>

    </div>
</body>

</html>