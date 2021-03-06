<?php
class Validate{
    private $_passed = false,
            $_errors = array(),
            $_db = null;
    public function __construct(){
        $this->_db = DB::getInstance();
    }
    public function check($items = array()){
        foreach($items as $item => $rules){
            foreach($rules as $rule => $rule_value){
                $value = trim(Input::get($item));
                $item = escape($item);
                if($rule === 'required' && empty($value)){
                    $this->addError("{$item} is required");
                } else if(!empty($value)) {
                 
                    switch($rule){
                        case 'min':
                            if(strlen($value) < $rule_value){
                                $this->addError("{$item} must be a minimum of {$rule_value} characters");
                            }
                        break;
                        case 'max':
                            if(strlen($value) > $rule_value){
                                $this->addError("{$item} must be a maximum of {$rule_value} characters");
                            }

                        break;
                        case 'matches':
                            if($value != Input::get($rule_value)){
                                $this->addError("{$rule_value} must mach {$item}");
                            }
                        break;
                        case 'unique':
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            if($check->count()){
                                $this->addError("{$item} already exists");
                            }
                        break;
                        
                    }
                }
            }
        }
        if(empty($this->_errors)){
            $this->_passed = true;
        }
        return $this;
    }
    private function addError($error){
        $this->_errors[] = $error;
    }
    public function checkLogin()
    {
        if(!Session::exists("UserId"))
        {
            $this->addError("You are not authorized to do that. Please Login!");
            $this->_passed = false;
        }

    }
    public function checkManager()
    {
        if(!Controls::CheckManager())
        {
            $this->addError("You are not a Manager.");
            $this->_passed = false;
        }
    }
    public function errors(){
        return $this->_errors;
    }
    public function passed(){
        return $this->_passed;
    }
}