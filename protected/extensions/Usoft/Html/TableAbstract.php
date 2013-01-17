<?php

/**
 *
 * @author Kovács Tamás
 * @category Iwebs
 * @package Iwebs_Html
 * @subpackage Table
 */
class Iwebs_Html_TableAbstract extends Iwebs_ComponentAbstract
{
	/**
	 * A táblázat fejléce.
	 *
	 * @var Iwebs_Html_Table_Header
	 */
	protected $_header = null;

	/**
	 * A táblázat lapozója.
	 *
	 * @var Iwebs_Pager
	 */
	protected $_pager = null;

	/**
	 * A táblázad adatai.
	 *
	 * @var array
	 */
	protected $_dataRows = array();

	/**
	 * Config tömb.
	 *
	 * @var array
	 */
	protected $_config = array(
		'pageNumber' => 1,
		'csvExport' => false,
		'mode' => 'HTML',
		'filters' => array()
	);


	protected function _init()
	{
		parent::_init();
	}

	/**
	 * Visszaadja a táblázat lapozóját.
	 *
	 * @return Iwebs_Pager
	 */
	public function getPager()
	{
		if (null === $this->_pager) {
			$this->_pager = new Iwebs_Pager(Iwebs::app()->getConfigOption('rowPerPage'), $this->_config['pageNumber']);
		}

		return $this->_pager;
	}
	/**
	 * Visszaadja a táblázat fejlécét.
	 *
	 * @return Iwebs_Html_Table_Header
	 */
	public function getHeader()
	{}

	public function render()
	{
		$this->_config['mode'] = 'HTML';
		$this->getDataRows();

		$maxRows = $this->_pager->getMaxRows();

		if ($maxRows > 0) {
			$str = "
				<div style=\"float: left; clear: both; width: 230px;\">
					Találatok száma: " . $maxRows . "
					<br />
					<a href=\"" . $_SERVER['REQUEST_URI'] . "&export=csv\" style=\"text-decoration: none; \" ><img src=\"images/icons/large/file_extension_xls.png\" align=\"absmiddle\" /> CSV export</a>
				</div>
				<div class=\"pager\" style=\"margin-top: 10px; \" >
					" . $this->getPager()->render() . "
				</div>
				<table class=\"data-table\">
					" . $this->getHeader()->render() . "

					<tbody>
						" . $this->_renderRows() . "
					</tbody>
				</table>
			";
		} else {
			$str = '<em>Nincs a keresési feltételeknek megfelelő találat.</em>';
		}

		return $str;
	}
	/** Gabi módosítása a popup-okhoz **/
	public function renderPopup()
	{
		$this->_config['mode'] = 'HTML';
		$this->getDataRows();


		$maxRows = $this->_pager->getMaxRows();

		if ($maxRows > 0) {
			$str = "
				<div class=\"pager\" style=\"margin-top: 10px; \" >
					" . $this->getPager()->render() . "
				</div>
				<table class=\"data-table\">
					" . $this->getHeader()->render() . "

					<tbody>
						" . $this->_renderRows() . "
					</tbody>
				</table>
			";
		} else {
			$str = '<em>Nincs a keresési feltételeknek megfelelő találat.</em>';
		}

		return $str;
	}


	public function _renderRows()
	{
		$str = '';
		$rowClass = 'row-0';

		foreach ($this->getDataRows() as $dataRow) {
			$str .= $this->_renderRow($dataRow, $rowClass);
			$rowClass = 'row-1' === $rowClass ? 'row-0' : 'row-1';
		}
		//echo Iwebs_Debug::varDump($str); die();

		return $str;
	}

	public function _renderRow($dataRow, $rowClass = 'row-0')
	{
		$colDefinitions = $this->_header->getColDefinitions();
		$str = '<tr class="' . $rowClass . '" >';

		foreach ($colDefinitions as $colDefinition) {
			$style = $this->_header->getColStyle($colDefinition['sortById']);
			$onclick = $colDefinition['onclick'];
			if (!empty($style)) {
				$style = ' style = "' . $style . '" ';
			}
			if (!empty($onclick)) {
				$onclick = ' onclick = "' . str_replace('{id}', $dataRow['id'], $onclick) . '" ';
			}

			$str .= '<td' . $style . $onclick . '>' . $this->_renderColContent($colDefinition, $dataRow) . '</td>';
		}

		return $str . '</tr>';
	}

	protected function _renderColContent($colDefinition, $dataRow)
	{
		$colId = $colDefinition['sortById'];
		$renderMethod = 'renderCol' . ucfirst($colId);

		if (method_exists($this, $renderMethod)) {
			return $this->$renderMethod($colDefinition, $dataRow);
		}

		return $dataRow[$colId];
	}

	public function renderCsv()
	{
		$this->_config['mode'] = 'EXPORT';
		$colDefinitions = $this->_header->getColDefinitions();

		foreach ($colDefinitions as $colDefinition) {
			if ($colDefinition['exportable']) {
				$str .= '"' . addslashes(strtoupper($colDefinition['text'])) . '";';
			}
		}

		$str .= "\n";
		foreach ($this->getDataRows() as $dataRow) {
			foreach ($colDefinitions as $colDefinition) {
				if ($colDefinition['exportable']) {
					$str .= '"' . addslashes($this->_renderColContent($colDefinition, $dataRow)) . '";';
				}
			}
			$str .= "\n";
		}

		return iconv('UTF-8', 'ISO-8859-2', $str);
	}

	public function setDataRows($dataRows)
	{
		$this->_dataRows = $dataRows;
		return $this;
	}

	public function getDataRows()
	{
		return $this->_dataRows;
	}

	protected function _getOrderBy()
	{
		return trim($this->_header->getSort());
	}

	protected function _getLimit()
	{
		if ('EXPORT' === $this->_config['mode']) {
			return null;
		}

		return $this->_pager->getLimitStartNumber() . ', ' . $this->_pager->getRowsPerPage();
	}

	public function renderColEdit($colDefinition, $dataRow)
	{
		$href = 'index.php?p=' . Iwebs::app()->getRequest()->getParam('p') . '&amp;sp=edit&amp;id=' . $dataRow['id'];
		return Iwebs::view()->renderPartialScript('common/editRow.phtml', array('href' => $href), true);
	}
	//2011.09.07 Gabi
	public function renderColEditPartner($colDefinition, $dataRow)
	{
		$href = 'index.php?p=' . Iwebs::app()->getRequest()->getParam('p') . '&amp;sp=editPartner&amp;id=' . $dataRow['id'];
		return Iwebs::view()->renderPartialScript('common/editPartnerRow.phtml', array('href' => $href), true);
	}
	//2011.09.08 Gabi
	public function renderColEditContact($colDefinition, $dataRow)
	{
		$href = 'index.php?p=' . Iwebs::app()->getRequest()->getParam('p') . '&amp;sp=editContact&amp;id=' . $dataRow['id'];
		return Iwebs::view()->renderPartialScript('common/editContactRow.phtml', array('href' => $href), true);
	}

	public function renderColDelete($colDefinition, $dataRow)
	{
		$href = 'index.php?p=' . Iwebs::app()->getRequest()->getParam('p') . '&amp;sp=delete&amp;id=' . $dataRow['id'];
		return Iwebs::view()->renderPartialScript('common/deleteRow.phtml', array('href' => $href), true);
	}

	public function renderColShow($colDefinition, $dataRow)
	{
		$href = 'index.php?p=' . Iwebs::app()->getRequest()->getParam('p') . '&amp;sp=show&amp;id=' . $dataRow['id'];
		return Iwebs::view()->renderPartialScript('common/showRow.phtml', array('href' => $href), true);
	}
}
