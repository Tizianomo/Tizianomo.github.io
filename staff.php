<?php
session_start();

$staffMembers = [
    [
        'username' => 'HerobrinePro',
        'rank' => 'Founder',
        'joinDate' => '2023-01-01',
        'permissions' => ['All Permissions', 'Server Management', 'Staff Management'],
        'avatar' => 'https://mc-heads.net/head/HerobrinePro/left',
        'avatar3d' => 'https://mc-heads.net/body/HerobrinePro/right',
        'discord' => 'HerobrinePro#0001',
        'social' => [
            'youtube' => 'https://youtube.com/@HerobrinePro',
            'twitter' => 'https://twitter.com/HerobrinePro'
        ]
    ],
    [
        'username' => 'DiamondMaster',
        'rank' => 'Owner',
        'joinDate' => '2023-02-15',
        'permissions' => ['Server Management', 'Ban', 'Unban', 'Staff Management'],
        'avatar' => 'https://mc-heads.net/head/DiamondMaster/left',
        'avatar3d' => 'https://mc-heads.net/body/DiamondMaster/right',
        'discord' => 'DiamondMaster#1234',
        'social' => [
            'youtube' => 'https://youtube.com/@DiamondMaster'
        ]
    ],
    [
        'username' => 'EnderGuard',
        'rank' => 'Moderator',
        'joinDate' => '2023-04-10',
        'permissions' => ['Ban', 'Kick', 'Mute', 'Warn', 'Teleport'],
        'avatar' => 'https://mc-heads.net/head/EnderGuard/left',
        'avatar3d' => 'https://mc-heads.net/body/EnderGuard/right',
        'discord' => 'EnderGuard#5678',
        'social' => []
    ],
    [
        'username' => 'ChatMaster',
        'rank' => 'ChatMod',
        'joinDate' => '2023-06-20',
        'permissions' => ['Mute', 'Warn', 'Chat Management'],
        'avatar' => 'https://mc-heads.net/head/ChatMaster/left',
        'avatar3d' => 'https://mc-heads.net/body/ChatMaster/right',
        'discord' => 'ChatMaster#9012',
        'social' => []
    ]
];

$rankColors = [
    'Founder' => '#FF6B35',
    'Owner' => '#4ECDC4',
    'Moderator' => '#45B7D1',
    'ChatMod' => '#96CEB4',
    'Helper' => '#FFEAA7'
];

$rankDescriptions = [
    'Founder' => 'Server founder with full administrative access',
    'Owner' => 'Server owner with high-level management permissions',
    'Moderator' => 'Responsible for maintaining server rules and player conduct',
    'ChatMod' => 'Monitors and manages chat environment',
    'Helper' => 'Assists players and handles basic reports'
];

$serverInfo = [
    'ip' => 'frog.bosscraft.net',
    'discord' => 'builtbybit',
    'store' => 'https://example.com'
];

function getDiscordInfo($inviteCode) {
    $url = "https://discord.com/api/v9/invites/{$inviteCode}?with_counts=true";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    if ($response) {
        $data = json_decode($response, true);
        return [
            'total_members' => $data['approximate_member_count'] ?? 0,
            'online_members' => $data['approximate_presence_count'] ?? 0
        ];
    }
    
    return ['total_members' => 0, 'online_members' => 0];
}

$discordInfo = getDiscordInfo($serverInfo['discord']);

$page = isset($_GET['page']) ? $_GET['page'] : 'staff';

$aboutContent = [
    'title' => 'About Us',
    'description' => 'Welcome to BossCraft',
    'mainText' => '
        BossCraft has been providing a unique gaming experience to Minecraft enthusiasts since 2023. 
        With our professional team and robust infrastructure, we deliver uninterrupted gaming enjoyment.
        
        Our server hosts one of the most active Minecraft communities. With our experienced 
        management team and powerful anti-cheat systems, we provide our players with a safe 
        and fun gaming environment.
        
        Our 24/7 active support team, advanced plugin systems, and regular events ensure 
        that we always provide the best service. Our goal is to provide all our players 
        with an unforgettable Minecraft experience.
        
        Join our server now to become part of this great community!'
];

$rulesContent = [
    'title' => 'Server Rules',
    'description' => 'To maintain a friendly and fair environment, all players must follow these rules:',
    'categories' => [
        [
            'title' => 'General Rules',
            'rules' => [
                'Respect all players and staff members',
                'No harassment, bullying, or toxic behavior',
                'No spamming or flooding the chat',
                'English only in public chat',
                'No advertising other servers'
            ]
        ],
        [
            'title' => 'Gameplay Rules',
            'rules' => [
                'No hacking or using unfair advantages',
                'No bug exploitation',
                'No AFK farming',
                'No griefing or stealing',
                'Respect others\' builds and properties'
            ]
        ],
        [
            'title' => 'Chat Rules',
            'rules' => [
                'No swearing or inappropriate language',
                'No sharing personal information',
                'No political or religious discussions',
                'No caps lock abuse',
                'No trading real-world items'
            ]
        ]
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff | BossCraft</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=VT323:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/leonardosnt/mc-player-counter/dist/mc-player-counter.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-primary: #1a1a1a;
            --bg-secondary: #2d2d2d;
            --bg-tertiary: #404040;
            --accent-primary: #55ff55;
            --accent-secondary: #ffaa00;
            --accent-tertiary: #ff5555;
            --text-primary: #ffffff;
            --text-secondary: #cccccc;
            --text-muted: #888888;
            --border-light: #555555;
            --border-dark: #333333;
            --card-bg: rgba(45, 45, 45, 0.9);
            --card-hover: rgba(45, 45, 45, 1);
            --glow-primary: 0 0 10px rgba(85, 255, 85, 0.5);
            --glow-secondary: 0 0 15px rgba(255, 170, 0, 0.5);
            --gradient-primary: linear-gradient(45deg, var(--accent-primary), var(--accent-secondary));
            --gradient-secondary: linear-gradient(45deg, var(--accent-secondary), var(--accent-tertiary));
            --transition: all 0.3s ease;
            --pixel-border: 2px solid var(--border-light);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'VT323', monospace;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(85, 255, 85, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(255, 170, 0, 0.1) 0%, transparent 50%);
            background-attachment: fixed;
        }

        /* Minecraft-style background pattern */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(90deg, transparent 98%, rgba(85, 255, 85, 0.1) 100%),
                linear-gradient(0deg, transparent 98%, rgba(85, 255, 85, 0.1) 100%);
            background-size: 20px 20px;
            pointer-events: none;
            z-index: -1;
        }

        /* Header Styles */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: rgba(26, 26, 26, 0.95);
            border-bottom: var(--pixel-border);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-family: 'Press Start 2P', cursive;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent-primary);
            text-decoration: none;
            text-shadow: var(--glow-primary);
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo:hover {
            color: var(--accent-secondary);
            text-shadow: var(--glow-secondary);
            transform: scale(1.05);
        }

        .logo i {
            font-size: 1.2rem;
        }

        .nav {
            display: flex;
            gap: 1rem;
        }

        .nav-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 700;
            padding: 0.75rem 1rem;
            border: 2px solid transparent;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            background: transparent;
        }

        .nav-link:hover {
            color: var(--accent-primary);
            border-color: var(--accent-primary);
            box-shadow: var(--glow-primary);
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: var(--accent-primary);
            border-color: var(--accent-primary);
            background: rgba(85, 255, 85, 0.1);
            box-shadow: var(--glow-primary);
        }

        .nav-link i {
            margin-right: 0.5rem;
        }

        /* Mobile Menu */
        .mobile-menu {
            display: none;
            background: transparent;
            border: 2px solid var(--accent-primary);
            color: var(--accent-primary);
            font-size: 1.5rem;
            padding: 0.5rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .mobile-menu:hover {
            background: var(--accent-primary);
            color: var(--bg-primary);
        }

        @media (max-width: 768px) {
            .nav-container {
                padding: 1rem;
            }

            .mobile-menu {
                display: block;
            }

            .nav {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: var(--bg-secondary);
                border-top: var(--pixel-border);
                flex-direction: column;
                padding: 1rem;
            }

            .nav.active {
                display: flex;
            }

            .nav-link {
                width: 100%;
                text-align: center;
            }
        }

        /* Hero Section */
        .hero {
            padding: 8rem 2rem 4rem;
            text-align: center;
            max-width: 1400px;
            margin: 0 auto;
        }

        .hero-title {
            font-family: 'Press Start 2P', cursive;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--accent-primary);
            text-shadow: var(--glow-primary);
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            color: var(--text-secondary);
            max-width: 700px;
            margin: 0 auto;
        }

        /* Server Stats */
        .server-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            max-width: 1400px;
            margin: 0 auto 4rem;
            padding: 0 2rem;
        }

        .stat-card {
            background: var(--card-bg);
            border: var(--pixel-border);
            padding: 2rem 1.5rem;
            text-align: center;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--accent-primary);
            box-shadow: var(--glow-primary);
        }

        .stat-icon {
            font-size: 2.5rem;
            color: var(--accent-primary);
            margin-bottom: 1rem;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .stat-value.copy-tooltip:hover {
            color: var(--accent-primary);
            text-shadow: var(--glow-primary);
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Staff Grid */
        .staff-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .staff-card {
            background: var(--card-bg);
            border: var(--pixel-border);
            overflow: hidden;
            transition: var(--transition);
            position: relative;
        }

        .staff-card:hover {
            transform: translateY(-5px);
            border-color: var(--accent-primary);
            box-shadow: var(--glow-primary);
        }

        .staff-banner {
            height: 120px;
            background: var(--bg-tertiary);
            position: relative;
            overflow: hidden;
        }

        .staff-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, var(--accent-primary), var(--accent-secondary));
            opacity: 0.3;
        }

        .staff-avatar-container {
            position: absolute;
            top: 70px;
            left: 2rem;
            width: 100px;
            height: 100px;
            border: 4px solid var(--bg-primary);
            border-radius: 8px;
            overflow: hidden;
            background: var(--bg-primary);
        }

        .staff-avatar-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .minecraft-3d {
            position: absolute;
            right: 1rem;
            bottom: -30px;
            height: 180px;
            filter: drop-shadow(0 5px 10px rgba(0, 0, 0, 0.5));
        }

        .staff-content {
            padding: 4rem 2rem 2rem;
        }

        .staff-name {
            font-family: 'Press Start 2P', cursive;
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--accent-primary);
            text-shadow: var(--glow-primary);
        }

        .rank-description {
            color: var(--text-secondary);
            font-size: 1rem;
            margin: 0.5rem 0 1.5rem;
            line-height: 1.4;
        }

        .staff-details {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            background: var(--bg-tertiary);
            border: 1px solid var(--border-light);
            color: var(--text-secondary);
            transition: var(--transition);
        }

        .detail-item:hover {
            background: var(--bg-secondary);
            border-color: var(--accent-primary);
            color: var(--text-primary);
        }

        .detail-item.copy-tooltip {
            cursor: pointer;
        }

        .permissions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .permission {
            padding: 0.5rem 1rem;
            background: var(--bg-tertiary);
            border: 1px solid var(--border-light);
            border-radius: 4px;
            font-size: 0.8rem;
            color: var(--text-secondary);
            transition: var(--transition);
        }

        .permission:hover {
            background: var(--accent-primary);
            color: var(--bg-primary);
            border-color: var(--accent-primary);
        }

        .social-links {
            display: flex;
            gap: 1rem;
            justify-content: center;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-light);
        }

        .social-link {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-tertiary);
            border: 1px solid var(--border-light);
            color: var(--text-primary);
            text-decoration: none;
            transition: var(--transition);
        }

        .social-link:hover {
            background: var(--accent-primary);
            color: var(--bg-primary);
            border-color: var(--accent-primary);
            transform: translateY(-2px);
        }

        /* About Page */
        .about-section {
            text-align: center;
            max-width: 1000px;
            margin: 0 auto;
            padding: 8rem 2rem 4rem;
        }

        .letter-container {
            background: var(--card-bg);
            border: var(--pixel-border);
            padding: 3rem;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .letter-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
        }

        .about-title {
            font-family: 'Press Start 2P', cursive;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: var(--accent-primary);
            text-shadow: var(--glow-primary);
        }

        .about-text {
            font-size: 1.2rem;
            color: var(--text-secondary);
            line-height: 1.6;
            text-align: left;
            margin-bottom: 2rem;
        }

        .letter-footer {
            text-align: right;
            color: var(--text-secondary);
            font-size: 1.1rem;
            margin-top: 2rem;
        }

        .letter-signature {
            font-family: 'Press Start 2P', cursive;
            font-size: 1rem;
            color: var(--accent-primary);
            margin-top: 0.5rem;
        }

        /* Rules Page */
        .rules-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
}
