# ProxChat

a chat plugin for Minecraft servers that allows you and other players to be within a certain distance from each other to use chat and communicate.

## Installation
You can get the compiled .phar file on poggit by clicking [here](https://poggit.pmmp.io/ci/DontTouchMeXD/ProxChat).

## Configurated
```php
# enable or disable PureChat support
purechat_support: false

# radius for player to communicate or chatting (meter)
radius: 20 

# chat format (if purechat_support is false)
# {username} = player original/real name
# {display_name} = player display name
# {message} = chat message
chat_format: "{username}: {message}"
```
