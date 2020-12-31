<?php

namespace ProxChat;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Player;

class Main extends PluginBase {
    
    /** @var Config $config */
    public $config;
    
    /** @var bool $isPureChatEnable */
    private $isPureChatEnable = false;
    
    public function onEnable(): void {
        $pluginManager = $this->getServer()->getPluginManager();
        $this->saveResource("config.yml");
        $pluginManager->registerEvents(new EventListener($this), $this);
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        if($this->config->get("purechat_support")){
            if($pluginManager->getPlugin("PureChat") === null){
                $this->getLogger()->warning("can't found PureChat plugin, disabling plugin....");
                $pluginManager->disablePlugin($this);
            }
        } else {
            $this->isPureChatEnable = true;
        }
    }
    
    public function isPureChatEnable(): bool {
        return $this->isPureChatEnable;
    }
    
    public function getPlayerNearby(Player $player): array {
        $nearby = [];
        foreach($player->getLevel()->getPlayers() as $p){
            if($p->distance($player) <= $this->config->get("radius")){
                $nearby[] = $p;
            }
        }
        return $nearby;
    }
}

