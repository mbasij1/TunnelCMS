<?php
////////////////////////////////////////////////////////////
///////////////////// CONECTOR DATABASE MYSQL
///////////////////// CREATED BY MORTEZA BASIJ V 1.0
////////////////////////////////////////////////////////////
class database
{
	private $client;
	private $db;
	private $collection;// = $db->SelectCollection('Form');
	
	function __construct() {
		$this->client = new MongoClient();
		$this->db     = $this->client->SelectDB(DB_NAME);
	}
	
	function __get($key)
	{
		$this->collection = $this->db->SelectCollection($key);
		return $this->collection;
	}
	
	public function storeUpload($name , $metadata = array())
	{
		$gridfs = $this->db->getGridFS();
		return $gridfs->storeUpload($name, $metadata);
	}
	
	public function GetFile($id, $isObjectID = false)
	{
		$gridfs = $this->db->getGridFS();
		if($isObjectID)
			return $gridfs->findOne(array("_id" => $id));
		else
			return $gridfs->findOne(array("_id" => new MongoId($id)));
	}
}
?>