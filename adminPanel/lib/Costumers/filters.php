<?php
class filters
{
    /**
     *
     */
    public function __construct()
    {
    }

    /**
     *
     */
    public function __destruct()
    {
    }
    
    /**
     * Set friendly columns\' names to order tables\' entries
     */
    public function setOrderingValues()
    {
        $ordering = [
            'id' => 'ID',
            'title' => 'Title',
            'author' => 'Author',
            'isbn' => 'ISBN',
            'category' => 'Category',
        ];

        return $ordering;
    }
}
?>
