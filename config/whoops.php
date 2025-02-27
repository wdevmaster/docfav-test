<?php

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

$whoops = (new Run())->pushHandler(new PrettyPageHandler());
$whoops->register();