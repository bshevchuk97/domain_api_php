<?php

namespace App\Service\Session;

use App\Models\Session;
use DateTime;
use Exception;

class SessionValidator
{
    private static int $EXPIRATION_HOURS = 4;
    private string $token;


    public function __construct(?string $token) {
        $this->token = $token;
    }


    /**
     * @throws Exception
     */
    public function isValid(): bool {
        return $this->validToken() && $this->validSession();
    }


    private function validToken(): bool {
        if (empty($this->token)) {
            return false;
        }

        return true;
    }


    /**
     * @throws Exception
     */
    private function validSession(): bool {
        $session = Session::findToken($this->token);

        if ($session == NULL)
            return false;

        $created_datetime = new DateTime($session->created_time);
        if (self::expired($created_datetime)){
            return false;
        }

        if ($session->user == NULL)
            return false;

        return true;
    }


    private static function expired(DateTime $creationDateTime): bool {
        $interval = new \DateInterval('PT1H');
        $periods = new \DatePeriod($creationDateTime, $interval, now());
        $hoursPassed = iterator_count($periods);

        return $hoursPassed >= self::$EXPIRATION_HOURS;
    }
}
