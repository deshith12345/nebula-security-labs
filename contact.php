<?php
// contact.php - XSS demonstration version (No sessions)

// Educational variables
$educational_answer = "";
$educational_feedback = "";
$educational_correct = false;
$flag = "FLAG{XSS_4L3RT}";

// Simple state variables (no sessions)
$messages = [];
$xss_triggered = false;
$challenge_completed = false;
$show_success = false;
$show_flag_popup = false;

// Handle POSTs
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Educational form submitted
    if (isset($_POST['educational_submit'])) {
        $educational_answer = trim($_POST['educational_answer'] ?? '');
        // Normalize for comparison
        if (strcasecmp($educational_answer, $flag) === 0) {
            $educational_feedback = "Correct! You've successfully demonstrated the XSS vulnerability!";
            $educational_correct = true;
            $challenge_completed = true;
            $show_success = true;
        } else {
            $educational_feedback = "❌ Incorrect. Try using an XSS payload like &lt;script&gt;alert('XSS')&lt;/script&gt;";
            $educational_correct = false;
        }
    } else {
        // Message form submission
        $name = trim($_POST['name'] ?? '');
        $msg  = trim($_POST['message'] ?? '');

        // Basic server-side limits
        $name = substr($name, 0, 100);
        $msg  = substr($msg, 0, 2000);

        // Store message in array
        $messages[] = [
            'name' => $name ?: 'Anonymous',
            'message' => $msg,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Keep only last 5 messages
        if (count($messages) > 5) {
            $messages = array_slice($messages, -5);
        }

        // Check if message contains XSS patterns
        if (containsXSSPayload($msg)) {
            $xss_triggered = true;
            $show_flag_popup = true;
        }
    }
}

// Reset challenge if requested
if (isset($_GET['reset'])) {
    $messages = [];
    $xss_triggered = false;
    $challenge_completed = false;
    $show_success = false;
    $show_flag_popup = false;
    $educational_feedback = "";
    $educational_answer = "";
}

function containsXSSPayload($input) {
    $xssPatterns = [
        '/<script/i',
        '/javascript:/i',
        '/onload=/i',
        '/onerror=/i',
        '/onclick=/i',
        '/alert\(/i',
        '/confirm\(/i',
        '/prompt\(/i',
        '/document\./i',
        '/window\./i',
        '/eval\(/i',
        '/xss/i'
    ];
    
    foreach ($xssPatterns as $pattern) {
        if (preg_match($pattern, $input)) {
            return true;
        }
    }
    return false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Forum - Nebula Security Labs</title>
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%, 0% 0%, 0% 50%; }
            50% { background-position: 100% 50%, 100% 100%, 100% 50%; }
        }

        .forum-container {
            background: var(--ios-glass);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            padding: 3rem;
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08), inset 0 1px 0 var(--ios-highlight);
            width: 100%;
            max-width: 900px;
            position: relative;
            border: 0.5px solid var(--ios-border);
        }

        .forum-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .forum-header h1 {
            color: var(--dark);
            margin-bottom: 0.5rem;
            font-size: 2.2rem;
            font-weight: 600;
            letter-spacing: -0.5px;
        }

        .forum-header p {
            color: #666;
            font-size: 1rem;
            letter-spacing: -0.2px;
        }

        .form-section {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            padding: 2rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            border: 0.5px solid var(--ios-border);
        }

        .form-section h2 {
            color: var(--dark);
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            letter-spacing: -0.3px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--dark);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
            letter-spacing: -0.2px;
        }

        .form-input, .form-textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.6);
            font-family: inherit;
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
        }

        .form-input:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(0, 122, 255, 0.1);
            background: white;
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }

        .submit-btn {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 122, 255, 0.25);
            letter-spacing: -0.2px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 122, 255, 0.35);
        }

        .reset-btn {
            background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(237, 137, 54, 0.25);
        }

        .reset-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(237, 137, 54, 0.35);
        }

        .messages-section {
            background: var(--ios-glass);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
            border: 0.5px solid var(--ios-border);
        }

        .messages-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
        }

        .messages-container {
            padding: 1.5rem;
            max-height: 400px;
            overflow-y: auto;
        }

        .message-item {
            padding: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            transition: background-color 0.3s ease;
        }

        .message-item:last-child {
            border-bottom: none;
        }

        .message-item:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .message-author {
            font-weight: 600;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .message-time {
            color: #718096;
            font-size: 0.9rem;
        }

        .message-content {
            color: #4a5568;
            line-height: 1.6;
            padding-left: 0.5rem;
        }

        .educational-section {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border-radius: 16px;
            padding: 2rem;
            border: 0.5px solid var(--ios-border);
        }

        .educational-section h3 {
            color: var(--dark);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: -0.3px;
        }

        .educational-content {
            margin-bottom: 1.5rem;
        }

        .educational-content p {
            margin-bottom: 1rem;
            color: #555;
            line-height: 1.6;
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
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
        }

        .answer-input:focus {
            outline: none;
            border-color: var(--success);
            box-shadow: 0 0 0 4px rgba(52, 199, 89, 0.1);
            background: white;
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
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 199, 89, 0.35);
        }

        .feedback {
            padding: 1rem;
            border-radius: 12px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
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
            border: 1px solid var(--primary);
            padding: 0.8rem 1.5rem;
            border-radius: 12px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            font-family: inherit;
        }

        .hint-btn:hover {
            background: var(--primary);
            color: white;
        }

        .hint-content {
            display: none;
            margin-top: 1rem;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 12px;
            border: 1px solid var(--ios-border);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
        }

        .hint-content.show {
            display: block;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
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
            box-shadow: 0 4px 12px rgba(52, 199, 89, 0.25);
        }

        .xss-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: var(--ios-glass);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            padding: 2rem;
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3), inset 0 1px 0 var(--ios-highlight);
            z-index: 1000;
            text-align: center;
            display: none;
            max-width: 90%;
            width: 400px;
            border: 0.5px solid var(--ios-border);
        }

        .xss-popup.show {
            display: block;
            animation: popup 0.3s ease-out;
        }

        @keyframes popup {
            from { opacity: 0; transform: translate(-50%, -60%); }
            to { opacity: 1; transform: translate(-50%, -50%); }
        }

        .xss-popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            display: none;
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        .xss-popup-overlay.show {
            display: block;
        }

        .xss-popup h3 {
            color: var(--dark);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-weight: 600;
        }

        .xss-popup .flag {
            background: rgba(255, 255, 255, 0.6);
            padding: 1rem;
            border-radius: 12px;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            margin: 1rem 0;
            border: 2px dashed var(--primary);
            font-size: 1.1rem;
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
        }

        .xss-popup-close {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 12px;
            cursor: pointer;
            margin-top: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 122, 255, 0.25);
        }

        .xss-popup-close:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 122, 255, 0.35);
        }

        .back-link {
            text-align: center;
            margin-top: 2rem;
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
        }

        code {
            background: rgba(0, 0, 0, 0.06);
            padding: 0.2rem 0.4rem;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            color: var(--dark);
        }

        @media (max-width: 768px) {
            body { padding: 1rem; }
            .forum-container { padding: 2rem 1.5rem; }
            .answer-form { flex-direction: column; }
            .message-header { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
            .xss-popup { width: 95%; padding: 1.5rem; }
        }
    </style>
</head>
<body>
    <?php if ($show_flag_popup && !$challenge_completed): ?>
    <div class="xss-popup-overlay show" id="xssOverlay"></div>
    <div class="xss-popup show" id="xssPopup">
        <h3><i class="fas fa-bug"></i> XSS Vulnerability Detected!</h3>
        <p>You've successfully triggered an XSS attack! Here's your flag:</p>
        <div class="flag"><?= htmlspecialchars($flag, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div>
        <p>Enter this flag in the educational section below to complete the challenge.</p>
        <button class="xss-popup-close" onclick="closeXSSPopup()">Close</button>
    </div>
    <?php endif; ?>

    <div class="forum-container">
        <div class="forum-header">
            <h1><i class="fas fa-comments"></i> Community Forum</h1>
            <p>Share your thoughts and connect with the community</p>
        </div>

        <div class="form-section">
            <h2><i class="fas fa-plus-circle"></i> Post New Message</h2>
            
            <form method="POST" id="messageForm" autocomplete="off">
                <div class="form-group">
                    <label class="form-label" for="name">
                        <i class="fas fa-user"></i> Your Name
                    </label>
                    <input type="text" id="name" name="name" class="form-input" placeholder="Enter your name (optional)" value="<?= htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="message">
                        <i class="fas fa-comment"></i> Message
                    </label>
                    <textarea id="message" name="message" class="form-textarea" placeholder="Share your thoughts..."><?= htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>

                <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-paper-plane"></i> Post Message
                    </button>
                    <button type="button" class="hint-btn" onclick="toggleHint()">
                        <i class="fas fa-lightbulb"></i> Need a hint?
                    </button>
                </div>

                <div class="hint-content" id="hintContent">
                    <p><strong>XSS Payload Examples:</strong></p>
                    <p><code>&lt;script&gt;alert('XSS')&lt;/script&gt;</code></p>
                    <p><code>&lt;script&gt;alert('XSS Vulnerability!')&lt;/script&gt;</code></p>
                    <p><code>&lt;img src=x onerror=alert('XSS')&gt;</code></p>
                    <p>Try any of these payloads in the message field to trigger the XSS popup!</p>
                </div>
            </form>
        </div>

        <div class="messages-section">
            <div class="messages-header">
                <h2><i class="fas fa-list"></i> Recent Messages (<?= count($messages) ?>)</h2>
            </div>
            
            <div class="messages-container">
                <?php if (!empty($messages)): ?>
                    <?php foreach (array_reverse($messages) as $message): ?>
                    <div class="message-item">
                        <div class="message-header">
                            <div class="message-author">
                                <i class="fas fa-user-circle"></i>
                                <?= htmlspecialchars($message['name'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>
                            </div>
                            <div class="message-time">
                                <?= htmlspecialchars($message['created_at'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>
                            </div>
                        </div>
                        <div class="message-content">
                            <!-- VULNERABLE: Intentionally not escaped to demonstrate XSS -->
                            <?= $message['message'] ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="message-item">
                        <div class="message-header">
                            <div class="message-author"><i class="fas fa-info-circle"></i> System</div>
                            <div class="message-time">—</div>
                        </div>
                        <div class="message-content">
                            No messages yet. Be the first to post!
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="educational-section">
            <h3><i class="fas fa-graduation-cap"></i> XSS Challenge</h3>
            
            <div class="educational-content">
                <p><strong>About XSS (Cross-Site Scripting):</strong> XSS occurs when an attacker can inject malicious scripts into web pages viewed by other users. Stored XSS persists and affects all users who view the compromised page.</p>
                
                <p><strong>Your Mission:</strong> Use XSS to inject a script that will display a popup with the flag. Try posting a message containing JavaScript code.</p>
                
                <p><strong>Challenge:</strong> Enter the flag that appears in the XSS popup below to complete this challenge.</p>
            </div>

            <form method="POST" id="educationalForm">
                <input type="hidden" name="educational_submit" value="1">
                <div class="answer-form">
                    <input type="text" name="educational_answer" class="answer-input" 
                           placeholder="Enter the flag (FLAG{...})" 
                           value="<?= htmlspecialchars($educational_answer, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
                    <button type="submit" class="submit-answer-btn">
                        <i class="fas fa-flag"></i>
                        Submit Flag
                    </button>
                </div>
                
                <?php if ($educational_feedback): ?>
                    <div class="feedback <?= $educational_correct ? 'correct' : 'incorrect' ?>">
                        <i class="fas <?= $educational_correct ? 'fa-check-circle' : 'fa-times-circle' ?>"></i>
                        <?= htmlspecialchars($educational_feedback, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>
                    </div>
                <?php endif; ?>

                <?php if ($show_success): ?>
                    <div class="flag-reveal">
                        <i class="fas fa-flag"></i> <?= htmlspecialchars($flag, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>
                    </div>
                <?php endif; ?>
            </form>

            <?php if ($show_success): ?>
            <div style="margin-top: 1rem;">
                <a href="?reset=true" class="reset-btn">
                    <i class="fas fa-redo"></i> Try Again
                </a>
            </div>
            <?php endif; ?>
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

        function closeXSSPopup() {
            document.getElementById('xssOverlay').classList.remove('show');
            document.getElementById('xssPopup').classList.remove('show');
        }

        // Clear forms when the other is submitted
        document.getElementById('educationalForm').addEventListener('submit', function() {
            document.getElementById('messageForm').reset();
        });

        document.getElementById('messageForm').addEventListener('submit', function() {
            document.getElementById('educationalForm').reset();
        });

        // Mark XSS challenge complete when educational form is successfully submitted
        document.addEventListener('DOMContentLoaded', function() {
            const educationalForm = document.getElementById('educationalForm');
            if (educationalForm) {
                educationalForm.addEventListener('submit', function(e) {
                    const answerInput = this.querySelector('input[name="educational_answer"]');
                    if (answerInput && answerInput.value.toUpperCase() === 'FLAG{XSS_4L3RT}') {
                        // Mark challenge complete
                        if (typeof markChallengeComplete === 'function') {
                            setTimeout(() => markChallengeComplete('xss'), 1000);
                        } else {
                            // Fallback methods
                            sessionStorage.setItem('challenge_completed', 'xss');
                            
                            // Update in memory directly
                            try {
                                const stored = localStorage.getItem('nebula_progress');
                                const progress = stored ? JSON.parse(stored) : {
                                    sqli: false, xss: false, idor: false, cmdi: false
                                };
                                progress.xss = true;
                                localStorage.setItem('nebula_progress', JSON.stringify(progress));
                            } catch (e) {
                                console.log('LocalStorage not available');
                            }
                        }
                    }
                });
            }
            
            // Also mark complete if XSS popup is shown
            <?php if ($show_flag_popup): ?>
            setTimeout(() => {
                if (typeof markChallengeComplete === 'function') {
                    markChallengeComplete('xss');
                } else {
                    sessionStorage.setItem('challenge_completed', 'xss');
                }
            }, 2000);
            <?php endif; ?>
        });

        // Close popup with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeXSSPopup();
            }
        });

        // Close popup when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('xss-popup-overlay')) {
                closeXSSPopup();
            }
        });

        // Auto-execute any XSS payloads in messages (for demonstration)
        document.addEventListener('DOMContentLoaded', function() {
            // This is intentionally vulnerable to demonstrate XSS
            const messageContents = document.querySelectorAll('.message-content');
            messageContents.forEach(content => {
                // If content contains script tags, they will execute
                // This simulates the real XSS vulnerability
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = content.innerHTML;
                content.innerHTML = tempDiv.innerHTML;
            });
        });

        // Auto-scroll to educational section if there's feedback
        <?php if ($educational_feedback): ?>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.educational-section').scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        });
        <?php endif; ?>
    </script>
</body>
</html>