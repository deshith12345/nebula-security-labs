<?php
// admin.php - Admin profile accessed via SQL injection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile - Nebula Security</title>
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
            background: radial-gradient(circle at 20% 80%, rgba(0, 122, 255, 0.15) 0%, transparent 50%),
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
        .container { max-width: 800px; width: 100%; margin: 0 auto; position: relative; z-index: 1; }
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
        .sql-success {
            background: linear-gradient(135deg, var(--success) 0%, #38a169 100%);
            color: white; padding: 1rem; border-radius: 0; margin: 0;
            text-align: center; font-weight: 600; display: flex;
            align-items: center; justify-content: center; gap: 0.5rem;
        }
        .completion-notice {
            background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
            color: white; padding: 1rem; margin: 0; text-align: center;
            font-weight: 600; display: none; align-items: center; justify-content: center; gap: 0.5rem;
        }
        .profile-section { padding: 2rem 2.5rem; border-bottom: 1px solid rgba(0, 0, 0, 0.06); }
        .profile-section:last-child { border-bottom: none; }
        .section-title {
            display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;
            color: var(--dark); font-size: 1.3rem; letter-spacing: -0.3px;
        }
        .profile-section p { margin-bottom: 0.8rem; line-height: 1.6; color: #4a5568; }
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
        .back-link {
            text-align: center; padding: 2rem;
            background: rgba(247, 250, 252, 0.6);
            border-top: 1px solid rgba(0, 0, 0, 0.06);
        }
        .btn {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.8rem 1.5rem; background: var(--primary); color: white;
            text-decoration: none; border-radius: 12px; margin: 0.5rem;
            font-weight: 600; transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 122, 255, 0.25);
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 122, 255, 0.35);
        }
        @media (max-width: 768px) { .container { padding: 1rem; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <div class="profile-avatar"><i class="fas fa-user-shield"></i></div>
            <h1 class="profile-name">admin</h1>
            <p class="profile-subtitle">Administrator Profile</p>
        </div>
        <div class="profile-content">
            <div class="sql-success">
                <i class="fas fa-check-circle"></i> SQL Injection Successful! Authentication Bypassed.
            </div>
            <div id="completionNotice" class="completion-notice">
                <i class="fas fa-trophy"></i> SQL Injection Challenge Completed!
            </div>
            <div class="profile-section">
                <h2 class="section-title"><i class="fas fa-info-circle"></i> User Information</h2>
                <p><strong>Username:</strong> admin</p>
                <p><strong>User ID:</strong> 1</p>
                <p><strong>Email:</strong> admin@nebulasec.local</p>
                <p><strong>Role:</strong> Administrator</p>
            </div>
            <div class="profile-section">
                <h2 class="section-title"><i class="fas fa-key"></i> Security Flag</h2>
                <div class="secret-flag"><i class="fas fa-flag"></i> FLAG{SQLI_INJ3CTION}</div>
                <div class="warning-note">
                    <i class="fas fa-exclamation-triangle"></i> 
                    This flag is visible due to SQL injection vulnerability - you bypassed authentication
                </div>
            </div>
            <div class="back-link">
                <a href="login.php" class="btn"><i class="fas fa-arrow-left"></i> Back to Login</a>
                <a href="index.php?completed=sqli" class="btn"><i class="fas fa-home"></i> Back to Home</a>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof markChallengeComplete === 'function') {
                markChallengeComplete('sqli');
                document.getElementById('completionNotice').style.display = 'flex';
            } else {
                sessionStorage.setItem('challenge_completed', 'sqli');
                document.getElementById('completionNotice').style.display = 'flex';
                try {
                    const stored = localStorage.getItem('nebula_progress');
                    const progress = stored ? JSON.parse(stored) : {sqli: false, xss: false, idor: false, cmdi: false};
                    if (!progress.sqli) {
                        progress.sqli = true;
                        localStorage.setItem('nebula_progress', JSON.stringify(progress));
                    }
                } catch (e) { console.log('LocalStorage not available'); }
            }
        });
    </script>
</body>
</html>