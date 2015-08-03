<?php
include_once (LIBS.'database.php');

class Tags
{
    public $tags, $sep = ";";

    function __construct()
    {
        $this->db = new Database;
    }

    public function storeTags($pid)
    {
        $tags = $this->toArray($this->tags);
        if (is_array($tags)){
            foreach ($tags as $tag) {
                $this->db->add('tags', array('name' => $tag, 'pid' => $pid));
            }
        }
        else $this->db->add('tags', array('name' => $tags, 'pid' => $pid));
    }

    public function editTags($pid)
    {
        $tags = $this->toArray($this->tags);
        if (is_array($tags)){
            foreach ($tags as $tag) {
                $this->db->edit('tags', array('name' => $tag),array('pid' => $pid));
            }
        }
        else $this->db->edit('tags', array('name' => $tags),array('pid' => $pid));
    }

    public function filterTags($tags,$reg = '/[^a-z0-9\\040\\-\\_]/')
    {
        return preg_replace( "{[ \t]+}", $this->sep, trim(preg_replace($reg," ", strtolower($tags))));
    }

    public function toArray($tags)
    {
        return explode($this->sep, $tags);
    }
}
