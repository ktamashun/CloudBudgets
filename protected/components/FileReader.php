<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FileReader
 *
 * @author Tamás
 */
class FileReader
{
	/**
	 * Line length.
	 *
	 * @var int
	 */
	const LINE_LENGTH = 4096;

	/**
	 * The filepath.
	 *
	 * @var string
	 */
	protected $_filePath = null;

	/**
	 * The php resource pointing to the file.
	 *
	 * @var resource
	 */
	protected $_resource = null;


	/**
	 * Constructor.
	 *
	 * @param string $filePath
	 */
	public function __construct($filePath)
	{
		$this->setFilePath($filePath);
	}

	/**
	 * Sets the filepath.
	 *
	 * @param string $filePath
	 * @return \FileReader
	 * @throws Exception If the given file does not exists.
	 */
	public function setFilePath($filePath)
	{
		if (!realpath($filePath)) {
			throw new Exception('The give file could not be found: ' . $filePath);
		}

		$this->_filePath = realpath($filePath);
		return $this;
	}

	/**
	 * Opens the file.
	 *
	 * @return \FileReader
	 */
	public function open()
	{
		$this->_resource = fopen($this->_filePath, 'r');
		return $this;
	}

	/**
	 * Closes the file.
	 *
	 * @return \FileReader
	 */
	public function close()
	{
		if (null == $this->_resource) {
			fclose($this->_resource);
		}

		return $this;
	}

	/**
	 * Reads a line from the file and returns it.
	 *
	 * @return string|false
	 */
	public function readLine()
	{
		if (null === $this->_resource) {
			$this->open();
		}

		return fgets($this->_resource);
	}

	/**
	 * Reads the whole file and returns its content.
	 *
	 * @return string|false
	 */
	public function readFile()
	{
		return file_get_contents($this->_filePath);
	}
}
