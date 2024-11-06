# Description
When a player places a special TNT it will cancel the block placement and automatically ignite the tnt. Very easy and straight foward plugin!

# How to install/use
- Download the .phar from either poggit or from github releases.

- Move the .phar to the 'plugins' folder just like any other plugin.

- Restart or turn on the server and enjoy!

Its that easy!

# For developers
To get the TNT item you must do:

**Import the class**

```
use wavycraft\tnt\TNT;
```

**Use the following method**

```
$player must be an instanceof Player class

$amount = 10;

$tnt = TNT::getInstance()->giveTNT($player, $amount);
```

**Give the player the TNT**

```
$player->getInventory()->addItem($tnt);
```
