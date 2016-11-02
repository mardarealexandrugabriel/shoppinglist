<?php
class Controls{

    public static function GetProductListByName($name)
    {
        $db = DB::getInstance()->get('products', array('ProductName', 'LIKE', '%'.$name.'%'));
        if($db->error())
        {
            throw new Exception("There was a problem selecting the product list");
        }
        else
        {
            if(!$db->count())
            {
                throw new Exception("No produduct with name : ".escape($name));
            }
            else
            {
                return $db->results();           
            }
        }
    }
    
}
?>