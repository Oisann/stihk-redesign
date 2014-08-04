		<div class="news" style="padding-left: 10px; margin-right: -10px">
			<h1>Istider <span id="season"><?php echo $funksjoner->sesong(); ?></span></h1>
			Uke markert med stjerne (*) er uken vi er inne i nå.
			<div class="settings">
				<select id="ishall">
					<option selected disabled>Laster inn ishaller...</option>
				</select>
				<select id="uke">
					<option selected disabled>Velg en ishall</option>
				</select>
			</div>
			<iframe id="istid" src="" style="border: 0px;width: 100%;"></iframe>
			<script src="<?php echo $funksjoner->fix_linking(); ?>assets/js/istider.js"></script>
			<div class="istider-liste">
				<?php
					$sesong = str_replace('/', '_', $funksjoner->sesong());
					$istider = glob('../../istider/' . $sesong . '/*.htm');
					foreach($istider as $uke) {
						echo "<a href=\"$uke\">" . $uke . "</a><br>";
					}
				?>
			</div>
		</div>