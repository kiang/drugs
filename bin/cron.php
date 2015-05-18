<?php

$path = dirname(__DIR__);
$now = date('Y-m-d H:i:s');

system("cd {$path} && /usr/bin/git pull");

system("/usr/bin/php -q {$path}/cake2/lib/Cake/Console/cake.php import update -working {$path}");

system("/usr/bin/php -q {$path}/cake2/lib/Cake/Console/cake.php mohw update -working {$path}");

system("/usr/bin/php -q {$path}/cake2/lib/Cake/Console/cake.php mohw import -working {$path}");

system("/usr/bin/php -q {$path}/cake2/lib/Cake/Console/cake.php import dump -working {$path}");

system("cd {$path} && /usr/bin/git add -A");

system("cd {$path} && /usr/bin/git commit --author 'auto commit <noreply@localhost>' -m 'auto update @ {$now}'");

system("cd {$path} && /usr/bin/git push origin master");
