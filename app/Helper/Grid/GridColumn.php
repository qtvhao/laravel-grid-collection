<?php
namespace App\Helper\Grid;


use Illuminate\Support\Collection;

class GridColumn {
	private $label;
	private $means;
	/**
	 * @var Collection
	 */
	private $valueFilters;

	/**
	 * @return GridColumn
	 */
	public static function make() {
		$argv = func_get_args();

		return new static(...$argv);
	}

	public function __construct($means = '') {
		$this->means( $means);
		$this->setValueFilters( new Collection());
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
		$means = $this->getMeans();
		$value_filters = $this->getValueFilters();
		if ( $value_filters->isEmpty() ) {
			$cellValue = data_get( $item, $means );
		}else{
			$cellValue = $item;
			/** @var callable $value_filter */
			foreach( $value_filters as $value_filter) {
				$cellValue = call_user_func( $value_filter, $cellValue, $item);
			}
		}

		return $cellValue;
	}

	/**
	 * @return Collection
	 */
	public function getValueFilters() {
		return $this->valueFilters;
	}

	/**
	 * @param Collection $valueFilters
	 */
	public function setValueFilters(Collection $valueFilters ) {
		$this->valueFilters = $valueFilters;
	}

	/**
	 * @param callable $filter
	 *
	 * @return $this
	 */
	public function pipeValue(callable $filter) {
		$this->valueFilters->push( $filter);

		return $this;
	}
}
