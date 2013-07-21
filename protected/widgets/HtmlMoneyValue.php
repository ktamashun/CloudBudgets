<?php

/**
 * Class HtmlMoneyValue
 */
class HtmlMoneyValue extends CWidget
{
    /**
     * @var int
     */
    public $value = null;

    /**
     * @var Account
     */
    public $account = null;

    /**
     * @var Transaction
     */
    public $transaction = null;

    /**
     * Css classes.
     *
     * @var array
     */
    public $class = array();

    /**
     * Override default balance css class.
     *
     * @var null|string
     */
    public $forcedBalanceClass = null;

    /**
     * @var string
     */
    public $prepend = '';


    /**
     *
     */
    public function init()
	{}

    /**
     *
     */
    public function run()
	{
		if (null === $this->account) {
			$iso_code = User::getLoggedInUser()->defaultCurrency->iso_code;
		} else {
			$iso_code = $this->account->currency->iso_code;
		}

		if (null === $this->value) {
            $this->value = 0;
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

        if (null == $this->forcedBalanceClass) {
            $this->class[] = (0 < $this->value ? 'positive-balance' : (0 == $this->value ? 'zero-balance' : 'negative-balance'));
        } else {
            $this->class[] = $this->forcedBalanceClass;
        }

		echo '<span class="' . implode(' ', $this->class) . '">' . $this->prepend . number_format($this->value, 2, '.', ',') . ' ' . $iso_code . '</span>';
	}
}
