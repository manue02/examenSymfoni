<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\FacturaRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Factura;
use App\Form\FacturaType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Empleado;

#[Route('/factura', name: 'app_factura_')]
class FacturaController extends AbstractController
{
    #[Route('/verFacturas', name: 'verFacturas')]
    public function verTodasFacturas(FacturaRepository $facturaRepository): Response
    {
        //http://127.0.0.1:8000/factura/verFacturas
        $factura = $facturaRepository->consulta2();

        return $this->render('factura/index.html.twig', [
            'controller_name' => 'Controlador entrenadores',
            'filasFacturas' => $factura,
        ]);


    }

    #[Route('/verFacturasEmpleado/{idEmpleado}', name: 'verFacturasEmpleado')]
    public function verFacturasEmpleado(FacturaRepository $facturaRepository, int $idEmpleado, EntityManagerInterface $gestorEntidades): Response
    {
        //http://127.0.0.1:8000/factura/verFacturasEmpleado/1
        $factura = $facturaRepository->consulta3($idEmpleado);
        $empleado = $gestorEntidades->getRepository(Empleado::class)->findBy(['id' => $idEmpleado]);

        return $this->render('factura/index.html.twig', [
            'filasFacturasFiltrado' => $factura,
            'empleado' => $empleado,
        ]);
    }

    #[Route('/insertarFactura', name: 'insertarFactura')]
    public function insertarFactura(EntityManagerInterface $gestorEntidades, Request $request): Response
    {
        //http://127.0.0.1:8000/factura/insertarFactura
        $factura = new Factura();

        $formulario = $this->createForm(FacturaType::class, $factura); //creamos el formulario a partir de JugadoresType y le pasamos el objeto jugador
        $formulario->handleRequest($request); //recogemos la información del formulario

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $gestorEntidades->persist($factura);
            $gestorEntidades->flush();
            $this->addFlash('exito', 'Factura insertado correctamente');//mensaje de éxito
            return $this->redirectToRoute("app_factura_verFacturas");
        }

        return $this->render('factura/index.html.twig', [
            'formulario' => $formulario->createView(),
        ]);
    }
}
