<?php

/*
*  Resize wrapper for GD
*  original source : http://www.phproots.com/resizing-images-with-php/
*
*  added by Thijzer methods : icon, crop, store, getPath, getArray
*/
class ResizeImage
{

  var $image,$picsstr;
  var $image_type;

  function load($filename)
  {
    $image_info = getimagesize($filename);
    $this->image_type = $image_info[2];
    if( $this->image_type == IMAGETYPE_JPEG ) {
       $this->image = imagecreatefromjpeg($filename);
    } elseif( $this->image_type == IMAGETYPE_GIF ) {
       $this->image = imagecreatefromgif($filename);
    } elseif( $this->image_type == IMAGETYPE_PNG ) {
       $this->image = imagecreatefrompng($filename);
    }
  }
  function save($filename, $compression=75, $image_type=IMAGETYPE_JPEG, $permissions=null)
  {
    if( $image_type == IMAGETYPE_JPEG ) {
       imagejpeg($this->image,$filename,$compression);
    } elseif( $image_type == IMAGETYPE_GIF ) {
       imagegif($this->image,$filename);
    } elseif( $image_type == IMAGETYPE_PNG ) {
       imagepng($this->image,$filename);
    }
    if( $permissions != null) {
       chmod($filename,$permissions);
    }
  }
  function output($image_type=IMAGETYPE_JPEG)
  {
    if( $image_type == IMAGETYPE_JPEG ) {
       imagejpeg($this->image);
    } elseif( $image_type == IMAGETYPE_GIF ) {
       imagegif($this->image);
    } elseif( $image_type == IMAGETYPE_PNG ) {
       imagepng($this->image);
    }
  }
  function getWidth()
  {
    return imagesx($this->image);
  }
  function getHeight()
  {
    return imagesy($this->image);
  }
  function resizeToHeight($height)
  {
    $ratio = $height / $this->getHeight();
    $width = $this->getWidth() * $ratio;
    $this->resize($width,$height);
  }
  function resizeToWidth($width)
  {
    $ratio = $width / $this->getWidth();
    $height = $this->getheight() * $ratio;
    $this->resize($width,$height);
  }
  function scale($scale)
  {
    $width = $this->getWidth() * $scale/100;
    $height = $this->getheight() * $scale/100;
    $this->resize($width,$height);
  }
  function icon($size)
  {
    $this->resizeToHeight($size);
    $this->crop($size,$size,$size/4,0);
  }
  function crop($new_width, $new_height, $left, $top)
  {
    $canvas = imagecreatetruecolor($new_width, $new_height);
    imagecopy($canvas, $this->image, 0, 0, $left, $top, $this->getWidth(), $this->getHeight());
    $this->image = $canvas;
  }
  function resize($width, $height)
  {
    $new_image = imagecreatetruecolor($width, $height);
    imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
    $this->image = $new_image;
  }

  function store($array_pics,$arg = array())
  {
    $default = array(
    'IMG' => '.jpg',
    'path' => 'img/',
    'filename' => date('Ymd-His'),
    'sizes' => array(
    '0' => array(
      'type' => 'resizeToWidth',
      'size' => '800',
      'name' => 'm',
      'quality' => '80')
    ));
    $arg = array_merge($default,$arg);

    $c = count($array_pics);
    for ($i = 0; $i < $c; $i++)
    {
      if ($array_pics[$i])
      {

        if ($arg['filename'] === 'original') {
          $name = substr($_FILES['pics']['name'][$i], 0,-4);
        }else {
          $name = $arg['filename'].'-'.$i.'-';
        }
        $path = PUB.$arg['path'].$name;
        $this->picsstr[] = $name; // builds the array

        $files = $array_pics[$i];
        $s = count($arg['sizes']);
        for ($x = 0; $x < $s; $x++)
        {
          $this->load($files);
          $this->{$arg['sizes'][$x]['type']}($arg['sizes'][$x]['size']);
          $this->save($path.$arg['sizes'][$x]['name'].$arg['IMG'], $arg['sizes'][$x]['quality']);
          $files = $path.$arg['sizes'][$x]['name'].$arg['IMG'];
        } // end of for sizes loop
        move_uploaded_file($array_pics[$i], $path.$arg['IMG']); // original
      } // end of if empty check
    } // end of for files loop
  }
  function getArrayPath()
  {
    return $this->picsstr;
  }
  function getPath($sep = '%%')
  {
    return implode($sep, $this->picsstr); // no needed in loop
  }

}?>