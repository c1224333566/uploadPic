<?php
/**
 * 这里是对图片进行裁剪的类
 *
 * @author lidaming<lidaming307@163.com>
 * @copyright Copyright © 2014-2015 Dajiangtai.com Inc.
 */

class Crop {

    private $filename;
	private $destname;  	
    private $ext;  
    private $x;  
    private $y;  
    private $src_width;  
    private $src_height;  
    private $dest_width;  
    private $dest_height;  
    private $jpeg_quality = 90;  

    /** 
     * 初始化截图对象 
     *@param filename 源文件路径全明 
     *@param x  横坐标1 
     *@param y  纵坐标1 
     *@param width  截图的宽 
     *@param height  截图的高 
     *  
     */  
    public function initialize($filename, $destname, $x, $y, $dest_width, $dest_height, $src_width, $src_height)  
    {  
        if(file_exists($filename))  
        {  
            $this->filename = $filename; 
			$this->destname = $destname; 
            $pathinfo = pathinfo($filename);  
            $this->ext = $pathinfo['extension'];
			$this->dest_width = $dest_width;
			$this->dest_height = $dest_height;
			$this->src_width = $src_width;
			$this->src_height = $src_height;
        }  
        else  
        {  
            $e = new Exception('the file is not exists!',1050);  
            throw $e;  
        }  
        $this->x = $x;  
        $this->y = $y;     
 
    }
      
    /** 
     * 生成截图 
     * 根据图片的格式，生成不同的截图 
     */  
    public function generate_shot()  
    {  
        switch($this->ext)  
        {  
            case 'jpg': 
			case 'jpeg': 
                return $this->generate_jpg();  
                break;  
            case 'png':  
                return $this->generate_png();  
                break;  
            case 'gif':  
                return $this->generate_gif();  
                break;  
            default:  
                return false;  
        }  
    }  
    
    /** 
     * 生成jpg格式的图片 
     *  
     */  
    private function generate_jpg()  
    {  
    	//裁剪后的文件名，包含文件路径
        $shot_name = $this->destname; 
        //从原图片生成image资源 对象
        $img_r = imagecreatefromjpeg($this->filename);
        //新建将要生成的image资源对象
        $dst_r = ImageCreateTrueColor($this->dest_width, $this->dest_height);  
        //将$img_r中的一块正方形区域拷贝到$dst_r中
        imagecopyresampled($dst_r, $img_r, 0, 0, $this->x, $this->y, $this->dest_width, $this->dest_height, $this->src_width, $this->src_height);  
        //输出图像到$shot_name文件中，其中$this->jpeg_quality为可选项，范围从 0（最差质量，文件更小）到 100（最佳质量，文件最大），这里定义为90
        return imagejpeg($dst_r,$shot_name,$this->jpeg_quality);    
    }  
    /** 
     * 生成gif格式的图片 
     *  
     */  
    private function generate_gif()  
    {  
        $shot_name = $this->destname;  
        $img_r = imagecreatefromgif($this->filename);  
        $dst_r = ImageCreateTrueColor($this->dest_width, $this->dest_height); 
        //将$img_r中的一块正方形区域拷贝到$dst_r中
		imagecopyresampled($dst_r, $img_r, 0, 0, $this->x, $this->y, $this->dest_width, $this->dest_height, $this->src_width, $this->src_height);  
		//输出图像到$shot_name文件中
		return imagegif($dst_r,$shot_name);  
    }  
    /** 
     * 生成png格式的图片 
     *  
     */  
    private function generate_png()  
    {  
        $shot_name = $this->destname;  
        $img_r = imagecreatefrompng($this->filename);  
        $dst_r = ImageCreateTrueColor($this->dest_width, $this->dest_height); 
        //将$img_r中的一块正方形区域拷贝到$dst_r中
		imagecopyresampled($dst_r, $img_r, 0, 0, $this->x, $this->y, $this->dest_width, $this->dest_height, $this->src_width, $this->src_height);  
		//输出图像到$shot_name文件中
		return imagepng($dst_r,$shot_name);   
    }  
}
