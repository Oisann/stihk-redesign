<?php
	
	class funksjoner {

		public function sesong() {
			if(date("n") <= 5) return "FØR JUNI"; //date("Y") - 1 . "/" . date("Y");
			return "ETTTER JUNI"; //date("Y") . "/" . date("Y") + 1;
		}

		public function neste_sesong() {
			if(date("n") <= 5) return "" . date("Y") . "/" . date("Y") + 1;
			return "" . date("Y") + 1 . "/" . date("Y") + 2;
		}

	}