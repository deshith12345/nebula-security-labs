<?php
// profile.php - SIMULATED VERSION (No database queries)

// Get the requested profile ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Initialize educational variables
$educational_answer = "";
$educational_feedback = "";
$educational_correct = false;

// Simulated user data
$simulated_users = [
    1 => [
        'username' => 'admin',
        'role' => 'Administrator',
        'flag' => 'FLAG{ADMIN_PRIVILEGES}'
    ],
    2 => [
        'username' => 'sunil', 
        'role' => 'Manager',
        'flag' => 'FLAG{SUNIL_SECRETS}'
    ],
    3 => [
        'username' => 'kamal',
        'role' => 'User',
        'flag' => 'FLAG{KAMAL_CONFIDENTIAL}'
    ]
];

// Check if it's the educational form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['educational_submit'])) {
    $educational_answer = trim($_POST['educational_answer']);
    
    // Get correct answer based on current profile
    $correct_answer = isset($simulated_users[$id]) ? $simulated_users[$id]['flag'] : "FLAG{ID0R_ACC3SS}";
    
    if (strtoupper($educational_answer) === strtoupper($correct_answer)) {
        $educational_feedback = "✅ Correct! You've successfully exploited the IDOR vulnerability!";
        $educational_correct = true;
    } else {
        $educational_feedback = "❌ Incorrect. This flag doesn't match the current profile. Try accessing different user profiles by changing the ID parameter.";
        $educational_correct = false;
    }
}

// If no ID specified, show guest profile
if ($id === 0) {
    showGuestProfile();
    exit;
}

// Get user data from simulation
$user = isset($simulated_users[$id]) ? $simulated_users[$id] : null;

// If user not found, show profile not found page
if (!$user) {
    showProfileNotFound($id);
    exit;
}

$user['id'] = $id;

function showGuestProfile() {
    global $educational_answer, $educational_feedback, $educational_correct;
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Guest Profile - Nebula Security</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            
            :root {
                --primary: #007aff; --secondary: #5856d6; --success: #34c759; --dark: #1d1d1f;
                --ios-glass: rgba(255, 255, 255, 0.25); --ios-border: rgba(255, 255, 255, 0.3);
                --ios-highlight: rgba(255, 255, 255, 0.4); --glass-blur: saturate(180%) blur(20px);
            }
            
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Segoe UI', sans-serif;
                background: 
                    radial-gradient(circle at 20% 80%, rgba(0, 122, 255, 0.15) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(88, 86, 214, 0.15) 0%, transparent 50%),
                    linear-gradient(135deg, #f5f5f7 0%, #e8e8ed 50%, #f5f5f7 100%);
                background-size: 400% 400%, 200% 200%, 400% 400%;
                animation: gradientShift 20s ease infinite;
                min-height: 100vh; padding: 2rem; color: var(--dark);
                display: flex; align-items: center; justify-content: center;
            }
            
            @keyframes gradientShift {
                0%, 100% { background-position: 0% 50%, 0% 0%, 0% 50%; }
                50% { background-position: 100% 50%, 100% 100%, 100% 50%; }
            }
            
            .container { max-width: 900px; width: 100%; position: relative; z-index: 1; }
            
            .profile-header {
                background: var(--ios-glass); backdrop-filter: var(--glass-blur);
                -webkit-backdrop-filter: var(--glass-blur); padding: 3rem 2.5rem 2rem;
                border-radius: 24px 24px 0 0; text-align: center;
                border: 0.5px solid var(--ios-border);
                box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08), inset 0 1px 0 var(--ios-highlight);
            }
            
            .profile-avatar {
                width: 120px; height: 120px;
                background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
                border-radius: 50%; display: flex; align-items: center; justify-content: center;
                margin: 0 auto 1.5rem; color: white; font-size: 3rem;
            }
            
            .profile-name { font-size: 2.2rem; color: var(--dark); margin-bottom: 0.5rem; letter-spacing: -0.5px; }
            .profile-subtitle { color: #666; font-size: 1.1rem; letter-spacing: -0.2px; }
            
            .profile-content {
                background: var(--ios-glass); backdrop-filter: var(--glass-blur);
                -webkit-backdrop-filter: var(--glass-blur); border-radius: 0 0 24px 24px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); overflow: hidden;
                border: 0.5px solid var(--ios-border);
            }
            
            .guest-message {
                background: rgba(255, 255, 255, 0.5); padding: 2rem;
                border-radius: 16px; margin: 2rem 2.5rem; text-align: center;
                backdrop-filter: var(--glass-blur); -webkit-backdrop-filter: var(--glass-blur);
                border: 0.5px solid var(--ios-border);
            }
            
            .guest-message i { font-size: 3rem; color: var(--primary); margin-bottom: 1rem; display: block; }
            .guest-message h3 { margin-bottom: 1rem; color: var(--dark); font-size: 1.5rem; letter-spacing: -0.3px; }
            .guest-message p { color: #666; line-height: 1.6; letter-spacing: -0.2px; }
            
            .educational-section {
                background: rgba(255, 255, 255, 0.5); backdrop-filter: var(--glass-blur);
                -webkit-backdrop-filter: var(--glass-blur); border-radius: 16px;
                padding: 2rem; margin: 0 2.5rem 2rem; border: 0.5px solid var(--ios-border);
            }
            
            .educational-section h3 {
                color: var(--dark); margin-bottom: 1rem; display: flex;
                align-items: center; gap: 0.5rem; font-size: 1.5rem;
                font-weight: 600; letter-spacing: -0.3px;
            }
            
            .educational-content { margin-bottom: 1.5rem; }
            .educational-content p { margin-bottom: 1rem; color: #555; line-height: 1.6; letter-spacing: -0.2px; }
            
            .hint-container { margin-top: 1rem; }
            
            .hint-btn {
                background: transparent; color: var(--primary); border: 1px solid var(--primary);
                padding: 0.8rem 1.5rem; border-radius: 12px; cursor: pointer;
                font-size: 1rem; transition: all 0.3s ease; font-weight: 500;
                font-family: inherit; display: inline-flex; align-items: center; gap: 0.5rem;
            }
            
            .hint-btn:hover { background: var(--primary); color: white; }
            
            .hint-content {
                display: none; margin-top: 1rem; padding: 1.5rem;
                background: rgba(255, 255, 255, 0.6); border-radius: 12px;
                border: 1px solid var(--ios-border); backdrop-filter: var(--glass-blur);
                -webkit-backdrop-filter: var(--glass-blur);
            }
            
            .hint-content.show { display: block; animation: fadeIn 0.3s ease-out; }
            
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            .hint-content p { margin-bottom: 0.5rem; color: #4a5568; line-height: 1.6; }
            
            code {
                background: rgba(0, 0, 0, 0.06); padding: 0.2rem 0.4rem;
                border-radius: 6px; font-family: 'Courier New', monospace;
                font-size: 0.9rem; color: var(--dark);
            }
            
            .btn-container { text-align: center; padding: 2rem; background: rgba(247, 250, 252, 0.6); }
            
            .btn {
                display: inline-flex; align-items: center; gap: 0.5rem;
                padding: 0.9rem 1.8rem; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
                color: white; text-decoration: none; border-radius: 14px;
                font-weight: 600; transition: all 0.3s ease; border: none;
                cursor: pointer; box-shadow: 0 2px 12px rgba(0, 122, 255, 0.25);
                letter-spacing: -0.2px; margin: 0.5rem;
            }
            
            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(0, 122, 255, 0.35);
            }
            
            @media (max-width: 768px) {
                body { padding: 1rem; }
                .container { padding: 0; }
                .educational-section, .guest-message { margin-left: 1.5rem; margin-right: 1.5rem; padding: 1.5rem; }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="profile-header">
                <div class="profile-avatar"><i class="fas fa-user-secret"></i></div>
                <h1 class="profile-name">Guest Mode</h1>
                <p class="profile-subtitle">You are viewing profiles as a guest</p>
            </div>

            <div class="profile-content">
                <div class="guest-message">
                    <i class="fas fa-info-circle"></i>
                    <h3>Guest Access Active</h3>
                    <p>You are currently browsing in guest mode. No sensitive information is displayed.</p>
                </div>

                <div class="educational-section">
                    <h3><i class="fas fa-graduation-cap"></i> IDOR Challenge</h3>
                    
                    <div class="educational-content">
                        <p><strong>About IDOR:</strong> Insecure Direct Object References (IDOR) occur when an application provides direct access to objects based on user-supplied input. This allows attackers to bypass authorization and access resources directly by modifying the value of a parameter.</p>
                        
                        <p><strong>Your Mission:</strong> Use IDOR to access other user profiles by modifying the ID parameter in the URL. Each profile contains a unique flag that you need to find.</p>
                        
                        <p><strong>Challenge:</strong> Find the flags in different user profiles and enter them below when you access each profile. Try profiles with IDs 1, 2, and 3.</p>
                    </div>

                    <div class="hint-container">
                        <button type="button" class="hint-btn" onclick="toggleHint()">
                            <i class="fas fa-lightbulb"></i> Need a hint?
                        </button>
                        <div class="hint-content" id="hintContent">
                            <p><strong>Hint 1:</strong> Try changing the URL parameter to <code>profile.php?id=1</code>, <code>profile.php?id=2</code>, or <code>profile.php?id=3</code>.</p>
                            <p><strong>Hint 2:</strong> Each profile has a different flag - admin, sunil, and KAMAL each have their own secrets.</p>
                            <p><strong>Hint 3:</strong> The flag format is FLAG{...} - enter the exact flag for the profile you're currently viewing.</p>
                        </div>
                    </div>
                </div>

                <div class="btn-container">
                    <a href="index.php" class="btn">
                        <i class="fas fa-home"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>

        <script>
            function toggleHint() {
                const hintContent = document.getElementById('hintContent');
                hintContent.classList.toggle('show');
            }
        </script>
    </body>
    </html>
    <?php
    exit;
}

function showProfileNotFound($id) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile Not Found - Nebula Security</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            
            :root {
                --primary: #007aff; --secondary: #5856d6; --danger: #ff3b30; --dark: #1d1d1f;
                --ios-glass: rgba(255, 255, 255, 0.25); --ios-border: rgba(255, 255, 255, 0.3);
                --ios-highlight: rgba(255, 255, 255, 0.4); --glass-blur: saturate(180%) blur(20px);
            }
            
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Segoe UI', sans-serif;
                background: 
                    radial-gradient(circle at 20% 80%, rgba(0, 122, 255, 0.15) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(88, 86, 214, 0.15) 0%, transparent 50%),
                    linear-gradient(135deg, #f5f5f7 0%, #e8e8ed 50%, #f5f5f7 100%);
                background-size: 400% 400%, 200% 200%, 400% 400%;
                animation: gradientShift 20s ease infinite;
                min-height: 100vh; padding: 2rem; color: var(--dark);
                display: flex; align-items: center; justify-content: center;
            }
            
            @keyframes gradientShift {
                0%, 100% { background-position: 0% 50%, 0% 0%, 0% 50%; }
                50% { background-position: 100% 50%, 100% 100%, 100% 50%; }
            }
            
            .container { max-width: 900px; width: 100%; position: relative; z-index: 1; }
            
            .profile-header {
                background: linear-gradient(135deg, rgba(255, 59, 48, 0.15) 0%, rgba(255, 59, 48, 0.25) 100%);
                backdrop-filter: var(--glass-blur); -webkit-backdrop-filter: var(--glass-blur);
                padding: 3rem 2.5rem 2rem; border-radius: 24px 24px 0 0; text-align: center;
                border: 0.5px solid rgba(255, 59, 48, 0.3);
                box-shadow: 0 4px 24px rgba(255, 59, 48, 0.15), inset 0 1px 0 var(--ios-highlight);
            }
            
            .profile-avatar {
                width: 120px; height: 120px;
                background: linear-gradient(135deg, var(--danger) 0%, #e53e3e 100%);
                border-radius: 50%; display: flex; align-items: center; justify-content: center;
                margin: 0 auto 1.5rem; color: white; font-size: 3rem;
            }
            
            .profile-name { font-size: 2.2rem; color: var(--dark); margin-bottom: 0.5rem; letter-spacing: -0.5px; }
            .profile-subtitle { color: #666; font-size: 1.1rem; letter-spacing: -0.2px; }
            
            .profile-content {
                background: var(--ios-glass); backdrop-filter: var(--glass-blur);
                -webkit-backdrop-filter: var(--glass-blur); border-radius: 0 0 24px 24px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); padding: 2.5rem;
                border: 0.5px solid var(--ios-border);
            }
            
            .error-message {
                background: rgba(255, 59, 48, 0.1); padding: 2rem;
                border-radius: 16px; margin-bottom: 2rem; text-align: center;
                border-left: 4px solid var(--danger);
                backdrop-filter: var(--glass-blur); -webkit-backdrop-filter: var(--glass-blur);
            }
            
            .error-message h3 {
                margin-bottom: 1rem; color: #c53030; display: flex;
                align-items: center; justify-content: center; gap: 0.5rem;
                font-size: 1.4rem; font-weight: 600; letter-spacing: -0.3px;
            }
            
            .error-message p { color: #744210; line-height: 1.6; margin-bottom: 1rem; font-size: 1.1rem; letter-spacing: -0.2px; }
            
            .idor-hint {
                background: rgba(255, 255, 255, 0.5); border: 1px solid var(--ios-border);
                padding: 1.5rem; border-radius: 16px; margin-bottom: 2rem;
                backdrop-filter: var(--glass-blur); -webkit-backdrop-filter: var(--glass-blur);
            }
            
            .idor-hint h4 {
                color: var(--primary); margin-bottom: 1rem; display: flex;
                align-items: center; gap: 0.5rem; font-size: 1.2rem;
                font-weight: 600; letter-spacing: -0.3px;
            }
            
            .idor-hint p { color: #555; line-height: 1.6; margin-bottom: 0.8rem; letter-spacing: -0.2px; }
            
            code {
                background: rgba(0, 122, 255, 0.1); color: var(--primary);
                padding: 0.2rem 0.5rem; border-radius: 6px;
                font-family: 'Courier New', monospace; font-weight: 600;
            }
            
            .btn-container { text-align: center; margin-top: 2rem; }
            
            .btn {
                display: inline-flex; align-items: center; gap: 0.5rem;
                padding: 0.9rem 1.8rem; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
                color: white; text-decoration: none; border-radius: 14px;
                font-weight: 600; transition: all 0.3s ease;
                box-shadow: 0 2px 12px rgba(0, 122, 255, 0.25);
                letter-spacing: -0.2px; margin: 0.5rem;
            }
            
            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(0, 122, 255, 0.35);
            }
            
            .btn-secondary {
                background: linear-gradient(135deg, #a0aec0 0%, #718096 100%);
                box-shadow: 0 2px 12px rgba(160, 174, 192, 0.25);
            }
            
            .btn-secondary:hover { box-shadow: 0 6px 20px rgba(160, 174, 192, 0.35); }
            
            @media (max-width: 768px) {
                body { padding: 1rem; }
                .profile-content { padding: 1.5rem; }
                .btn-container { display: flex; flex-direction: column; }
                .btn { width: 100%; justify-content: center; }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="profile-header">
                <div class="profile-avatar"><i class="fas fa-user-times"></i></div>
                <h1 class="profile-name">Profile Not Found</h1>
                <p class="profile-subtitle">The requested user profile could not be found</p>
            </div>

            <div class="profile-content">
                <div class="error-message">
                    <h3><i class="fas fa-exclamation-circle"></i> User Profile Does Not Exist</h3>
                    <p>The profile you requested (ID: <?= htmlentities($id) ?>) could not be found in the system.</p>
                </div>

                <div class="idor-hint">
                    <h4><i class="fas fa-lightbulb"></i> IDOR Challenge Hint</h4>
                    <p><strong>Valid Profile IDs:</strong> Try accessing profiles with IDs 1, 2, or 3 to find the flags.</p>
                    <p><strong>Example URLs:</strong> 
                        <code>profile.php?id=1</code>, 
                        <code>profile.php?id=2</code>, 
                        <code>profile.php?id=3</code>
                    </p>
                    <p>Each valid profile contains a unique flag that you need to discover for the IDOR challenge.</p>
                </div>

                <div class="btn-container">
                    <a href="profile.php" class="btn">
                        <i class="fas fa-user"></i> Back to Guest Profile
                    </a>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-home"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Nebula Security</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        :root {
            --primary: #007aff; --secondary: #5856d6; --success: #34c759; --dark: #1d1d1f;
            --ios-glass: rgba(255, 255, 255, 0.25); --ios-border: rgba(255, 255, 255, 0.3);
            --ios-highlight: rgba(255, 255, 255, 0.4); --glass-blur: saturate(180%) blur(20px);
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Segoe UI', sans-serif;
            background: 
                radial-gradient(circle at 20% 80%, rgba(0, 122, 255, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(88, 86, 214, 0.15) 0%, transparent 50%),
                linear-gradient(135deg, #f5f5f7 0%, #e8e8ed 50%, #f5f5f7 100%);
            background-size: 400% 400%, 200% 200%, 400% 400%;
            animation: gradientShift 20s ease infinite;
            min-height: 100vh; padding: 2rem; color: var(--dark);
            display: flex; align-items: center; justify-content: center;
        }
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%, 0% 0%, 0% 50%; }
            50% { background-position: 100% 50%, 100% 100%, 100% 50%; }
        }
        
        .container { max-width: 900px; width: 100%; position: relative; z-index: 1; }
        
        .profile-header {
            background: var(--ios-glass); backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur); padding: 3rem 2.5rem 2rem;
            border-radius: 24px 24px 0 0; text-align: center;
            border: 0.5px solid var(--ios-border);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08), inset 0 1px 0 var(--ios-highlight);
        }
        
        .profile-avatar {
            width: 120px; height: 120px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.5rem; color: white; font-size: 3rem;
        }
        
        .profile-name { font-size: 2.2rem; color: var(--dark); margin-bottom: 0.5rem; letter-spacing: -0.5px; }
        .profile-subtitle { color: #666; font-size: 1.1rem; letter-spacing: -0.2px; }
        
        .profile-content {
            background: var(--ios-glass); backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur); border-radius: 0 0 24px 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); overflow: hidden;
            border: 0.5px solid var(--ios-border);
        }
        
        .profile-section {
            padding: 2rem 2.5rem; border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        }
        
        .profile-section:last-child { border-bottom: none; }
        
        .section-title {
            display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;
            color: var(--dark); font-size: 1.3rem; font-weight: 600; letter-spacing: -0.3px;
        }
        
        .profile-section p { margin-bottom: 0.8rem; line-height: 1.6; color: #4a5568; letter-spacing: -0.2px; }
        .profile-section strong { color: var(--dark); }
        
        .secret-flag {
            background: linear-gradient(135deg, var(--success) 0%, #38a169 100%);
            color: white; padding: 1.5rem; border-radius: 12px;
            font-family: 'Courier New', monospace; font-weight: 600;
            text-align: center; margin: 1.5rem 0; font-size: 1.1rem;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(52, 199, 89, 0.25);
        }
        
        .warning-note {
            text-align: center; color: #744210;
            background: rgba(250, 240, 137, 0.6); padding: 1rem;
            border-radius: 8px; margin-top: 1rem; font-size: 0.9rem;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            backdrop-filter: var(--glass-blur); -webkit-backdrop-filter: var(--glass-blur);
        }
        
        .educational-section {
            background: rgba(255, 255, 255, 0.5); backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur); border-radius: 16px;
            padding: 2rem; margin: 2rem 2.5rem; border: 0.5px solid var(--ios-border);
        }
        
        .educational-section h3 {
            color: var(--dark); margin-bottom: 1rem; display: flex;
            align-items: center; gap: 0.5rem; font-size: 1.5rem;
            font-weight: 600; letter-spacing: -0.3px;
        }
        
        .educational-content { margin-bottom: 1.5rem; }
        .educational-content p { margin-bottom: 1rem; color: #555; line-height: 1.6; letter-spacing: -0.2px; }
        
        .answer-form { display: flex; gap: 0.5rem; margin-bottom: 1rem; }
        
        .answer-input {
            flex: 1; padding: 1rem; border: 2px solid rgba(0, 0, 0, 0.08);
            border-radius: 12px; font-size: 1rem; background: rgba(255, 255, 255, 0.6);
            font-family: inherit; backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
        }
        
        .answer-input:focus {
            outline: none; border-color: var(--success);
            box-shadow: 0 0 0 4px rgba(52, 199, 89, 0.1); background: white;
        }
        
        .submit-answer-btn {
            padding: 1rem 1.5rem; background: var(--success); color: white;
            border: none; border-radius: 12px; font-weight: 600;
            cursor: pointer; transition: all 0.3s ease; display: flex;
            align-items: center; gap: 0.5rem; box-shadow: 0 4px 12px rgba(52, 199, 89, 0.25);
        }
        
        .submit-answer-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 199, 89, 0.35);
        }
        
        .submit-answer-btn:disabled { background: #a0aec0; cursor: not-allowed; box-shadow: none; }
        
        .feedback {
            padding: 1rem; border-radius: 12px; font-weight: 500;
            display: flex; align-items: center; gap: 0.5rem;
            backdrop-filter: var(--glass-blur); -webkit-backdrop-filter: var(--glass-blur);
        }
        
        .feedback.correct {
            background: rgba(52, 199, 89, 0.15); color: #1e7e34;
            border: 1px solid rgba(52, 199, 89, 0.3);
        }
        
        .feedback.incorrect {
            background: rgba(255, 59, 48, 0.15); color: #c4190c;
            border: 1px solid rgba(255, 59, 48, 0.3);
        }
        
        .hint-container { margin-top: 1rem; }
        
        .hint-btn {
            background: transparent; color: var(--primary); border: 1px solid var(--primary);
            padding: 0.8rem 1.5rem; border-radius: 12px; cursor: pointer;
            font-size: 1rem; transition: all 0.3s ease; font-weight: 500;
            font-family: inherit; display: inline-flex; align-items: center; gap: 0.5rem;
        }
        
        .hint-btn:hover { background: var(--primary); color: white; }
        
        .hint-content {
            display: none; margin-top: 1rem; padding: 1.5rem;
            background: rgba(255, 255, 255, 0.6); border-radius: 12px;
            border: 1px solid var(--ios-border); backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
        }
        
        .hint-content.show { display: block; animation: fadeIn 0.3s ease-out; }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .hint-content p { margin-bottom: 0.5rem; color: #4a5568; line-height: 1.6; }
        
        .flag-reveal {
            background: linear-gradient(135deg, var(--success) 0%, #38a169 100%);
            color: white; padding: 1.5rem; border-radius: 12px;
            text-align: center; margin-top: 1rem; font-family: 'Courier New', monospace;
            font-weight: 600; font-size: 1.1rem; display: flex;
            align-items: center; justify-content: center; gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(52, 199, 89, 0.25);
        }
        
        .back-link {
            text-align: center; padding: 2rem;
            background: rgba(247, 250, 252, 0.6);
            border-top: 1px solid rgba(0, 0, 0, 0.06);
        }
        
        .btn {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.9rem 1.8rem; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white; text-decoration: none; border-radius: 14px;
            font-weight: 600; transition: all 0.3s ease; border: none;
            cursor: pointer; box-shadow: 0 2px 12px rgba(0, 122, 255, 0.25);
            letter-spacing: -0.2px; margin: 0.5rem;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 122, 255, 0.35);
        }
        
        code {
            background: rgba(0, 0, 0, 0.06); padding: 0.2rem 0.4rem;
            border-radius: 6px; font-family: 'Courier New', monospace;
            font-size: 0.9rem; color: var(--dark);
        }
        
        @media (max-width: 768px) {
            body { padding: 1rem; }
            .container { padding: 0; }
            .educational-section { margin-left: 1.5rem; margin-right: 1.5rem; padding: 1.5rem; }
            .answer-form { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <div class="profile-avatar"><i class="fas fa-user-circle"></i></div>
            <h1 class="profile-name"><?= htmlentities($user['username']) ?></h1>
            <p class="profile-subtitle"><?= htmlentities($user['role']) ?></p>
        </div>

        <div class="profile-content">
            <div class="profile-section">
                <h2 class="section-title">
                    <i class="fas fa-user"></i>
                    Profile Information
                </h2>
                <p><strong>Username:</strong> <?= htmlentities($user['username']) ?></p>
                <p><strong>Role:</strong> <?= htmlentities($user['role']) ?></p>
                <p><strong>User ID:</strong> <?= htmlentities($user['id']) ?></p>
                <p><strong>Status:</strong> <span style="color: #48bb78;">Active</span></p>
            </div>

            <div class="profile-section">
                <h2 class="section-title">
                    <i class="fas fa-shield-alt"></i>
                    Security Information
                </h2>
                <div class="secret-flag">
                    <i class="fas fa-flag"></i>
                    <?= htmlentities($user['flag']) ?>
                </div>
                <div class="warning-note">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Security Notice:</strong> This page demonstrates an IDOR vulnerability. Users can access other profiles by modifying the ID parameter.
                </div>
            </div>

            <div class="educational-section">
                <h3><i class="fas fa-graduation-cap"></i> IDOR Challenge</h3>
                
                <div class="educational-content">
                    <p><strong>Current Profile:</strong> You are viewing profile ID <?= $id ?> (<?= htmlentities($user['username']) ?>)</p>
                    <p><strong>Your Mission:</strong> Try accessing other user profiles by changing the ID parameter in the URL. Find all the flags!</p>
                    <p><strong>Challenge:</strong> Enter the flag for the current profile below to complete this part of the challenge.</p>
                </div>

                <form method="POST" id="educationalForm">
                    <div class="answer-form">
                        <input type="text" name="educational_answer" class="answer-input" 
                               placeholder="Enter the flag for <?= htmlentities($user['username']) ?>'s profile" 
                               value="<?= htmlentities($educational_answer) ?>"
                               <?= $educational_correct ? 'disabled' : '' ?>>
                        <button type="submit" name="educational_submit" class="submit-answer-btn"
                                <?= $educational_correct ? 'disabled' : '' ?>>
                            Submit Flag
                        </button>
                    </div>
                    
                    <?php if ($educational_feedback): ?>
                        <div class="feedback <?= $educational_correct ? 'correct' : 'incorrect' ?>">
                            <?= $educational_feedback ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($educational_correct): ?>
                        <div class="flag-reveal">
                            <i class="fas fa-flag"></i> <?= htmlentities($user['flag']) ?>
                        </div>
                    <?php endif; ?>
                </form>

                <div class="hint-container">
                    <button type="button" class="hint-btn" onclick="toggleHint()">
                        <i class="fas fa-lightbulb"></i> Need a hint?
                    </button>
                    <div class="hint-content" id="hintContent">
                        <p><strong>Hint 1:</strong> Try changing the URL parameter to <code>profile.php?id=1</code>, <code>profile.php?id=2</code>, or <code>profile.php?id=3</code>.</p>
                        <p><strong>Hint 2:</strong> Each profile has a different flag - admin, sunil, and KAMAL each have their own secrets.</p>
                        <p><strong>Hint 3:</strong> The flag format is FLAG{...} - enter the exact flag for the profile you're currently viewing.</p>
                    </div>
                </div>
            </div>

            <div class="back-link">
                <a href="index.php" class="btn">
                    <i class="fas fa-home"></i> Back to Home
                </a>
                <a href="login.php" class="btn">
                    <i class="fas fa-sign-in-alt"></i> Login Page
                </a>
            </div>
        </div>
    </div>

    <script>
        function toggleHint() {
            const hintContent = document.getElementById('hintContent');
            hintContent.classList.toggle('show');
        }

        // Mark IDOR challenge complete when educational form is successfully submitted
        document.addEventListener('DOMContentLoaded', function() {
            const educationalForm = document.getElementById('educationalForm');
            if (educationalForm) {
                educationalForm.addEventListener('submit', function(e) {
                    const answerInput = this.querySelector('input[name="educational_answer"]');
                    const currentId = <?= $id ?>;
                    
                    // Define correct flags for each profile
                    const flags = {
                        1: 'FLAG{ADMIN_PRIVILEGES}',
                        2: 'FLAG{SUNIL_SECRETS}', 
                        3: 'FLAG{KAMAL_CONFIDENTIAL}'
                    };
                    
                    if (answerInput && flags[currentId] && answerInput.value.toUpperCase() === flags[currentId].toUpperCase()) {
                        // Mark IDOR challenge complete
                        if (typeof markChallengeComplete === 'function') {
                            setTimeout(() => markChallengeComplete('idor'), 1000);
                        } else {
                            // Fallback methods
                            sessionStorage.setItem('challenge_completed', 'idor');
                            
                            // Update in memory directly
                            try {
                                const stored = localStorage.getItem('nebula_progress');
                                const progress = stored ? JSON.parse(stored) : {
                                    sqli: false, xss: false, idor: false, cmdi: false
                                };
                                progress.idor = true;
                                localStorage.setItem('nebula_progress', JSON.stringify(progress));
                            } catch (e) {
                                console.log('LocalStorage not available');
                            }
                        }
                    }
                });
            }
            
            // Also mark complete if accessing admin profile (ID 1) via IDOR
            const currentId = <?= $id ?>;
            if (currentId === 1) {
                // Check if we got here via IDOR (not SQL injection)
                if (!window.location.pathname.includes('admin.php')) {
                    setTimeout(() => {
                        if (typeof markChallengeComplete === 'function') {
                            markChallengeComplete('idor');
                        } else {
                            sessionStorage.setItem('challenge_completed', 'idor');
                        }
                    }, 1000);
                }
            }
        });
    </script>
</body>
</html>