<?php

namespace ProxChat;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;

class EventListener implements Listener {
    
    /** @var Main $main */
    private $main;
    
    public function __construct(Main $main){
        $this->main = $main;
    }
    
    public function onChat(PlayerChatEvent $event){
        if($event->isCancelled()) return;
        $message = $event->getMessage();
        $player = $event->getPlayer(); 
        if($this->main->isPureChatEnable()){
            $pureChat = $this->main->getServer()->getPluginManager()->getPlugin("PureChat");
            $levelName = $pureChat->getConfig()->get("enable-multiworld-chat") ? $player->getLevel()->getName() : null;
            $originalChatFormat = $pureChat->getOriginalChatFormat($player, $levelName);
            $chatFormat = $pureChat->applyColors($originalChatFormat);
            $chatFormat = $pureChat->applyPCTags($chatFormat, $player, $message, $levelName);
            $event->setFormat($chatFormat);
        } else {
            $chatFormat = str_replace(["{username}", "{display_name}", "{message}"], [$player->getName(), $player->getDisplayName(), $message], $this->main->config->get("chat_format"));
            $event->setFormat($chatFormat);
        }
        $recipients = $event->getRecipients();
		foreach($recipients as $key => $recipient){
			if($recipient instanceof Player){
				if($recipient->getLevel() != $player->getLevel() or $recipient->distance($player) > $this->main->config->get("radius")){
				    unset($recipients[$key]); 
				}
			}
		}
		$event->setRecipients($recipients);  
    }
}
