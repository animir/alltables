<?php
namespace Animir\Alltables\Table;

/**
 *
 * @author animir
 */
class TableArray{
    private $_array = [];
    
    /**
     * Add header to table
     * 
     * @param array $row
     * @return \Animir\Alltables\Table\TableArray
     */
    public function addHeader(array $row) {
        array_unshift($this->_array, $row);
        return $this;
    }
    
    /**
     * Add row to table
     * 
     * @param array $row
     * @return \Animir\Alltables\Table\TableArray
     */
    public function addRow(array $row) {
        $this->_array[]= $row;
        return $this;
    }
    
    /**
     * Add array of rows
     * 
     * @param array $rows
     * @return \Animir\Alltables\Table\TableArray
     */
    public function addRows(array $rows) {
        foreach ($rows as $row) {
            $this->addRow($row);
        }
        return $this;
    }
    
    /**
     * Add subheader to table
     * 
     * @param string $row
     * @return \Animir\Alltables\Table\TableArray
     */
    public function addSubHeader($row) {
        if (!is_scalar($row)) return null;
        $this->_array[]= ['__h2__' => $row];
        return $this;
    }
    
    public function getArray() {
        return $this->_array;
    }
    
}
