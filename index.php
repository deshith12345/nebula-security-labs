<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nebula Security Labs - Security Education Platform</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
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
            --border: rgba(0, 0, 0, 0.1);
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.18);
            --glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.06);
            --glass-blur: saturate(180%) blur(20px);
            --ios-glass: rgba(255, 255, 255, 0.25);
            --ios-border: rgba(255, 255, 255, 0.3);
            --ios-highlight: rgba(255, 255, 255, 0.4);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Segoe UI', sans-serif;
            line-height: 1.6;
            color: #1d1d1f;
            background: 
                radial-gradient(circle at 20% 80%, rgba(0, 122, 255, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(88, 86, 214, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(175, 82, 222, 0.12) 0%, transparent 50%),
                linear-gradient(135deg, #f5f5f7 0%, #e8e8ed 50%, #f5f5f7 100%);
            background-size: 400% 400%, 200% 200%, 300% 300%, 400% 400%;
            animation: 
                gradientShift 20s ease infinite,
                pulseGlow 8s ease-in-out infinite;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            /* Performance optimizations */
            transform: translateZ(0);
            backface-visibility: hidden;
            perspective: 1000;
            will-change: auto;
        }

        @keyframes gradientShift {
            0%, 100% { 
                background-position: 0% 50%, 0% 0%, 0% 0%, 0% 50%; 
            }
            50% { 
                background-position: 100% 50%, 100% 100%, 50% 50%, 100% 50%; 
            }
        }

        @keyframes pulseGlow {
            0%, 100% {
                filter: brightness(1);
            }
            50% {
                filter: brightness(1.02);
            }
        }

        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.6) 0%, rgba(255, 255, 255, 0.2) 50%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            animation: floatParticle linear infinite;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.4);
            filter: blur(0.5px);
            /* Performance optimization */
            will-change: transform, opacity;
        }

        @keyframes floatParticle {
            0% {
                transform: translateY(100vh) translateX(0) scale(0);
                opacity: 0;
            }
            10% {
                opacity: 0.6;
                transform: translateY(90vh) translateX(var(--drift-x)) scale(var(--scale));
            }
            90% {
                opacity: 0.3;
                transform: translateY(10vh) translateX(calc(var(--drift-x) * 2)) scale(calc(var(--scale) * 0.8));
            }
            100% {
                transform: translateY(-10vh) translateX(calc(var(--drift-x) * 2.5)) scale(0);
                opacity: 0;
            }
        }

        .floating-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
            animation: floatOrb 25s ease-in-out infinite;
            mix-blend-mode: normal;
            /* Performance optimization */
            will-change: transform, opacity;
        }

        .orb-1 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(0, 122, 255, 0.4) 0%, transparent 70%);
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(88, 86, 214, 0.35) 0%, transparent 70%);
            top: 60%;
            right: 15%;
            animation-delay: 8s;
        }

        .orb-3 {
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(175, 82, 222, 0.3) 0%, transparent 70%);
            bottom: 15%;
            left: 50%;
            animation-delay: 16s;
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

        .header {
            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            padding: 1rem 0;
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.04);
            border-bottom: 0.5px solid rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 0;
            z-index: 100;
            animation: fadeInDown 0.6s ease-out;
            /* Enhanced iOS glass effect */
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.8) 0%,
                rgba(255, 255, 255, 0.6) 50%,
                rgba(255, 255, 255, 0.8) 100%
            );
            border: 0.5px solid var(--ios-border);
            box-shadow: 
                0 1px 0 rgba(0, 0, 0, 0.04),
                inset 0 1px 0 var(--ios-highlight);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            position: relative;
            z-index: 1;
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 600;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo i {
            animation: float 3s ease-in-out infinite;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #1d1d1f;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            cursor: pointer;
            font-size: 0.95rem;
            letter-spacing: -0.2px;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .hero {
            text-align: center;
            padding: 4rem 2rem 3rem;
            color: #1d1d1f;
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
            letter-spacing: -1.5px;
            animation: fadeInUp 0.6s ease-out;
            background: linear-gradient(135deg, #1d1d1f 0%, #424245 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.75;
            animation: fadeInUp 0.6s ease-out 0.2s both;
            font-weight: 400;
            letter-spacing: -0.3px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }

        /* Enhanced iOS Liquid Glass Progress Section */
        .progress-section {
            background: var(--ios-glass);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            margin: -2rem auto 3rem;
            max-width: 1100px;
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 
                0 4px 24px rgba(0, 0, 0, 0.08),
                0 1px 2px rgba(0, 0, 0, 0.04),
                inset 0 1px 0 var(--ios-highlight);
            border: 0.5px solid var(--ios-border);
            position: relative;
            z-index: 10;
            animation: scaleIn 0.6s ease-out 0.3s both;
            /* Enhanced iOS glass effect */
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.25) 0%,
                rgba(255, 255, 255, 0.15) 50%,
                rgba(255, 255, 255, 0.25) 100%
            );
            overflow: hidden;
        }

        .progress-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.1) 0%,
                rgba(255, 255, 255, 0.05) 50%,
                rgba(255, 255, 255, 0.1) 100%
            );
            z-index: -1;
            border-radius: 24px;
        }

        .progress-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .progress-header h2 {
            color: var(--dark);
            font-size: 2rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-weight: 600;
            letter-spacing: -0.5px;
        }

        .progress-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--ios-glass);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            padding: 1.5rem;
            border-radius: 18px;
            text-align: center;
            border: 0.5px solid var(--ios-border);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            animation: fadeInUp 0.6s ease-out forwards;
            /* Enhanced iOS glass effect */
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.3) 0%,
                rgba(255, 255, 255, 0.2) 50%,
                rgba(255, 255, 255, 0.3) 100%
            );
            box-shadow: 
                0 4px 16px rgba(0, 0, 0, 0.06),
                inset 0 1px 0 var(--ios-highlight);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.1) 0%,
                rgba(255, 255, 255, 0.05) 50%,
                rgba(255, 255, 255, 0.1) 100%
            );
            z-index: -1;
            border-radius: 18px;
        }

        .stat-card:nth-child(1) { animation-delay: 0.5s; }
        .stat-card:nth-child(2) { animation-delay: 0.6s; }
        .stat-card:nth-child(3) { animation-delay: 0.7s; }
        .stat-card:nth-child(4) { animation-delay: 0.8s; }

        .stat-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 
                0 8px 24px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 var(--ios-highlight);
            border-color: rgba(0, 122, 255, 0.4);
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            letter-spacing: -1px;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
            font-weight: 500;
            letter-spacing: -0.2px;
        }

        .overall-progress {
            background: var(--ios-glass);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            padding: 1.5rem;
            border-radius: 18px;
            margin-bottom: 2rem;
            border: 0.5px solid var(--ios-border);
            /* Enhanced iOS glass effect */
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.2) 0%,
                rgba(255, 255, 255, 0.1) 50%,
                rgba(255, 255, 255, 0.2) 100%
            );
            box-shadow: 
                0 4px 16px rgba(0, 0, 0, 0.06),
                inset 0 1px 0 var(--ios-highlight);
            position: relative;
            overflow: hidden;
        }

        .overall-progress::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.1) 0%,
                rgba(255, 255, 255, 0.05) 50%,
                rgba(255, 255, 255, 0.1) 100%
            );
            z-index: -1;
            border-radius: 18px;
        }

        .progress-bar-container {
            background: rgba(0, 0, 0, 0.06);
            height: 30px;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            margin-bottom: 1rem;
            /* Enhanced glass effect */
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
            border: 0.5px solid rgba(0, 0, 0, 0.05);
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 15px;
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 2px 10px rgba(0, 122, 255, 0.3);
            position: relative;
            overflow: hidden;
        }

        .progress-bar::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shimmer 2s infinite;
        }

        .progress-label {
            text-align: center;
            color: var(--dark);
            font-weight: 500;
            font-size: 1.1rem;
            letter-spacing: -0.2px;
        }

        .features {
            background: transparent;
            padding: 4rem 2rem;
        }

        .section-title {
            text-align: center;
            margin-bottom: 1rem;
            color: var(--dark);
            font-size: 2.5rem;
            font-weight: 700;
            letter-spacing: -1px;
        }

        .section-subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 3rem;
            font-size: 1.1rem;
            font-weight: 400;
            letter-spacing: -0.2px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        /* Enhanced iOS Liquid Glass Challenge Cards */
        .feature-card {
            background: var(--ios-glass);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            padding: 2rem;
            border-radius: 24px;
            box-shadow: 
                0 4px 24px rgba(0, 0, 0, 0.08),
                0 1px 2px rgba(0, 0, 0, 0.04),
                inset 0 1px 0 var(--ios-highlight);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 0.5px solid var(--ios-border);
            position: relative;
            overflow: hidden;
            /* Enhanced iOS glass effect */
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.25) 0%,
                rgba(255, 255, 255, 0.15) 50%,
                rgba(255, 255, 255, 0.25) 100%
            );
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.1) 0%,
                rgba(255, 255, 255, 0.05) 50%,
                rgba(255, 255, 255, 0.1) 100%
            );
            z-index: -1;
            border-radius: 24px;
        }

        .feature-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
            transform: scaleX(0);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .feature-card:hover::after {
            transform: scaleX(1);
        }

        .feature-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.12),
                0 2px 4px rgba(0, 0, 0, 0.06),
                inset 0 1px 0 var(--ios-highlight);
            border-color: rgba(0, 122, 255, 0.4);
        }

        .feature-card.completed {
            border-color: rgba(52, 199, 89, 0.4);
            background: linear-gradient(
                135deg,
                rgba(242, 255, 247, 0.6) 0%,
                rgba(242, 255, 247, 0.4) 50%,
                rgba(242, 255, 247, 0.6) 100%
            );
        }

        .feature-card.completed::after {
            background: var(--success);
            transform: scaleX(1);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 16px rgba(0, 122, 255, 0.2);
            /* Enhanced glass effect */
            position: relative;
            overflow: hidden;
        }

        .feature-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.3) 0%,
                rgba(255, 255, 255, 0.1) 50%,
                rgba(255, 255, 255, 0.3) 100%
            );
            border-radius: 18px;
        }

        .feature-card.completed .feature-icon {
            background: var(--success);
            box-shadow: 0 4px 16px rgba(52, 199, 89, 0.2);
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .feature-icon i {
            font-size: 2rem;
            color: white;
            position: relative;
            z-index: 1;
        }

        .feature-card h3 {
            color: var(--dark);
            margin-bottom: 1rem;
            font-size: 1.4rem;
            font-weight: 600;
            letter-spacing: -0.3px;
        }

        .feature-card p {
            color: #666;
            margin-bottom: 1.5rem;
            line-height: 1.7;
            font-weight: 400;
            letter-spacing: -0.2px;
        }

        .badge-container {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .completion-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--success);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            animation: scaleIn 0.3s ease-out;
            box-shadow: 0 2px 8px rgba(52, 199, 89, 0.2);
            /* Enhanced glass effect */
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 0.5px solid rgba(255, 255, 255, 0.3);
        }

        .difficulty-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            /* Enhanced glass effect */
            border: 0.5px solid rgba(255, 255, 255, 0.3);
        }

        .difficulty-easy {
            background: rgba(52, 199, 89, 0.15);
            color: #1e7e34;
            border: 0.5px solid rgba(52, 199, 89, 0.3);
        }

        .difficulty-medium {
            background: rgba(255, 149, 0, 0.15);
            color: #a05a00;
            border: 0.5px solid rgba(255, 149, 0, 0.3);
        }

        .difficulty-hard {
            background: rgba(255, 59, 48, 0.15);
            color: #c4190c;
            border: 0.5px solid rgba(255, 59, 48, 0.3);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.9rem 1.8rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            text-decoration: none;
            border-radius: 14px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 122, 255, 0.25);
            letter-spacing: -0.2px;
            /* Enhanced glass effect */
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 0.5px solid rgba(255, 255, 255, 0.3);
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 20px rgba(0, 122, 255, 0.35);
        }

        .btn:active {
            transform: translateY(0) scale(0.98);
        }

        .btn span {
            position: relative;
            z-index: 1;
        }

        .btn-outline {
            background: rgba(255, 255, 255, 0.5);
            color: var(--primary);
            border: 1px solid rgba(0, 122, 255, 0.3);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .footer {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            color: white;
            text-align: center;
            padding: 3rem 2rem;
            position: relative;
            z-index: 1;
            border-top: 0.5px solid rgba(230, 221, 221, 0.1);
            /* Enhanced glass effect */
            background: linear-gradient(
                135deg,
                rgba(0, 0, 0, 0.95) 0%,
                rgba(5, 5, 5, 0.85) 50%,
                rgba(1, 1, 1, 0.95) 100%
            );
            box-shadow: 
                0 -1px 0 rgba(255, 255, 255, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            opacity: 0.8;
            transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            font-weight: 400;
            letter-spacing: -0.2px;
        }

        .footer-links a:hover {
            opacity: 1;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
            
            .nav-links {
                display: none;
            }

            .progress-section {
                padding: 1.5rem;
                margin: -1rem 1rem 2rem;
            }

            .stat-value {
                font-size: 2rem;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        /* Performance optimizations */
        .performance-optimized {
            transform: translateZ(0);
            backface-visibility: hidden;
            perspective: 1000;
            will-change: transform, opacity;
        }

        /* Reduced motion for accessibility */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body>
    <div class="particles" id="particles">
        <div class="floating-orb orb-1"></div>
        <div class="floating-orb orb-2"></div>
        <div class="floating-orb orb-3"></div>
    </div>

    <header class="header">
        <div class="container">
            <nav class="nav">
                <a href="#home" class="logo">
                    <i class="fas fa-shield-halved"></i>
                    Nebula Security Labs
                </a>
                <ul class="nav-links">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#progress">Progress</a></li>
                    <li><a href="#challenges">Challenges</a></li>
                    <li><a href="#about">About</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero" id="home">
        <div class="container">
            <h1><i class="fas fa-graduation-cap"></i> Security Education Platform</h1>
            <p>Master cybersecurity through hands-on challenges with real vulnerabilities</p>
        </div>
    </section>

    <div class="container">
        <section class="progress-section" id="progress">
            <div class="progress-header">
                <h2><i class="fas fa-chart-line"></i> Your Learning Progress</h2>
                <p style="color: #666;">Track your journey through web security fundamentals</p>
            </div>

            <div class="progress-stats">
                <div class="stat-card">
                    <div class="stat-value" id="completedCount">0</div>
                    <div class="stat-label">Completed</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="inProgressCount">0</div>
                    <div class="stat-label">In Progress</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="totalCount">4</div>
                    <div class="stat-label">Total Challenges</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="percentComplete">0%</div>
                    <div class="stat-label">Overall Progress</div>
                </div>
            </div>

            <div class="overall-progress">
                <div class="progress-bar-container">
                    <div class="progress-bar" id="overallProgressBar" style="width: 0%;">
                        <span id="progressText">0%</span>
                    </div>
                </div>
                <div class="progress-label">Complete all challenges to master web security basics!</div>
            </div>
        </section>
    </div>

    <section class="features" id="challenges">
        <div class="container">
            <h2 class="section-title">Security Challenges</h2>
            <p class="section-subtitle">Learn by exploiting intentional vulnerabilities in a safe environment</p>
            
            <div class="features-grid">
                <div class="feature-card" data-challenge="sqli">
                    <div class="badge-container">
                        <div class="difficulty-badge difficulty-easy">
                            <i class="fas fa-star"></i> Easy
                        </div>
                        <div class="completion-badge" style="display: none;">
                            <i class="fas fa-check-circle"></i> Completed
                        </div>
                    </div>
                    <div class="feature-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3>SQL Injection</h3>
                    <p>Master authentication bypass techniques through SQL injection vulnerabilities in login systems.</p>
                    <a href="login.php" class="btn">
                        <span><i class="fas fa-play"></i> Start Challenge</span>
                    </a>
                </div>

                <div class="feature-card" data-challenge="xss">
                    <div class="badge-container">
                        <div class="difficulty-badge difficulty-easy">
                            <i class="fas fa-star"></i> Easy
                        </div>
                        <div class="completion-badge" style="display: none;">
                            <i class="fas fa-check-circle"></i> Completed
                        </div>
                    </div>
                    <div class="feature-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3>Cross-Site Scripting</h3>
                    <p>Explore XSS vulnerabilities and understand how malicious scripts can be injected and executed.</p>
                    <a href="contact.php" class="btn">
                        <span><i class="fas fa-play"></i> Start Challenge</span>
                    </a>
                </div>

                <div class="feature-card" data-challenge="idor">
                    <div class="badge-container">
                        <div class="difficulty-badge difficulty-medium">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i> Medium
                        </div>
                        <div class="completion-badge" style="display: none;">
                            <i class="fas fa-check-circle"></i> Completed
                        </div>
                    </div>
                    <div class="feature-icon">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <h3>IDOR Vulnerability</h3>
                    <p>Discover insecure direct object references and learn about proper access control implementation.</p>
                    <a href="profile.php" class="btn">
                        <span><i class="fas fa-play"></i> Start Challenge</span>
                    </a>
                </div>

                <div class="feature-card" data-challenge="cmdi">
                    <div class="badge-container">
                        <div class="difficulty-badge difficulty-medium">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i> Medium
                        </div>
                        <div class="completion-badge" style="display: none;">
                            <i class="fas fa-check-circle"></i> Completed
                        </div>
                    </div>
                    <div class="feature-icon">
                        <i class="fas fa-terminal"></i>
                    </div>
                    <h3>Command Injection</h3>
                    <p>Learn how command injection allows attackers to execute arbitrary commands on servers.</p>
                    <a href="ping.php" class="btn">
                        <span><i class="fas fa-play"></i> Start Challenge</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer" id="about">
        <div class="footer-content">
            <div class="footer-links">
                <a href="#home">Home</a>
                <a href="#progress">Progress</a>
                <a href="#challenges">Challenges</a>
                <a href="#about">About</a>
            </div>
            <p>&copy; 2025 Nebula Security Labs. Created for cybersecurity education and training.</p>
            <p style="margin-top: 0.5rem; opacity: 0.8;">
                <i class="fas fa-exclamation-triangle"></i> Educational purposes only - Practice responsibly
            </p>
        </div>
    </footer>

    <script>
        // Performance optimizations
        let rafId;
        let lastScrollY = 0;
        let ticking = false;
        
        // Throttled scroll handler
        function onScroll() {
            lastScrollY = window.scrollY;
            if (!ticking) {
                rafId = requestAnimationFrame(updateScroll);
                ticking = true;
            }
        }
        
        function updateScroll() {
            // Add scroll-based animations here if needed
            ticking = false;
        }
        
        // Optimized particle creation
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 40; // Reduced for performance
            
            // Use DocumentFragment for batch DOM operations
            const fragment = document.createDocumentFragment();
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle performance-optimized';
                
                const size = Math.random() * 3 + 2; // Smaller particles
                const startX = Math.random() * 100;
                const driftX = (Math.random() - 0.5) * 80; // Reduced drift
                const scale = Math.random() * 0.5 + 0.5;
                
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = startX + '%';
                particle.style.bottom = '-50px';
                particle.style.setProperty('--drift-x', driftX + 'px');
                particle.style.setProperty('--scale', scale);
                particle.style.animationDuration = (Math.random() * 10 + 15) + 's'; // Faster animations
                particle.style.animationDelay = (Math.random() * 5) + 's';
                particle.style.opacity = Math.random() * 0.2 + 0.1; // Lower opacity
                
                fragment.appendChild(particle);
            }
            
            particlesContainer.appendChild(fragment);
        }

        // Debounced resize handler
        let resizeTimeout;
        function onResize() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                // Handle resize operations here
            }, 250);
        }

        // Intersection Observer for animations
        function initScrollAnimations() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }, index * 100);
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            document.querySelectorAll('.feature-card').forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });

            document.querySelectorAll('.section-title, .section-subtitle').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(el);
            });
        }

        // Optimized counter animation
        function animateCounter(element, target) {
            const duration = 800; // Reduced duration
            const start = 0;
            const increment = target / (duration / 16);
            let current = start;

            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target + (element.id === 'percentComplete' ? '%' : '');
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current) + (element.id === 'percentComplete' ? '%' : '');
                }
            }, 16);
        }

        // Optimized DOMContentLoaded
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('a[href^="#"]');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    const targetSection = document.querySelector(targetId);
                    
                    if (targetSection) {
                        const headerOffset = 80;
                        const elementPosition = targetSection.getBoundingClientRect().top;
                        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                        
                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Initialize with optimizations
            createParticles();
            initScrollAnimations();
            
            // Add scroll and resize listeners
            window.addEventListener('scroll', onScroll, { passive: true });
            window.addEventListener('resize', onResize, { passive: true });
        });

        // Clean up on page unload
        window.addEventListener('beforeunload', () => {
            if (rafId) {
                cancelAnimationFrame(rafId);
            }
            window.removeEventListener('scroll', onScroll);
            window.removeEventListener('resize', onResize);
        });

        // Existing challenge functionality
        const CHALLENGES = {
            sqli: 'FLAG{SQLI_INJ3CTION}',
            xss: 'FLAG{XSS_4L3RT}',
            idor: 'FLAG{ADMIN_PRIVILEGES}',
            cmdi: 'FLAG{CMD_INJ3CT10N}'
        };

        function initProgress() {
            const stored = localStorage.getItem('nebula_progress');
            return stored ? JSON.parse(stored) : {
                sqli: false,
                xss: false,
                idor: false,
                cmdi: false
            };
        }

        function saveProgress(progress) {
            localStorage.setItem('nebula_progress', JSON.stringify(progress));
        }

        function markChallengeComplete(challengeType) {
            const progress = initProgress();
            if (!progress[challengeType]) {
                progress[challengeType] = true;
                saveProgress(progress);
                updateUI();
                showCompletionNotification(challengeType);
            }
        }

        function showCompletionNotification(challengeType) {
            const names = {
                sqli: 'SQL Injection',
                xss: 'Cross-Site Scripting',
                idor: 'IDOR Vulnerability',
                cmdi: 'Command Injection'
            };
            
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: rgba(52, 199, 89, 0.95);
                backdrop-filter: saturate(180%) blur(20px);
                -webkit-backdrop-filter: saturate(180%) blur(20px);
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 14px;
                box-shadow: 0 8px 32px rgba(52, 199, 89, 0.3);
                z-index: 1000;
                animation: slideIn 0.3s ease-out;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                border: 0.5px solid rgba(255, 255, 255, 0.18);
            `;
            notification.innerHTML = `
                <i class="fas fa-check-circle"></i>
                <strong>${names[challengeType]} Completed!</strong>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease-in';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        function updateUI() {
            const progress = initProgress();
            const completed = Object.values(progress).filter(v => v).length;
            const total = Object.keys(CHALLENGES).length;
            const percent = Math.round((completed / total) * 100);

            document.getElementById('completedCount').textContent = completed;
            document.getElementById('totalCount').textContent = total;
            document.getElementById('percentComplete').textContent = percent + '%';
            document.getElementById('overallProgressBar').style.width = percent + '%';
            document.getElementById('progressText').textContent = percent + '%';

            Object.keys(progress).forEach(challenge => {
                const card = document.querySelector(`[data-challenge="${challenge}"]`);
                if (card && progress[challenge]) {
                    card.classList.add('completed');
                    card.querySelector('.completion-badge').style.display = 'inline-flex';
                    const btn = card.querySelector('.btn span');
                    btn.innerHTML = '<i class="fas fa-redo"></i> Retry Challenge';
                    card.querySelector('.btn').classList.add('btn-outline');
                }
            });
        }

        function checkCompletion() {
            const params = new URLSearchParams(window.location.search);
            const completed = params.get('completed');
            
            if (completed && CHALLENGES[completed]) {
                markChallengeComplete(completed);
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        }

        window.addEventListener('storage', (e) => {
            if (e.key === 'nebula_progress') {
                updateUI();
            }
        });

        window.addEventListener('challengeComplete', (e) => {
            if (e.detail && e.detail.challenge) {
                markChallengeComplete(e.detail.challenge);
            }
        });

        function checkSessionCompletion() {
            const completed = sessionStorage.getItem('challenge_completed');
            if (completed) {
                markChallengeComplete(completed);
                sessionStorage.removeItem('challenge_completed');
            }
        }

        window.addEventListener('load', () => {
            updateUI();
            checkCompletion();
            checkSessionCompletion();
            
            setTimeout(() => {
                const progress = initProgress();
                const completed = Object.values(progress).filter(v => v).length;
                const total = Object.keys(CHALLENGES).length;
                const percent = Math.round((completed / total) * 100);
                
                animateCounter(document.getElementById('completedCount'), completed);
                animateCounter(document.getElementById('inProgressCount'), 0);
                animateCounter(document.getElementById('totalCount'), total);
                animateCounter(document.getElementById('percentComplete'), percent);
            }, 800);
        });

        window.markChallengeComplete = markChallengeComplete;
    </script>
</body>
</html>