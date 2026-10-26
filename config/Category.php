<?php

class Category {

	public $iPCatID		= NULL;
	public $iParentID		= NULL;
	public $vName		= NULL;
	public $vUrlName		= NULL;
	public $vMenuImage		= NULL;
	public $vMenuImage_AltTag	= NULL;

	public $parent      = NULL;
	public $children	= [];
	public $count	= 0;

	public function __construct(?array $data = NULL) {

		if (!is_null($data)) {
			if (count($data) == 6) {

				$this->iPCatID	    = $data[0];
				$this->iParentID	    = $data[1];
				$this->vName		    = $data[2];
				$this->vUrlName	    = $data[3];
				$this->vMenuImage	    = $data[4];
				$this->vMenuImage_AltTag  = $data[5];
			} else {
				die("Incomplete information for Category construction");
			}
		}

		$this->children   = [];
		$this->count	    = 0;
	}

	public function addSubCategory(Category $category) {

		$this->children[] = $category;
		$category->parent = $this;
	}

	public function crumbs() {

		$category = $this;

		$crumbs = array(
			array(
				'vName' => $category->vName,
				'vUrlName' => $category->vUrlName
			)
		);

		while ($parent = $category->parent) {

			if (! $parent->iPCatID) break;

			$crumbs[] = array(
				'vName' => $parent->vName,
				'vUrlName' => $parent->vUrlName
			);
			$category = $parent;
		}

		$crumbs = array_reverse($crumbs);
		return $crumbs;
	}
}
