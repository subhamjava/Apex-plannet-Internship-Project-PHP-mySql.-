<!DOCTYPE html>
<html>
<head>
    <title>Welcome to My PHP App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #00a3ad;
            color: #333;
            padding: 20px;
        }
        .container {
            background: #F8B195;
            border-radius: 10px;
            padding: 30px;
            max-width: 700px;
            margin: 50px auto;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .section {
            margin-top: 20px;
        }
        code {
            background: #eee;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.95em;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Welcome to My PHP Project</h1>
    
    <div class="section">
        <h2>📅 Today's Date</h2>
        <p>
            <?php
                echo "Today is: " . date("l, F j, Y");
            ?>
        </p>
    </div>

    <div class="section">
        <h2>⏰ Server Time</h2>
        <p>
            <?php
                date_default_timezone_set("Asia/Kolkata"); // set your timezone
                echo "Current time: " . date("h:i:s A");
            ?>
        </p>
    </div>

    <div class="section">
        <h2>ℹ️ About This App</h2>
        <p>This is a simple PHP application used for testing local server setup and Git integration.</p>
        <ul>
            <li>Built with PHP and HTML</li>
            <li>Running on a local Apache server</li>
            <li>Version controlled using Git</li>
        </ul>
    </div>

    <div class="section">
        <h2>⚙️ PHP Configuration</h2>
        <p>Your current PHP version is: 
            <code>
                <?php echo phpversion(); ?>
            </code>
        </p>
    </div>
</div>
    <footer>Developed by @Ritesh Kumar Jena</footer>
</body>
</html>
