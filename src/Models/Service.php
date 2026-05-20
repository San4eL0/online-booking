<?php
// src/Models/Service.php
class Service {
    public $id;
    public $name;
    public $description;
    public $price;
    public $duration_minutes;
    public $is_active;
    public $created_at;
    
    public function getFormattedPrice() {
        return number_format($this->price, 2, '.', ' ') . ' ₽';
    }
    
    public function getFormattedDuration() {
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        
        if ($hours > 0 && $minutes > 0) {
            return "{$hours} ч {$minutes} мин";
        } elseif ($hours > 0) {
            return "{$hours} ч";
        } else {
            return "{$minutes} мин";
        }
    }
    
    public function getStatusBadge() {
        if ($this->is_active) {
            return '<span class="badge bg-success">Активна</span>';
        }
        return '<span class="badge bg-secondary">Неактивна</span>';
    }
}
