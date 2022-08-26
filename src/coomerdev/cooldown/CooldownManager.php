<?php

declare(strict_types=1);

namespace coomerdev\cooldown;

use coomerdev\cooldown\Cooldown;

class CooldownManager {
    
    private $cooldowns = [];
    
    public function getCooldowns(): array {
        return $this->cooldowns;
    }
    
    public function add(string $name, int $duration, $args, \Closure $onTick, \Closure $onClose) {
        if (isset($this->cooldowns[$name])) return;
        
        $this->cooldowns[$name] = new Cooldown($this, $name, $duration, $args, $onTick, $onClose);
    }
    
    public function get(String $name) {
        return $this->cooldowns[$name] ?? null;
    }
    
    public function remove(String $name) {
        if (isset($this->cooldowns[$name])) unset($this->cooldowns[$name]);
    }
}