<?php
PathManager::setAppPrefix("/admin");

PathManager::loadPaths(
    array("", "index"),
    array("/login", "login"),
    array("/logout", "logout")
);
