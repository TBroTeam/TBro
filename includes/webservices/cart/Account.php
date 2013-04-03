<?php

namespace webservices\cart;

class Account extends \WebService {

    public function execute($querydata) {
        session_start();

        switch ($querydata['action']) {
            case 'login':
                // OPEN_ID Login
                require_once INC . '/libs/openid.php';
                $openid = new LightOpenID(OPENID_DOMAIN);

                if ($openid->mode) {
                    if ($openid->mode == 'cancel') {
                        
                    } elseif ($openid->validate()) {
                        $data = $openid->getAttributes();
                        $identity = $openid->identity;
                        $email = $data['contact/email'];
                        $name = sprintf('%s %s', $data['namePerson/first'], $data['namePerson/last']);
                    }
                }
                break;
        }
    }
}

?>
