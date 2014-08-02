		<div class="news" style="padding-left: 10px; margin-right: -10px">
			<h1>Istider <span id="season"><?php echo $funksjoner->sesong(); ?></span></h1>
			<div class="settings">
				<select id="ishall">
					<option selected disabled>Laster inn ishaller...</option>
				</select>
				<select id="uke">
					<option selected disabled>Velg en ishall</option>
				</select>
			</div>
			<iframe id="istid" src="./2014_2015/uke_23_leangen2.htm" style="border: 0px;width: 100%;min-height: 100%;"></iframe>
			<script src="<?php echo $funksjoner->fix_linking(); ?>assets/js/istider.js"></script>
		</div>