<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TransactionImporterBase
 *
 * @author Tamás
 */
abstract class TransactionImporterBase
{
	/**
	 * The file reader object.
	 *
	 * @var FileReader
	 */
	protected $_fileReader = null;


	/**
	 * Constructor.
	 *
	 * @param FileReader $fileReader
	 */
	public function __construct(FileReader $fileReader)
	{
		$this->_fileReader = $fileReader;
	}
}
