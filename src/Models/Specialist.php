<?php
// src/Models/Specialist.php
class Specialist {
    public $id;
    public $last_name;
    public $first_name;
    public $middle_name;
    public $specialization;
    public $phone;
    public $email;
    public $hire_date;
    public $is_active;
    public $created_at;
    
    public function getFullName() {
        $name = $this->last_name . ' ' . $this->first_name;
        if ($this->middle_name) {
            $name .= ' ' . $this->middle_name;
        }
        return $name;
    }
    
    public function getStatusBadge() {
        if ($this->is_active) {
            return '<span class="badge bg-success">Работает</span>';
        }
        return '<span class="badge bg-danger">Уволен</span>';
    }
    
    public function getExperience() {
        if ($this->hire_date) {
            $hireDate = new DateTime($this->hire_date);
            $today = new DateTime();
            $years = $today->diff($hireDate)->y;
            $months = $today->diff($hireDate)->m;
            
            if ($years > 0) {
                $yearWord = $this->getYearWord($years);
                return "{$years} {$yearWord}";
            }
            $monthWord = $this->getMonthWord($months);
            return "{$months} {$monthWord}";
        }
        return '—';
    }
    
    private function getYearWord($years) {
        $years = abs($years) % 100;
        if ($years > 10 && $years < 20) return 'лет';
        $years %= 10;
        if ($years == 1) return 'год';
        if ($years >= 2 && $years <= 4) return 'года';
        return 'лет';
    }
    
    private function getMonthWord($months) {
        $months = abs($months) % 100;
        if ($months > 10 && $months < 20) return 'месяцев';
        $months %= 10;
        if ($months == 1) return 'месяц';
        if ($months >= 2 && $months <= 4) return 'месяца';
        return 'месяцев';
    }
}
