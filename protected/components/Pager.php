<?php

class Pager extends CComponent
{
	/**
	 *
	 * @var int
	 */
	public $rowsPerPage = 25;

	/**
	 *
	 * @var int
	 */
	public $actPage = 1;

	/**
	 *
	 * @var int
	 */
	public $maxRows = 0;

	public $pageUrl = '';


	/**
	 * Constructor.
	 *
	 * @param int $rowsPerPage
	 * @param int $actPage
	 * @return void
	 */
	public function __construct($actPage = 1, $rowsPerPage = null)
	{
		if ((int)$actPage < 0) {
			throw new Exception('Az aktuális oldalszám 0-nál nagyobb legyen.');
		}
		if (0 === (int)$actPage) {
			$actPage = 1;
		}

		$this->actPage = (int)$actPage;

		if (null !== $rowsPerPage) {
			$this->rowsPerPage = (int)$rowsPerPage;
		}
	}

	public function init()
	{
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

		$this->maxRows = $maxRows;
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
			$this->actPage = (int)$actPage;
		}

		return $this;
	}

	/**
	 *
	 * @return string
	 */
	public function render()
	{
		if ($this->maxRows <= $this->rowsPerPage) {
			return ''; //'<div class="spacer"></div>';
		}

		$returnString = '<div class="pagination"><ul>'
			//. $this->_renderButton('&laquo;', 1, 0)
			. $this->_renderButton('&laquo;', (1 === $this->actPage ? 1 : ($this->actPage - 1)), 0)
			. $this->renderNumberButtons()
			. $this->_renderButton('&raquo;', ($this->getLastPageNumber() === $this->actPage ? $this->getLastPageNumber() : ($this->actPage + 1)), 0)
			//. $this->_renderButton('&raquo;', $this->getLastPageNumber(), 0)
			. '</ul></div>';

		return $returnString;
	}

	/**
	 *
	 * @return string
	 */
	public function renderNumberButtons()
	{
		$diff = 10;
		$startPage = $this->actPage - $diff < 1 ? 1 : $this->actPage - $diff;
		$endPage = $this->actPage + $diff > $this->getLastPageNumber() ? $this->getLastPageNumber() : $this->actPage + $diff;
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
		return (int)ceil($this->maxRows / $this->rowsPerPage);
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
		if ($this->actPage !== (int)$pageNumber) {
			$returnString = '<li><a href="' . $this->getPagerUrl($pageNumber) . '" >' . $text . '</a></li>';
		} else {
			if (0 === $btnType) {
				$returnString = '<li class="disabled" ><a href="' . $this->getPagerUrl($pageNumber) . '" >' . $text . '</a></li>';
			} else {
				$returnString = '<li' . (0 !== (int)$text ? ' class="active" ' : '') . '><a href="' . $this->getPagerUrl($pageNumber) . '" >' . $text . '</a></li>';
			}
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
		$pageUrl = $this->pageUrl;
		$pageUrl['pageNumber'] = $pageNumber;

		return CHtml::normalizeUrl($pageUrl);
	}

	/**
	 *
	 * @return int
	 */
	public function getLimitStartNumber()
	{
		return $this->rowsPerPage * ($this->actPage - 1);
	}
}
