<?php
// ping.php - SIMULATED Command Injection Vulnerability Challenge
// No actual system commands used - safe for shared hosting

// Educational variables
$educational_answer = "";
$educational_feedback = "";
$educational_correct = false;
$flag = "FLAG{CMD_INJ3CT10N}"; // This is the actual flag

$target = "";
$result = "";
$vulnerability_triggered = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Educational form submission
    if (isset($_POST['educational_submit'])) {
        $educational_answer = trim($_POST['educational_answer'] ?? '');
        if (strcasecmp($educational_answer, $flag) === 0) {
            $educational_feedback = "✅ Correct! You've successfully demonstrated command injection!";
            $educational_correct = true;
        } else {
            $educational_feedback = "❌ Incorrect. Try using command injection to read the flag file.";
            $educational_correct = false;
        }
    } else {
        // Ping form submission
        $target = trim($_POST['target'] ?? '');
        
        if (!empty($target)) {
            // SIMULATED ping command (no actual system calls)
            $result = "PING {$target} ({$target}): 56 data bytes\n";
            $result .= "64 bytes from {$target}: icmp_seq=0 ttl=64 time=1.234 ms\n";
            $result .= "64 bytes from {$target}: icmp_seq=1 ttl=64 time=1.123 ms\n";
            $result .= "64 bytes from {$target}: icmp_seq=2 ttl=64 time=1.345 ms\n\n";
            $result .= "--- {$target} ping statistics ---\n";
            $result .= "3 packets transmitted, 3 packets received, 0.0% packet loss\n";
            $result .= "round-trip min/avg/max/stddev = 1.123/1.234/1.345/0.098 ms\n";
            
            // Check if command injection was attempted
            if (containsCommandInjection($target)) {
                $vulnerability_triggered = true;
                
                // Simulate command execution based on user input
                if (strpos($target, 'flag.txt') !== false) {
                    $result .= "\n\n--- flag.txt CONTENT ---\n" . $flag . "\n--- END FILE ---";
                }
                elseif (strpos($target, '/etc/passwd') !== false || strpos($target, 'etc/passwd') !== false) {
                    $result .= "\n\n--- /etc/passwd CONTENT ---\n" . 
                              "root:x:0:0:root:/root:/bin/bash\n" .
                              "daemon:x:1:1:daemon:/usr/sbin:/usr/sbin/nologin\n" .
                              "bin:x:2:2:bin:/bin:/usr/sbin/nologin\n" .
                              "sys:x:3:3:sys:/dev:/usr/sbin/nologin\n" .
                              "sync:x:4:65534:sync:/bin:/bin/sync\n" .
                              "--- END FILE ---";
                }
                elseif (strpos($target, 'ls') !== false || strpos($target, 'dir') !== false) {
                    $result .= "\n\n--- DIRECTORY LISTING ---\n" .
                              "total 128\n" .
                              "drwxr-xr-x  12 root root  4096 Dec 15 10:30 .\n" .
                              "drwxr-xr-x  12 root root  4096 Dec 15 10:30 ..\n" .
                              "-rw-r--r--   1 root root   310 Dec 15 10:25 flag.txt\n" .
                              "-rw-r--r--   1 root root  1824 Dec 15 10:25 index.php\n" .
                              "-rw-r--r--   1 root root  4521 Dec 15 10:25 login.php\n" .
                              "-rw-r--r--   1 root root  8921 Dec 15 10:25 profile.php\n" .
                              "-rw-r--r--   1 root root  7512 Dec 15 10:25 contact.php\n" .
                              "-rw-r--r--   1 root root  1024 Dec 15 10:25 ping.php\n" .
                              "--- END LISTING ---";
                }
                elseif (strpos($target, 'whoami') !== false || strpos($target, 'id') !== false) {
                    $result .= "\n\n--- USER INFORMATION ---\n" .
                              "uid=1000(www-data) gid=1000(www-data) groups=1000(www-data)\n" .
                              "--- END INFO ---";
                }
                elseif (strpos($target, 'pwd') !== false) {
                    $result .= "\n\n--- CURRENT DIRECTORY ---\n" .
                              "/var/www/html\n" .
                              "--- END DIRECTORY ---";
                }
            }
        }
    }
}

function containsCommandInjection($input) {
    $injectionPatterns = [
        ';', '&', '|', '`', '$', '(', ')', '<', '>', 
        'cat', 'ls', 'dir', 'echo', 'whoami', 'id', 'pwd',
        'flag.txt', '/etc/passwd', 'etc/passwd'
    ];
    
    foreach ($injectionPatterns as $pattern) {
        if (stripos($input, $pattern) !== false) {
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
    <title>Network Diagnostics - Nebula Security Labs</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #007aff;
            --secondary: #5856d6;
            --success: #34c759;
            --danger: #ff3b30;
            --dark: #1d1d1f;
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
        }

        @keyframes gradientShift {
            0%, 100% { 
                background-position: 0% 50%, 0% 0%, 0% 0%, 0% 50%; 
            }
            50% { 
                background-position: 100% 50%, 100% 100%, 50% 50%, 100% 50%; 
            }
        }

        .container {
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
            max-width: 900px;
            position: relative;
            border: 0.5px solid var(--ios-border);
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            color: var(--dark);
            margin-bottom: 0.5rem;
            font-size: 2.2rem;
            font-weight: 600;
            letter-spacing: -0.5px;
        }

        .header p {
            color: #666;
            font-size: 1rem;
            letter-spacing: -0.2px;
        }

        .warning-banner {
            background: linear-gradient(135deg, var(--danger) 0%, #e53e3e 100%);
            color: white;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            text-align: center;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(255, 59, 48, 0.25);
        }

        .tool-section {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            padding: 2rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            border: 0.5px solid var(--ios-border);
        }

        .tool-section h2 {
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

        .form-input {
            width: 100%;
            padding: 1rem;
            border: 2px solid rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.6);
            font-family: 'Courier New', monospace;
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(0, 122, 255, 0.1);
            background: white;
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
        }

        .hint-content.show {
            display: block;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .result-section {
            background: var(--ios-glass);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
            border: 0.5px solid var(--ios-border);
        }

        .result-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
        }

        .result-content {
            padding: 1.5rem;
            max-height: 300px;
            overflow-y: auto;
            font-family: 'Courier New', monospace;
            background: #1a1a1a;
            color: #00ff00;
            white-space: pre-wrap;
            font-size: 0.9rem;
            line-height: 1.5;
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
            line-height: 1.5;
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
            font-family: inherit;
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

        .submit-answer-btn:disabled {
            background: #a0aec0;
            cursor: not-allowed;
            box-shadow: none;
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

        .command-hints {
            background: rgba(52, 199, 89, 0.1);
            border: 1px solid rgba(52, 199, 89, 0.3);
            border-radius: 12px;
            padding: 1rem;
            margin-top: 1rem;
        }

        .command-hints h4 {
            color: #1e7e34;
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }

        .command-hints p {
            margin-bottom: 0.5rem;
            color: #2d3748;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            .container {
                padding: 2rem 1.5rem;
            }
            
            .answer-form {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-network-wired"></i> Network Diagnostics</h1>
            <p>Test network connectivity and diagnose connection issues</p>
        </div>

        <?php if ($vulnerability_triggered): ?>
        <div class="warning-banner">
            <i class="fas fa-exclamation-triangle"></i>
            Command Injection Detected! Check the results below for the flag.
        </div>
        <?php endif; ?>

        <div class="tool-section">
            <h2><i class="fas fa-bullseye"></i> Ping Tool</h2>
            
            <form method="POST" id="pingForm">
                <div class="form-group">
                    <label class="form-label" for="target">
                        <i class="fas fa-server"></i> Target Host
                    </label>
                    <input type="text" id="target" name="target" class="form-input" 
                           placeholder="Enter IP address or hostname (e.g., nebulasecuritylabs.liveblog365.com)" 
                           value="<?= htmlspecialchars($target, ENT_QUOTES, 'UTF-8') ?>"
                           required>
                </div>

                <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-play"></i> Run Ping
                    </button>
                    <button type="button" class="hint-btn" onclick="toggleHint()">
                        <i class="fas fa-lightbulb"></i> Need a hint?
                    </button>
                </div>

                <div class="hint-content" id="hintContent">
                    <p><strong>Command Injection Examples:</strong></p>
                    <p><code>nebulasecuritylabs.liveblog365.com; cat filename</code></p>
                    <p><code>127.0.0.1 && ls</code></p>
                    <p><code>localhost | whoami</code></p>
                    <p>Try appending commands to the target host to read system files!</p>
                    
                    <div class="command-hints">
                        <h4><i class="fas fa-terminal"></i> Available Commands & Results:</h4>
                        <p><strong>cat filename</strong> - Returns the flag</p>
                        <p><strong>ls or dir</strong> - Returns directory listing</p>
                        <p><strong>whoami or id</strong> - Returns user info</p>
                        <p><strong>/etc/passwd</strong> - Returns system file content</p>
                    </div>
                </div>
            </form>
        </div>

        <?php if (!empty($result)): ?>
        <div class="result-section">
            <div class="result-header">
                <h2><i class="fas fa-terminal"></i> Command Results</h2>
            </div>
            <div class="result-content"><?= htmlspecialchars($result, ENT_QUOTES, 'UTF-8') ?></div>
        </div>
        <?php endif; ?>

        <div class="educational-section">
            <h3><i class="fas fa-graduation-cap"></i> Command Injection Challenge</h3>
            
            <div class="educational-content">
                <p><strong>About Command Injection:</strong> Command injection occurs when an application passes unsafe user input to a system shell. This allows attackers to execute arbitrary commands on the server.</p>
                
                <p><strong>Your Mission:</strong> Use command injection to read the flag file on the server. The flag is stored in a text file.</p>
                
                <p><strong>Challenge:</strong> Enter the flag you find to complete this challenge.</p>
            </div>

            <form method="POST" id="educationalForm">
                <div class="answer-form">
                    <input type="text" name="educational_answer" class="answer-input" 
                           placeholder="Enter the flag (FLAG{...})" 
                           value="<?= htmlspecialchars($educational_answer, ENT_QUOTES, 'UTF-8') ?>"
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
                        <?= htmlspecialchars($educational_feedback, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php endif; ?>

                <?php if ($educational_correct): ?>
                    <div class="flag-reveal">
                        <i class="fas fa-trophy"></i> Challenge Completed! Flag: <?= htmlspecialchars($flag, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php endif; ?>
            </form>


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

        function toggleEducationalHint() {
            const educationalHintContent = document.getElementById('educationalHintContent');
            educationalHintContent.classList.toggle('show');
        }

        // Clear forms when the other is submitted
        document.getElementById('educationalForm').addEventListener('submit', function() {
            document.getElementById('pingForm').reset();
        });

        document.getElementById('pingForm').addEventListener('submit', function() {
            document.getElementById('educationalForm').reset();
        });

        // Mark command injection challenge complete when educational form is successfully submitted
        document.addEventListener('DOMContentLoaded', function() {
            const educationalForm = document.getElementById('educationalForm');
            if (educationalForm) {
                educationalForm.addEventListener('submit', function(e) {
                    const answerInput = this.querySelector('input[name="educational_answer"]');
                    if (answerInput && answerInput.value.toUpperCase() === 'FLAG{CMD_INJ3CT10N}') {
                        // Mark challenge complete
                        if (typeof markChallengeComplete === 'function') {
                            setTimeout(() => markChallengeComplete('cmdi'), 1000);
                        } else {
                            // Fallback methods
                            sessionStorage.setItem('challenge_completed', 'cmdi');
                            
                            // Update in memory directly
                            try {
                                const stored = localStorage.getItem('nebula_progress');
                                const progress = stored ? JSON.parse(stored) : {
                                    sqli: false, xss: false, idor: false, cmdi: false
                                };
                                progress.cmdi = true;
                                localStorage.setItem('nebula_progress', JSON.stringify(progress));
                            } catch (e) {
                                console.log('LocalStorage not available');
                            }
                        }
                    }
                });
            }
            
            // Also check if command injection was triggered and flag is visible
            const resultContent = document.querySelector('.result-content');
            if (resultContent && resultContent.textContent.includes('FLAG{CMD_INJ3CT10N}')) {
                setTimeout(() => {
                    if (typeof markChallengeComplete === 'function') {
                        markChallengeComplete('cmdi');
                    } else {
                        sessionStorage.setItem('challenge_completed', 'cmdi');
                    }
                }, 2000);
            }
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