<?php
class Product{
    private $_id;
    private $_name;
    private $_description;
    private $_addedby;
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
    public function SetAttributesFromDB($DBArray)
    {
        
        $this->SetId($DBArray->ProductId);
        $this->SetName($DBArray->ProductName);
        $this->SetDescription($DBArray->ProductDescription);
        $this->SetAddedBy($DBArray->ProductAddedBy);
        $this->SetEnterDate($DBArray->ProductEnterDate);
    }
    public function ProductToArray()
    {
        $ret_arr = array();
        $ret_arr["ProductId"] = $this->GetId();
        $ret_arr["ProductName"] = $this->GetName();
        $ret_arr["ProductDescription"] = $this->GetDescription();
        $ret_arr["ProductAddedBy"] = $this->GetAddedBy();
        $ret_arr["ProductEnterDate"] = $this->GetEnterDate();
        return $ret_arr;
    }
    public function AddANewProduct()
    {
        $params = $this->ProductToArray();
        $existresult = $this->_db->get('products', array("ProductName", "=", $this->GetName()));
        if($this->_db->count() != 0)
        {
            throw new Exception("That product already exists");
        }
        else
        {
            if(!$this->_db->insert('products', $params))
            {
                throw new Exception("There was a problem inserting the product");
            }

        }
    }
    public function GetProductById($id)
    {
        if(!$this->_db->get('products', array('ProductId', '=', $id)))
        {
            throw new Exception("There was a problem selecting the product");
        }
        else
        {
            if($this->_db->count())
            {
                $this->SetAttributesFromDB($this->_db->first());    
                $this->SetProductExists(true);       
            }
        }
    }
    public function GetProductByName($name)
    {
        if(!$this->_db->get('products', array('ProductName', 'LIKE', '%'.$name.'%')))
        {
            throw new Exception("There was a problem selecting the product");
        }
        else
        {
            if($this->_db->count())
            {
                $this->SetAttributesFromDB($this->_db->first()); 
                $this->SetProductExists(true);
            }
        }
    }
   
    public function CheckIfProductExists($name)
    {
    
    }
   
}