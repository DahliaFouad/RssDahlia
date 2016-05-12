<?php

class IndexController extends Zend_Controller_Action
{

public function indexAction()
{

$users = new Application_Model_Users();
$form = new Application_Form_LoginForm();
$this->view->form = $form;
if($this->getRequest()->isPost()){
if($form->isValid($_POST)){
$data = $form->getValues();
$auth = Zend_Auth::getInstance();
$authAdapter = new Zend_Auth_Adapter_DbTable($users->getAdapter(),'Users');
$authAdapter->setIdentityColumn('username')
->setCredentialColumn('password');
$authAdapter->setIdentity($data['username'])
->setCredential($data['password']);
$result = $auth->authenticate($authAdapter);
if($result->isValid()){
$storage = new Zend_Auth_Storage_Session();
$storage->write($authAdapter->getResultRowObject());
$this->_redirect('index/home');
} else {
$this->view->errorMessage = "Invalid username or password. Please try again.";
}
}
}

}
 function signupAction()
{

$users = new Application_Model_Users();
$form = new Application_Form_RegistrationForm();
$this->view->form=$form;
if($this->getRequest()->isPost()){
if($form->isValid($_POST)){
$data = $form->getValues();
if($data['password'] != $data['confirmPassword']){
$this->view->errorMessage = "Password and confirm password don’t match.";
return;
}
unset($data['confirmPassword']);
$users->insert($data);
$this->_redirect('index/index');
}
}

}
 function logoutAction()
{
$storage = new Zend_Auth_Storage_Session();
$storage->clear();
$this->_redirect('index/index');

}
 function homeAction()
{

$storage = new Zend_Auth_Storage_Session();
$data = $storage->read();
if(!$data)
{
$this->_redirect('index/index');
}
$this->view->username = $data->username;
}


}

