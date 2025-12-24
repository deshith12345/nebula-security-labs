<?php 
/**
 * Global Navigation Component
 * 
 * Displays the main site header with navigation menu.
 * Includes responsive mobile menu toggle functionality.
 * Links to all main pages and security challenge sections.
 */ 
?>
<!-- Site Header with Navigation -->
<header class="site-header">
	<div class="container">
		<nav class="nav">
			<!-- Logo/Brand -->
			<a href="/vulnweb/index.php" class="logo">
				<i class="fas fa-shield-halved"></i>
				Nebula Security Labs
			</a>
			<!-- Mobile Menu Toggle Button -->
			<button class="nav-toggle" aria-label="Toggle navigation" onclick="document.getElementById('navLinks').classList.toggle('open')">
				<i class="fas fa-bars"></i>
			</button>
			<!-- Navigation Links -->
			<ul id="navLinks" class="nav-links">
				<li><a href="/vulnweb/index.php#home">Home</a></li>
				<li><a href="/vulnweb/index.php#progress">Progress</a></li>
				<li><a href="/vulnweb/index.php#challenges">Challenges</a></li>
				<!-- Security Challenge Links -->
				<li><a href="/vulnweb/login.php">SQLi</a></li>          <!-- SQL Injection Challenge -->
				<li><a href="/vulnweb/contact.php">XSS</a></li>        <!-- Cross-Site Scripting Challenge -->
				<li><a href="/vulnweb/profile.php?id=0">IDOR</a></li> <!-- Insecure Direct Object Reference Challenge -->
				<li><a href="/vulnweb/ping.php">CMDi</a></li>          <!-- Command Injection Challenge -->
			</ul>
		</nav>
	</div>
</header>
