<?php

return array(


    'pdf' => array(
        'enabled' => true,
        'binary'  => 'xvfb-run -- /usr/bin/wkhtmltopdf',
        //'binary'  => '/usr/local/bin/wkhtmltopdf',
        //'binary'  => '/vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => 'xvfb-run -- /usr/bin/wkhtmltoimage',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),


);
