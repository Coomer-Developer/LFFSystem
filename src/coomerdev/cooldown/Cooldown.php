<?php

namespace coomerdev\cooldown;

use coomerdev\cooldown\CooldownManager;
use coomerdev\cooldown\CooldownTask;
use coomerdev\LFFSystem;
use pocketmine\scheduler\TaskHandler;

class Cooldown {
    
    private $manager;
    private $name;
    private $duration;
    private $onTick;
    private $onClose;
    private $args;
    
    protected TaskHandler $taskId;
    
    public function __construct(CooldownManager $manager, string $name, int $duration, $args, \Closure $onTick, \Closure $onClose) {
        $this->manager = $manager;
        $this->name = $name;
        $this->duration = $duration;
        $this->args = $args;
        $this->onTick = $onTick;
        $this->onClose = $onClose;
        
        $this->taskId = LFFSystem::getInstance()->getScheduler()->scheduleRepeatingTask(new CooldownTask($this), 20);
    }
    
    public function getTime(): int {
        return $this->duration;
    }
    
    public function onTick(): void {
        $this->duration--;
        ($this->onTick)($this->duration, $this->args);
    }
    
    public function onClose(): void {
        ($this->onClose)($this->duration, $this->args);
        $this->taskId->remove();
        $this->manager->remove($this->name);
    }
    
}

?>
