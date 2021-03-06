<?php
/**
 * This file contains the DefaultController class.
 *
 * @author      Aitor García (Falc) <aitor.falc@gmail.com>
 * @copyright   2012-2013 Aitor García (Falc) <aitor.falc@gmail.com>
 * @license     https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\ContactBundle\Controller;

use AitorGarcia\ContactBundle\Entity\Enquiry;
use AitorGarcia\ContactBundle\Form\Type\EnquiryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Contains some basic actions.
 */
class DefaultController extends Controller
{
    /**
     * Displays the contact form and processes it.
     */
    public function contactAction()
    {
        // Create a blank enquiry and the form
        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);

        $request = $this->getRequest();
        $form->handleRequest($request);

        // If the form data is valid:
        if ($form->isValid())
        {
            // 1) Create the email
            $message = \Swift_Message::newInstance();
            $message->setSubject('Email de contacto');
            $message->setFrom($this->container->getParameter('contact_from'));
            $message->setTo($this->container->getParameter('contact_email'));
            $message->setBody(
                $this->renderView(
                    'AitorGarciaContactBundle:Default:contact_email.txt.twig',
                    array(
                        'enquiry' => $enquiry
                    )
                )
            );
            $message->setContentType('text/html');

            // 2) Send the email
            $this->get('mailer')->send($message);

            // 3) Display a success message
            $successMessage = $this->get('translator')->trans('contact.message.success_send');
            $request->getSession()->getFlashBag()->add('success', $successMessage);

            // 4) Redirect the user to the contact page again
            return $this->redirect($this->generateUrl('contact'));
        }

        // Render the form
        return $this->render(
            'AitorGarciaContactBundle:Default:contact.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }
}
