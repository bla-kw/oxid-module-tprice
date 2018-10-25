<?php

/**
 * [vt] tprice - ___MODULE___
 * Copyright (C) 2018  Marat Bedoev
 * info:  schwarzarbyter@gmail.com
 *
 * This program is free software;
 * you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation;
 * either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with this program; if not, see <http://www.gnu.org/licenses/>
 *
 * author: Marat Bedoev
 */

class vt_tprice extends oxSuperCfg
{
    public static function install()
    {
        //adding new fields to the oxcontents table
        $oDb = oxDb::getDb();
        //$aColumns = $oDb->metaColumnNames( "oxcontents" ); // throws php errors...
        $aColumns = $oDb->getAssoc("SHOW COLUMNS FROM oxarticles");

        if ( !array_key_exists( "vttpricetype", $aColumns ) && !array_key_exists( "VTTPRICETYPE", $aColumns ) )
        {
            $q = "ALTER TABLE `oxarticles` ADD `VTTPRICETYPE` VARCHAR(16) NOT NULL DEFAULT '' COMMENT 'tprice type (vt/tprice)'";
            $oDb->execute( $q );

            // update views
            $oMetaData = oxNew('oxDbMetaDataHandler');
            $oMetaData->updateViews();

            //clear tmp
            $dir = oxRegistry::getConfig()->getConfigParam("sCompileDir") . "smarty/*";
            foreach (glob($dir) as $item) {
                if (!is_dir($item)) {
                    unlink($item);
                }
            }
        }
    }
}