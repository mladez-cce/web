<?php

initTheme();

// Enable categories for our custom "event" post type.
add_action("init", function() {
	register_taxonomy_for_object_type("category", "event");
});
