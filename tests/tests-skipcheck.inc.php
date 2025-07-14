<?php
// Skip check for timecop tests

if (!extension_loaded('timecop')) {
    die("skip timecop extension not loaded");
}

// Check required functions
if (isset($required_func) && is_array($required_func)) {
    foreach ($required_func as $func) {
        if (!function_exists($func)) {
            die("skip function $func not found");
        }
    }
}

// Check required classes
if (isset($required_class) && is_array($required_class)) {
    foreach ($required_class as $class) {
        if (!class_exists($class)) {
            die("skip class $class not found");
        }
    }
}