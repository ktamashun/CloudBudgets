<?php

/**
 *
 * @author Kovács Tamás
 * @category Iwebs
 * @package Iwebs_Html
 * @subpackage Table
 */
class Iwebs_Html_Table_Header
{
	const SORT_DIRECTION_ASC = 'ASC';
	const SORT_DIRECTION_DESC = 'DESC';
	protected $_sortOrderName = 'sortOrder';
	protected $_sortByIdName = 'sortById';

	/**
	 * A cellák tömbje.
	 *
	 * @var array
	 */
	protected $_colsDefinition = array();

	/**
	 * Melyik cella szerint rendeztük a táblázatot.
	 *
	 * @var int
	 */
	protected $_sortedBy = null;

	/**
	 * Milyen irányú a rendezés.
	 *
	 * @var string ASC vagy DESC
	 */
	protected $_sortOrder = self::SORT_DIRECTION_ASC;

	/**
	 * Az url amit meg kell nyitni rendezésnél, benne a helytartók.
	 *
	 * @var string
	 */
	protected $_linkPattern = null;

	/**
	 *
	 * @var Iwebs_Pager
	 */
	protected $_pager = null;


	/**
	 * Constructor.
	 *
	 * @param string $linkPattern
	 * @return void
	 */
	public function __construct($linkPattern = '')
	{
		$this->_linkPattern = $linkPattern;
	}

	public function setSortOrderName($sortOrderName) {
		$this->_sortOrderName = $sortOrderName;
	}

	public function setSortByIdName($sortByIdName) {
		$this->_sortByIdName = $sortByIdName;
	}

	/**
	 * Hozzáad a fejléchez egy új oszlopot.
	 *
	 * @param array $definition
	 * @return Iwebs_Html_Table_Header
	 */
	public function addCol($definition)
	{
		$defaultDefinition = array(
			'text' => null,
			'sortable' => true,
			'exportable' => true,
			'style' => '',
			'class' => '',
			'onclick' => ''
		);

		$defaultDefinition[$this->_sortByIdName] = null;

		$definition = array_merge($defaultDefinition, $definition);
		$this->_colsDefinition[$definition[$this->_sortByIdName]] = $definition;
		return $this;
	}

	/**
	 * Visszaadja a keresett oszlop stílusát
	 *
	 * @param string $id
	 * @return string
	 */
	public function getColStyle($id)
	{
		return $this->_colsDefinition[$id]['style'];
	}


	/**
	 * Iwebs_Html_Table_Header::getColClass()
	 *
	 * @param mixed $id
	 * @return
	 */
	public function getColClass($id)
	{
		return $this->_colsDefinition[$id]['class'];
	}

	public function getColDefinitions()
	{
		return $this->_colsDefinition;
	}

	/**
	 * Beállítja, hogy melyik oszlop szerint van rendezve a táblázat.
	 *
	 * @param $sortedBy
	 * @return Iwebs_Html_Table_Header
	 */
	public function setSortedBy($sortedBy)
	{
		if (null !== $sortedBy) {
			$this->_sortedBy = $sortedBy;
		}

		return $this;
	}

	/**
	 * Beállítja, hogy milyen irányú a rendezés.
	 *
	 * @param $sortOrder
	 * @return Iwebs_Html_Table_Header
	 */
	public function setSortOrder($sortOrder)
	{
		if (null !== $sortOrder) {
			$this->_sortOrder = $sortOrder;
		}

		return $this;
	}

	/**
	 * Elkészíti a fejléc HTML forrását.
	 *
	 * @return string
	 */
	public function render()
	{
        $returnString = '';
		$returnString .= '<thead><tr>'; // . $this->renderPager();

		foreach ($this->_colsDefinition as $definition) {
			$returnString .= $this->renderCol($definition);
		}

		$returnString .= '</tr></thead>';

		return $returnString;
	}

	/**
	 * Elkészíti a fejléc cella HTML forrását.
	 *
	 * @param array $definition
	 * @return string
	 */
	public function renderCol($definition)
	{
		$returnString = '<th style="' . $definition['style'] . '"';		// STYLE
        $returnString .= ' class="' . $definition['class'] . '">';		// CLASS
		$returnString .= '<label>' . $definition['text'] . '</label>' ; // TITLE
		if (array_key_exists('sortable', $definition) and true === $definition['sortable']) {
			$returnString .= ' ' . $this->renderSortImage(
				self::SORT_DIRECTION_DESC,
				$definition[$this->_sortByIdName],
				$this->_sortedBy === $definition[$this->_sortByIdName] and self::SORT_DIRECTION_DESC === $this->_sortOrder
			);
			$returnString .= $this->renderSortImage(
				self::SORT_DIRECTION_ASC,
				$definition[$this->_sortByIdName],
				$this->_sortedBy === $definition[$this->_sortByIdName] and self::SORT_DIRECTION_ASC === $this->_sortOrder
			);
		}

		return $returnString . '</th>';
	}

	/**
	 *
	 * @param string $direction
	 * @param string $sortById
	 * @param bool $isActive
	 * @return string
	 */
	public function renderSortImage($sortOrder, $sortById, $isActive = false)
	{
		// str_replace(array('{sortOrder}', '{sortById}'), array($sortOrder, $sortById), $this->_linkPattern) .
		return '<a href="' . $this->getSortUrl($sortOrder, $sortById) . '" class="sort' . (self::SORT_DIRECTION_ASC === $sortOrder ? 'up' : 'down') . ($isActive ? 'active' : '') . '" >'
			//. '<img src="images/' . strtolower($sortOrder) . '-' . ($isActive ? 'active' : 'inactive') . '.png" />'
			. '</a>';
	}

	/**
	 *
	 *
	 * @param $sortOrder
	 * @param $sortById
	 * @return string
	 */
	public function getSortUrl($sortOrder, $sortById)
	{
		$getParams = array();
		$getParams[$this->_sortOrderName] = $this->_sortOrderName.'=' . $sortOrder;
		$getParams[$this->_sortByIdName] = $this->_sortByIdName.'=' . $sortById;

		foreach ($_GET as $key => $value) {
			if ($this->_sortOrderName === $key) {
				$getParams[$this->_sortOrderName] = $this->_sortOrderName.'=' . $sortOrder;
			} elseif ($this->_sortByIdName === $key) {
				$getParams[$this->_sortByIdName] = $this->_sortByIdName.'=' . $sortById;
			} else {
				if (is_array($value)) {
					foreach ($value as $arrayKey => $arrayValue) {
						$getParams[] = $key . '[' . $arrayKey . ']=' . urlencode($arrayValue);
					}
				} else {
					$getParams[] = $key . '=' . urlencode($value);
				}
			}
		}

		return 'index.php?' . implode('&amp;', $getParams);
	}

	public function getSort()
	{
		return $this->_colsDefinition[$this->_sortedBy][$this->_sortByIdName] . ' ' . $this->_sortOrder;
	}

	public function getSortOrder()
	{
		return $this->_sortOrder;
	}

	public function getSortedBy()
	{
		return $this->_sortedBy;
	}

	/**
	 *
	 * @return string
	 */
	public function renderPager()
	{
		if (count($this->_pager->getLimits()) > 0) {
			return '<tr><th colspan="' . count($this->_colsDefinition) . '" >' . $this->_pager->createPlaceHolder() . '</th></tr>';
		}

		return '';
	}

	public function setPager(Iwebs_Pager $pager)
	{
		$this->_pager = $pager;
	}
}