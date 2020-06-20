<?php

$initTheme[] = function () {
	add_action('phpmailer_init', function (PHPMailer $mailer) {
		global $App;
		assert($App instanceof \Nette\DI\Container);

		if (!array_key_exists('smtp', $App->parameters)) {
			return;
		}

		$config = $App->parameters['smtp'];
		assert(array_key_exists('host', $config), 'Host key is required in SMTP config!');

		$mailer->isSMTP();
		$mailer->SMTPAuth = true;
		$mailer->SMTPSecure = isset($config['secure']) ? $config['secure'] : '';
		$mailer->Host = $config['host'];
		$mailer->Port = isset($config['port']) ? $config['port'] : ($mailer->SMTPSecure === 'ssl' ? 465 : 25);
		$mailer->Username = isset($config['username']) ? $config['username'] : '';
		$mailer->Password = isset($config['password']) ? $config['password'] : '';
	});
};
