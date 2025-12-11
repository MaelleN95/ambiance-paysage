<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Form\ContactType;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $email = (new Email())
                ->from('contact@koji-dev.fr')
                ->to('maelle.nioche@gmail.com')
                ->subject('Nouveau message depuis le formulaire de contact')
                ->text(
                    "Société: {$data['company']}\n".
                    "Prénom: {$data['firstName']}\n".
                    "Nom: {$data['lastName']}\n".
                    "Adresse: {$data['address']}\n".
                    "Téléphone: {$data['phone']}\n".
                    "Email: {$data['email']}\n".
                    "Service: {$data['service']}\n".
                    "Message:\n{$data['message']}"
                );

            $mailer->send($email);

            $this->addFlash('success', 'Message envoyé.');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
