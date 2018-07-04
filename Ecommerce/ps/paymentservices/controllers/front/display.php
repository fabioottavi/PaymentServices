<?php

class helloWorldDisplayModuleFrontController extends ModuleFrontController
{


    public function initContent()
    {
        parent::initContent();
        $this->title = $this->module->l('My module title');
        $this->setTemplate('module:paymentservices/views/templates/front/display.tpl');
    }

    public function initHeader()
    {
        parent::initHeader();

    }

    public function hookDisplayHeader()
    {
        $this->context->controller->addCSS($this->_path.'css/hello_world.css');
    }
}