<?php
class Application_Form_Rss extends Zend_Form
{
    public function init()
    {
        
/* Form Elements & Other Definitions Here ... */
        $id = new Zend_Form_Element_Hidden("id");
        
        $name = new Zend_Form_Element_Text("name");
        $name->setRequired();
        $name->setlabel("Site Name:");
        $name->setAttrib("class","form-control");
        $name->setAttrib("placeholder","Enter site name");

        $description= new Zend_Form_Element_Textarea("description");
        $description->setRequired();
        $description->setlabel("Description:");
        $description->setAttrib("class","form-control");
        $description->setAttrib("placeholder","Enter Description");
        
        
        $url = new Zend_Form_Element_Text("url");
        $url->setRequired();
        $url->setlabel("Site URL:");
        $url->setAttrib("class","form-control");
        $url->setAttrib("placeholder","Enter a valid URL");
    
        $submit = new Zend_Form_Element_Submit('submit');
        
        $this->addElements(array($id , $name , $description , $url , $submit ));
    }
    
}
