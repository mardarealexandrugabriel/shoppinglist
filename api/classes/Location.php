<?php
class Location
{
    private $_id;
    private $_locationid;
    private $_companyid;
    private $_address;
    private $_lat;
    private $_lng;
    private $_db;
    public function __construct()
    {
       $this->_db = DB::getInstance();
    }
    public function SetId($id = null)
    {
       $this->_id = $id; 
    }
    public function SetLocationId($locationid= null)
    {
       $this->_locationid= $locationid; 
    }
    public function SetCompanyId($companyid = null)
    {
       $this->_companyid = $companyid; 
    }
    public function SetAddress($address = null)
    {
       $this->_address = $address; 
    }
    public function SetLat($lat = null)
    {
       $this->_lat = $lat; 
    }
    public function SetEnterDate($lng = null)
    {
       $this->_lng = $lng; 
    }
}

?>