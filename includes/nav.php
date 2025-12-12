<?php /* Global navigation */ ?>
<header class="site-header">
	<div class="container">
		<nav class="nav">
			<a href="/vulnweb/index.php" class="logo">
				<i class="fas fa-shield-halved"></i>
				Nebula Security Labs
			</a>
			<button class="nav-toggle" aria-label="Toggle navigation" onclick="document.getElementById('navLinks').classList.toggle('open')">
				<i class="fas fa-bars"></i>
			</button>
			<ul id="navLinks" class="nav-links">
				<li><a href="/vulnweb/index.php#home">Home</a></li>
				<li><a href="/vulnweb/index.php#progress">Progress</a></li>
				<li><a href="/vulnweb/index.php#challenges">Challenges</a></li>
				<li><a href="/vulnweb/login.php">SQLi</a></li>
				<li><a href="/vulnweb/contact.php">XSS</a></li>
				<li><a href="/vulnweb/profile.php?id=0">IDOR</a></li>
				<li><a href="/vulnweb/ping.php">CMDi</a></li>
			</ul>
		</nav>
	</div>
</header>

