<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail{

    private $api_key = 'd4bebc3fbbb405eeb25e3d4af52185ed';
    private $api_key_secret = '421d0257f1717b95ea3f06fe0fe35bf5';

    public function send($to_email,$to_name,$subject,$carrierPrice,$carrierName,$products,$firstNameUser,$reference){
        $mj = new Client($this->api_key , $this->api_key_secret,true,['version' => 'v3.1']);
        //$mj = new \Mailjet\Client(getenv('MJ_APIKEY_PUBLIC'), getenv('MJ_APIKEY_PRIVATE'),true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "mejin972@gmail.com",
                        'Name' => "La Boutique Française"
                    ],
                    'To' => [
                        [
                            'Email' => "$to_email",
                            'Name' => "$to_name"
                        ]
                    ],
                    'TemplateID' => 3067765,
                    'TemplateLanguage' => true,
                    'Subject' => "Votre commande",
                    'Variables' => [
                        "reference"=> "$reference",
                        "firstNameUser"=> "$firstNameUser",
                        "product"=> "$products",
                        "carrierName"=> "$carrierName",
                        "carrierPrice"=> "$carrierPrice",
                        "mailUser"=> "$to_email"
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() ;//&& dd($response->getData());
    }

    public function registerSend($to_email,$to_name,$firstName){
        $mj = new Client($this->api_key , $this->api_key_secret,true,['version' => 'v3.1']);
        //$mj = new \Mailjet\Client(getenv('MJ_APIKEY_PUBLIC'), getenv('MJ_APIKEY_PRIVATE'),true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "mejin972@gmail.com",
                        'Name' => "La Boutique Française"
                    ],
                    'To' => [
                        [
                            'Email' => "$to_email",
                            'Name' => "$to_name"
                        ]
                    ],
                    'TemplateID' => 3068772,
                    'TemplateLanguage' => true,
                    'Subject' => "Confirmation d'inscription",
                    'Variables' => [
                        "firstName"=> "$firstName",
                        "userMail"=> "$to_email"
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() ;//&& dump($response->getData());
    }

    public function statutSend($to_email,$to_name,$firstName, $orderStatue, $linkCompteVoir ){
        $mj = new Client($this->api_key , $this->api_key_secret,true,['version' => 'v3.1']);
        //$mj = new \Mailjet\Client(getenv('MJ_APIKEY_PUBLIC'), getenv('MJ_APIKEY_PRIVATE'),true,['version' => 'v3.1']);
    
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "mejin972@gmail.com",
                        'Name' => "La Boutique Française"
                    ],
                    'To' => [
                        [
                            'Email' => "$to_email",
                            'Name' => "$to_name"
                        ]
                    ],
                    'TemplateID' => 3072667,
                    'TemplateLanguage' => true,
                    'Subject' => "Information statue de commande",
                    'Variables' => [
                        "firstName"=> "$firstName",
                        "orderStatue"=> "$orderStatue",
                        "linkCompteVoirCommande" => "$linkCompteVoir",
                    ]
                ]
            ]
        ];
        
        
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() ;//&& dump($response->getData());
    }

    public function updatePasswordSend($to_email,$to_name,$firstName, $dateOfRequest,$url_updatePassword ){
        $mj = new Client($this->api_key , $this->api_key_secret,true,['version' => 'v3.1']);
        //$mj = new \Mailjet\Client(getenv('MJ_APIKEY_PUBLIC'), getenv('MJ_APIKEY_PRIVATE'),true,['version' => 'v3.1']);
    
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "mejin972@gmail.com",
                        'Name' => "La Boutique Française"
                    ],
                    'To' => [
                        [
                            'Email' => "$to_email",
                            'Name' => "$to_name"
                        ]
                    ],
                    'TemplateID' => 3081526,
                    'TemplateLanguage' => true,
                    'Subject' => " Réinitialisation mot de passe ",
                    'Variables' => [
                        "firstName"=> "$firstName",
                        "dateOfRequest"=> "$dateOfRequest",
                        "url_updatePassword"=>$url_updatePassword,
                    ]
                ]
            ]
        ];
        
        
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() ;//&& dump($response->getData());
    }

    public function confirmUpdatePasswordSend($to_email,$to_name,$firstName, $url_compte ){
        $mj = new Client($this->api_key , $this->api_key_secret,true,['version' => 'v3.1']);
        //$mj = new \Mailjet\Client(getenv('MJ_APIKEY_PUBLIC'), getenv('MJ_APIKEY_PRIVATE'),true,['version' => 'v3.1']);
    
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "mejin972@gmail.com",
                        'Name' => "La Boutique Française"
                    ],
                    'To' => [
                        [
                            'Email' => "$to_email",
                            'Name' => "$to_name"
                        ]
                    ],
                    'TemplateID' => 3083963,
                    'TemplateLanguage' => true,
                    'Subject' => " Changement mot de passe",
                    'Variables' => [
                        "firstName"=> "$firstName",
                        "url_compte"=> "$url_compte",
                        
                    ]
                ]
            ]
        ];
        
        
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() ;//&& dump($response->getData());
    }

    public function contactFromCustumersSend($to_email,$to_name,$firstName, $lastName , $content ,$isRegistered, $mailCustumer ){
        $mj = new Client($this->api_key , $this->api_key_secret,true,['version' => 'v3.1']);
        //$mj = new \Mailjet\Client(getenv('MJ_APIKEY_PUBLIC'), getenv('MJ_APIKEY_PRIVATE'),true,['version' => 'v3.1']);
    
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "mejin972@gmail.com",
                        'Name' => "La Boutique Française"
                    ],
                    'To' => [
                        [
                            'Email' => "$to_email",
                            'Name' => "$to_name"
                        ]
                    ],
                    'TemplateID' => 3091340,
                    'TemplateLanguage' => true,
                    'Subject' => " Contact de client",
                    'Variables' => [
                        "firstName"=> "$firstName",
                        "lastName"=> "$lastName ",
                        "contentMassage"=> "$content",
                        "mailCustumer"=> "$mailCustumer",
                        "isInDataBase"=> "$isRegistered"
                        
                    ]
                ]
            ]
        ];
        
        
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() ;//&& dump($response->getData());
    }


    public function infoRejectSend($to_email,$to_name,$reference){
        $mj = new Client($this->api_key , $this->api_key_secret,true,['version' => 'v3.1']);
        //$mj = new \Mailjet\Client(getenv('MJ_APIKEY_PUBLIC'), getenv('MJ_APIKEY_PRIVATE'),true,['version' => 'v3.1']);
    
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "mejin972@gmail.com",
                        'Name' => "La Boutique Française"
                    ],
                    'To' => [
                        [
                            'Email' => "$to_email",
                            'Name' => "$to_name"
                        ]
                    ],
                    'TemplateID' => 3171071,
                    'TemplateLanguage' => true,
                    'Subject' => " Contact de client",
                    'Variables' => [
                        "reference"=> "$reference",                        
                    ]
                ]
            ]
        ];
        
        
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() ;//&& dump($response->getData());
    }
}




?>