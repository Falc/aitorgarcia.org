<?php

namespace AitorGarcia\PortfolioBundle\Controller;

use AitorGarcia\PortfolioBundle\Entity\Enquiry;
use AitorGarcia\PortfolioBundle\Form\Type\EnquiryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        // Render the index view
        return $this->render('PortfolioBundle:Default:index.html.twig');
    }

    public function contactAction()
    {
        // Create a blank enquiry
        $enquiry = new Enquiry();

        // Create the form and set the data
        $form = $this->createForm(new EnquiryType(), $enquiry);

        // Get the request
        $request = $this->get('request');

        // If the request method is POST, process the data
        if ($request->getMethod() === 'POST')
        {
            // Bind the request
            $form->bind($request);

            // If the form data is valid:
            if ($form->isValid())
            {
                // 1) Create the email
                $message = \Swift_Message::newInstance();
                $message->setSubject('Email de contacto');
                $message->setFrom(
                    $this->container->getParameter('contact_from')
                );
                $message->setTo(
                    $this->container->getParameter('contact_email')
                );
                $message->setBody(
                    $this->renderView(
                        'PortfolioBundle:Default:contact_email.txt.twig',
                        array('enquiry' => $enquiry)
                    )
                );

                // 2) Send the email
                $this->get('mailer')->send($message);

                // 3) Display a success message
                $request->getSession()->getFlashBag()->add('success', 'El email ha sido enviado correctamente');

                // 4) Redirect the user to the contact page again
                return $this->redirect($this->generateUrl('contact'));
            }
        }

        // Render the form
        return $this->render(
            'PortfolioBundle:Default:contact.html.twig',
            array('form' => $form->createView())
        );
    }
}
