<?php

namespace Hotel\ClienteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Hotel\ClienteBundle\Form\ReservarType;
use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ClienteBundle:Default:index.html.twig', array('name' => $name));
    }
    public function portadaAction()
    {
    	return $this->render('ClienteBundle:Default:portada.html.twig');
    }
    public function habiprecAction()
    {
    	return $this->render('ClienteBundle:Default:habiprec.html.twig');
    }
    public function reservarAction()
    {
        $peticion = $this->getRequest();        
        $formulario = $this->createForm(new ReservarType());
        $formulario->handleRequest($peticion);

        if($formulario->isValid())
        {
            $nombre = $formulario->get('nombre')->getData();
            $email = $formulario->get('email')->getData();
            $telefono = $formulario->get('telefono')->getData();
            $habitacion = $formulario->get('habitacion')->getData();

            //$mailer = $this->container->get('mailer');
            $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com',465,'ssl')
                    ->setUsername('davidquispeg@gmail.com')
                    ->setPassword('linustorvalds');
            
            $message = \Swift_Message::newInstance()
                    ->setSubject('Reserva')
                    ->setFrom('davidquispeg@gmail.com')
                    ->setTo('davidquispeg@gmail.com')
                    ->setBody('body')
                    ->addPart('
                        <html><body><h3>Solicitud de Reserva</h3>
                        <table>
                        <thead>
                            <th>Nombre y Apellidos</th>
                            <th>Correo</th>
                            <th>Telefono</th>
                            <th>Habitacion</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>'.$nombre.'</td>
                                <td>'.$email.'</td>
                                <td>'.$telefono.'</td>
                                <td>'.$habitacion.'</td>
                            </tr>
                        </tbody>
                        </table>','text/html');

            $mailer = \Swift_Mailer::newInstance($transport);
            $mailer->send($message);
            $this->get('session')->getFlashBag()->add('aviso','Su solicitud se envio con exito.');

            return $this->redirect($this->generateUrl('cliente_reservas'));
        }
        return $this->render('ClienteBundle:Default:reserva.html.twig',array('formu'=>$formulario->createView()));
    }

    public function ubicarAction()
    {
        return $this->render('ClienteBundle:Default:ubicacion.html.twig');
    }
}
