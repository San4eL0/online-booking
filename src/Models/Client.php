<?php
// src/Models/Client.php
class Client {
    public $id;
    public $last_name;
    public $first_name;
    public $middle_name;
    public $phone;
    public $email;
    public $birth_date;
    
    public function getFullName() {
        $name = $this->last_name . ' ' . $this->first_name;
        if ($this->middle_name) {
            $name .= ' ' . $this->middle_name;
        }
        return $name;
    }
    
    public function getFormattedBirthDate() {
        if ($this->birth_date) {
            return date('d.m.Y', strtotime($this->birth_date));
        }
        return '—';
    }
}
