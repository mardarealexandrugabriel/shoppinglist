<?php
    class User{
        private $_id;
        private $_username;
        private $_password;
        private $_name;
        private $_enterdate;
        private $_location_id;
        private $_is_manager;
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
        public function SetLocationId($location_id = null)
        {
            $this->_location_id = $location_id; 
        }
        public function SetIsManager($is_manager = null)
        {
            $this->_is_manager = $is_manager; 
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
        public function GetLocationId()
        {
            return $this->_location_id; 
        }
        public function GetIsManager()
        {
            return $this->_is_manager; 
        }
        public function SetAttributesFromDB($DBArray)
        {
            $this->SetId($DBArray->UserId);
            $this->SetName($DBArray->UName);
            $this->SetUsername($DBArray->Username);
            $this->SetPassword($DBArray->Password);
            $this->SetEnterDate($DBArray->UserEnterDate);
            $this->SetLocationId($DBArray->LocationId);
            $this->SetIsManager($DBArray->IsManager);
        }
        public function UserToArray()
        {
            $ret_arr = array();
            $ret_arr["UserId"] = $this->GetId();
            $ret_arr["UName"] = $this->GetName();
            $ret_arr["Username"] = $this->GetUsername();
            $ret_arr["Password"] = $this->GetPassword();
            $ret_arr["UserEnterDate"] = $this->GetEnterDate();
            $ret_arr["LocationId"] = $this->GetLocationId();
            $ret_arr["IsManager"] = $this->GetIsManager();
            return $ret_arr;
        }
        public function AddANewUser()
        {
            $params = $this->UserToArray();
            $this->_db->get('users', array("Username", "=", $this->GetUserName()));
            if($this->_db->count() != 0)
            {
                throw new Exception("Username already exists");
            }
            else
            {
                $this->_db = DB::getInstance();
                $this->_db->get('users', array("Username", "=", $this->GetUserName()));
                if($this->_db->count() != 0)
                {
                    throw new Exception("That username already exists");
                }
                else
                {            
                    $params = $this->UserToArray();
                    $this->_db = DB::getInstance();
                    if(!$this->_db->insert('users', $params))
                    {
                        throw new Exception("There was a problem inserting the user");
                    }
                }
            }
    }

}
?>