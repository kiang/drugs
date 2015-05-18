<?php

$path = dirname(__DIR__);
$now = date('Y-m-d H:i:s');

exec("cd {$path} && /usr/bin/git pull");

exec("/usr/bin/php -q {$path}/cake2/lib/Cake/Console/cake.php import update -working {$path}");

exec("/usr/bin/php -q {$path}/cake2/lib/Cake/Console/cake.php mohw update -working {$path}");

exec("/usr/bin/php -q {$path}/cake2/lib/Cake/Console/cake.php mohw import -working {$path}");

exec("/usr/bin/php -q {$path}/cake2/lib/Cake/Console/cake.php import dump -working {$path}");

exec("cd {$path} && /usr/bin/git add -A");

exec("cd {$path} && /usr/bin/git commit --author 'auto commit <noreply@localhost>' -m 'auto update @ {$now}'");

exec("cd {$path} && /usr/bin/git push origin master");
