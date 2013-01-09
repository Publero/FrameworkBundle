<?php
namespace Publero\FrameworkBundle\Form\Handler;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;

class BaseHandler
{
    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @var FormTypeInterface
     */
    private $formType;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @var Registry
     */
    protected $doctrine;

    /**
     * @param FormInterface|FormTypeInterface $form
     */
    public function __construct($form = null)
    {
        if ($form instanceof FormInterface) {
            $this->setForm($form);
        } elseif ($form instanceof FormTypeInterface) {
            $this->setFormType($form);
        } elseif ($form !== null) {
            throw new \InvalidArgumentException('form');
        }
    }

    /**
     * Returns a form.
     *
     * If form instance has been set, it's returned directly.
     * If form type has been set instead, a form is built (form the type) and stored for future usage with this handler.
     * Ant further changes to type will have no effect on form.
     *
     * @return FormInterface
     */
    public function getForm()
    {
        if ($this->form === null && $this->formType !== null) {
            if ($this->getFormFactory() === null) {
                throw new \InvalidMethodCallException("can't build a Form from FormType without FormFactory");
            }
            $this->form = $this->getFormFactory()->create($this->getFormType());
        }

        return $this->form;
    }

    /**
     * @param FormInterface $formType
     */
    public function setForm(FormInterface $form)
    {
        $this->form = $form;
    }

    /**
     * @return FormTypeInterface
     */
    public function getFormType()
    {
        return $this->formType;
    }

    /**
     * @param FormTypeInterface $formType
     */
    public function setFormType(FormTypeInterface $formType)
    {
        $this->formType = $formType;
    }

    /**
     * @return FormFactoryInterface
     */
    public function getFormFactory()
    {
        return $this->formFactory;
    }

    /**
     * @param FormFactoryInterface $formFactory
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getRequest(Request $request)
    {
        return $this->request;
    }

    /**
     * @return EventDispatcher
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * @param EventDispatcher $eventDispatcher
     */
    public function setEventDispatcher(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param Registry $doctrine
     */
    public function setDoctrine(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @return Registry
     */
    public function getDoctrine()
    {
        return $this->doctrine;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->getDoctrine()->getEntityManager();
    }

    /**
     * @return boolean
     */
    public function isToBeProcessed()
    {
        return 'POST' === $this->request->getMethod();
    }

    /**
     * @return boolean
     */
    public function process()
    {
        $this->preBind();
        $this->getForm()->bind($this->request);

        $this->preValidate();
        if ($this->form->isValid()) {
            return $this->onValid();
        }

        return $this->onInvalid();
    }

    protected function preBind()
    {
    }

    protected function preValidate()
    {
    }

    /**
     * @return boolean
     */
    protected function onValid()
    {
        return true;
    }

    /**
     * @return boolean
     */
    protected function onInvalid()
    {
        return false;
    }
}
