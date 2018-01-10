<?php
namespace App\Helper\Grid;

use Illuminate\Support\Collection;

class GridCollection extends Collection {
	/**
	 * @var GridColumn[]|Collection
	 */
	private $columns;
	private $id;

	public function __toString() {
		$id     = $this->getId();
		$table  = "<table class='table table-responsive table-bordered' id='$id'>";
		$header = $this->getHeader();
		$table  .= $header;
		$body   = $this->getBody();
		$table  .= $body;
		$table  .='</table>';

		return "<div class='table-container' id='container-$id'><div class='table-wrapper'>$table</div></div>";
	}


	private function getHeader() {
		$th_td_items = $this->columns->map( function ( GridColumn $gridColumn ) {
			$label = $gridColumn->getLabel();
			return "<td>$label</td>";
		} )->implode('');

		return "<thead><tr>$th_td_items</tr></thead>";
	}

	private function getBody() {
		$table_body = "<tbody>";
		$table_body .= $this->getRows();
		$table_body .= "</tbody>";

		return $table_body;
	}

	public function col( $columnName ) {
		$gridColumn = GridColumn::make();
		$columnTitle = title_case( $columnName );
		$gridColumn
			->means($columnName)
			->labeled( $columnTitle );
		$this->addColumn( $gridColumn );

		return $this;
	}

	public function addColumn( GridColumn $gridColumn ) {
		$this->columns->push( $gridColumn);
	}

	public function __construct( $items = [] ) {
		parent::__construct( $items );
		$this->columns = Collection::make();
		$this->id = str_random(8);
	}

	private function getRows() {
		$rows = '';
		foreach($this->items as $item){
			$rows .= '<tr>';
			$rows .= $this->getItemCells($item);
			$rows .= '</tr>';
		}

		return $rows;
	}

	private function getItemCells( $item ) {
		$cells = '';
		foreach ($this->columns as $gridColumn){
			/** @var GridColumn $gridColumn */
			$value = $gridColumn->getCellValue($item);
			$cells .= "<td>$value</td>";
		}

		return $cells;
	}

	/**
	 * @param string $id
	 *
	 * @return GridCollection
	 */
	public function setId( $id ) {
		$this->id = $id;

		return $this;
}

	/**
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}
}
