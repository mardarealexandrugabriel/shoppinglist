<?php
class Company{
    private $_id;
    private $_name;
    private $_username;
    private $_password;
    private $_enterdate;
    private $_db;
    public function __construct()
    {
       $this->_db = DB::getInstance();
    }
    public function SetId($id = null)
    {
       $this->_id = $id; 
    }
    public function SetName($name= null)
    {
       $this->_name = $name; 
    }
    public function SetUsername($username = null)
    {
       $this->_username = $username; 
    }
    public function SetPassword($password = null)
    {
       $this->_password = $password; 
    }
    public function SetEnterDate($enterdate = null)
    {
       $this->_enterdate = $enterdate; 
    }
    public function GetId()
    {
       return $this->_id; 
    }
    public function GetName()
    {
       return $this->_name; 
    }
    public function GetUsername()
    {
       return $this->_username; 
    }
    public function GetPassword()
    {
       return $this->_password; 
    }
    public function GetEnterDate()
    {
       return $this->_enterdate; 
    }
    private function SetAttributesFromDB($DBArray)
    {
        $this->SetId($DBArray->CompanyId);
        $this->SetName($DBArray->CompanyName);
        $this->SetUsername($DBArray->ComapnyUsername);
        $this->SetPassword($DBArray->ComapnyPassword);
        $this->SetEnterDate($DBArray->CompanyEnterDate);
    }
    public function CompanyToArray()
    {
        $ret_arr = array();
        $ret_arr["CompanyId"] = $this->GetId();
        $ret_arr["CompanyName"] = $this->GetName();
        $ret_arr["ComapnyUsername"] = $this->GetUsername();
        $ret_arr["ComapnyPassword"] = $this->GetPassword();
        $ret_arr["CompanyEnterDate"] = $this->GetEnterDate();
        return $ret_arr;
    }
    public function AddANewCompany()
    {
        $params = $this->CompanyToArray();
        $this->_db->get('companies', array("CompanyName", "=", $this->GetName()));
        if($this->_db->count() != 0)
        {
            throw new Exception("Company with that name already exists");
        }
        else
        {
            $this->_db = DB::getInstance();
            $this->_db->get('companies', array("ComapnyUsername", "=", $this->GetUserName()));
            if($this->_db->count() != 0)
            {
                throw new Exception("Company with that username already exists");
            }
            else
            {            
                $params = $this->CompanyToArray();
                $this->_db = DB::getInstance();
                if(!$this->_db->insert('companies', $params))
                {
                    throw new Exception("There was a problem inserting the company");
                }
            }
        }
    }
}
?>