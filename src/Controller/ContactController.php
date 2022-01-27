<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        

$emails = ['baudaisc@gmail.com', 'padseeyew@gmail.com'];

        if($form->isSubmitted() && $form->isValid()) {
for ($i = 0; $i < count($emails); $i++){

                $contactFormData = $form->getData();
                $message = (new Email())
                    ->from(new Address($contactFormData['email'], $contactFormData['nom']))

                    ->to($emails[$i])
                    ->subject('vous avez reçu un email')
                    ->text(
                        'Sender : ' . $contactFormData['nom'] . \PHP_EOL .
                            $contactFormData['message'],
                        'text/plain'
                    );
                $mailer->send($message);

                $this->addFlash('success', 'Votre message a été envoyé');

}
    

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'our_form' => $form->createView()
        ]);
    }
}
