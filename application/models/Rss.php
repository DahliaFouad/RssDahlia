<?php
class Application_Model_Rss extends Zend_Db_Table_Abstract
{
    protected $_name = 'rss';
	
    public function addAction($data)
    {
        $row = $this->createRow();
        $row->name = $data['name'];
        $row->description = $data['description'];
        $row->url = $data['url'];
        $row->user_id = $data['user_id'];
        return $row->save();
    }
    function listRssPerUser($uid){
       	return $this -> fetchAll( 'user_id='.$uid ) -> toArray();
	}
	
    
    function getRssById($data){
		return $this->find($data)->toArray();
	}
    
            
    function deleteRss($id){
        return $this->delete('id='.$id);
    }

}
