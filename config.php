<?php
return $config = 
[
    'db'=>[
        'server'=>'localhost',
        'dbname'=>'paytabs',
        'dbpass'=>'',
        'dbuser'=>'root'
    ],
    'paytab'=>[
        'paytabs_url'=>'https://secure-egypt.paytabs.com/payment/request',
        'profile_id'=>'132344',
        'integration_key'=>'SWJ992BZTN-JHGTJBWDLM-BZJKMR2ZHT',
        'return'=>'/paymentsuccess',
        'callback'=>'http://localhost/payment_callback.php' 
    ],
    // 'paytab'=>[
    //     'paytabs_url'=>'https://secure-global.paytabs.com/payment/request',
    //     'profile_id'=>'161041',
    //     'integration_key'=>'SZJ9BMTWM6-JKNH92ZTB9-N6DK6MRDHN',
    //     'return'=>'/paymentsuccess',
    //     'callback'=>'http://localhost/payment_callback.php' 
    // ]
];