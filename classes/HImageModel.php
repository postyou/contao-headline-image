<?php
/**
 * Headlineimage
 * Extension for Contao Open Source CMS (contao.org)
 *
 * Copyright (c) 2015 POSTYOU
 *
 * @package headline-image
 * @author  Gerald Meier
 * @link    http://www.postyou.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */
 
namespace postyou;


class HImageModel extends \ContentModel
{


    function modifyElement($objElement, $strBuffer)
    {
     if($objElement->arrData["type"]=="alias" && $objElement->arrData["cteAlias"]>0){
			       return \Controller::getContentElement($objElement->arrData["cteAlias"]);
		      }
        $insertStr = "";
        if ($objElement->arrData["addHeadLineImage"] == '1') {

            $objFile = \FilesModel::findByPk($objElement->arrData["headlineImageFilepath"]);
            if ($objFile !== null && is_file(TL_ROOT . '/' . $objFile->path))
                $insertStr .= "<img class=\"headlineimage\" src=\"" . $objFile->path . "\" alt=\"Icon\">";

            if ($objElement->arrData["type"] == "accordionSingle" || $objElement->row()["type"] == "accordionStart") {

                $openDivPos = strpos($strBuffer, "toggler");
                if ($openDivPos != 0 && !empty($insertStr)) {
                    $openDivPos = strpos($strBuffer, ">", $openDivPos) + 1;
                    $strBuffer = substr($strBuffer, 0, $openDivPos) . $insertStr . substr($strBuffer, $openDivPos);
                }
                return $strBuffer;
            }
            $openTagPos = strpos($strBuffer, "<h");
            if ($openTagPos!==false && !empty($insertStr)) {
                $openTagPos = strpos($strBuffer, ">", $openTagPos) + 1;
                $strBuffer = substr($strBuffer, 0, $openTagPos) . $insertStr . substr($strBuffer, $openTagPos);

            }
        }

        return $strBuffer;
    }
} 
