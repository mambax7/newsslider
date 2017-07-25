<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * News Utils class
 *
 * @copyright   XOOPS Project (https://xoops.org)
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Hossein Azizabadi (AKA Voltan)
 * @version     $Id$
 */

class NewsUtils {
    
    /**
     * Uploadimg function
     *
     * For manage all upload parts for images
     * Add topic , Edit topic , Add article , Edit article
     */
    function News_UploadImg($NewsModule, $type, $obj, $image) {
        include_once XOOPS_ROOT_PATH . "/class/uploader.php";
        $pach_original = XOOPS_ROOT_PATH . xoops_getModuleOption ( 'img_dir', $NewsModule->getVar ( 'dirname' ) ) .'/original/';
        $pach_medium = XOOPS_ROOT_PATH . xoops_getModuleOption ( 'img_dir', $NewsModule->getVar ( 'dirname' ) ) .'/medium/';
        $pach_thumb = XOOPS_ROOT_PATH . xoops_getModuleOption ( 'img_dir', $NewsModule->getVar ( 'dirname' ) ) .'/thumb/';
        
        $uploader_img = new XoopsMediaUploader ( $pach_original , xoops_getModuleOption ( 'img_mime', $NewsModule->getVar ( 'dirname' ) ), xoops_getModuleOption ( 'img_size', $NewsModule->getVar ( 'dirname' ) ), xoops_getModuleOption ( 'img_maxwidth', $NewsModule->getVar ( 'dirname' ) ), xoops_getModuleOption ( 'img_maxheight', $NewsModule->getVar ( 'dirname' ) ) );
        if ($uploader_img->fetchMedia ( $type )) {
            $uploader_img->setPrefix ( $type . '_' );
            $uploader_img->fetchMedia ( $type );
            if (! $uploader_img->upload ()) {
                $errors = $uploader_img->getErrors ();
                self::News_Redirect ( "javascript:history.go(-1)", 3, $errors );
                xoops_cp_footer ();
               exit ();
            } else {
                $obj->setVar ( $type, $uploader_img->getSavedFileName () );
                self::News_ResizePicture($pach_original . $uploader_img->getSavedFileName () , $pach_medium . $uploader_img->getSavedFileName () , xoops_getModuleOption ( 'img_mediumwidth', $NewsModule->getVar ( 'dirname' ) ) , xoops_getModuleOption ( 'img_mediumheight', $NewsModule->getVar ( 'dirname' ) ));
                self::News_ResizePicture($pach_original . $uploader_img->getSavedFileName () , $pach_thumb . $uploader_img->getSavedFileName (), xoops_getModuleOption ( 'img_thumbwidth', $NewsModule->getVar ( 'dirname' ) ) , xoops_getModuleOption ( 'img_thumbheight', $NewsModule->getVar ( 'dirname' ) ));
            }
        } else {
            if (isset ( $image )) {
                $obj->setVar ( $type, $image );
            }
        }
    }
    
    /**
     * Deleteimg function
     *
     * For Deleteing uploaded images
     * Edit topic ,Edit article
     */
    function News_DeleteImg($NewsModule, $type, $obj) {
        if ($obj->getVar ( $type )) {
            
            // delete original image
            $currentPicture = XOOPS_ROOT_PATH . xoops_getModuleOption ( 'img_dir', $NewsModule->getVar ( 'dirname' ) ) .'/original/'. $obj->getVar ( $type );
            if (is_file ( $currentPicture ) && file_exists ( $currentPicture )) {
                if (! unlink ( $currentPicture )) {
                    trigger_error ( "Error, impossible to delete the picture attached to this article" );
                }
            }
            
            // delete original medium
            $currentPicture = XOOPS_ROOT_PATH . xoops_getModuleOption ( 'img_dir', $NewsModule->getVar ( 'dirname' ) ) .'/medium/'. $obj->getVar ( $type );
            if (is_file ( $currentPicture ) && file_exists ( $currentPicture )) {
                if (! unlink ( $currentPicture )) {
                    trigger_error ( "Error, impossible to delete the picture attached to this article" );
                }
            }
            
            // delete original thumb
            $currentPicture = XOOPS_ROOT_PATH . xoops_getModuleOption ( 'img_dir', $NewsModule->getVar ( 'dirname' ) ) .'/thumb/'. $obj->getVar ( $type );
            if (is_file ( $currentPicture ) && file_exists ( $currentPicture )) {
                if (! unlink ( $currentPicture )) {
                    trigger_error ( "Error, impossible to delete the picture attached to this article" );
                }
            }
        }
        $obj->setVar ( $type, '' );
    }

    /**
     * Resize a Picture to some given dimensions (using the wideImage library)
     * @copyright   XOOPS Project (https://xoops.org)
     * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
     * @author      Hervé Thouzard (ttp://www.instant-zero.com)
     *
     * @param string  $src_path      Picture's source
     * @param string  $dst_path      Picture's destination
     * @param integer $param_width   Maximum picture's width
     * @param integer $param_height  Maximum picture's height
     * @param boolean $keep_original Do we have to keep the original picture ?
     * @param string  $fit           Resize mode (see the wideImage library for more information)
     */
    function News_ResizePicture($src_path , $dst_path, $param_width , $param_height, $keep_original = true, $fit = 'inside')
    {
      require XOOPS_ROOT_PATH.'/modules/newsslider/include/wideimage/WideImage.inc.php';
      $resize = true;
        $pictureDimensions = getimagesize($src_path);
        if (is_array($pictureDimensions)) {
            $pictureWidth = $pictureDimensions[0];
            $pictureHeight = $pictureDimensions[1];
            if ($pictureWidth < $param_width && $pictureHeight < $param_height) {
                $resize = false;
            }
        }
    
      $img = wiImage::load($src_path);
      if ($resize) {
        $result = $img->resize($param_width, $param_height, $fit);
        $result->saveToFile($dst_path);
       } else {
            @copy($src_path, $dst_path);
       }
      if(!$keep_original) {
        @unlink( $src_path ) ;
      }

      return true;
    }
}
