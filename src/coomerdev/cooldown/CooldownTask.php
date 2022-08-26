<?php

declare(strict_types=1);

namespace coomerdev\cooldown;

use coomerdev\cooldown\Cooldown;
use pocketmine\scheduler\Task;

class CooldownTask extends Task {
    
    private $controler;
    
    public function __construct(Cooldown $controler) {
        $this->controler = $controler;
    }
    
    public function onRun(): void {
        if ($this->controler->getTime() === 0) {
            $this->controler->onClose();
            $this->getHandler()->remove();
        } else {
            $this->controler->onTick();
        }
    }
    
}

?>