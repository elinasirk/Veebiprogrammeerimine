<?php
	class Test {
		//muutujad ehk properties
		private $secretNumber;
		public $knownNumber;
		
		//funktsioonid ehk methods
		//constructor ehk meetod, mis käivitub üks kord klassi kasutusele võtmisel(2 allkriipsu järgnevas)
		function __construct($sentNumber){
			$this->secretNumber = 3;
			$this->knownNumber = $sentNumber;
			echo "Salajane: " .$this->secretNumber ." ja teadaolev: " .$this->knownNumber ;
			$this->addNumbers();
		}//construct lõppeb
		
		//destructor kasutatakse üks kord klassi töö lõpetamisel
		function __destruct(){
			echo "Klass lõpetab!";
		}
		
		private function addNumbers(){
			$sum = $this->secretNumber + $this->knownNumber ;
			echo " Summa on: " .$sum;
		}
		
		public function multiplyNumbers(){
			$result = $this->secretNumber * $this->knownNumber;
			echo " Korrutis on: " .$result;
		}
		
	}//class lõppeb