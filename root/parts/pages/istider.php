		<div class="news" style="padding-left: 10px; margin-right: -10px">
			<h1>Istider <?php echo $funksjoner->sesong(); ?></h1>
			<div class="settings">
				<select id="ishall">
					<option selected disabled>Laster Ishaller</option>
				</select>
				<select id="uke">
					<option>Uke 1 - 01.01.14 - 07.01.14</option>
					<option selected>Uke 2* - 08.01.14 - 14.01.14</option>
					<option>Uke 3 - 15.01.14 - 22.01.14</option>
				</select>
				<input type="button" id="oppdater" value="Oppdater" />
			</div>
			<iframe src="./2014_2015/uke_23_leangen2.htm" style="border: 0px;width: 100%;min-height: 100%;"></iframe>
			<script src="<?php echo $funksjoner->fix_linking(); ?>assets/js/istider.js"></script>
		</div>