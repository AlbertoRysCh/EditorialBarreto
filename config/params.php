<?php
$vars = env('APP_ENV', '');
$params = ['general' => [
       'ambiente' => $vars,
    ],
];
switch ($vars) {
    case'local':
        $params['global'] = [
            'app_id' => '67968b62-be48-4e97-98b0-996debef14fd',
            'auth_api' => 'admin',
            'password_api' => '12345678*',
            'url_apilogin' => 'http://marketbdoble.test/api/auth/login',
        ];
        break;

    case'production':
        $params['global'] = [
            'app_id' => 'a2884b65-61a0-4ec9-9876-17709f469ad4',
            'auth_api' => 'admin',
            'password_api' => '12345678*',
            'url_apilogin' => 'http://appbdoblemarket.net.pe/api/auth/login',
        ];        
        break;
    
        
}
return $params;
