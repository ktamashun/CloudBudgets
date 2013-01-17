<?php

/**
 *
 * @author Kovács Tamás
 * @category Buk
 * @package Iwebs_Pager
 */
class Iwebs_Pager
{
	/**
	 *
	 * @var int
	 */
	protected $_rowsPerPage = 25;

	/**
	 *
	 * @var int
	 */
	protected $_actPage = 1;

	/**
	 *
	 * @var int
	 */
	protected $_maxRows = 0;


	/**
	 * Constructor.
	 *
	 * @param int $rowsPerPage
	 * @param int $actPage
	 * @return void
	 */
	public function __construct($rowsPerPage = 25, $actPage = 1)
	{
		if ((int)$rowsPerPage <= 0) {
			throw new Exception('Csak 0-nál nagyobb számú sort tudunk megjeleníteni.');
		}
		if ((int)$actPage < 0) {
			throw new Exception('Az aktuális oldalszám 0-nál nagyobb legyen.');
		}
		if (0 === (int)$actPage) {
			$actPage = 1;
		}

		$this->_rowsPerPage = (int)$rowsPerPage;
		$this->_actPage = (int)$actPage;
	}

	/**
	 *
	 * @param int $maxRows
	 * @return Iwebs_Pager
	 */
	public function setMaxRows($maxRows)
	{
		if ((int)$maxRows < 0) {
			throw new Exception('A találatok száma 0, vagy annál nagyobb legyen.');
		}

		$this->_maxRows = $maxRows;
		return $this;
	}

	/**
	 * Iwebs_Pager::setActPage()
	 *
	 * @param int $actPage
	 * @return Iwebs_Pager
	 */
	public function setActPage($actPage)
	{
		if (null !== $actPage) {
			$this->_actPage = (int)$actPage;
		}

		return $this;
	}

	/**
	 *
	 * @return string
	 */
	public function render()
	{
		if ($this->_maxRows <= $this->_rowsPerPage) {
			return '<div class="spacer"></div>';
		}

		$returnString = '<ul>'
			. $this->_renderButton('&laquo;', 1, 0)
			. $this->_renderButton('&lsaquo;', (1 === $this->_actPage ? 1 : ($this->_actPage - 1)), 0)
			. $this->renderNumberButtons()
			. $this->_renderButton('&rsaquo;', ($this->getLastPageNumber() === $this->_actPage ? $this->getLastPageNumber() : ($this->_actPage + 1)), 0)
			. $this->_renderButton('&raquo;', $this->getLastPageNumber(), 0)
			. '</ul>';

		return $returnString;
	}

	/**
	 *
	 * @return string
	 */
	public function renderNumberButtons()
	{
		$diff = 15;
		$startPage = $this->_actPage - $diff < 1 ? 1 : $this->_actPage - $diff;
		$endPage = $this->_actPage + $diff > $this->getLastPageNumber() ? $this->getLastPageNumber() : $this->_actPage + $diff;
		$returnString = '';
		for ($i = $startPage; $i <= $endPage; $i++) {
			$returnString .= $this->_renderButton($i, $i, 1);
		}

		return $returnString;
	}

	/**
	 *
	 * @return int
	 */
	public function getLastPageNumber()
	{
		return (int)ceil($this->_maxRows / $this->_rowsPerPage);
	}

	/**
	 *
	 * @param string $text
	 * @param int $pageNumber
	 * * @param int $btnType
	 * @return string
	 */
	protected function _renderButton($text, $pageNumber ,$btnType)
	{
		$returnString = '';
		if ($this->_actPage !== (int)$pageNumber) {
			$returnString = '<li><a '.($btnType?'':'class="btn" ').'href="' . $this->getPagerUrl($pageNumber) . '" >' . $text . '</a></li>';
		} else {
			$returnString = '<li><a '.($btnType?'':'class="btn" ').'href="' . $this->getPagerUrl($pageNumber) . '" ' . (0 !== (int)$text ? 'class="active"' : '') . ' >' . $text . '</a></li>';
		}

		return $returnString;
	}

	/**
	 *
	 *
	 * @param int $pageNumber
	 * @return string
	 */
	public function getPagerUrl($pageNumber)
	{
		if (!array_key_exists('pageNumber', $_GET)) {
			$_GET['pageNumber'] = 1;
		}
		$getParams = array();
		foreach ($_GET as $key => $value) {
			if ('pageNumber' === $key) {
				$getParams[] = 'pageNumber=' . $pageNumber;
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

	/**
	 *
	 * @return int
	 */
	public function getLimitStartNumber()
	{
		return $this->_rowsPerPage * ($this->_actPage - 1);
	}

	/**
	 *
	 * @return int
	 */
	public function getRowsPerPage()
	{
		return $this->_rowsPerPage;
	}

	public function getMaxRows()
	{
		return $this->_maxRows;
	}
}