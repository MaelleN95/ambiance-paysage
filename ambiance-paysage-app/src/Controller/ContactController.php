<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use App\Form\ContactType;
use App\DTO\ContactData;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class, new ContactData());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $serviceNames = [];
            if (!empty($data->service) && is_iterable($data->service)) {
                foreach ($data->service as $service) {
                    $serviceNames[] = $service->getName();
                }
            }

            $email = (new TemplatedEmail())
                ->from(new Address('no-reply@ambiancepaysage-paca.com', 'Ambiance Paysage'))
                ->to('ambiance.paysage13@gmail.com')
                ->subject('Nouveau message depuis le formulaire de contact')
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'data' => $data,
                    'serviceNames' => $serviceNames,
                ]);

            $mailer->send($email);

            $this->addFlash('success', 'Message envoyé.');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
