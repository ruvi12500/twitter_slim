<?

namespace Twitter;

class Images
{

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }


    public function Insert()
    {
        $Image = $this -> getImage();
        if($Image != ""){
            ob_start();
            imagepng($Image, null, 9);
            $ImageBinary = ob_get_clean();
        }
    }

    public function Display()
    {

    }
}