#!/usr/bin/env bash
php gen-code.php
php-cs-fixer fix ../src --rules=@Symfony,class_attributes_separation
