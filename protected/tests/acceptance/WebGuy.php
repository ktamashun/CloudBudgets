<?php
// This class was automatically generated by build task
// You can change it manually, but it will be overwritten on next build

use Codeception\Maybe;
use Codeception\Module\PhpBrowser;
use Codeception\Module\WebHelper;

/**
 * Inherited methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void amTesting($method)
 * @method void amTestingMethod($method)
 * @method void testMethod($signature)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($role)
*/

class WebGuy extends \Codeception\AbstractGuy
{
    
    /**
     * Submits a form located on page.
     * Specify the form by it's css or xpath selector.
     * Fill the form fields values as array.
     *
     * Skipped fields will be filled by their values from page.
     * You don't need to click the 'Submit' button afterwards.
     * This command itself triggers the request to form's action.
     *
     * Examples:
     *
     * ``` php
     * <?php
     * $I->submitForm('#login', array('login' => 'davert', 'password' => '123456'));
     *
     * ```
     *
     * For sample Sign Up form:
     *
     * ``` html
     * <form action="/sign_up">
     *     Login: <input type="text" name="user[login]" /><br/>
     *     Password: <input type="password" name="user[password]" /><br/>
     *     Do you agree to out terms? <input type="checkbox" name="user[agree]" /><br/>
     *     Select pricing plan <select name="plan"><option value="1">Free</option><option value="2" selected="selected">Paid</option></select>
     *     <input type="submit" value="Submit" />
     * </form>
     * ```
     * I can write this:
     *
     * ``` php
     * <?php
     * $I->submitForm('#userForm', array('user' => array('login' => 'Davert', 'password' => '123456', 'agree' => true)));
     *
     * ```
     * Note, that pricing plan will be set to Paid, as it's selected on page.
     *
     * @param $selector
     * @param $params
     * @see PhpBrowser::submitForm()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function submitForm($selector, $params) {
        $this->scenario->action('submitForm', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * If your page triggers an ajax request, you can perform it manually.
     * This action sends a POST ajax request with specified params.
     * Additional params can be passed as array.
     *
     * Example:
     *
     * Imagine that by clicking checkbox you trigger ajax request which updates user settings.
     * We emulate that click by running this ajax request manually.
     *
     * ``` php
     * <?php
     * $I->sendAjaxPostRequest('/updateSettings', array('notifications' => true); // POST
     * $I->sendAjaxGetRequest('/updateSettings', array('notifications' => true); // GET
     *
     * ```
     *
     * @param $uri
     * @param $params
     * @see PhpBrowser::sendAjaxPostRequest()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function sendAjaxPostRequest($uri, $params = null) {
        $this->scenario->action('sendAjaxPostRequest', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * If your page triggers an ajax request, you can perform it manually.
     * This action sends a GET ajax request with specified params.
     *
     * See ->sendAjaxPostRequest for examples.
     *
     * @param $uri
     * @param $params
     * @see PhpBrowser::sendAjaxGetRequest()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function sendAjaxGetRequest($uri, $params = null) {
        $this->scenario->action('sendAjaxGetRequest', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * Opens the page.
     *
     * @param $page
     * @see PhpBrowser::amOnPage()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function amOnPage($page) {
        $this->scenario->condition('amOnPage', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * Check if current page doesn't contain the text specified.
     * Specify the css selector to match only specific region.
     *
     * Examples:
     *
     * ```php
     * <?php
     * $I->dontSee('Login'); // I can suppose user is already logged in
     * $I->dontSee('Sign Up','h1'); // I can suppose it's not a signup page
     * $I->dontSee('Sign Up','//body/h1'); // with XPath
     * ```
     *
     * @param $text
     * @param null $selector
     * @see PhpBrowser::dontSee()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function dontSee($text, $selector = null) {
        $this->scenario->action('dontSee', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * Check if current page contains the text specified.
     * Specify the css selector to match only specific region.
     *
     * Examples:
     *
     * ``` php
     * <?php
     * $I->see('Logout'); // I can suppose user is logged in
     * $I->see('Sign Up','h1'); // I can suppose it's a signup page
     * $I->see('Sign Up','//body/h1'); // with XPath
     *
     * ```
     *
     * @param $text
     * @param null $selector
     * @see PhpBrowser::see()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function see($text, $selector = null) {
        $this->scenario->assertion('see', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * Checks if the document has link that contains specified
     * text (or text and url)
     *
     * @param  string $text
     * @param  string $url (Default: null)
     * @return mixed
     * @see PhpBrowser::seeLink()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function seeLink($text, $url = null) {
        $this->scenario->assertion('seeLink', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * Checks if the document hasn't link that contains specified
     * text (or text and url)
     *
     * @param  string $text
     * @param  string $url (Default: null)
     * @return mixed
     * @see PhpBrowser::dontSeeLink()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function dontSeeLink($text, $url = null) {
        $this->scenario->action('dontSeeLink', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * Clicks on either link or button (for PHPBrowser) or on any selector for JS browsers.
     * Link text or css selector can be passed.
     *
     * @param $link
     * @see PhpBrowser::click()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function click($link) {
        $this->scenario->action('click', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * Reloads current page
     * @see PhpBrowser::reloadPage()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function reloadPage() {
        $this->scenario->action('reloadPage', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * Moves back in history
     * @see PhpBrowser::moveBack()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function moveBack() {
        $this->scenario->action('moveBack', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * Moves forward in history
     * @see PhpBrowser::moveForward()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function moveForward() {
        $this->scenario->action('moveForward', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * Fill the field with given value.
     * Field is searched by its id|name|label|value or CSS selector.
     *
     * @param $field
     * @param $value
     * @see PhpBrowser::fillField()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function fillField($field, $value) {
        $this->scenario->action('fillField', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * Selects opition from selectbox.
     * Use field name|label|value|id or CSS selector to match selectbox.
     * Either values or text of options can be used to fetch option.
     *
     * @param $select
     * @param $option
     * @see PhpBrowser::selectOption()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function selectOption($select, $option) {
        $this->scenario->action('selectOption', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * Check matched checkbox or radiobutton.
     * Field is searched by its id|name|label|value or CSS selector.
     *
     * @param $option
     * @see PhpBrowser::checkOption()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function checkOption($option) {
        $this->scenario->action('checkOption', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * Uncheck matched checkbox or radiobutton.
     * Field is searched by its id|name|label|value or CSS selector.
     *
     * @param $option
     * @see PhpBrowser::uncheckOption()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function uncheckOption($option) {
        $this->scenario->action('uncheckOption', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * Checks if current url contains the $uri.
     *
     * @param $uri
     * @see PhpBrowser::seeInCurrentUrl()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function seeInCurrentUrl($uri) {
        $this->scenario->assertion('seeInCurrentUrl', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * Attaches file stored in Codeception data directory to field specified.
     * Field is searched by its id|name|label|value or CSS selector.
     *
     * @param $field
     * @param $filename
     * @see PhpBrowser::attachFile()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function attachFile($field, $filename) {
        $this->scenario->action('attachFile', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * Asserts the checkbox is checked.
     * Field is searched by its id|name|label|value or CSS selector.
     *
     * @param $checkbox
     * @see PhpBrowser::seeCheckboxIsChecked()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function seeCheckboxIsChecked($checkbox) {
        $this->scenario->assertion('seeCheckboxIsChecked', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * Asserts that checbox is not checked
     * Field is searched by its id|name|label|value or CSS selector.
     *
     * @param $checkbox
     * @see PhpBrowser::dontSeeCheckboxIsChecked()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function dontSeeCheckboxIsChecked($checkbox) {
        $this->scenario->action('dontSeeCheckboxIsChecked', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * Checks the value of field is equal to value passed.
     *
     * @param $field
     * @param $value
     * @see PhpBrowser::seeInField()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function seeInField($field, $value) {
        $this->scenario->assertion('seeInField', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * Checks the value in field is not equal to value passed.
     * Field is searched by its id|name|label|value or CSS selector.
     *
     * @param $field
     * @param $value
     * @see PhpBrowser::dontSeeInField()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function dontSeeInField($field, $value) {
        $this->scenario->action('dontSeeInField', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * Finds and returns text contents of element.
     * Element is searched by CSS selector, XPath or matcher by regex.
     *
     * Example:
     *
     * ``` php
     * <?php
     * $heading = $I->grabTextFrom('h1');
     * $heading = $I->grabTextFrom('descendant-or-self::h1');
     * $value = $I->grabTextFrom('~<input value=(.*?)]~sgi');
     * ?>
     * ```
     *
     * @param $cssOrXPathOrRegex
     * @return mixed
     * @see PhpBrowser::grabTextFrom()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function grabTextFrom($cssOrXPathOrRegex) {
        $this->scenario->action('grabTextFrom', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     * Finds and returns field and returns it's value.
     * Searches by field name, then by CSS, then by XPath
     *
     * Example:
     *
     * ``` php
     * <?php
     * $name = $I->grabValueFrom('Name');
     * $name = $I->grabValueFrom('input[name=username]');
     * $name = $I->grabValueFrom('descendant-or-self::form/descendant::input[@name = 'username']');
     * ?>
     * ```
     *
     * @param $field
     * @return mixed
     * @see PhpBrowser::grabValueFrom()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function grabValueFrom($field) {
        $this->scenario->action('grabValueFrom', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }

 
    /**
     *
     * @see PhpBrowser::grabAttribute()
     *
     * ! This method is generated. DO NOT EDIT. !
     * ! Documentation taken from corresponding module !
     */
    public function grabAttribute() {
        $this->scenario->action('grabAttribute', func_get_args());
        if ($this->scenario->running()) {
            $result = $this->scenario->runStep();
            return new Maybe($result);
        }
        return new Maybe();
    }
}

