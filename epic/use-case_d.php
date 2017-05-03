<!DOCTYPE html>
<html>
	<meta charset="UTF-8">
	<title>
		Use Case
	</title>
	<body>
		<main>
			<h2>Use Case</h2>
			<p>Piper has come in to meet with Dylan to set up mySQL before the course starts. She walks around the CNM Stemulus classroom for the first time. Pondering about spending the next 10 weeks here she wonders if yellow and grey were the best colors. Off to the side she notices a mirror hanging on the wall. Walking towards it to take a moment to fix her hair the mirror suddenly turns on! She is startled mirrors don't turn on!?! She notices the time and outside weather displayed. Piper realized that this is a smart mirror.</p>
			<h3>Interaction Flow</h3>
			<ul>
				<li>Piper walks up to mirror</li>
				<li>Motion/Distance sensors detect movement 2-3 feet in front</li>
				<li>Sensors sends volts to wake up raspberry pi from sleep mode</li>
				<li>Raspberry pi3 turns on display monitor</li>
				<li>Raspberry pi displays web page</li>
				<li>Web page pulls clock information from raspberry pi and displays the time</li>
				<li>Web page uses weather underground api for Albuquerque, NM</li>
				<li>Web page displays weather as 82 degrees</li>
				<li>Piper exclaims "Dam it's hot!"</li>
				<li>Piper walks away from mirror</li>
				<li>Motion/ distance sensor does not detect movement or anything in front for over 1 minute signal sent to raspberry pi</li>
				<li>Pi turns off display and goes to sleep mode</li>
			</ul>
			<p>After Seeing the coolest mirror ever (and fixing her hair) She begins to have a more positive outlook on life and her choice to join the Deep Dive Bootcamp because of the magic mirror and the charming pi-o-mirrors.</p>
		</main>
	</body>
</html>