<?php

/**
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2008 Martijn van der Kleijn <martijn.niji@gmail.com>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
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
 * This file will insert all basic data to database
 *
 * @package wolf
 * @subpackage installer
 */

/* Make sure we've been called using index.php */
if (!defined('INSTALL_SEQUENCE') || !isset($admin_name) || !isset($admin_passwd) || !isset($admin_salt)) {
    echo '<p>Illegal call. Terminating.</p>';
    exit();
}

function wolf_datetime_incrementor() {
    static $cpt=1;
    $cpt++;
    return date('Y-m-d H:i:s', time()+$cpt);
}


//  Dumping data for table: cron -------------------------------------------

$PDO->exec("INSERT INTO ".TABLE_PREFIX."cron (id, lastrun) VALUES (1, '0')");


//  Dumping data for table: layout -------------------------------------------

$PDO->exec("INSERT INTO ".TABLE_PREFIX."layout (id, name, content_type, content, created_on, updated_on, created_by_id, updated_by_id) VALUES (1, 'none', 'text/html', '<?php echo \$this->content(); ?>', '".wolf_datetime_incrementor()."', '".wolf_datetime_incrementor()."', 1, 1)");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."layout (id, name, content_type, content, created_on, updated_on, created_by_id, updated_by_id) VALUES (2, 'Wolf', 'text/html', '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en-GB\">\r\n\r\n<head>\r\n	<title><?php echo \$this->title(); ?></title>\r\n\r\n  <meta http-equiv=\"content-type\" content=\"application/xhtml+xml; charset=utf-8\" />\r\n  <meta name=\"robots\" content=\"index, follow\" />\r\n  <meta name=\"description\" content=\"<?php echo (\$this->description() != '''') ? \$this->description() : ''Default description goes here''; ?>\" />\r\n  <meta name=\"keywords\" content=\"<?php echo (\$this->keywords() != '''') ? \$this->keywords() : ''default, keywords, here''; ?>\" />\r\n  <meta name=\"author\" content=\"Author Name\" />\r\n\r\n  <link rel=\"favourites icon\" href=\"<?php echo URL_PUBLIC; ?>favicon.ico\" />\r\n\r\n  <!-- Adapted from Matthew James Taylor''s \"Holy Grail 3 column liquid-layout\" = http://bit.ly/ejfjq -->\r\n  <!-- No snippets used; but snippet blocks for header, secondary nav, and footer are indicated -->\r\n\r\n  <link rel=\"stylesheet\" href=\"<?php echo URL_PUBLIC; ?>public/themes/wolf/screen.css\" media=\"screen\" type=\"text/css\" />\r\n  <link rel=\"stylesheet\" href=\"<?php echo URL_PUBLIC; ?>public/themes/wolf/print.css\" media=\"print\" type=\"text/css\" />\r\n  <link rel=\"alternate\" type=\"application/rss+xml\" title=\"Wolf Default RSS Feed\" href=\"<?php echo URL_PUBLIC.((USE_MOD_REWRITE)?'''':''/?''); ?>rss.xml\" />\r\n\r\n</head>\r\n<body>\r\n\r\n<!-- HEADER - COULD BE SNIPPET / START -->\r\n<div id=\"header\">\r\n	<h1><a href=\"<?php echo URL_PUBLIC; ?>\">Wolf</a><span class=\"tagline\">content management simplified</span></h1>\r\n</div><!-- / #header -->\r\n<div id=\"nav\">\r\n	<ul>\r\n      <li><a<?php echo url_match(''/'') ? '' class=\"current\"'': ''''; ?> href=\"<?php echo URL_PUBLIC; ?>\">Home</a></li>\r\n<?php foreach(\$this->find(''/'')->children() as \$menu): ?>\r\n      <li><?php echo \$menu->link(\$menu->title, (in_array(\$menu->slug, explode(''/'', \$this->url)) ? '' class=\"current\"'': null)); ?></li>\r\n<?php endforeach; ?> \r\n	</ul>\r\n</div><!-- / #nav -->\r\n<!-- HEADER / END -->\r\n\r\n<div id=\"colmask\"><div id=\"colmid\"><div id=\"colright\"><!-- = outer nested divs -->\r\n\r\n	<div id=\"col1wrap\"><div id=\"col1pad\"><!-- = inner/col1 nested divs -->\r\n\r\n		<div id=\"col1\">\r\n		<!-- Column 1 start = main content -->\r\n\r\n<h2><?php echo \$this->title(); ?></h2>\r\n\r\n  <?php echo \$this->content(); ?> \r\n  <?php if (\$this->hasContent(''extended'')) echo \$this->content(''extended''); ?> \r\n\r\n		<!-- Column 1 end -->\r\n		</div><!-- / #col1 -->\r\n	\r\n	<!-- end inner/col1 nested divs -->\r\n	</div><!-- / #col1pad --></div><!-- / #col1wrap -->\r\n\r\n		<div id=\"col2\">\r\n		<!-- Column 2 start = left/running sidebar -->\r\n\r\n  <?php echo \$this->content(''sidebar'', true); ?> \r\n\r\n		<!-- Column 2 end -->\r\n		</div><!-- / #col2 -->\r\n\r\n		<div id=\"col3\">\r\n		<!-- Column 3 start = right/secondary nav sidebar -->\r\n\r\n<!-- THIS CONDITIONAL NAVIGATION COULD GO INTO A SNIPPET / START -->\r\n<?php if (\$this->level() > 0) { \$parent = reset(explode(''/'', CURRENT_URI)); \$topPage = \$this->find(\$parent); } ?>\r\n<?php if(isset(\$topPage) && \$topPage != '''' && \$topPage != null) : ?>\r\n\r\n<?php if (\$this->level() > 0) : ?>\r\n<?php if (count(\$topPage->children()) > 0 && \$topPage->slug() != ''articles'') : ?>\r\n<h2><?php echo \$topPage->title(); ?> Menu</h2>\r\n<ul>\r\n<?php foreach (\$topPage->children() as \$subPage): ?>\r\n    <li><?php echo \$subPage->link(\$subPage->title, (url_start_with(\$subPage->url) ? '' class=\"current\"'': null)); ?></li>\r\n<?php endforeach; ?>\r\n</ul>\r\n<?php endif; ?>\r\n<?php endif; ?>\r\n<?php endif; ?>\r\n<!-- CONDITIONAL NAVIGATION / END -->\r\n\r\n		<!-- Column 3 end -->\r\n		</div><!-- / #col3 -->\r\n\r\n<!-- end outer nested divs -->\r\n</div><!-- / #colright --></div><!-- /colmid # --></div><!-- / #colmask -->\r\n\r\n<!-- FOOTER - COULD BE SNIPPET / START -->\r\n<div id=\"footer\">\r\n\r\n  <p>&copy; Copyright <?php echo date(''Y''); ?> <a href=\"http://www.wolfcms.org/\" title=\"Wolf\">Your name</a><br />\r\n  <a href=\"http://www.wolfcms.org/\" title=\"Wolf CMS\">Wolf CMS</a> Inside.\r\n  </p>\r\n  \r\n</div><!-- / #footer -->\r\n<!-- FOOTER / END -->\r\n\r\n</body>\r\n</html>', '".wolf_datetime_incrementor()."', '".wolf_datetime_incrementor()."', 1, 1)");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."layout (id, name, content_type, content, created_on, updated_on, created_by_id, updated_by_id) VALUES (3, 'Simple', 'text/html', '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"\r\n\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n  <title><?php echo \$this->title(); ?></title>\r\n\r\n  <meta http-equiv=\"content-type\" content=\"application/xhtml+xml; charset=utf-8\" />\r\n  <meta name=\"robots\" content=\"index, follow\" />\r\n  <meta name=\"description\" content=\"<?php echo (\$this->description() != '''') ? \$this->description() : ''Default description goes here''; ?>\" />\r\n  <meta name=\"keywords\" content=\"<?php echo (\$this->keywords() != '''') ? \$this->keywords() : ''default, keywords, here''; ?>\" />\r\n  <meta name=\"author\" content=\"Author Name\" />\r\n\r\n  <link rel=\"favourites icon\" href=\"<?php echo URL_PUBLIC; ?>favicon.ico\" />\r\n    <link rel=\"stylesheet\" href=\"<?php echo URL_PUBLIC; ?>public/themes/simple/screen.css\" media=\"screen\" type=\"text/css\" />\r\n    <link rel=\"stylesheet\" href=\"<?php echo URL_PUBLIC; ?>public/themes/simple/print.css\" media=\"print\" type=\"text/css\" />\r\n    <link rel=\"alternate\" type=\"application/rss+xml\" title=\"Wolf Default RSS Feed\" href=\"<?php echo URL_PUBLIC.((USE_MOD_REWRITE)?'''':''/?''); ?>rss.xml\" />\r\n\r\n</head>\r\n<body>\r\n<div id=\"page\">\r\n<?php \$this->includeSnippet(''header''); ?>\r\n<div id=\"content\">\r\n\r\n  <h2><?php echo \$this->title(); ?></h2>\r\n  <?php echo \$this->content(); ?> \r\n  <?php if (\$this->hasContent(''extended'')) echo \$this->content(''extended''); ?> \r\n\r\n</div> <!-- end #content -->\r\n<div id=\"sidebar\">\r\n\r\n  <?php echo \$this->content(''sidebar'', true); ?> \r\n\r\n</div> <!-- end #sidebar -->\r\n<?php \$this->includeSnippet(''footer''); ?>\r\n</div> <!-- end #page -->\r\n</body>\r\n</html>', '".wolf_datetime_incrementor()."', '".wolf_datetime_incrementor()."', 1, 1)");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."layout (id, name, content_type, content, created_on, updated_on, created_by_id, updated_by_id) VALUES (4, 'RSS XML', 'application/rss+xml', '<?php echo \$this->content(); ?>', '".wolf_datetime_incrementor()."', '".wolf_datetime_incrementor()."', 1, 1)");


//  Dumping data for table: page ---------------------------------------------

$PDO->exec("INSERT INTO ".TABLE_PREFIX."page (id, title, slug, breadcrumb, parent_id, layout_id, behavior_id, status_id, created_on, published_on, updated_on, created_by_id, updated_by_id, position, is_protected, needs_login) VALUES (1, 'Home Page', '', 'Home Page', 0, 2, '', 100, '".wolf_datetime_incrementor()."', '".wolf_datetime_incrementor()."', '".wolf_datetime_incrementor()."', 1, 1, 0, 1, 0)");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."page (id, title, slug, breadcrumb, parent_id, layout_id, behavior_id, status_id, created_on, published_on, updated_on, created_by_id, updated_by_id, position, is_protected, needs_login) VALUES (2, 'RSS Feed', 'rss.xml', 'RSS Feed', 1, 4, '', 101, '".wolf_datetime_incrementor()."', '".wolf_datetime_incrementor()."', '".wolf_datetime_incrementor()."', 1, 1, 2, 1, 0)");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."page (id, title, slug, breadcrumb, parent_id, layout_id, behavior_id, status_id, created_on, published_on, updated_on, created_by_id, updated_by_id, position, is_protected, needs_login) VALUES (3, 'About us', 'about_us', 'About us', 1, 0, '', 100, '".wolf_datetime_incrementor()."', '".wolf_datetime_incrementor()."', '".wolf_datetime_incrementor()."', 1, 1, 0, 0, 2)");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."page (id, title, slug, breadcrumb, parent_id, layout_id, behavior_id, status_id, created_on, published_on, updated_on, created_by_id, updated_by_id, position, is_protected, needs_login) VALUES (4, 'Articles', 'articles', 'Articles', 1, 0, 'archive', 100, '".wolf_datetime_incrementor()."', '".wolf_datetime_incrementor()."', '".wolf_datetime_incrementor()."', 1, 1, 1, 1, 2)");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."page (id, title, slug, breadcrumb, parent_id, layout_id, behavior_id, status_id, created_on, published_on, updated_on, created_by_id, updated_by_id, position, is_protected, needs_login) VALUES (5, 'My first article', 'my_first_article', 'My first article', 4, 0, '', 100, '".wolf_datetime_incrementor()."', '".wolf_datetime_incrementor()."', '".wolf_datetime_incrementor()."', 1, 1, 0, 0, 2)");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."page (id, title, slug, breadcrumb, parent_id, layout_id, behavior_id, status_id, created_on, published_on, updated_on, created_by_id, updated_by_id, position, is_protected, needs_login) VALUES (6, 'My second article', 'my_second_article', 'My second article', 4, 0, '', 100, '".wolf_datetime_incrementor()."', '".wolf_datetime_incrementor()."', '".wolf_datetime_incrementor()."', 1, 1, 0, 0, 2)");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."page (id, title, slug, breadcrumb, parent_id, layout_id, behavior_id, status_id, created_on, published_on, updated_on, created_by_id, updated_by_id, position, is_protected, needs_login) VALUES (7, '%B %Y archive', 'monthly_archive', '%B %Y archive', 4, 0, 'archive_month_index', 101, '".wolf_datetime_incrementor()."', '".wolf_datetime_incrementor()."', '".wolf_datetime_incrementor()."', 1, 1, 0, 1, 2)");


//  Dumping data for table: page_part ----------------------------------------

$PDO->exec("INSERT INTO ".TABLE_PREFIX."page_part (id, name, filter_id, content, content_html, page_id) VALUES (1, 'body', '', '<?php \r\n\r\n\$page_article = \$this->find(''/articles/'');\r\n\r\nif (\$page_article->childrenCount() > 0) {\r\n    \$last_article = \$page_article->children(array(''limit''=>1, ''order''=>''page.created_on DESC''));\r\n    \$last_articles = \$page_article->children(array(''limit''=>4, ''offset'' => 1, ''order''=>''page.created_on DESC''));\r\n?>\r\n<div class=\"first entry\">\r\n  <h3><?php echo \$last_article->link(); ?></h3>\r\n  <?php echo \$last_article->content(); ?>\r\n  <?php if (\$last_article->hasContent(''extended'')) echo \$last_article->link(''Continue Reading&#8230;''); ?>\r\n  <p class=\"info\">Posted by <?php echo \$last_article->author(); ?> on <?php echo \$last_article->date(); ?></p>\r\n</div>\r\n\r\n<?php foreach (\$last_articles as \$article): ?>\r\n<div class=\"entry\">\r\n  <h3><?php echo \$article->link(); ?></h3>\r\n  <?php echo \$article->content(); ?>\r\n  <?php if (\$article->hasContent(''extended'')) echo \$article->link(''Continue Reading&#8230;''); ?>\r\n  <p class=\"info\">Posted by <?php echo \$article->author(); ?> on <?php echo \$article->date(); ?></p>\r\n</div>\r\n\r\n<?php\r\n    endforeach; \r\n}\r\n?>', '<?php \r\n\r\n\$page_article = \$this->find(''/articles/'');\r\n\r\nif (\$page_article->childrenCount() > 0) {\r\n    \$last_article = \$page_article->children(array(''limit''=>1, ''order''=>''page.created_on DESC''));\r\n    \$last_articles = \$page_article->children(array(''limit''=>4, ''offset'' => 1, ''order''=>''page.created_on DESC''));\r\n?>\r\n<div class=\"first entry\">\r\n  <h3><?php echo \$last_article->link(); ?></h3>\r\n  <?php echo \$last_article->content(); ?>\r\n  <?php if (\$last_article->hasContent(''extended'')) echo \$last_article->link(''Continue Reading&#8230;''); ?>\r\n  <p class=\"info\">Posted by <?php echo \$last_article->author(); ?> on <?php echo \$last_article->date(); ?></p>\r\n</div>\r\n\r\n<?php foreach (\$last_articles as \$article): ?>\r\n<div class=\"entry\">\r\n  <h3><?php echo \$article->link(); ?></h3>\r\n  <?php echo \$article->content(); ?>\r\n  <?php if (\$article->hasContent(''extended'')) echo \$article->link(''Continue Reading&#8230;''); ?>\r\n  <p class=\"info\">Posted by <?php echo \$article->author(); ?> on <?php echo \$article->date(); ?></p>\r\n</div>\r\n\r\n<?php\r\n    endforeach; \r\n}\r\n?>', 1)");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."page_part (id, name, filter_id, content, content_html, page_id) VALUES (2, 'body', '', '<?php echo ''<?''; ?>xml version=\"1.0\" encoding=\"UTF-8\"<?php echo ''?>''; ?> \r\n<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\r\n<channel>\r\n	<title>Wolf CMS</title>\r\n	<link><?php echo BASE_URL ?></link>\r\n	<atom:link href=\"<?php echo BASE_URL ?>rss.xml\" rel=\"self\" type=\"application/rss\+xml\" />\r\n	<language>en-us</language>\r\n	<copyright>Copyright <?php echo date(''Y''); ?>, wolfcms.org</copyright>\r\n	<pubDate><?php echo strftime(''%a, %d %b %Y %H:%M:%S %z''); ?></pubDate>\r\n	<lastBuildDate><?php echo strftime(''%a, %d %b %Y %H:%M:%S %z''); ?></lastBuildDate>\r\n	<category>any</category>\r\n	<generator>Wolf CMS</generator>\r\n	<description>The main news feed from Wolf CMS.</description>\r\n	<docs>http://www.rssboard.org/rss-specification</docs>\r\n	<?php \$articles = \$this->find(''articles''); ?>\r\n	<?php foreach (\$articles->children(array(''limit'' => 10, ''order'' => ''page.created_on DESC'')) as \$article): ?>\r\n	<item>\r\n		<title><?php echo \$article->title(); ?></title>\r\n		<description><?php if (\$article->hasContent(''summary'')) { echo \$article->content(''summary''); } else { echo strip_tags(\$article->content()); } ?></description>\r\n		<pubDate><?php echo \$article->date(''%a, %d %b %Y %H:%M:%S %z''); ?></pubDate>\r\n		<link><?php echo \$article->url(); ?></link>\r\n		<guid><?php echo \$article->url(); ?></guid>\r\n	</item>\r\n	<?php endforeach; ?>\r\n</channel>\r\n</rss>', '<?php echo ''<?''; ?>xml version=\"1.0\" encoding=\"UTF-8\"<?php echo ''?>''; ?> \r\n<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\r\n<channel>\r\n	<title>Wolf CMS</title>\r\n	<link><?php echo BASE_URL ?></link>\r\n	<atom:link href=\"<?php echo BASE_URL ?>rss.xml\" rel=\"self\" type=\"application/rss\+xml\" />\r\n	<language>en-us</language>\r\n	<copyright>Copyright <?php echo date(''Y''); ?>, wolfcms.org</copyright>\r\n	<pubDate><?php echo strftime(''%a, %d %b %Y %H:%M:%S %z''); ?></pubDate>\r\n	<lastBuildDate><?php echo strftime(''%a, %d %b %Y %H:%M:%S %z''); ?></lastBuildDate>\r\n	<category>any</category>\r\n	<generator>Wolf CMS</generator>\r\n	<description>The main news feed from Wolf CMS.</description>\r\n	<docs>http://www.rssboard.org/rss-specification</docs>\r\n	<?php \$articles = \$this->find(''articles''); ?>\r\n	<?php foreach (\$articles->children(array(''limit'' => 10, ''order'' => ''page.created_on DESC'')) as \$article): ?>\r\n	<item>\r\n		<title><?php echo \$article->title(); ?></title>\r\n		<description><?php if (\$article->hasContent(''summary'')) { echo \$article->content(''summary''); } else { echo strip_tags(\$article->content()); } ?></description>\r\n		<pubDate><?php echo \$article->date(''%a, %d %b %Y %H:%M:%S %z''); ?></pubDate>\r\n		<link><?php echo \$article->url(); ?></link>\r\n		<guid><?php echo \$article->url(); ?></guid>\r\n	</item>\r\n	<?php endforeach; ?>\r\n</channel>\r\n</rss>', 2)");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."page_part (id, name, filter_id, content, content_html, page_id) VALUES (3, 'body', 'textile', 'This is my site. I live in this city ... I do some nice things, like this and that ...', '<p>This is my site. I live in this city &#8230; I do some nice things, like this and that &#8230;</p>', 3)");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."page_part (id, name, filter_id, content, content_html, page_id) VALUES (4, 'body', '', '<?php \$last_articles = \$this->children(array(''limit''=>5, ''order''=>''page.created_on DESC'')); ?>\r\n<?php foreach (\$last_articles as \$article): ?>\r\n<div class=\"entry\">\r\n  <h3><?php echo \$article->link(\$article->title); ?></h3>\r\n  <?php echo \$article->content(); ?>\r\n  <p class=\"info\">Posted by <?php echo \$article->author(); ?> on <?php echo \$article->date(); ?>  \r\n     <br />tags: <?php echo join('', '', \$article->tags()); ?>\r\n  </p>\r\n</div>\r\n<?php endforeach; ?>\r\n\r\n', '<?php \$last_articles = \$this->children(array(''limit''=>5, ''order''=>''page.created_on DESC'')); ?>\r\n<?php foreach (\$last_articles as \$article): ?>\r\n<div class=\"entry\">\r\n  <h3><?php echo \$article->link(\$article->title); ?></h3>\r\n  <?php echo \$article->content(); ?>\r\n  <p class=\"info\">Posted by <?php echo \$article->author(); ?> on <?php echo \$article->date(); ?>  \r\n     <br />tags: <?php echo join('', '', \$article->tags()); ?>\r\n  </p>\r\n</div>\r\n<?php endforeach; ?>\r\n\r\n', 4)");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."page_part (id, name, filter_id, content, content_html, page_id) VALUES (5, 'body', 'markdown', 'My **first** test of my first article that uses *Markdown*.', '<p>My <strong>first</strong> test of my first article that uses <em>Markdown</em>.</p>\n', 5)");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."page_part (id, name, filter_id, content, content_html, page_id) VALUES (7, 'body', 'markdown', 'This is my second article.', '<p>This is my second article.</p>\n', 6)");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."page_part (id, name, filter_id, content, content_html, page_id) VALUES (8, 'body', '', '<?php \$archives = \$this->archive->get(); ?>\r\n<?php foreach (\$archives as \$archive): ?>\r\n<div class=\"entry\">\r\n  <h3><?php echo \$archive->link(); ?></h3>\r\n  <p class=\"info\">Posted by <?php echo \$archive->author(); ?> on <?php echo \$archive->date(); ?> \r\n  </p>\r\n</div>\r\n<?php endforeach; ?>', '<?php \$archives = \$this->archive->get(); ?>\r\n<?php foreach (\$archives as \$archive): ?>\r\n<div class=\"entry\">\r\n  <h3><?php echo \$archive->link(); ?></h3>\r\n  <p class=\"info\">Posted by <?php echo \$archive->author(); ?> on <?php echo \$archive->date(); ?> \r\n  </p>\r\n</div>\r\n<?php endforeach; ?>', 7)");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."page_part (id, name, filter_id, content, content_html, page_id) VALUES (9, 'sidebar', '', '<h3>About Me</h3>\r\n\r\n<p>I''m just a demonstration of how easy it is to use Wolf CMS to power a blog. <a href=\"<?php echo BASE_URL; ?>about_us\">more ...</a></p>\r\n\r\n<h3>Favorite Sites</h3>\r\n<ul>\r\n  <li><a href=\"http://www.wolfcms.org\">Wolf CMS</a></li>\r\n</ul>\r\n\r\n<?php if(url_match(''/'')): ?>\r\n<h3>Recent Entries</h3>\r\n<?php \$page_article = \$this->find(''/articles/''); ?>\r\n<ul>\r\n<?php foreach (\$page_article->children(array(''limit'' => 10, ''order'' => ''page.created_on DESC'')) as \$article): ?>\r\n  <li><?php echo \$article->link(); ?></li> \r\n<?php endforeach; ?>\r\n</ul>\r\n<?php endif; ?>\r\n\r\n<p><a href=\"<?php echo BASE_URL; ?>articles\">Archives</a></p>\r\n\r\n<h3>Syndicate</h3>\r\n\r\n<p><a href=\"<?php echo BASE_URL; ?>rss.xml\">Articles RSS Feed</a></p>', '<h3>About Me</h3>\r\n\r\n<p>I''m just a demonstration of how easy it is to use Wolf CMS to power a blog. <a href=\"<?php echo BASE_URL; ?>about_us\">more ...</a></p>\r\n\r\n<h3>Favorite Sites</h3>\r\n<ul>\r\n  <li><a href=\"http://www.wolfcms.org\">Wolf CMS</a></li>\r\n</ul>\r\n\r\n<?php if(url_match(''/'')): ?>\r\n<h3>Recent Entries</h3>\r\n<?php \$page_article = \$this->find(''/articles/''); ?>\r\n<ul>\r\n<?php foreach (\$page_article->children(array(''limit'' => 10, ''order'' => ''page.created_on DESC'')) as \$article): ?>\r\n  <li><?php echo \$article->link(); ?></li> \r\n<?php endforeach; ?>\r\n</ul>\r\n<?php endif; ?>\r\n\r\n<p><a href=\"<?php echo BASE_URL; ?>articles\">Archives</a></p>\r\n\r\n<h3>Syndicate</h3>\r\n\r\n<p><a href=\"<?php echo BASE_URL; ?>rss.xml\">Articles RSS Feed</a></p>', 1)");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."page_part (id, name, filter_id, content, content_html, page_id) VALUES (10, 'sidebar', '', '<?php \$article = \$this->find(''articles''); ?>\r\n<?php \$archives = \$article->archive->archivesByMonth(); ?>\r\n\r\n<h3>Archives By Month</h3>\r\n<ul>\r\n<?php foreach (\$archives as \$date): ?>\r\n  <li><a href=\"<?php echo BASE_URL . \$this->url .''/''. \$date . URL_SUFFIX; ?>\"><?php echo strftime(''%B %Y'', strtotime(strtr(\$date, ''/'', ''-''))); ?></a></li>\r\n<?php endforeach; ?>\r\n</ul>', '<?php \$article = \$this->find(''articles''); ?>\r\n<?php \$archives = \$article->archive->archivesByMonth(); ?>\r\n\r\n<h3>Archives By Month</h3>\r\n<ul>\r\n<?php foreach (\$archives as \$date): ?>\r\n  <li><a href=\"<?php echo BASE_URL . \$this->url .''/''. \$date . URL_SUFFIX; ?>\"><?php echo strftime(''%B %Y'', strtotime(strtr(\$date, ''/'', ''-''))); ?></a></li>\r\n<?php endforeach; ?>\r\n</ul>', 4)");


//  Dumping data for table: permission ---------------------------------------

$PDO->exec("INSERT INTO ".TABLE_PREFIX."permission (id, name) VALUES (1, 'administrator')");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."permission (id, name) VALUES (2, 'developer')");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."permission (id, name) VALUES (3, 'editor')");


//  Dumping data for table: setting ------------------------------------------

$PDO->exec("INSERT INTO ".TABLE_PREFIX."setting (name, value) VALUES ('admin_title', 'Wolf CMS')");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."setting (name, value) VALUES ('admin_email', 'do-not-reply@wolfcms.org')");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."setting (name, value) VALUES ('language', 'en')");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."setting (name, value) VALUES ('theme', 'brown_and_green')");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."setting (name, value) VALUES ('default_status_id', '1')");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."setting (name, value) VALUES ('default_filter_id', '')");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."setting (name, value) VALUES ('default_tab', '')");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."setting (name, value) VALUES ('allow_html_title', 'off')");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."setting (name, value) VALUES ('plugins', 'a:5:{s:7:\"textile\";i:1;s:8:\"markdown\";i:1;s:7:\"archive\";i:1;s:14:\"page_not_found\";i:1;s:12:\"file_manager\";i:1;}')");


//  Dumping data for table: snippet ------------------------------------------

$PDO->exec("INSERT INTO ".TABLE_PREFIX."snippet (id, name, filter_id, content, content_html, created_on, updated_on, created_by_id, updated_by_id) VALUES (1, 'header', '', '<div id=\"header\">\r\n  <h1><a href=\"<?php echo URL_PUBLIC; ?>\">Wolf</a> <span>content management simplified</span></h1>\r\n  <div id=\"nav\">\r\n    <ul>\r\n      <li><a<?php echo url_match(''/'') ? '' class=\"current\"'': ''''; ?> href=\"<?php echo URL_PUBLIC; ?>\">Home</a></li>\r\n<?php foreach(\$this->find(''/'')->children() as \$menu): ?>\r\n      <li><?php echo \$menu->link(\$menu->title, (in_array(\$menu->slug, explode(''/'', \$this->url)) ? '' class=\"current\"'': null)); ?></li>\r\n<?php endforeach; ?> \r\n    </ul>\r\n  </div> <!-- end #navigation -->\r\n</div> <!-- end #header -->', '<div id=\"header\">\r\n  <h1><a href=\"<?php echo URL_PUBLIC; ?>\">Wolf</a> <span>content management simplified</span></h1>\r\n  <div id=\"nav\">\r\n    <ul>\r\n      <li><a<?php echo url_match(''/'') ? '' class=\"current\"'': ''''; ?> href=\"<?php echo URL_PUBLIC; ?>\">Home</a></li>\r\n<?php foreach(\$this->find(''/'')->children() as \$menu): ?>\r\n      <li><?php echo \$menu->link(\$menu->title, (in_array(\$menu->slug, explode(''/'', \$this->url)) ? '' class=\"current\"'': null)); ?></li>\r\n<?php endforeach; ?> \r\n    </ul>\r\n  </div> <!-- end #navigation -->\r\n</div> <!-- end #header -->', '".wolf_datetime_incrementor()."', '".wolf_datetime_incrementor()."', 1, 1)");
$PDO->exec("INSERT INTO ".TABLE_PREFIX."snippet (id, name, filter_id, content, content_html, created_on, updated_on, created_by_id, updated_by_id) VALUES (2, 'footer', '', '<div id=\"footer\"><div id=\"footer-inner\">\r\n  <p>&copy; Copyright <?php echo date(''Y''); ?> <a href=\"http://www.wolfcms.org/\" title=\"Wolf\">Your Name</a><br />\r\n  <a href=\"http://www.wolfcms.org/\" title=\"Wolf CMS\">Wolf CMS</a> Inside.\r\n  </p>\r\n</div></div><!-- end #footer -->', '<div id=\"footer\"><div id=\"footer-inner\">\r\n  <p>&copy; Copyright <?php echo date(''Y''); ?> <a href=\"http://www.wolfcms.org/\" alt=\"Wolf\">Your Name</a><br />\r\n  <a href=\"http://www.wolfcms.org/\" alt=\"Wolf\">Wolf CMS</a> Inside.\r\n  </p>\r\n</div></div><!-- end #footer -->', '".wolf_datetime_incrementor()."', '".wolf_datetime_incrementor()."', 1, 1)");


//  Dumping data for table: user ---------------------------------------------

$PDO->exec("INSERT INTO ".TABLE_PREFIX."user (id, name, email, username, password, salt, language, created_on, updated_on, created_by_id, updated_by_id) VALUES (1, 'Administrator', 'admin@yoursite.com', '".$admin_name."', '".$admin_passwd."', '".$admin_salt."', 'en', '".wolf_datetime_incrementor()."', '".wolf_datetime_incrementor()."', 1, 1)");


//  Dumping data for table: user_permission ----------------------------------

$PDO->exec("INSERT INTO ".TABLE_PREFIX."user_permission (user_id, permission_id) VALUES (1, 1)");
