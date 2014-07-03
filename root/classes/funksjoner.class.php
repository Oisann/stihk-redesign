<?php
	
	class funksjoner {

		public function sesong() {
			if(date("n") <= 5) return (date("Y") - 1) . "/" . date("Y");
			return date("Y") . "/" . (date("Y") + 1);
		}

		public function neste_sesong() {
			if(date("n") <= 5) return date("Y") . "/" . (date("Y") + 1);
			return (date("Y") + 1) . "/" . (date("Y") + 2);
		}

		public function qrcode($text, $size=250) {
               return "http://api.qrserver.com/v1/create-qr-code/?data=" . urlencode($text) . "&size=" . $size . "x" . $size;
        }

        public function url_folder_depth() {
            $folder_depth = substr_count($_SERVER['REQUEST_URI'] , "/");
            if($folder_depth == false)
                return 1;
            return intval($folder_depth);
        }
        
        public function fix_linking() {
            $depth = $this->url_folder_depth();
            if($depth == 1) return "";
            $prefix = "../";
            $result = "";
            for ($i = 0; $i < $depth - 1; $i++) {
                $result .= $prefix;
            }
            return $result;
        }

        public function startsWith($haystack, $needle) {
            return $needle === "" || strpos($haystack, $needle) === 0;
        }
        
        public function endsWith($haystack, $needle) {
            return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
        }

        /*
         *
         * DESCRIPTION: Checks for $_POST varible with name, else return $_GET variable
         * RETURN: $_POST[$name] or $_GET[$name]
         *
         */
        public function request($name) {
            if(isset($_POST[$name]))
                return $_POST[$name];
            if(isset($_GET[$name]))
                return $_GET[$name];
            return null;
        }
        
        /*
         *
         * DESCRIPTION: Grabs $_GET variables through the friendly urls
         * RETURN: the same as $_GET[$name] would've done without the friendly urls
         *
         */
        public function getRequest($name) {
            $url = $_SERVER['REQUEST_URI'];
            preg_match('/' . $name . '=[0-9A-Za-z]*/', $url, $matches);
            if(empty($matches[0]))
                return null;
            $result = str_replace($name . "=", "", $matches[0]);
            if(empty($result))
                return null;
            return $result;
        }

	}