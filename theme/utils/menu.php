<?php

/** A simple data object representing an item from a WordPress menu. */
class MenuItem {
	public $id;
	public $url;
	public $label;

	/**
	 * Submenu items if this item has a submenu.
	 * @var array
	 */
	public $submenu;

	public function __construct($id, $url, $label) {
		$this->id = $id;
		$this->url = $url;
		$this->label = $label;
		$this->submenu = [];
	}
}

/**
 * Returns a WordPress menu as a hierarchy of objects which corresponds to
 * the actual menu structure.
 *
 * This makes it more suitable for recursive printing as opposed to
 * {@code wp_get_nav_menu_items} which returns the menu as a one-dimensional
 * array.
 *
 * It takes the same arguments as {@code wp_get_nav_menu_items}.
 *
 * @param int|string|WP_Term $menu
 * @param array $args
 * @return MenuItem[]
 */
function get_structured_menu($menu, $args = []) {
	$wp_items = wp_get_nav_menu_items($menu, $args);

	$menu = [];
	$items_by_id = [];

	foreach ($wp_items as $wp_item) {
		$item = new MenuItem($wp_item->ID, $wp_item->url, $wp_item->title);
		$items_by_id[$wp_item->ID] = $item;

		if ($wp_item->menu_item_parent === "0") {
			$menu[] = $item;
		} else {
			// We are relying on WordPress giving us the menu items in the right
			// order in which the parent item comes before any child items.
			$parent_id = intval($wp_item->menu_item_parent); // Comes in as a string.
			assert(array_key_exists($parent_id, $items_by_id));
			$items_by_id[$wp_item->menu_item_parent]->submenu[] = $item;
		}
	}

	return $menu;
}
