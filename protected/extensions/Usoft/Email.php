<?php

@include_once 'Rmail/Rmail.php';

if (!class_exists('Rmail')) {
    class Buk_Email {}
    throw new Exception('Nem található az Rmail csomag. ');
}

/**
 *
 * @author Kovács Tamás
 *
 */
class Buk_Email extends Rmail
{
    /**
     * A konfigurációk tömbje.
     *
     * @var array
     */
    protected static $_config = array(
        'defaultRecipients' => null,
        'redirectTo' => null,
        'fromName' => 'eGov',
        'redirectTo' => null,
        'redirectTo' => null,
        'fromAddress' => null,
        'charset' => null,
        'sendingMethod' => null,
        'smtp' => null,
        'bccAddress' => null,
        'disableSending' => false
    );

    protected $_params = array();


	public function appendText($text){
		$this->text .= $text;
	}

    /**
     * Constructor.
     */
    public function __construct($params = array())
    {
		$this->_params = $params;
        parent::__construct();
        $this->init();
    }

    /**
     *
     */
    public function init()
    {
        if (self::$_config['sendingMethod']=='smtp') {
            $this->setSMTPParams(self::$_config['smtp']['host'], null, null, self::$_config['smtp']['useAuth'], self::$_config['smtp']['user'], self::$_config['smtp']['pass']);
        }
		$this->setFrom(self::$_config['fromName'].' <'.self::$_config['fromAddress'].'>');
		$this->setReturnPath(self::$_config['fromAddress']);
		$this->setHeadCharset(self::$_config['charset']);
		$this->setHTMLCharset(self::$_config['charset']);
		$this->setTextCharset(self::$_config['charset']);
    }

    /**
     * Beállítja a megadott config adatokat.
     * Megadható beállítások:
     * - fromAddress: A feladó e-mail cím.
     * - charset: A fejléc, a html szöveg és a sima szöveg kódolása.
     * - smtp: SMTP beállítások. Megadható adatok: host.
     *
     * @param array $config A konfig beállítások tömbként.
     * @return void
     */
    public static function setConfig($config)
    {
        foreach (self::$_config as $key => $value) {
            if (array_key_exists($key, $config)) {
                self::$_config[$key] = $config[$key];
            }
        }
    }

	public function getMessage(){
		return $this->text;
	}

    /**
    * Sends the mail.
    *
    * @param  array  $recipients Array of receipients to send the mail to
    * @return mixed
    */
    public function send($recipients=array())
    {
    	if (true === self::$_config['disableSending']) {
    		return true;
    	}

    	if (self::$_config['redirectTo'] != null) {
    		$this->appendText("\n\nEredeti Címzettek: ".implode(', ',(array)$recipients));
    		$recipients = self::$_config['redirectTo'];
    	} elseif (count($recipients)==0) {
            $recipients = self::$_config['defaultRecipients'];
        }
        return parent::send((array)$recipients, self::$_config['sendingMethod']);
    }

    public function setBccAddress($bcc=NULL){
    	if ($bcc === NULL) {
    		$bcc = self::$_config['bccAddress'];
    	}
    	$this->setBcc($bcc);
    }

    public function getFrom(){
    	return $this->headers['From'];
    }
}