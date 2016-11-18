<?php
class PriceStock{
    private $_id;
    private $_locationid;
    private $_productid;
    private $_price;
    private $_stock;
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
    public function SetLocationId($locationid= null)
    {
       $this->_locationid= $locationid; 
    }
    public function SetProductId($productid = null)
    {
       $this->_productid = $productid; 
    }
    public function SetPrice($price = null)
    {
       $this->_price = $price; 
    }
    public function SetStock($stock = null)
    {
       $this->_stock = $stock; 
    }
    public function SetEnterDate($enterdate = null)
    {
       $this->_enterdate = $enterdate; 
    }
    public function GetId()
    {
        return $this->_id; 
    }
    public function GetLocationId()
    {
       return $this->_locationid; 
    }
    public function GetProductId()
    {
       return $this->_productid; 
    }
    public function GetPrice()
    {
        return $this->_price; 
    }
    public function GetStock()
    {
       return $this->_stock; 
    }
    public function GetEnterDate()
    {
       return $this->_enterdate; 
    }
    public function SetAttributesFromDB($DBArray)
    {
        $this->SetId($DBArray->PriceStockId);
        $this->SetLocationId($DBArray->location_id);
        $this->SetProductId($DBArray->product_id);
        $this->SetPrice($DBArray->Price);
        $this->SetStock($DBArray->Stock);
        $this->SetEnterDate($DBArray->PriceStockEnterDate);
    }
    public function PriceStockToArray()
    {
        $ret_arr = array();
        $ret_arr["PriceStockId"] = $this->GetId();
        $ret_arr["location_id"] = $this->GetLocationId();
        $ret_arr["product_id"] = $this->GetProductId();
        $ret_arr["Price"] = $this->GetPrice();
        $ret_arr["Stock"] = $this->GetStock();
        $ret_arr["PriceStockEnterDate"] = $this->GetEnterDate();
        return $ret_arr;
    }
    public function AddANewPriceStock()
    {
        $params = $this->PriceStockToArray();
        if(!$this->_db->insert('priceandstock', $params))
        {
            throw new Exception("There was a problem inserting the and the stock");
        }
    }

}
?>