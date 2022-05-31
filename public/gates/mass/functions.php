<?php

function encode_mass_part(array $user, array $card, array $cmd) {
	return json_encode([
		'user' => $user,
		'cc' => [
			'cc' => $card['cc'],
			'card' => $card['card']
		],
    'cmd' => $cmd,
		'bin' => $card['bin'],
	]);
};

function encode_controller_send(array $user, array $req, array $cmd, string $file_name) {
  return json_encode([
		'cmd' => $cmd,
    'user' => $user,
    'req' => [
      'total' => $req['total'],
      'n' => $req['n']
    ],
    'file' => $file_name
  ]);
};
