<?php

$initTheme[] = function ($dir) {
	$widgetsDir = $dir.'/admin/widgets';

	add_action('wp_dashboard_setup', function ($toolbar) use ($widgetsDir) {
		foreach (glob("$widgetsDir/*.php") as $filepath) {
			$result = require_once $filepath;

			if (empty($result) || is_bool($result)) {
				continue;
			}

			if (!empty($result['render'])) {
				wp_add_dashboard_widget(
								basename($filepath, '.php'),
isset(								$result['name']) ? 								$result['name'] : (isset($result['title']) ? $result['title'] : ''),
								$result['render'],
isset(								$result['renderControl']) ? 								$result['renderControl'] : null
							);
			}

			if (!empty($result['latte'])) {
				wp_add_dashboard_widget(
					basename($filepath, '.php'),
isset(					$result['name']) ? 					$result['name'] : (isset($result['title']) ? $result['title'] : ''),
					function () use ($result) {
						view($result['latte'], isset($result['data']) ? $result['data'] : (isset($result['props']) ? $result['props'] : []));
					},
					empty($result['latteControl']) ? null : function () use ($result) {
						view($result['latteControl'], isset($result['data']) ? $result['data'] : (isset($result['props']) ? $result['props'] : []));
					}
				);
			}

			if (!empty($result['component'])) {
				wp_add_dashboard_widget(
					basename($filepath, '.php'),
isset(					$result['name']) ? 					$result['name'] : (isset($result['title']) ? $result['title'] : ''),
					function () use ($filepath, $result) {
						Mangoweb\renderAdminComponent(basename($filepath, '.php'), $result['component'], isset($result['data']) ? $result['data'] : (isset($result['props']) ? $result['props'] : []));
					},
					empty($result['componentControl']) ? null : function () use ($filepath, $result) {
						Mangoweb\renderAdminComponent(basename($filepath, '.php'), $result['componentControl'], isset($result['data']) ? $result['data'] : (isset($result['props']) ? $result['props'] : []));
					}
				);
			}
		}
	});
};
