<?php
class RssController extends Zend_Controller_Action
{
    private $auth=null;
    private $user=null;

    public function init()
    {
        $this->auth = Zend_Auth::getInstance();
        if($this->auth->hasIdentity()){
            $this->view->user=$this->auth->getIdentity();
            $this->user=$this->auth->getIdentity();
        }
            $this->model = new Application_Model_Rss();
            if($this->auth->getIdentity()){}else{$this->redirect('/index/index');
        }
    }
    public function isValidUrl($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL) === false) 
         {
            try{
                  $feed = Zend_Feed_Reader::import($url);  
                  return true;
                }
                catch(Exception $e)
                {
                    return false;
                }
           
         } 
         else {
            return false;
              }
    }
    public function alreadyExists($id)
    {
         $result = $this->model->listRssPerUser($this->user->id,$id);
         if (empty($result))
         {
             return false;
         }
         else
         {
             return true;

         }
    }
    public function addAction()
    {
        $data = $this->getRequest()->getParams();
        $form = new Application_Form_Rss();
        if($this->getRequest()->isPost())
        {
            if($this->isValidUrl($data['url']))
                {

                            
            $data['user_id']=$this->user->id;
            $data['id']=null;
            if($form->isValid($data))
            {
                if ($this->model->addAction($data))
                {
                    $this->redirect('rss/add');
                }
            }
            }
           
        }
        $this->view->flag = 1;
        $this->view->form = $form;
        $this->render('add');
    }
    

    public function deleteAction()
    {
      
             $rssid = $this->getRequest()->getParam('id');
             if ($this->model->deleteRss($rssid))
                $this->redirect('rss/list');        

                $this->redirect('rss/list');        
                
    }
     function viewAction()
    {
   $rssid = $this->getRequest()->getParam('id');

         $old = $this->model->getRssById($rssid);
         $this->view->rsstitle=$old[0]['name'];
         $this->view->rssdesc=$old[0]['description'];
         echo '<meta charset="UTF-8">';
         $feed = Zend_Feed_Reader::import($old[0]['url']); 
        foreach ($feed as $entry) {
                     $edata = array(
                         'id' => $entry->getId(),
                         'title'        => $entry->getTitle(),
                         'description'  => $entry->getDescription(),
                         'dateModified' => $entry->getDateModified(),
                        'authors'       => $entry->getAuthors(),
                         'link'         => $entry->getLink(),
                        'content'      => $entry->getContent()
                     );
                     $data['entries'][] = $edata;
                                 }

                                
     $this->view->rssdata=$data;
       
 
                
    }
function listAction()
    {
        $uid=$this->user->id;
        $this->view->rss = $this->model->listRssPerUser($uid);
    }

}
