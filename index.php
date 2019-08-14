if ( isset( $_GET['code'] ) ) {
 
	$params = array(
		'7096955'     => $clientId,
		'c1czWGqLEgSpe3DP2qdP' => $clientSecret,
		'code'          => $_GET['code'],
		'https://github.com/Kamakepar2028/vk/index.php'  => $redirectUri
	);
 
	if (!$content = @file_get_contents('https://oauth.vk.com/access_token?' . http_build_query($params))) {
		$error = error_get_last();
		throw new Exception('HTTP request failed. Error: ' . $error['message']);
	}
 
	$response = json_decode($content);
 
	// Если при получении токена произошла ошибка
	if (isset($response->error)) {
		throw new Exception('При получении токена произошла ошибка. Error: ' . $response->error . '. Error description: ' . $response->error_description);
	}
 
	$token = $response->access_token; // Токен
	$expiresIn = $response->expires_in; // Время жизни токена
	$userId = $response->user_id; // ID авторизовавшегося пользователя
 
	// Сохраняем токен в сессии
	$_SESSION['token'] = $token;
 
 
} elseif ( isset( $_GET['error'] ) ) { // Если при авторизации произошла ошибка
 
	throw new Exception( 'При авторизации произошла ошибка. Error: ' . $_GET['error']
	                     . '. Error reason: ' . $_GET['error_reason']
	                     . '. Error description: ' . $_GET['error_description'] );
}
