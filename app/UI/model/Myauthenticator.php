<?php



namespace App\UI\Model;


use Nette\Security\SimpleIdentity;
use Nette\Security\Authenticator as A;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;
use Exception;

class MyAuthenticator
{
    public function __construct(
        private UserFacade $userFacade,
        private RoleFacade $roleFacade,
        private Passwords $passwords,
    ) {}
    /**
    * @inheritDoc
    */

    function authenticate(string $user,string $password): IIdentity
    {

        // Získání uživatele podle e-mailu
        $row = $this->userFacade->getByEmail($user);
        
		if (!$row) {
            throw new Exception('User not found.');
        }

        // Ověření hesla
        if (!$this->passwords->verify($password, $row->password)) {
            throw new Exception('Invalid password.');
        }
		        // Připravení dat identity
        $user = $row->toArray();
        unset($user['password']);

        return new SimpleIdentity(
            $row->id,
            	$this->roleFacade->findByUserIdToSelect($row->id), // Role uživatele
            $user   // Další data uživatele
        );
    }
}
