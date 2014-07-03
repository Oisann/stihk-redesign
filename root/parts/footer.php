<div class="shadow divider"></div>
		<div class="widgets">
			<table class="stats">
				<tr>
					<td><h3>Statistikk</h3></td>
				</tr>
				<tr>
					<td><strong>Besøkende for øyeblikket:</strong></td>
					<td><span class="currentVisitorCount">0</span></td>
				</tr>
				<tr>
					<td><strong>Kamper i dag:</strong></td>
					<td>0</td>
				</tr>
				<tr>
					<td><strong>Lisensierte spillere:</strong></td>
					<td>1337</td>
				</tr>
				<tr>
					<td><strong>Dommere:</strong></td>
					<td>16</td>
				</tr>
				<tr>
					<td><strong>Sesong:</strong></td>
					<td><?php echo $funksjoner->sesong(); ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><h3>Hva skjer nå?</h3></td>
				</tr>
				<tr>
					<td><strong>Leangen Arena:</strong></td>
					<td class="arena">N/A</td>
				</tr>
				<tr>
					<td><strong>Leangen Ungdomshall:</strong></td>
					<td class="ungdomshall">N/A</td>
				</tr>
				<tr>
					<td><strong>Dalgård:</strong></td>
					<td class="dalgard">N/A</td>
				</tr>
				<tr>
					<td><strong>Hølonda Utebane:</strong></td>
					<td class="holonda">N/A</td>
				</tr>
			</table>
			<iframe class="facebook" src="http://www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fwww.stihk.no&amp;width=300&amp;height=427&amp;colorscheme=light&amp;show_faces=false&amp;header=true&amp;stream=true&amp;show_border=true&amp;appId=172164879660704" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
		</div>
		<footer>Copyright Sør-Trøndelag Ishockeykrets &copy; <?php echo date("Y"); ?><br><span class="small">Laget av <a class="normal" target="_blank" href="https://www.oisann.net/">Jonas Refseth</a></span>
		</footer>
	</body>
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script src="https://cdn.socket.io/socket.io-1.0.0.js"></script>
	<script src="<?php echo $funksjoner->fix_linking(); ?>assets/js/jquery.marquee.min.js"></script>
	<script src="<?php echo $funksjoner->fix_linking(); ?>assets/js/script.js"></script>
</html>