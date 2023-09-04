<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['userIsLoggedIn']) || $_SESSION['userIsLoggedIn'] !== true) {
    header('Location: http://localhost/weblab/');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rdfx Bot Dashboard</title>
    <style>
        /* Add your video container styles here */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
            font-family: Arial, sans-serif;
        }
        #video-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        /* Add additional styles here */
        .welcome-message {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
        }
        .welcome-text {
            font-size: 2rem;
            margin-bottom: 10px;
            color: green; /* Add red color to the welcome text */
        }
        .redirect-text {
            font-size: 1.5rem;
            margin-top: 20px;
            color: green; /* Add red color to the countdown timer */
        }
    </style>
</head>
<body>
    <div id="video-container">
        <!-- Use your video file as the source -->
        <video autoplay muted loop>
            <source src="bot.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    <!-- Display personalized welcome message -->
    <div class="welcome-message">
        <div class="welcome-text" id="welcome-text"></div>
        <div class="redirect-text" id="redirect-text"></div>
    </div>

    <script>
        // Typing animation for welcome message
        const welcomeText = document.getElementById('welcome-text');
        const redirectText = document.getElementById('redirect-text');
        const userFirstName = '<?php echo isset($_SESSION['userdata']['first_name']) ? $_SESSION['userdata']['first_name'] : '' ?>';
        const welcomeMessages = [
            'Welcome to, ' + userFirstName + '',
            'Empower Your Investments withAI-Driven Trading',
            'Maximize Returns with Our Cutting-Edge Robot Traders',
            'Automated Trading for Modern Investors',
            'Unleash the Potential of Robotic Trading Technology'
        ];
        const redirectDelay = 3000; // 3 seconds
        
        let currentMessageIndex = 0;
        let currentCharIndex = 0;
        
        function typeEffect() {
            if (currentCharIndex < welcomeMessages[currentMessageIndex].length) {
                welcomeText.innerHTML += welcomeMessages[currentMessageIndex].charAt(currentCharIndex);
                currentCharIndex++;
                setTimeout(typeEffect, 50);
            } else {
                setTimeout(clearEffect, 1000);
            }
        }
        
        function clearEffect() {
            if (currentCharIndex >= 0) {
                welcomeText.innerHTML = welcomeMessages[currentMessageIndex].substring(0, currentCharIndex);
                currentCharIndex--;
                setTimeout(clearEffect, 50);
            } else {
                currentMessageIndex = (currentMessageIndex + 1) % welcomeMessages.length;
                setTimeout(typeEffect, 1000);
            }
        }

        typeEffect();

        // Countdown and redirect
        let countdown = 32;
        const redirectTimer = setInterval(() => {
            redirectText.innerHTML = `Redirecting to your dashboard in <span style="color: red;">${countdown}</span>...`;
            countdown--;

            if (countdown < 0) {
                clearInterval(redirectTimer);
                window.location.href = 'http://localhost/weblab/'; // Change this URL to your dashboard page
            }
        }, 1000);
    </script>
</body>
</html>
