<?php

class CategoryTree {

    public $root = NULL;
    public $index = NULL;

    public function __construct (Category $category, array $index) {

        $this -> root = $category;
	$this -> index = $index;
    }

    public function find (string $vUrlName) {

	return array_key_exists ($vUrlName, $this -> index) ?
	       $this -> index [$vUrlName] : NULL;
    }

    public function traverse (Category $category, int $level = 0) {

        if ($category) {

            echo str_repeat ("-----", $level);
            echo " " . $category -> vName . " (" . $category -> count . ")\n";

            foreach ($category -> children as $subCategory) {

                $this -> traverse ($subCategory, $level + 1);
            }
        }
    }
}
