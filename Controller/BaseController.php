<?php
namespace Publero\FrameworkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

class BaseController extends Controller
{
    /**
     * Umozni funkci Render vyhledat custom sablonu pro lokalizaci XXX.{_locale}.html.twig
     *
     * Pokud existuje vedle pozadovane sablony ($view) konkretni sablona pro aktualni jazykovou mutaci,
     * podstrci pro renderovani tuto konkretni sablonu.
     *
     * Demo:
     * $_locale = 'cs'
     * $view = ...Default:index.html.twig
     * - pokud v adresari pro sablony existuje i sablona index.cs.html.twig - bude nactena tato
     * - jinak bude nactena pozadovana sablona
     *
     *
     * @param string $view
     * @param array $parameters
     * @param Response $response
     */
    public function render($view, array $parameters = array(), Response $response = null)
    {
        $locale = $this->getRequest()->getLocale();
        if ($locale && strrpos($view, '.html.twig') === 0) {
            $localizedTemplate = str_replace('.html.twig', '.' . $locale . '.html.twig', $view);
            if ($this->container->get('templating')->exists($localizedTemplate)) {
                $view = $localizedTemplate;
            }
        }

        return parent::render($view, $parameters, $response);
    }

    /**
     * @throws AuthenticationCredentialsNotFoundException
     * @return UserInterface
     */
    public function getUser()
    {
        if ($this->isUserLoggedIn()) {
            return $this->get('security.context')->getToken()->getUser();
        }

        throw new AuthenticationCredentialsNotFoundException('User is not set');
    }

    /**
     * @return boolean
     */
    public function isUserLoggedIn()
    {
        return !($this->get('security.context')->getToken() instanceof AnonymousToken);
    }

    /**
     * @return Pecserke\FlashMessagesBundle\HttpFoundation\Session\Session\FlashMessages
     */
    public function getFlashMessagesHelper()
    {
        return $this->get('pecserke.session.flash_messages');
    }

    /**
     * @return \Symfony\Component\HttpKernel\Debug\ContainerAwareTraceableEventDispatcher
     */
    public function getEventDispatcher()
    {
        return $this->get('event_dispatcher');
    }

    /**
     * @return \Symfony\Component\Translation\Translator
     */
    public function getTranslator()
    {
        return $this->get('translator');
    }

    /**
     * @param string $id
     * @param array $parameters
     * @param string $domain
     * @param string $locale
     * @return string
     */
    public function trans($id, array $parameters = array(), $domain = 'messages', $locale = null)
    {
        return $this->getTranslator()->trans($id, $parameters, $domain, $locale);
    }

    /**
     * @param int $id
     * @param number $number
     * @param array $parameters
     * @param string $domain
     * @param string $locale
     * @return string
     */
    public function transChoice($id, $number, array $parameters = array(), $domain = 'messages', $locale = null)
    {
        return $this->getTranslator()->transChoice($id, $number, $parameters, $domain, $locale);
    }

    /**
     * Redirects to specified URL, but preserves some query parameters form this request
     * Which are they is defined in configuration.
     * Query parameters in URL override preserved ones if they have same name.
     *
     * @param string $url
     * @param int $status
     */
    /*public function redirect($url, $status = 302)
    {
        $preservedParams = $this->getQueryParametersToPreserveDuringRedirect();

        if (!empty($preservedParams)) {
            $urlParts = parse_url($url);
            if ($urlParts === false) {
                throw new \InvalidArgumentException("url: $url");
            }

            $urlParams = array();
            if (!empty($urlParts['query'])) {
                parse_str($urlParts['query'], $urlParams);
            }
            $params = array_merge($preservedParams, $urlParams);

            $urlParts['query'] = http_build_query($params);
            $url = http_build_url($urlParts);
        }

        return parent::redirect($url, $status);
    }*/

    /**
     * @return array
     */
    /*private function getQueryParametersToPreserveDuringRedirect()
    {
        $preserveParams = $this->get('service_container')->getParameter('publero_frontend.redirect.preserve_parameters');
        $queryParams = $this->getRequest()->query->all();

        $params = array();
        foreach ($preserveParams as $param) {
            $isPresent = strpos($param, '*');
            if ($isPresent !== false && $isPresent !== -1) {
                $pattern = '/^' . str_replace('*', '.*', $param) . '$/';
                foreach (array_keys($queryParams) as $queryParam) {
                    if (preg_match($pattern, $queryParam)) {
                        $params[$queryParam] = $queryParams[$queryParam];
                    }
                }
            } elseif (isset($queryParams[$param])) {
                $params[$param] = $queryParams[$param];
            }
        }

        return $params;
    }*/
}
