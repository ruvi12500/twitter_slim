<?

namespace Twitter;

class Images
{

    public function setName($name)
    {
        $this->name = ($name);
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function display()
    {
        $connect_db = new Database();
        $db= $connect_db->connect_db();
        $stmt = $db->prepare('SELECT * FROM images WHERE name = ?');
        $stmt->execute([$this->getName()]);

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $image[] = $row;
        }

        if (!empty($image)) {
            return $image;
        }
    }
}
