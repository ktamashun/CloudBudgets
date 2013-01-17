<?php

class Command extends CConsoleCommand
{
	protected function _log($message = 'done.', $eol = "\n")
	{
		echo date('Y-m-d H:i:s: ') . $message . $eol;
	}
}
