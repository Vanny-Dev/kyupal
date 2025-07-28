<?php
// index.php - Public page with login form
require_once './config/auth.php';

// If user is already logged in, redirect to home
if (isLoggedIn()) {
    header('Location: home.php');
    exit();
}

// Set the target date (you can modify this to your desired date)
$target_date = "2025-07-03T00:00:00";
$current_date = date("Y-m-d H:i:s");

// Calculate the difference (counting UP from target date)
$diff = strtotime($current_date) - strtotime($target_date);

// Convert to days, hours, minutes, seconds
$days = floor($diff / (60 * 60 * 24));
$hours = floor(($diff % (60 * 60 * 24)) / (60 * 60));
$minutes = floor(($diff % (60 * 60)) / 60);
$seconds = $diff % 60;

// Sample memories data (you can replace with database queries)
$memories = [
    [
        'id' => 1,
        'date' => 'July 3, 2025',
        'image' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=300&h=200&fit=crop',
        'title' => 'Mountain Adventure'
    ],
    [
        'id' => 2,
        'date' => 'July 3, 2025',
        'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=300&h=200&fit=crop',
        'title' => 'Beach Sunset'
    ],
    [
        'id' => 3,
        'date' => 'July 3, 2025',
        'image' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=300&h=200&fit=crop',
        'title' => 'Forest Walk'
    ],
    [
        'id' => 4,
        'date' => 'July 3, 2025',
        'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=300&h=200&fit=crop',
        'title' => 'City Lights'
    ]
];

$messages = [
    [
        'id' => 1,
        'date' => 'July 15, 2025',
        'sender' => 'You',
        'message' => 'I love you so much! ❤️',
        'time' => '2:30 PM'
    ],
    [
        'id' => 2,
        'date' => 'July 14, 2025',
        'sender' => 'Love',
        'message' => 'Missing you already 💕',
        'time' => '10:15 AM'
    ],
    [
        'id' => 3,
        'date' => 'July 13, 2025',
        'sender' => 'You',
        'message' => 'Can\'t wait to see you tonight! 🌟',
        'time' => '6:45 PM'
    ],
    [
        'id' => 4,
        'date' => 'July 12, 2025',
        'sender' => 'Love',
        'message' => 'Thank you for the beautiful flowers 🌹',
        'time' => '1:20 PM'
    ]
];

$notes = [
    [
        'id' => 1,
        'date' => 'July 20, 2025',
        'title' => 'Things I Love About You',
        'content' => 'Your smile lights up my entire world...',
        'color' => '#fce7f3'
    ],
    [
        'id' => 2,
        'date' => 'July 18, 2025',
        'title' => 'Our First Date',
        'content' => 'I still remember every detail of that magical evening...',
        'color' => '#fdf2f8'
    ],
    [
        'id' => 3,
        'date' => 'July 16, 2025',
        'title' => 'Future Dreams',
        'content' => 'All the places we want to visit together...',
        'color' => '#f3e8ff'
    ],
    [
        'id' => 4,
        'date' => 'July 14, 2025',
        'title' => 'Gratitude',
        'content' => 'Every day with you feels like a blessing...',
        'color' => '#fce7f3'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memories</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 50%, #f3e8ff 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(236, 72, 153, 0.1);
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .header {
            background: linear-gradient(135deg, #ec4899, #be185d);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .logo h1 {
            font-size: 28px;
            font-weight: 300;
            letter-spacing: 2px;
        }

        .login-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .login-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        .countdown-section {
            text-align: center;
            padding: 40px 20px;
            background: linear-gradient(135deg, #fdf2f8, #fce7f3);
        }

        .countdown-timer {
            font-size: 3.5rem;
            font-weight: 300;
            color: #be185d;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(190, 24, 93, 0.1);
        }

        .countdown-label {
            color: #9d174d;
            font-size: 1.1rem;
            font-weight: 500;
            letter-spacing: 1px;
        }

        .nav-tabs {
            display: flex;
            justify-content: center;
            gap: 0;
            margin-top: 20px;
            border-radius: 25px;
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.1);
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .nav-tab {
            flex: 1;
            padding: 12px 20px;
            background: white;
            color: #9d174d;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            position: relative;
            user-select: none;
            -webkit-tap-highlight-color: transparent;
        }

        .nav-tab:hover {
            background: rgba(236, 72, 153, 0.1);
            color: #be185d;
            text-decoration: none;
        }

        .nav-tab.active {
            background: linear-gradient(135deg, #ec4899, #be185d);
            color: white;
        }

        .nav-tab:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 20%;
            height: 60%;
            width: 1px;
            background: rgba(157, 23, 77, 0.2);
        }

        /* Fixed content container for smooth sliding */
        .content-container {
            position: relative;
            overflow: hidden;
            min-height: 400px;
            width: 100%;
        }

        .content-section {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            min-height: 400px;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            pointer-events: none;
            will-change: transform, opacity;
        }

        .content-section.active {
            opacity: 1;
            transform: translateX(0);
            pointer-events: all;
            position: relative;
        }

        .content-section.slide-out-left {
            opacity: 0;
            transform: translateX(-100%);
        }

        .content-section.slide-out-right {
            opacity: 0;
            transform: translateX(100%);
        }

        .content-section.slide-in-left {
            opacity: 1;
            transform: translateX(0);
        }

        .content-section.slide-in-right {
            opacity: 1;
            transform: translateX(0);
        }

        .messages-grid, .notes-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            padding: 40px;
            max-width: 600px;
            margin: 0 auto;
        }

        .message-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(236, 72, 153, 0.1);
            transition: all 0.3s ease;
            border-left: 4px solid #ec4899;
        }

        .message-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(236, 72, 153, 0.15);
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .message-sender {
            font-weight: 600;
            color: #be185d;
        }

        .message-time {
            font-size: 0.8rem;
            color: #9d174d;
        }

        .message-content {
            color: #374151;
            font-size: 1rem;
            line-height: 1.5;
        }

        .message-date {
            font-size: 0.8rem;
            color: #ec4899;
            margin-top: 8px;
        }

        .note-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(236, 72, 153, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .note-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #ec4899, #be185d);
        }

        .note-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(236, 72, 153, 0.15);
        }

        .note-title {
            font-weight: 600;
            color: #be185d;
            font-size: 1.1rem;
            margin-bottom: 8px;
        }

        .note-content {
            color: #374151;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .note-date {
            font-size: 0.8rem;
            color: #ec4899;
        }

        .memories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            padding: 40px;
        }

        .memory-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(236, 72, 153, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .memory-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(236, 72, 153, 0.15);
        }

        .memory-image {
            width: 100%;
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
            overflow: hidden;
        }

        .memory-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(236, 72, 153, 0.1), rgba(190, 24, 93, 0.1));
            opacity: 0;
            transition: all 0.3s ease;
        }

        .memory-card:hover .memory-image::before {
            opacity: 1;
        }

        .memory-info {
            padding: 20px;
            text-align: center;
        }

        .memory-date {
            color: #ec4899;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .memory-title {
            color: #374151;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .placeholder-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: rgba(190, 24, 93, 0.6);
            font-size: 3rem;
            pointer-events: none;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                padding: 15px;
            }

            .logo h1 {
                font-size: 24px;
            }

            .login-btn {
                padding: 8px 16px;
                font-size: 0.9rem;
            }

            .countdown-section {
                padding: 30px 15px;
            }

            .countdown-timer {
                font-size: 2.5rem;
            }

            .countdown-label {
                font-size: 1rem;
            }

            .nav-tabs {
                max-width: 100%;
                margin-top: 15px;
                border-radius: 15px;
            }

            .nav-tab {
                padding: 10px 15px;
                font-size: 0.9rem;
            }

            .memories-grid {
                grid-template-columns: 1fr;
                padding: 30px 20px;
                gap: 20px;
            }

            .memory-card {
                border-radius: 12px;
            }

            .memory-image {
                height: 180px;
            }

            .memory-info {
                padding: 15px;
            }

            .container {
                margin: 10px;
                border-radius: 15px;
            }
            .messages-grid, .notes-grid {
                padding: 30px 20px;
            }

            .message-card, .note-card {
                border-radius: 12px;
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .container {
                margin: 0;
                border-radius: 12px;
            }

            .header {
                padding: 12px;
            }

            .logo h1 {
                font-size: 20px;
                letter-spacing: 1px;
            }

            .logo-icon {
                width: 35px;
                height: 35px;
                font-size: 18px;
            }

            .countdown-section {
                padding: 25px 10px;
            }

            .countdown-timer {
                font-size: 2rem;
            }

            .countdown-label {
                font-size: 0.9rem;
            }

            .nav-tabs {
                border-radius: 12px;
                margin-top: 12px;
            }

            .nav-tab {
                padding: 8px 12px;
                font-size: 0.85rem;
            }

            .memories-grid {
                padding: 20px 15px;
                gap: 15px;
            }

            .memory-image {
                height: 160px;
            }

            .memory-info {
                padding: 12px;
            }

            .memory-date {
                font-size: 0.8rem;
            }

            .memory-title {
                font-size: 1rem;
            }

            .placeholder-text {
                font-size: 2.5rem;
            }

            .messages-grid, .notes-grid {
                padding: 20px 15px;
                gap: 15px;
            }

            .message-card, .note-card {
                padding: 12px;
                border-radius: 10px;
            }

            .message-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
        }

        .fade-in {
            animation: fadeIn 0.8s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card-clicked {
            transform: scale(0.95) !important;
            transition: transform 0.15s ease-out !important;
        }

        /* Prevent text selection on nav tabs to reduce jitter */
        .nav-tab {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
    </style>
</head>
<body>
    <div class="container fade-in">
        <header class="header">
            <div class="logo">
                <div class="logo-icon">📸</div>
                <h1>Memories</h1>
            </div>
            <a href="#" class="login-btn">Login</a>
        </header>

        <div class="countdown-section">
            <div class="countdown-timer" id="countdown">
                <?php echo sprintf("%02d:%02d:%02d:%02d", $days, $hours, $minutes, $seconds); ?>
            </div>
            <div class="countdown-label">(Days:Hrs:Mins:Secs)</div>
            <div class="nav-tabs">
                <button class="nav-tab" data-tab="messages" data-index="0">Messages</button>
                <button class="nav-tab" data-tab="notes" data-index="1">Notes</button>
                <button class="nav-tab active" data-tab="gallery" data-index="2">Gallery</button>
            </div>
        </div>

        <div class="content-container">
            <!-- Messages Section -->
            <div id="messages-section" class="content-section">
                <div class="messages-grid">
                    <?php foreach($messages as $message): ?>
                        <div class="message-card">
                            <div class="message-header">
                                <div class="message-sender"><?php echo $message['sender']; ?></div>
                                <div class="message-time"><?php echo $message['time']; ?></div>
                            </div>
                            <div class="message-content"><?php echo $message['message']; ?></div>
                            <div class="message-date"><?php echo $message['date']; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Notes Section -->
            <div id="notes-section" class="content-section">
                <div class="notes-grid">
                    <?php foreach($notes as $note): ?>
                        <div class="note-card" style="background-color: <?php echo $note['color']; ?>">
                            <div class="note-title"><?php echo $note['title']; ?></div>
                            <div class="note-content"><?php echo $note['content']; ?></div>
                            <div class="note-date"><?php echo $note['date']; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Gallery Section -->
            <div id="gallery-section" class="content-section active">
                <div class="memories-grid">
                    <?php foreach($memories as $memory): ?>
                        <div class="memory-card">
                            <div class="memory-image" style="background-image: url('<?php echo $memory['image']; ?>')">
                                <div class="placeholder-text">📷</div>
                            </div>
                            <div class="memory-info">
                                <div class="memory-date"><?php echo $memory['date']; ?></div>
                                <div class="memory-title"><?php echo $memory['title']; ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Live counter update (counting UP from target date)
        function updateCountUp() {
            const startDate = new Date('<?php echo $target_date; ?>').getTime();
            const now = new Date().getTime();
            const difference = now - startDate;

            if (difference >= 0) {
                const days = Math.floor(difference / (1000 * 60 * 60 * 24));
                const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((difference % (1000 * 60)) / 1000);

                document.getElementById('countdown').textContent =
                    `${String(days).padStart(2, '0')}:${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            } else {
                document.getElementById('countdown').textContent = '00:00:00:00';
            }
        }

        // Update counter every second
        setInterval(updateCountUp, 1000);

        // Enhanced tab switching with smooth animations
        let currentTabIndex = 2; // Start with gallery (index 2)
        let isTransitioning = false;

        // Initialize tab functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.nav-tab');
            
            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const tabName = this.getAttribute('data-tab');
                    const tabIndex = parseInt(this.getAttribute('data-index'));
                    
                    switchTab(tabName, tabIndex, this);
                });
            });
        });

        function switchTab(tabName, newTabIndex, clickedTab) {
            // Prevent multiple transitions and clicking same tab
            if (isTransitioning || newTabIndex === currentTabIndex) {
                return;
            }
            
            isTransitioning = true;
            
            // Update active tab styling
            document.querySelectorAll('.nav-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            clickedTab.classList.add('active');
            
            // Get sections
            const currentSection = document.querySelector('.content-section.active');
            const targetSection = document.getElementById(tabName + '-section');
            
            if (!currentSection || !targetSection) {
                isTransitioning = false;
                return;
            }
            
            // Determine slide direction
            const slideDirection = newTabIndex > currentTabIndex ? 'right' : 'left';
            
            // Set initial position for target section
            targetSection.style.transform = slideDirection === 'right' ? 'translateX(100%)' : 'translateX(-100%)';
            targetSection.style.opacity = '0';
            targetSection.style.pointerEvents = 'none';
            
            // Force reflow to ensure initial position is set
            targetSection.offsetHeight;
            
            // Start transition
            currentSection.style.transform = slideDirection === 'right' ? 'translateX(-100%)' : 'translateX(100%)';
            currentSection.style.opacity = '0';
            currentSection.style.pointerEvents = 'none';
            
            // Animate target section in
            requestAnimationFrame(() => {
                targetSection.style.transform = 'translateX(0)';
                targetSection.style.opacity = '1';
                targetSection.style.pointerEvents = 'all';
            });
            
            // Clean up after animation
            setTimeout(() => {
                // Remove active class from current section
                currentSection.classList.remove('active');
                currentSection.style.transform = '';
                currentSection.style.opacity = '';
                currentSection.style.pointerEvents = '';
                
                // Add active class to target section
                targetSection.classList.add('active');
                targetSection.style.transform = '';
                targetSection.style.opacity = '';
                targetSection.style.pointerEvents = '';
                
                // Update current tab index and allow new transitions
                currentTabIndex = newTabIndex;
                isTransitioning = false;
            }, 400); // Match CSS transition duration
        }

        // Enhanced click effects for cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.memory-card, .message-card, .note-card');
            
            cards.forEach(card => {
                card.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Remove any existing animation classes
                    this.classList.remove('card-clicked');
                    
                    // Force reflow
                    this.offsetHeight;
                    
                    // Add click animation class
                    this.classList.add('card-clicked');
                    
                    // Remove the class after animation
                    setTimeout(() => {
                        this.classList.remove('card-clicked');
                    }, 150);
                });
            });
        });
    </script>
</body>
</html>