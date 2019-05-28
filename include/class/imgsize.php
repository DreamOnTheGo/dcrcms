<?php
/**
* ͼƬ������
* @author ��Դ������
* @version 1.0
* @copyright 2006-2010
* @package class
*/
class Image {
    var $imageResource = NULL;
    var $target = NULL;
    var $enableTypes = array();
    var $imageInfo = array();
    var $createFunc = '';
    var $imageType = NULL;
    
    /**
     * ��ʼ����
     *
     * @param string $image
     * @return Image
     */
    function Image($image = NULL) {
        //get enables
        if(imagetypes() & IMG_GIF) {
            $this->enableTypes[] = 'image/gif';
        }
        if(imagetypes() & IMG_JPEG) {
            $this->enableTypes[] = 'image/jpeg';
        }
        if (imagetypes() & IMG_JPG) {
            $this->enableTypes[] = 'image/jpg';
        }
        if(imagetypes() & IMG_PNG) {
            $this->enableTypes[] = 'image/png';
        }
        //end get
        
        if($image != NULL) {
            $this->setImage($image);
        }
    }
    
    /**
     * ����ͼƬԴ
     *
     * @param string $image ͼƬ·��
     * @return boolean
     */
    function setImage($image) {
        if(file_exists($image) && is_file($image)) {
            $this->imageInfo = getimagesize($image);
            $img_mime = strtolower($this->imageInfo['mime']);
            if(!in_array($img_mime, $this->enableTypes)) {
                exit('ϵͳ���ܲ�������ͼƬ����.');
            }
            switch ($img_mime) {
                case 'image/gif':
                    $link = imagecreatefromgif($image);
                    $this->createFunc = 'imagegif';
                    $this->imageType = 'gif';
                    break;
                case 'image/jpeg':
                case 'image/jpg':
                    $link = imagecreatefromjpeg($image);
                    $this->createFunc = 'imagejpeg';
                    $this->imageType = 'jpeg';
                    break;
                case 'image/png':
                    $link = imagecreatefrompng($image);
                    $this->createFunc = 'imagepng';
                    $this->imageType = 'png';
                    break;
                default:
                    $link = 'unknow';
                    $this->imageType = 'unknow';
                    break;
            }
            if($link !== 'unknow') {
                $this->imageResource = $link;
            } else {
                exit('����ͼƬ���Ͳ��ܸı�ߴ�.');
            }
            unset($link);
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * ����ͷ
     *
     */
    function setHeader() {
        switch ($this->imageType) {
            case 'gif':
                header('content-type:image/gif');
                break;
            case 'jpeg':
                header('content-type:image/jpeg');
                break;
            case 'png':
                header('content-type:image/png');
                break;
            default:
                exit('Can not set header.');
                break;
        }
        return true;
    }
    
    /**
     * �ı�ͼƬ��С
     *
     * @param int $width ��ͼƬ�Ŀ�
     * @param int $height ��ͼƬ�ĸ�
     * @return boolean
     */
    function changeSize($width, $height = -1) {
        if(!is_resource($this->imageResource)) {
            exit('���ܸı�ͼƬ�ĳߴ�,��������û������ͼƬ��Դ.');
        }
        $s_width = $this->imageInfo[0];
        $s_height = $this->imageInfo[1];
        $width = intval($width);
        $height = intval($height);
        
        if($width <= 0) exit('ͼƬ��ȱ��������.');
        if($height <= 0) {
            $height = ($s_height / $s_width) * $width;
        }
        
        $this->target = imagecreatetruecolor($width, $height);
        if(@imagecopyresized($this->target, $this->imageResource, 0, 0, 0, 0, $width, $height, $s_width, $s_height))
            return true;
        else 
            return false;
    }
    
    /**
     * Add watermark
     *
     * @param string $image
     * @param int $app
     */
    function addWatermark($image, $app = 50) {
        if(file_exists($image) && is_file($image)) {
            $s_info = getimagesize($image);
        } else {
            exit($image . '�ļ�������.');
        }

        $r_width = $s_info[0];
        $r_height = $s_info[1];

        if($r_width > $this->imageInfo[0]) exit('ˮӡͼƬ����С��Ŀ��ͼƬ');
        if($r_height > $this->imageInfo[1]) exit('ˮӡͼƬ����С��Ŀ��ͼƬ');
        
        switch ($s_info['mime']) {
            case 'image/gif':
                $resource = imagecreatefromgif($image);
                break;
            case 'image/jpeg':
            case 'image/jpg':
                $resource = imagecreatefromjpeg($image);
                break;
            case 'image/png':
                $resource = imagecreatefrompng($image);
                break;
            default:
                exit($s_info['mime'] .'���Ͳ�����Ϊˮӡ��Դ.');
                break;
        }
        
        $this->target = &$this->imageResource;
        imagecopymerge($this->target, $resource, $this->imageInfo[0] - $r_width - 5, $this->imageInfo[1] - $r_height - 5, 0,0 ,$r_width, $r_height, $app);
        imagedestroy($resource);
        unset($resource);
    }
    
    /**
     * ����ͼƬ
     *
     * @param string $name ���ɵ�ͼƬ��
     * @return boolean
     */
    function create($name = NULL) {
        $function = $this->createFunc;
        if($this->target != NULL && is_resource($this->target)) {
            if($name != NULL) {
                $function($this->target, $name);
            } else {
                $function($this->target);
            }
            return true;
        } else if($this->imageResource != NULL && is_resource($this->imageResource)) {
            if($name != NULL) {
                $function($this->imageResource, $name);
            } else {
                $function($this->imageResource);
            }
            return true;
        } else {
            exit('���ܴ���ͼƬ,ԭ�������û������ͼƬ��Դ.');
        }
    }
    
    /**
     * �ر���Դ
     *
     */
    function free() {
        if(is_resource($this->imageResource)) {
            @imagedestroy($this->imageResource);
        }
        if(is_resource($this->target)) {
            @imagedestroy($this->target);
        }
    }
} ?>