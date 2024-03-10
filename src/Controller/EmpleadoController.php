<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\EmpleadoRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Empleado;
use App\Form\EmpleadoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/empleado', name: 'app_empleado_')]
class EmpleadoController extends AbstractController
{
    #[Route('/verEmpleados', name: 'verEmpleados')]
    public function verEmpleados(EmpleadoRepository $empleadoRepository): JsonResponse
    {
        //http://127.0.0.1:8000/empleado/verEmpleados

        $empleados = $empleadoRepository->consulta1();
        return new JsonResponse($empleados);


    }

    #[Route('/verServicioEmpleado/{idEmpleado}', name: 'verFacturasEmpleado')]
    public function verServiciosEmpleado(EmpleadoRepository $empleadoRepository, int $idEmpleado, EntityManagerInterface $gestorEntidades): JsonResponse
    {
        //http://127.0.0.1:8000/empleado/verServicioEmpleado/1

        $servicios = $empleadoRepository->consulta4($idEmpleado);
        return new JsonResponse($servicios);

    }

    #[Route('/insertarEmpleado', name: 'insertarServicio')]
    public function insertarEmpleado(EntityManagerInterface $gestorEntidades, Request $request): Response
    {
        //http://127.0.0.1:8000/empleado/insertarEmpleado
        $empleado = new Empleado();

        $formulario = $this->createForm(EmpleadoType::class, $empleado); //creamos el formulario a partir de JugadoresType y le pasamos el objeto jugador
        $formulario->handleRequest($request); //recogemos la información del formulario

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $gestorEntidades->persist($empleado);
            $gestorEntidades->flush();
            $this->addFlash('exito', 'Empleado insertado correctamente');//mensaje de éxito
            return $this->redirectToRoute("app_empleado_verEmpleados");
        }

        return $this->render('empleado/index.html.twig', [
            'formulario' => $formulario->createView(),
        ]);
    }
}
