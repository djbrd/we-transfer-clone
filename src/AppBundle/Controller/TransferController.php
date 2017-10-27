<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SharedFile;
use AppBundle\Form\SharedFileType;
use AppBundle\Service\FilestackManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;

class TransferController extends Controller
{
    /**
     * @Route("transfer/share", name="transfer_share_file")
     */
    public function shareAction(Request $request, FilestackManager $filestackManager, LoggerInterface $logger)
    {
        $sharedFile = new SharedFile();
        $form = $this->createForm(SharedFileType::class, $sharedFile);
        $form->handleRequest($request);

        // Check for form submission
        if ($form->isSubmitted() && $form->isValid()) {
            // Hash the password - could use a separate variable for plain password, which isn't persisted in the database
            $password = $sharedFile->getPassword();
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sharedFile->setPassword($password);

            /** @var UploadedFile $file */
            // File is uploaded from the client into handle variable -
            //  again another variable could be used which isn't persisted to the db
            $file = $sharedFile->getHandle();
            try {
                $handle = $filestackManager->upload($file);
                $sharedFile->setHandle($handle);

                // Store the mimetype which could actually be retrieved from Filestack, but is required for building response
                //  and enables easier encapsulation
                $sharedFile->setMimeType($file->getMimeType());

                // Persist the object
                $em = $this->getDoctrine()->getManager();
                $em->persist($sharedFile);
                $em->flush();

                return $this->render('transfer/uploaded.html.twig', array(
                    'handle' => $handle
                ));
            } catch (\Exception $e) {
                $logger->error($e->getMessage());
                $this->addFlash('error', 'Upload unsuccessful - please try again later, or contact the site administrator');
            }
        }

        // return the form
        return $this->render('transfer/share.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("transfer/retrieve/{handle}", name="transfer_retrieve_file")
     */
    public function retrieveAction(Request $request, $handle, FilestackManager $filestackManager, LoggerInterface $logger)
    {
        // Get the file from the database here instead of using a param converter so that invalid handle can be handled
        //  gracefully and easily (without using an event listener to listen for a 404 exception thrown by this action)
        $repository = $this->getDoctrine()->getRepository(SharedFile::class);
        $sharedFile = $repository->findOneByHandle($handle);
        if (is_null($sharedFile)) {
            return $this->render('transfer/nofile.html.twig', array(
                'files' => $repository->findAll()
            ));
        }

        // Create a form with one field for the password
        $form = $this->createFormBuilder()
            ->add('password', PasswordType::class)
            ->add('submit', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Check the given password and check it matches the one saved with the object
            $field = $form->get('password');
            if (!password_verify($field->getData(), $sharedFile->getPassword())) {
                $field->addError(new FormError('invalid password'));
            } else {
                // Serve file with content from Filestack
                try {
                    $fileContent = $filestackManager->getFileContent($sharedFile->getHandle());
                    $response = new Response($fileContent);
                    $response->headers->set('Content-Type', $sharedFile->getMimeType());
                    return $response;
                } catch (\Exception $e) {
                    $logger->error($e->getMessage());
                    $this->addFlash('error', 'Retrieval unsuccessful - please try again later, or contact the site administrator');
                }
            }
        }

        return $this->render('transfer/retrieve.html.twig', array(
            'form' => $form->createView()
        ));
    }
}