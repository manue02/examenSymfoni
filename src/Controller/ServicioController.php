<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Servicio;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ServicioType;

#[Route('/servicio', name: 'app_servicio_')]
class ServicioController extends AbstractController
{
    #[Route('/verServicios', name: 'verServicios')]
    public function verServicios(EntityManagerInterface $gestorEntidades): JsonResponse
    {
        //http://127.0.0.1:8000/servicio/verServicios
        $resulServicios = $gestorEntidades->getRepository(Servicio::class)->findBy([]);

        $arrayServicios = [];

        foreach ($resulServicios as $servicio) {
            $arrayServicios[] = [
                'idServicio' => $servicio->getIdServicio(),
                'nombre' => $servicio->getNombre(),
                'idEmpleado' => $servicio->getIdEmpleado()->getId(),
                'precio' => $servicio->getPrecio(),
                'disponibilidad' => $servicio->isDisponibilidad()
            ];
        }

        return new JsonResponse($arrayServicios);
    }

    #[Route('/eliminarServicio/{idServicio}', name: 'eliminarServicio')]
    public function eliminarServicio(EntityManagerInterface $gestorEntidades, int $idServicio): Response
    {
        //http://127.0.0.1:8000/servicio/eliminarServicio/2
        $resulServicio = $gestorEntidades->getRepository(Servicio::class)->findOneBy(["idServicio" => $idServicio]);

        if ($resulServicio) {
            $gestorEntidades->remove($resulServicio);
            $gestorEntidades->flush();
        }
        return $this->redirectToRoute("app_servicio_verServicios");

    }

    #[Route('/editarServicio/{idServicio}/{nombre}/{precio}/{disponibilidad}', name: 'editarServicio')]
    public function editarServicio(EntityManagerInterface $gestorEntidades, int $idServicio, string $nombre, float $precio, bool $disponibilidad): Response
    {
        //http://127.0.0.1:8000/servicio/editarServicio/1/Reparacion/1000/1
        $resulServicio = $gestorEntidades->getRepository(Servicio::class)->findOneBy(["idServicio" => $idServicio]);

        if ($resulServicio) {
            $resulServicio->setNombre($nombre);
            $resulServicio->setPrecio($precio);
            $resulServicio->setDisponibilidad($disponibilidad);
            $gestorEntidades->persist($resulServicio);
            $gestorEntidades->flush();
        }
        return $this->redirectToRoute("app_servicio_verServicios");

    }

    #[Route('/insertarServicio', name: 'insertarServicio')]
    public function insertarServicio(EntityManagerInterface $gestorEntidades, Request $request): Response
    {
        //http://127.0.0.1:8000/servicio/insertarServicio
        $servicio = new Servicio();

        $formulario = $this->createForm(ServicioType::class, $servicio); //creamos el formulario a partir de JugadoresType y le pasamos el objeto jugador
        $formulario->handleRequest($request); //recogemos la información del formulario

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $gestorEntidades->persist($servicio);
            $gestorEntidades->flush();
            $this->addFlash('exito', 'Jugador insertado correctamente');//mensaje de éxito
            return $this->redirectToRoute("app_servicio_verServicios");
        }

        return $this->render('servicio/index.html.twig', [
            'formulario' => $formulario->createView(),
        ]);
    }

}
