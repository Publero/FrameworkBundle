<?php
namespace Publero\FrameworkBundle\Form\Handler;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseFormHandler
{
    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @var FormTypeInterface
     */
    protected $formType;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var ManagerRegistry
     */
    protected $doctrine;

    /**
     * Returns a form.
     *
     * If form instance has been set, it's returned directly.
     * If form type has been set instead, a form is built (form the type) and stored for future usage with this handler.
     * Any further changes to type will have no effect on form.
     *
     * @return FormInterface
     * @throws \BadMethodCallException
     */
    public function getForm()
    {
        if ($this->form === null && $this->formType !== null) {
            if ($this->formFactory === null) {
                throw new \BadMethodCallException("can't build a Form from FormType without FormFactory");
            }
            $this->form = $this->formFactory->create($this->getFormType());
        }

        return $this->form;
    }

    /**
     * @param FormInterface $form
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
     * @param FormFactoryInterface $formFactory
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param ManagerRegistry $doctrine
     */
    public function setDoctrine(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @return ObjectManager
     */
    protected function getManager()
    {
        return $this->doctrine->getManager();
    }

    /**
     * @return boolean
     */
    public function handleRequest(Request $request)
    {
        $this->preHandle($request);
        $this->getForm()->handleRequest($request);
        $this->preValidate($request);

        return $this->form->isValid() ?
            $this->onValid($request) :
            $this->onInvalid($request)
        ;
    }

    protected function preHandle(Request $request)
    {
    }

    protected function preValidate(Request $request)
    {
    }

    /**
     * @return boolean
     */
    protected abstract function onValid(Request $request);

    /**
     * @return boolean
     */
    protected function onInvalid(Request $request)
    {
        return false;
    }
}
