<?php
class Location
{
    private $_id;
    private $_companyid;
    private $_address;
    private $_name;
    private $_lat;
    private $_lng;
    private $_db;
    //Set
    public function __construct()
    {
       $this->_db = DB::getInstance();
    }
    public function SetId($id = null)
    {
       $this->_id = $id; 
    }
    public function SetCompanyId($companyid = null)
    {
       $this->_companyid = $companyid; 
    }
    public function SetName($name = null)
    {
       $this->_name = $name; 
    }
    public function SetAddress($address = null)
    {
       $this->_address = $address; 
    }
    public function SetLat($lat = null)
    {
       $this->_lat = $lat; 
    }
    public function SetLng($lng = null)
    {
       $this->_lng = $lng; 
    }
    //Get
    public function GetId()
    {
       return $this->_id; 
    }
    public function GetCompanyId()
    {
       return $this->_companyid; 
    }
    public function GetName()
    {
       return $this->_name; 
    }
    public function GetAddress()
    {
       return $this->_address; 
    }
    public function GetLat()
    {
       return $this->_lat; 
    }
    public function GetLng()
    {
       return $this->_lng; 
    }
    //Other methods
    public function SetAttributesFromDB($DBArray)
    {
        $this->SetId($DBArray->LocationId);
        $this->SetCompanyId($DBArray->company_id);
        $this->SetName($DBArray->LocationName);
        $this->SetAddress($DBArray->LocationAdress);
        $this->SetLat($DBArray->LocationLat);
        $this->SetLng($DBArray->LocationLng);
    }
    public function LocationToArray()
    {
        $ret_arr = array();
        $ret_arr["LocationId"] = $this->GetId();
        $ret_arr["company_id"] = $this->GetCompanyId();
        $ret_arr["LocationName"] = $this->GetName();
        $ret_arr["LocationAdress"] = $this->GetAddress();
        $ret_arr["LocationLat"] = $this->GetLat();
        $ret_arr["LocationLng"] = $this->GetLng();
        return $ret_arr;
    }
    public function AddANewLocation()
    {
        $params = $this->LocationToArray();
        $this->_db->query("SELECT * FROM locations WHERE `company_id` = ? AND ((`LocationLat` = ? AND `LocationLng` = ?) OR `LocationName` = ? )", array($this->GetCompanyId(), $this->GetLat(), $this->GetLng(), $this->GetName()));
        //print_r($this->_db);
        if($this->_db->count() != 0)
        {
             throw new Exception("Location with that Name or Latitude and Longitude already exists");
        }
        else
        {
            if(!$this->_db->insert('locations', $params))
            {
                throw new Exception("There was a problem inserting the company");
            }
        }
    }
}

?>