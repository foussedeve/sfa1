<?php

namespace App\EventSubscriber;

use App\Entity\HistoriqueConnexion;
use App\Repository\HistoriqueConnexionRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;

class LoginSubscriber implements EventSubscriberInterface
{

    private HistoriqueConnexionRepository $hcRepo;
    private RequestStack $request;
    public function __construct(HistoriqueConnexionRepository $hcRepo, RequestStack $request)
    {
        $this->hcRepo = $hcRepo;
        $this->request = $request;
    }

    public static function getSubscribedEvents()
    {
        return [
            'security.authentication.success' => 'onSecurityAuthenticationSuccess',
        ];
    }
    /**
     * Login success Login succes listener 
     * @param AuthenticationSuccessEvent 
     */
    public function onSecurityAuthenticationSuccess(AuthenticationSuccessEvent $event)
    {
        $request = $this->request->getCurrentRequest();

        $url = $request->server->get("PATH_INFO");
        $ip = $request->server->get("PATH_INFO");
        $date = new \DateTime();
        
        /**
         * @var User
         */
        $user = $event->getAuthenticationToken()->getUser();


        $hist_conneexion = new HistoriqueConnexion();
        $hist_conneexion->setEmail($user->getUsername())
            ->setAdresseIp($ip)
            ->setDateConnexion($date);

        $user->setLastConnexion($date->format("d/m/Y h:i:s"));
        $this->hcRepo->add($hist_conneexion,true);
       
    }
}
