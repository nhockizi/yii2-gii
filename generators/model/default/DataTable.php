<?php
echo '<?php
namespace backend\utilities\table;

abstract class DataTable {
	public $draw = 0;
	public $length = 10;
	public $start = 0;
	public $searchValue = "";
	public $column = 0;
	public $direction = SORT_DESC;
	public $totalRecords = 0;

	public function __construct( $argument ) {
		$this->draw   = $argument["draw"];
		$this->length = $argument["length"] ?: 10;
		$this->start  = $argument["start"];
		if ( array_key_exists( "data", $argument ) ) {
			$this->data = $argument["data"];
		}
		$this->searchValue = $argument["search"]["value"];
		if (array_key_exists("order", $argument)) {
			$this->column      = $argument["order"][0]["column"];
			if ( $argument["order"][0]["dir"] === "asc" ) {
				$this->direction = SORT_ASC;
			}
		}
	}

	public abstract function getData();
	public abstract function getModels();
	public abstract function getColumn();
}

?>';
?>
