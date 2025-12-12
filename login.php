<?php
// login.php - SIMULATED VERSION (No actual database queries)
$error_msg = "";
$success_msg = "";

// Initialize educational variables
$educational_answer = "";
$educational_feedback = "";
$educational_correct = false;

// Simulated user database
$simulated_users = [
    'admin' => 'admin123',
    'sunil' => 'sunil123', 
    'kamal' => 'kamal123'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if it's the educational form submission first
    if (isset($_POST['educational_submit'])) {
        $educational_answer = trim($_POST['educational_answer']);
        $correct_answer = "FLAG{SQLI_INJ3CTION}";
        
        if (strtoupper($educational_answer) === strtoupper($correct_answer)) {
            $educational_feedback = "✅ Correct! You've successfully exploited the SQL injection vulnerability!";
            $educational_correct = true;
        } else {
            $educational_feedback = "❌ Incorrect. Try using the SQL injection payload and check the admin panel for the flag.";
            $educational_correct = false;
        }
    } else {
        // Regular login form submission (SIMULATED)
        $user = isset($_POST['username']) ? $_POST['username'] : '';
        $pass = isset($_POST['password']) ? $_POST['password'] : '';

        // Check for SQL injection patterns (SIMULATED)
        if (isSqlInjectionAttempt($user) || isSqlInjectionAttempt($pass)) {
            // SQL Injection detected - redirect to admin.php
            header("Location: admin.php");
            exit();
        }

        // SIMULATED: Check credentials against simulated database
        if (isset($simulated_users[$user]) && $simulated_users[$user] === $pass) {
            // Valid credentials - redirect to profile
            $user_id = array_search($user, array_keys($simulated_users)) + 1;
            header("Location: profile.php?id=" . $user_id);
            exit();
        } else {
            $error_msg = "Invalid credentials. Please try again.";
        }
    }
}

function isSqlInjectionAttempt($input) {
    if (empty($input)) return false;
    
    $sqlKeywords = [
        "' OR '1'='1", "' OR 1=1 --", "' OR '1'='1' --", 
        "OR 1=1", "admin' --", "' OR 'a'='a", "' OR 1=1#",
        "admin' #", "' UNION SELECT", "'; DROP", "' OR 'x'='x",
        "' OR 1=1/*", "admin'/*", "' OR '1'", "1' OR '1'='1",
        "' or '1'='1", "' or 1=1 --", "or 1=1", "--", "#", "/*",
        "union select", "drop table", "insert into", "update set",
        "delete from", "sleep(", "waitfor delay", "benchmark(",
        "' OR '1", "' OR 1", "OR '1'='1'", "1=1", "'='"
    ];
    
    $input = strtolower($input);
    
    foreach ($sqlKeywords as $keyword) {
        if (stripos($input, $keyword) !== false) {
            return true;
        }
    }
    
    // Also check for common SQL injection patterns
    if (preg_match('/\'\s*(OR|AND)\s*[\'"]?\s*[\d\w]\s*[\'"]?\s*=\s*[\'"]?\s*[\d\w]/i', $input)) {
        return true;
    }
    
    if (preg_match('/\'\s*--\s*$/', $input) || preg_match('/\'\s*#\s*$/', $input)) {
        return true;
    }
    
    return false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Nebula Security Labs</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #007aff;
            --primary-dark: #0051d5;
            --secondary: #5856d6;
            --success: #34c759;
            --danger: #ff3b30;
            --warning: #ff9500;
            --dark: #1d1d1f;
            --light: #f5f5f7;
            --ios-glass: rgba(255, 255, 255, 0.25);
            --ios-border: rgba(255, 255, 255, 0.3);
            --ios-highlight: rgba(255, 255, 255, 0.4);
            --glass-blur: saturate(180%) blur(20px);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Segoe UI', sans-serif;
            background: 
                radial-gradient(circle at 20% 80%, rgba(0, 122, 255, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(88, 86, 214, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(175, 82, 222, 0.12) 0%, transparent 50%),
                linear-gradient(135deg, #f5f5f7 0%, #e8e8ed 50%, #f5f5f7 100%);
            background-size: 400% 400%, 200% 200%, 300% 300%, 400% 400%;
            animation: gradientShift 20s ease infinite;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow-x: hidden;
        }

        @keyframes gradientShift {
            0%, 100% { 
                background-position: 0% 50%, 0% 0%, 0% 0%, 0% 50%; 
            }
            50% { 
                background-position: 100% 50%, 100% 100%, 50% 50%, 100% 50%; 
            }
        }

      

        

        @keyframes floatOrb {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.3;
            }
            50% {
                transform: translate(50px, -50px) scale(1.1);
                opacity: 0.4;
            }
        }

        .login-container {
            background: var(--ios-glass);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            padding: 3rem;
            border-radius: 24px;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.08),
                0 1px 2px rgba(0, 0, 0, 0.04),
                inset 0 1px 0 var(--ios-highlight);
            width: 100%;
            max-width: 520px;
            position: relative;
            z-index: 1;
            border: 0.5px solid var(--ios-border);
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

       

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-header h1 {
            color: var(--dark);
            margin-bottom: 0.5rem;
            font-size: 2rem;
            font-weight: 600;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .login-header p {
            color: #666;
            font-size: 0.95rem;
            letter-spacing: -0.2px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--dark);
            font-weight: 500;
            font-size: 0.95rem;
            letter-spacing: -0.2px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            pointer-events: none;
            font-size: 1rem;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 2px solid rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            font-family: inherit;
            letter-spacing: -0.2px;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(0, 122, 255, 0.1);
        }

        .login-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
            letter-spacing: -0.2px;
            box-shadow: 0 4px 12px rgba(0, 122, 255, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 122, 255, 0.35);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .alert {
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert i {
            margin-right: 0.5rem;
        }

        .alert-error {
            background: rgba(255, 59, 48, 0.15);
            color: #c4190c;
            border: 1px solid rgba(255, 59, 48, 0.3);
        }

        .alert-success {
            background: rgba(52, 199, 89, 0.15);
            color: #1e7e34;
            border: 1px solid rgba(52, 199, 89, 0.3);
        }

        .hint-box {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 1px solid var(--ios-border);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .hint-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .hint-box h4 {
            color: var(--dark);
            margin-bottom: 1rem;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .hint-box code {
            background: rgba(0, 0, 0, 0.06);
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            color: var(--dark);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .hint-box p {
            font-size: 0.9rem;
            color: #4a5568;
            margin-bottom: 0.5rem;
            line-height: 1.6;
            letter-spacing: -0.2px;
        }

        .hint-box p:last-child {
            margin-bottom: 0;
        }

        .back-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .back-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.5rem;
            border: 2px solid var(--primary);
            border-radius: 12px;
            transition: all 0.3s ease;
            letter-spacing: -0.2px;
        }

        .back-link a:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 122, 255, 0.3);
        }

        /* Educational Section Styles */
        .educational-section {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border-radius: 16px;
            padding: 2rem;
            margin-top: 2rem;
            border-left: 4px solid var(--primary);
            border: 0.5px solid var(--ios-border);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .educational-section h3 {
            color: var(--dark);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.3px;
        }

        .educational-section h3 i {
            color: var(--primary);
        }

        .educational-content {
            margin-bottom: 1.5rem;
        }

        .educational-content p {
            margin-bottom: 1rem;
            color: #555;
            line-height: 1.7;
            letter-spacing: -0.2px;
        }

        .answer-form {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .answer-input {
            flex: 1;
            padding: 1rem;
            border: 2px solid rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            font-family: inherit;
        }

        .answer-input:focus {
            outline: none;
            border-color: var(--success);
            box-shadow: 0 0 0 4px rgba(52, 199, 89, 0.1);
        }

        .submit-answer-btn {
            padding: 1rem 1.5rem;
            background: var(--success);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(52, 199, 89, 0.25);
        }

        .submit-answer-btn:hover {
            background: #2d9c4b;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 199, 89, 0.35);
        }

        .submit-answer-btn:disabled {
            background: #a0aec0;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .feedback {
            padding: 1rem;
            border-radius: 12px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            animation: slideDown 0.3s ease-out;
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
        }

        .feedback.correct {
            background: rgba(52, 199, 89, 0.15);
            color: #1e7e34;
            border: 1px solid rgba(52, 199, 89, 0.3);
        }

        .feedback.incorrect {
            background: rgba(255, 59, 48, 0.15);
            color: #c4190c;
            border: 1px solid rgba(255, 59, 48, 0.3);
        }

        .hint-container {
            margin-top: 1rem;
        }

        .hint-btn {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
            padding: 0.8rem 1.5rem;
            border-radius: 12px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            font-family: inherit;
        }

        .hint-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 122, 255, 0.3);
        }

        .hint-content {
            display: none;
            margin-top: 1rem;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 12px;
            border: 1px solid var(--ios-border);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
        }

        .hint-content.show {
            display: block;
            animation: slideDown 0.3s ease-out;
        }

        .hint-content p {
            margin-bottom: 0.8rem;
            color: #4a5568;
            line-height: 1.6;
            letter-spacing: -0.2px;
        }

        .hint-content p:last-child {
            margin-bottom: 0;
        }

        .hint-content code {
            background: rgba(0, 0, 0, 0.06);
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            color: var(--dark);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .flag-reveal {
            background: linear-gradient(135deg, var(--success) 0%, #38a169 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            margin-top: 1rem;
            font-family: 'Courier New', monospace;
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 8px 25px rgba(52, 199, 89, 0.4);
            animation: pulse 2s infinite;
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
        }

        @keyframes pulse {
            0%, 100% { 
                transform: scale(1); 
            }
            50% { 
                transform: scale(1.02); 
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 1rem;
            }

            .login-container {
                padding: 2rem 1.5rem;
            }
            
            .answer-form {
                flex-direction: column;
            }

            .educational-section {
                padding: 1.5rem;
            }

            .login-header h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
   

    <div class="login-container">
      
        
        <div class="login-header">
            <h1>
                </i>Login
            </h1>
            <p>Access your Nebula account</p>
        </div>

        <?php if ($error_msg): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <?= htmlentities($error_msg) ?>
        </div>
        <?php endif; ?>

        <form method="POST" id="loginForm">
            <div class="form-group">
                <label class="form-label" for="username">Username</label>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="text" id="username" name="username" class="form-input" 
                           placeholder="Enter your username" 
                           value="<?= isset($_POST['username']) && !isset($_POST['educational_submit']) ? htmlentities($_POST['username']) : '' ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" id="password" name="password" class="form-input" 
                           placeholder="Enter your password">
                </div>
            </div>

            <button type="submit" class="login-btn">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>
        </form>

   

        <!-- Educational Section -->
        <div class="educational-section">
            <h3>
                <i class="fas fa-graduation-cap"></i> SQL Injection Challenge
            </h3>
            
            <div class="educational-content">
                <p><strong>About SQL Injection:</strong> SQL Injection occurs when an attacker can insert malicious SQL code into a query, allowing them to manipulate the database and potentially bypass authentication.</p>
                
                <p><strong>Your Mission:</strong> Use SQL injection to bypass the login above. When successful, you'll be redirected to an admin panel containing a flag.</p>
                
                <p><strong>Challenge:</strong> Enter the flag you find in the admin panel below to complete this challenge.</p>
            </div>

            <form method="POST" id="educationalForm">
                <div class="answer-form">
                    <input type="text" name="educational_answer" class="answer-input" 
                           placeholder="Enter the flag (FLAG{...})" 
                           value="<?= htmlentities($educational_answer) ?>"
                           <?= $educational_correct ? 'disabled' : '' ?>>
                    <button type="submit" name="educational_submit" class="submit-answer-btn"
                            <?= $educational_correct ? 'disabled' : '' ?>>
                        <i class="fas fa-flag"></i>
                        Submit Flag
                    </button>
                </div>
                
                <?php if ($educational_feedback): ?>
                    <div class="feedback <?= $educational_correct ? 'correct' : 'incorrect' ?>">
                        <i class="fas <?= $educational_correct ? 'fa-check-circle' : 'fa-times-circle' ?>"></i>
                        <?= htmlentities($educational_feedback) ?>
                    </div>
                <?php endif; ?>

                <?php if ($educational_correct): ?>
                    <div class="flag-reveal">
                        <i class="fas fa-flag"></i> FLAG{SQLI_INJ3CTION}
                    </div>
                <?php endif; ?>
            </form>

            <div class="hint-container">
                <button type="button" class="hint-btn" onclick="toggleHint()">
                    <i class="fas fa-lightbulb"></i> Need a hint?
                </button>
                <div class="hint-content" id="hintContent">
                    <p><strong>Hint 1:</strong> Try using <code>' OR '1'='1</code> in both username and password fields.</p>
                    <p><strong>Hint 2:</strong> After successful injection, you'll be redirected to admin.php where you can find the flag.</p>
                    <p><strong>Hint 3:</strong> The flag format is FLAG{...} - look for it on the admin page after SQL injection.</p>
                </div>
            </div>
        </div>

        <div class="back-link">
            <a href="index.php">
                <i class="fas fa-arrow-left"></i>
                Back to Home
            </a>
        </div>
    </div>

    <script>
        function toggleHint() {
            const hintContent = document.getElementById('hintContent');
            hintContent.classList.toggle('show');
        }

        // Clear login form when educational form is submitted
        document.getElementById('educationalForm').addEventListener('submit', function() {
            document.getElementById('loginForm').reset();
        });

        // Clear educational form when login form is submitted  
        document.getElementById('loginForm').addEventListener('submit', function() {
            document.getElementById('educationalForm').reset();
        });
    </script>
</body>
</html>