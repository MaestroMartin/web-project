<?php



namespace App\UI\Model;



use Nette\Security\SimpleIdentity;
use Nette\Security\Authenticator ;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;
use Exception;

class MyAuthenticator implements Authenticator
{
    public function __construct(
        private UserFacade $userFacade,
        private RoleFacade $roleFacade,
        private Passwords $passwords,
    ) {}
    /**
    * @param string $name
    */

    function authenticate(string $name, string $password): IIdentity
    {

        // Získání uživatele podle e-mailu
        $row = $this->userFacade->getByEmail($name);
        
		if (!$row) {
            throw new Exception('User not found.');
        }
        
        // Ověření hesla
        if (!$this->passwords->verify($password, $row->password)) {
           
            throw new Exception('Invalid password.');
        }
		        // Připravení dat identity
                bdump($name);
        $user = $row->toArray();
        unset($user['password']);

        return new SimpleIdentity(
            $row->id,
            	$this->roleFacade->findAllByUserIdAsEntity($row->id), // Role uživatele
            $user,   // Další data uživatele
        );
    }
}
