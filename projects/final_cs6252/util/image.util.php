<?php
/**
 * This file contains functions for handling images within the application
 */
/**
 * Method processes images
 *
 * @param string $dir
 *          The directory for the image
 * @param string $filename
 *          The filename of the image
 */
function process_image($dir, $filename) {
  // Set up the variables
  $extSeperator = strrpos($filename, '.');
  $image_name = "image" . getUserID();
  $ext = substr($filename, $extSeperator);
  // Set up the read path
  $image_path = $dir . $filename;
  // Set up the write paths
  $image_path_m = $dir . $filename;
  // Create an image that's a maximum of 400x400 pixels
  resize_image($image_path, $image_path_m, 400, 400);
}

/**
 * Resizes an image and moves it from the old image path to the new image path
 *
 * @param string $old_image_path
 *          Image's old path
 * @param string $new_image_path
 *          Image's new path
 * @param int $max_width
 *          Max width of the new image
 * @param int $max_height
 *          Max height of the new image
 */
function resize_image($old_image_path, $new_image_path, $max_width, $max_height) {
  // Get image type
  try {
    $image_info = getimagesize($old_image_path);
    $image_type = $image_info [2];
    // Set up the function names
    switch ($image_type) {
      case IMAGETYPE_JPEG :
        $image_from_file = 'imagecreatefromjpeg';
        $image_to_file = 'imagejpeg';
        break;
      case IMAGETYPE_GIF :
        $image_from_file = 'imagecreatefromgif';
        $image_to_file = 'imagegif';
        break;
      case IMAGETYPE_PNG :
        $image_from_file = 'imagecreatefrompng';
        $image_to_file = 'imagepng';
        break;
      default :
        display_error('File must be a JPEG, GIF, or PNG image. File type was ' . $image_type);
        break;
        exit();
    }
    // Get the old image and its height and width
    $old_image = $image_from_file($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);
    // Calculate height and width ratios
    $width_ratio = $old_width / $max_width;
    $height_ratio = $old_height / $max_height;
    // If image is larger than specified ratio, create the new image
    if ($width_ratio > 1 || $height_ratio > 1) {
      // Calculate height and width for the new image
      $ratio = max($width_ratio, $height_ratio);
      $new_height = round($old_height / $ratio);
      $new_width = round($old_width / $ratio);
      // Create the new image
      $new_image = imagecreatetruecolor($new_width, $new_height);
      // Set transparency according to image type
      if ($image_type == IMAGETYPE_GIF) {
        $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
        imagecolortransparent($new_image, $alpha);
      }
      if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
        imagealphablending($new_image, false);
        imagesavealpha($new_image, true);
      }
      // Copy old image to new image - this resizes the image
      $new_x = 0;
      $new_y = 0;
      $old_x = 0;
      $old_y = 0;
      imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);
      // Write the new image to a new file
      $image_to_file($new_image, $new_image_path);
      // Free any memory associated with the new image
      imagedestroy($new_image);
    } else {
      // Write the old image to a new file
      $image_to_file($old_image, $new_image_path);
    }
    // Free any memory associated with the old image
    imagedestroy($old_image);
  } catch (Exception $e) {
    display_error($e->getMessage());
    exit();
  }
}

/**
 * Deletes an image according to the specified image path
 * 
 * @param string $dir
 *          Directory to image
 * @param string $file_name
 *          Name of image
 */
function delete_image($dir, $file_name) {
  $file_path = $dir . $file_name;
  if (file_exists($file_path)) {
    $success = unlink($file_path);
    if (! $success) {
      display_error("Unable to delete file");
    }
  }
}