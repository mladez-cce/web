<?php

// Add backend styles for Gutenberg.
add_action("enqueue_block_editor_assets", function () {
	wp_enqueue_style(
		"gutenberg-editor-style",
		"/assets/styles/gutenberg.css" );
});
