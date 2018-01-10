<?php
namespace App\Helper\Grid;


class GridColumn {
	private $label;
	private $means;

	/**
	 * @return GridColumn
	 */
	public static function make() {
		$argv = func_get_args();

		return new static(...$argv);
	}

	public function __construct($means = '') {
		$this->means( $means);
	}

	/**
	 * @param $columnName
	 *
	 * @return GridColumn
	 */
	public function means( $columnName ) {
		return $this->setMeans( $columnName);
	}

	/**
	 * @param $title_case
	 *
	 * @return GridColumn
	 */
	public function labeled( $title_case ) {
		$this->setLabel($title_case);
		return $this;
	}

	public function getLabel() {
		return $this->label;
	}

	/**
	 * @param $title_case
	 *
	 * @return GridColumn
	 */
	private function setLabel($title_case) {
		$this->label = $title_case;
		return $this;
	}

	/**
	 * @param mixed $means
	 *
	 * @return GridColumn
	 */
	public function setMeans( $means ) {
		$this->means = $means;

		return $this;
}

	/**
	 * @return mixed
	 */
	public function getMeans() {
		return $this->means;
	}

	public function getCellClass( $item ) {
		$means = str_slug( $this->getMeans());

		return "col-mean-$means";
	}
	public function getCellValue( $item ) {
		return data_get( $item, $this->getMeans());
	}
}
