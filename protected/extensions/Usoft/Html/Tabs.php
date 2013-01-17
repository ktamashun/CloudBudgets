<?php

/**
 *
 * @author Kovács Tamás
 * @category Iwebs
 * @package Iwebs_Html
 */
class Iwebs_Html_Tabs
{
    /**
     * @var array
     */
    protected $_tabDefinitions = array();

    /**
     * @var int
     */
    protected $_activeTabId = null;


    /**
     * Iwebs_Html_Tabs::__construct()
     *
     * @return void
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Iwebs_Html_Tabs::init()
     *
     * @return void
     */
    public function init()
    {}

    /**
     * Iwebs_Html_Tabs::addTab()
     *
     * @param array $definition
     * @return Iwebs_Html_Tabs
     */
    public function addTab($definition)
    {
        if (!is_array($definition)) {
            throw new Exception('A tab configját tömbként kell megadni.');
        }

        $this->_tabDefinitions[] = array_merge(
            array(
                'text' => 'Tab',
                'href' => '#',
                'width' => null,
                'target' => '',
                'onclick' => null
            ),
            $definition
        );

        return $this;
    }

    /**
     * Iwebs_Html_Tabs::render()
     *
     * @return string
     */
    public function render()
    {
        $returnStr = '<ul class="iwebs-tabs" >';

        foreach ($this->_tabDefinitions as $id => $tabDefinition) {
            $returnStr .= $this->renderTab($id);
        }

        return $returnStr . '</ul>';
    }

    /**
     * Iwebs_Html_Tabs::renderTab()
     *
     * @param int $tabId
     * @return string
     */
    public function renderTab($tabId)
    {
        $width = (null === $this->_tabDefinitions[$tabId]['width'] ? round(100 / count($this->_tabDefinitions)) . '%' : $this->_tabDefinitions[$tabId]['width']);
        $class = 'iwebs-tabs-tab' . ((int)$this->_activeTabId === (int)$tabId ? ' iwebs-tabs-active' : '');
        $href = str_replace('{tabId}', $tabId, $this->_tabDefinitions[$tabId]['href']);

        return '<li class="' . $class . '" style="width: ' . $width . '; " >'
            . '<a href="'. $href . '" target="'. $this->_tabDefinitions[$tabId]['target'] . '" >'. $this->_tabDefinitions[$tabId]['text'] . '</a>'
            . '</li>';
    }

    /**
     * Iwebs_Html_Tabs::setActiveTab()
     *
     * @param int $id
     * @return Iwebs_Html_Tabs
     */
    public function setActiveTab($id)
    {
        if (array_key_exists($id, $this->_tabDefinitions)) {
            $this->_activeTabId = $id;
        }

        return $this;
    }
}
