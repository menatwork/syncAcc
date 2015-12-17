<?php

class ExtendedLogin
{
    /**
     * @var Input
     */
    public $Input;

    /**
     * @var Database
     */
    public $Database;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->Input    = Input::getInstance();
        $this->Database = Database::getInstance();
    }

    /**
     * Test whether a password hash has been generated with crypt()
     *
     * @param string $strHash The password hash
     *
     * @return boolean True if the password hash has been generated with crypt()
     */
    protected function test($strHash)
    {
        if (strncmp($strHash, '$2y$', 4) === 0)
        {
            return true;
        }
        elseif (strncmp($strHash, '$2a$', 4) === 0)
        {
            return true;
        }
        elseif (strncmp($strHash, '$6$', 3) === 0)
        {
            return true;
        }
        elseif (strncmp($strHash, '$5$', 3) === 0)
        {
            return true;
        }

        return false;
    }

    /**
     * Verify a readable password against a password hash
     *
     * @param string $strPassword The readable password
     * @param string $strHash     The password hash
     *
     * @return boolean True if the password could be verified
     *
     * @see https://github.com/ircmaxell/password_compat
     */
    public static function verify($strPassword, $strHash)
    {
        if (function_exists('password_verify'))
        {
            return password_verify($strPassword, $strHash);
        }

        $getLength = function ($str)
        {
            return extension_loaded('mbstring') ? mb_strlen($str, '8bit') : strlen($str);
        };

        $newHash = crypt($strPassword, $strHash);
        if (!is_string($newHash) || $getLength($newHash) != $getLength($strHash) || $getLength($newHash) <= 13)
        {
            return false;
        }

        $intStatus = 0;

        for ($i = 0; $i < $getLength($newHash); $i++)
        {
            $intStatus |= (ord($newHash[ $i ]) ^ ord($strHash[ $i ]));
        }

        return $intStatus === 0;
    }

    /**
     * Generate a password hash
     *
     * @param string $strPassword The unencrypted password
     *
     * @return string The encrypted password
     *
     * @throws \Exception If none of the algorithms is available
     */
    public static function hash($strPassword)
    {
        $intCost = 10;

        if ($intCost < 4 || $intCost > 31)
        {
            throw new \Exception("The bcrypt cost has to be between 4 and 31, $intCost given");
        }

        if (function_exists('password_hash'))
        {
            return password_hash($strPassword, PASSWORD_BCRYPT, array('cost' => $intCost));
        }
        elseif (CRYPT_BLOWFISH == 1)
        {
            return crypt($strPassword, '$2y$' . sprintf('%02d', $intCost) . '$' . md5(uniqid(mt_rand(), true)) . '$');
        }
        elseif (CRYPT_SHA512 == 1)
        {
            return crypt($strPassword, '$6$' . md5(uniqid(mt_rand(), true)) . '$');
        }
        elseif (CRYPT_SHA256 == 1)
        {
            return crypt($strPassword, '$5$' . md5(uniqid(mt_rand(), true)) . '$');
        }

        throw new \Exception('None of the required crypt() algorithms is available');
    }

    /**
     * @param string $user
     *
     * @param string $password
     *
     * @param User   $caller
     *
     * @return bool The state of the login.
     */
    public function checkPassword($user, $password, $caller)
    {
        // The password has been generated with crypt()
        if ($this->test($caller->password))
        {
            $blnAuthenticated = $this->verify($password, $caller->password);
        }
        else
        {
            list($strPassword, $strSalt) = explode(':', $caller->password);
            $blnAuthenticated = ($strSalt == '') ? ($strPassword === sha1($password)) : ($strPassword === sha1($strSalt . $password));

            // Store a SHA-512 encrpyted version of the password
            if ($blnAuthenticated)
            {
                $this->password = $this->hash($password);
            }
        }

        return $blnAuthenticated;
    }
}
