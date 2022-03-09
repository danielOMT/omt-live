<?php

use OMT\Job\AutoLoadOptions;

// Load vendors and register namespaces
require_once 'autoload.php';

// Custom functions
require_once 'functions.php';

// Init Jobs/Hooks/Filters/Actions
AutoLoadOptions::init();
