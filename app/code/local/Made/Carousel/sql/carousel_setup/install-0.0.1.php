<?php
$installer = $this;
$installer->startSetup();
$installer->run("

CREATE TABLE IF NOT EXISTS `{$this->getTable('made_carousel_image')}` (
  `image_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `image_src` text NOT NULL,
  `position` tinyint(4) NOT NULL DEFAULT '0',
  `image_alt_text` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

CREATE TABLE IF NOT EXISTS `{$this->getTable('made_carousel_image_store')}` (
  `image_id` smallint(6) unsigned DEFAULT NULL,
  `store_id` smallint(6) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();
?>