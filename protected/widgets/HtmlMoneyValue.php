<?php

class HtmlMoneyValue extends CWidget
{
	public $value = null;
	public $account = null;
	public $transaction = null;
	public $class = array();
	public $prepend = '';


	public function init()
	{}

	public function run()
	{
		if (null === $this->account) {
			$iso_code = User::getLoggedInUser()->defaultCurrency->iso_code;
		} else {
			$iso_code = $this->account->currency->iso_code;
		}

		if (null === $this->value) {
			$value = 0;
		}

		if (null !== $this->transaction) {
			$this->value = $this->transaction->amount;

			if ($this->transaction->isTransfer()) {
				$this->prepend .= '<span class = "icon-refresh" ></span> ';

				if (null === $this->account) {
					$this->value = abs($this->value);
				}
			}
		}

		$this->class[] = 'balance-value';
		$this->class[] = (0 < $this->value ? 'positive-balance' : (0 == $this->value ? 'zero-balance' : 'negative-balance'));

		echo '<span class="' . implode(' ', $this->class) . '">' . $this->prepend . number_format($this->value, 2, '.', ',') . ' ' . $iso_code . '</span>';
	}
}
