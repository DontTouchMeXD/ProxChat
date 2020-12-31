<?php

namespace ProxChat;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase {
    
    /** @var Config $config */
    public $config;
    
    public function onEnable(): void {
        $pluginManager = $this->getServer()->getPluginManager();
        $pluginManager->registerEvents(new EventListener($this), $this);
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        if($this->config->get("purechat_support")){
            if($pluginManager->getPlugin("PureChat") === null){
                $this->getLogger()->warning("can't found PureChat plugin, disabling plugin....");
                $pluginManager->disablePlugin($this);
            }
        }
    }
}

