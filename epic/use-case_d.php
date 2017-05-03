<!DOCTYPE html>
<html>
	<meta charset="UTF-8">
	<title>
		Use Case
	</title>
	<body>
		<main>
			<h2>Use Case</h2>
			<p>Piper has come in to meet with Dylan to set up mySQL before the course starts. She walks around the CNM STEMulus Center for the first time. Pondering about spending the next 10 weeks here she wonders if yellow and grey were suitable colors for a productive environment. Off to the side she notices a mirror hanging on the wall. Walking towards it to take a moment to fix her hair, the mirror suddenly turns on! She got startled because since when do mirrors turn on?!?! She then notices the time and outside weather displayed. Dylan tells her that this is a smart mirror that an awesome capstone project team from cohort 16 built. She is then very excited for the program and wants to build her own smart mirror.</p>
			<h3>Interaction Flow</h3>
			<ul>
				<li>Piper arrives to the STEMulus center and notices a mirror on the cool, laser-cut wall divider in the classroom</li>
				<li>Motion/Distance sensors detect movement 2-3 feet in front</li>
				<li>Sensors sends volts to wake up the Raspberry Pi from sleep mode</li>
				<li>Raspberry Pi turns on the display monitor</li>
				<li>The web page displays on the mirror</li>
				<li>Web page pulls clock information and displays the time</li>
				<li>Web page uses Weather Underground API for Albuquerque, NM</li>
				<li>Web page displays weather as 82 degrees with 50mph wind gusts</li>
				<li>Piper exclaims "Wow, it is freaking hot and super windy!"</li>
				<li>Piper walks away from mirror</li>
				<li>Motion and distance sensors do not detect movement or object presence for 45 seconds and a signal is sent to the Raspberry Pi</li>
				<li>Pi turns off display and goes to sleep mode</li>
			</ul>
			<p>After Seeing the coolest mirror ever (and fixing her hair) She begins to have a more positive outlook on life and is super happy that she made the choice to enroll in the Deep Dive Bootcamp because of the magic mirror and the charming Pi-O-Mirrors team.</p>
		</main>
	</body>
</html>