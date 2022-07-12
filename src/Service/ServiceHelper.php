<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Security;

class ServiceHelper
{

    private LoggerInterface $logger;
    private Security $security;

    /**
     * @param LoggerInterface $logger
     * @param Security $security
     */
    public function __construct(LoggerInterface $logger, Security $security)
    {

        $this->logger = $logger;
        $this->security = $security;
    }

    public function getMethod()
    {
        if($this->security->getUser()){
            $this->logger->info('Utilizando el método method con {user}', [
                'user' => $this->security->getUser()->getUserIdentifier()
            ]);
        }
    }

}