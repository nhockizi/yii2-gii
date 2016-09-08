<?php
$excludesAttribute = [ 'is_delete', 'created_by', 'created_date', 'updated_date', 'id', 'updated_by' ];
echo "<?php\n"
?>
namespace <?= $utilitiesNS ?>\table;
use system\models\<?= $className ?>;
use <?= $utilitiesNS ?>\table\DataTable;

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
		return $this->getModels();
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