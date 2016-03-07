
<?php

//define('_JEXEC', 1) or die;
require 'Requests_library.php';

	class Structure{
		public $home_club;
		public $away_club;
		public $home_club_score;
		public $away_club_score;
		public function __constructor($home, $away, $homeScore, $awayScore){
			$this->home_club = $home;
			$this->away_club = $away;
			$this->home_club_score = $homeScore;
			$this->away_club_score = $awayScore;
		}
	}

	class Program {
		
		//getting data from servcer
		private function getData($season, $championship, $clubID) {
			$recievedData = (new getApi())->matchList(1, 1, 15, "asc", 0, '2012-02-13', 'current', $season, $championship, 'gclub_club', $clubID, 1);
			$this->decodeJSON($recievedData);	
		}
	
		//decoding JSON string into associating array
		public function decodeJSON($jsonString){
			$this->parseData(json_decode($jsonString, true, 2));
		}
		
		//parsing needless data from assotiating array into structure
		private function parseData($recievedData){
			$parsedArray = array();
			for($i = 0; $i < 15; $i++){
				$structure = new Structure($data['home_club']['title'], $data['away_club']['title'], $data['score']['home'], $data['score']['away']);
				$parsedArray[] = $structure;
			}
			$this->printOutList($parsedArray);
		}

		//front-end
		private function printOutList($parsedArray) {
			/*form and print data here*/
			echo "
				<style>
					th{text-align: center;border=\"1px\";}
					td{text-align: center;border=\"1px\";}
					table{border: 1px solid black; bgcolor=\"#FBF0DB\" width: 100%;}
				</style>
				<table>";

			foreach($parsedArray as $data){
				echo "
					<tr><th>{$data->home_club}</th><th>{$data->home_club_score}</th><th>:</th><th>{$data->away_club_score}</th><th>{$data->away_club}</th></tr>
					<br>";
			}
			echo "</table>";
		}
	}

	$program = new Program();
	$program->getData(0, 0, 0);

?>

