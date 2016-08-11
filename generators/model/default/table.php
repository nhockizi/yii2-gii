<?php
$excludesAttribute = [ 'is_delete', 'created_by', 'created_date', 'updated_date', 'id', 'updated_by' ];
echo "<?php\n"
?>
namespace <?= $utilitiesNS ?>;
use backend\models\<?= $className ?>;
use backend\utilities\table\DataTable;

class <?= $tableClassName ?> extends DataTable
{
	public function getColumn()
	{
		switch ($this->column) {
			<?php
				$i = 0;
				foreach ( $labels as $key => $label ) {
					if (!in_array($key, $excludesAttribute, true)) {
						if ($i === 0) {
							echo 'case ' . '\'' . $i . '\'' . ":\n";
						} else {
							echo "\t\t\t" . 'case ' . '\'' . $i . '\'' . ":\n";
						}
						echo "\t\t\t\t" . '$field = ' . '\'' . $key . '\'' . ';' . "\n";
						echo "\t\t\t\t" . 'break;' . "\n";
						$i++;
					}
				}
			?>
			default:
				$field = 'name';
				break;
		}
		return $field;
	}
	public function getData()
	{
		$models = $this->getModels();
		$dataArray = [];
		foreach ($models as $model) {
			$tempArray = array();
			$tempArray[] = '<div><input class="ace cb_single" type="checkbox" id="'<?= '.' . '$model->id' . '.' ?>'"/></div>';
			<?php
			$i = 0;
			foreach ( $labels as $key => $label ) {
				if (!in_array($key, $excludesAttribute, true)) {
					if ($i === 0) {
						echo '$tempArray[] = ' . '$model->' . $key . ';'  . "\n";
					} else {
						echo "\t\t\t" . '$tempArray[] = ' . '$model->' . $key . ';'  . "\n";
					}
					$i++;
				}
			}
			?>
			$htmlAction = '<button class="btn btn-success btn-view" type="button" data-id="'<?= '.' . '$model->id' . '.' ?>'">
                                    <i class="glyphicon glyphicon-eye-open"></i>
                                </button>';
            $htmlAction .= '&nbsp;<button class="btn btn-success btn-update" type="button" data-id="'<?= '.' . '$model->id' . '.' ?>'">
                                    <i class="glyphicon glyphicon-edit"></i>
                                </button>';
			$htmlAction .= '&nbsp;<button class="btn btn-danger btn-delete" type="button" data-id="'<?= '.'.'$model->id'.'.' ?>'">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </button>';
			$tempArray[] = $htmlAction;
			$dataArray[] = $tempArray;
		}
		return $dataArray;
	}
	public function getModels()
	{
		$column = $this->getColumn();
		$models = <?= $className ?>::find()->where(['is_delete' => 0]);

		$this->totalRecords = $models->count();

		$models = $models->andFilterWhere(['or',['like', 'name', $this->searchValue]])
		               ->limit($this->length)
		               ->offset($this->start)
		               ->orderBy([$column => $this->direction])
		               ->all();
		return $models;
	}
}
?>