<?php

namespace A2lix\DemoTranslationBundle\EventListener;

use Gedmo\Translatable\TranslatableListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * This listeners sets the current locale for the TranslatableListener
 *
 * @author Christophe COEVOET
 * @author David ALLIX
 */
class LocaleListener implements EventSubscriberInterface
{
    private $translatableListener;

    public function __construct(TranslatableListener $translatableListener)
    {
        $this->translatableListener = $translatableListener;
    }

    /**
     * Set the translation listener locale from the request.
     *
     * This method should be attached to the kernel.request event.
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        // Force Default Locale for backend new/edit
        // TODO find better way
        if (in_array($request->attributes->get('_route'), array('backend_product_new', 'backend_product_edit'))) {
            $this->translatableListener->setTranslatableLocale('en');       
            
        } else {
            $this->translatableListener->setTranslatableLocale($request->getLocale());
        }
    }

    static public function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => 'onKernelRequest',
        );
    }
}
