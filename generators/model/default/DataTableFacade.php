<?php
echo '<?php
namespace system\utilities\table;

class DataTableFacade
{
    private $dataTable = "";

    public function __construct(DataTable $dataTable)
    {
        $this->dataTable = $dataTable;
    }

    public function getData()
    {
        return $this->dataTable->getData();
    }

    public function getDraw()
    {
        return $this->dataTable->draw;
    }

    public function getTotalRecord()
    {
        return $this->dataTable->totalRecords;
    }

    public function getTotalFiltered()
    {
        return $this->dataTable->totalRecords;
    }
}';
