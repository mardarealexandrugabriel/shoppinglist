<?php
class Product{
    private $_id;
    private $_name;
    private $_description;
    private $_addedby;
    private $_enterdate;
    public function __construct($id=null, $name=null, $description=null, $addedby=null, $enterdate=null)
    {
        $this->_id = $id;
        $this->_name = $name;
        $this->_description = $description;
        $this->_addedby = $addedby;
        $this->_enterdate = $enterdate;
    }
    public function SetId($id = null)
    {
       $this->_id = $id; 
    }
    public function SetName($name= null)
    {
       $this->_name = $name; 
    }
    public function SetDescription($description= null)
    {
       $this->_description = $description; 
    }
    public function SetAddedBy($addedby= null)
    {
       $this->_addedby = $addedby; 
    }
    public function SetEnterDate($enterdate= null)
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
    public function GetDescription()
    {
       return $this->_description; 
    }
    public function GetAddedBy()
    {
       return $this->_addedby; 
    }
    public function GetEnterDate()
    {
       return $this->_enterdate; 
    }
    private function SetAttributesFromDB($DBArray = array())
    {
        $this->SetId($DBArray->pid);
        $this->SetName($DBArray->name);
        $this->SetDescription($DBArray->p_description);
        $this->SetAddedBy($DBArray->p_addedby);
        $this->SetEnterDate($DBArray->p_enterdate);
    }
    public function ProductToArray()
    {
        $ret_arr = array();
        $ret_arr["ProductId"] = $this->GetId();
        $ret_arr["ProductName"] = $this->GetName();
        $ret_arr["ProductDescription"] = $this->GetDescription();
        $ret_arr["ProductAddedBy"] = $this->GetAddedBy();
        $ret_arr["EnterDate"] = $this->GetEnterDate();
        return $ret_arr;
        
    }
}