<?php

/**
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2009 Martijn van der Kleijn <martijn.niji@gmail.com>
 *
 * This file is part of Wolf CMS.
 *
 * Wolf CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Wolf CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Wolf CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Wolf CMS has made an exception to the GNU General Public License for plugins.
 * See exception.txt for details and the full text.
 */

/**
 * @package wolf
 * @subpackage installer
 */

// Make sure we hide ugly errrors
error_reporting(0);

define('INSTALL_SEQUENCE', true);

define('CORE_ROOT', dirname(__FILE__).'/../wolf');
define('CFG_FILE', '../config.php');
define('DEFAULT_ADMIN_USER', 'admin');
define('DEFAULT_ADMIN_PWD', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>Wolf CMS - Installation routine</title>
    <link href="install.css" media="screen" rel="Stylesheet" type="text/css" />
</head>
<body>
    <div id="header">
        <div id="site-title">Wolf CMS</div>
    </div>
    <div id="content">

<?php
if (isset($_POST['install']) && !isset($_POST['commit']) && file_exists(CFG_FILE) && !(filesize(CFG_FILE) > 1)) {
    require 'install.php';
}
else if (isset($_POST['install']) && isset($_POST['commit']) && isset($_POST['config'])) {
    $config = $_POST['config'];
    require 'do-install.php';
    require 'post-install.php';
}
else {
    require 'requirements.php';
}
?>

    </div>
    <div id="footer">
        <p>Powered by <a href="http://www.wolfcms.org/">Wolf CMS</a></p>
    </div>
</body>
</html>