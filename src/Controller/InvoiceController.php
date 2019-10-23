<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Entity\InvoiceDetails;
use Doctrine\ORM\Query;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;


class InvoiceController extends AbstractController
{
    /**
     * @Route("/invoice/add", name="add")
     */
    public function add(Request $request)
    {
        $invoice = new Invoice();
        $invoice->setInvoiceDate(new \DateTime('now'));

        $form = $this->createFormBuilder($invoice)
            ->add('invoice_number', IntegerType::class)
            ->add('customer_id', IntegerType::class)
            ->add('save', SubmitType::class, ['label' => 'Add new invoice'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($invoice);
            $em->flush();
            $this->addFlash('success', 'New invoice added');

            return $this->redirectToRoute('add_details', ['id' => $invoice->getId()]);
        }

        return $this->render('invoice/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/invoice/add/{id}", name="add_details")
     */
    public function addDetails(Request $request)
    {

        $invoice_details = new InvoiceDetails();
        $id = $request->attributes->get('id');
        $em = $this->getDoctrine()->getManager();
        $iv = $em->getRepository(Invoice::class)->find($id);
        $invoice = $invoice_details->setInvoiceId($iv);

        $invoice_values = $em->getRepository(InvoiceDetails::class)
            ->createQueryBuilder('i')
            ->where('i.invoice_id = '.$id)
            ->getQuery();

        $invoice_data = (!empty($invoice_values->getResult(Query::HYDRATE_ARRAY))) ? $invoice_values->getResult(Query::HYDRATE_ARRAY)[0] : null;

        $form = $this->createFormBuilder($invoice)
            ->add('invoice_description', TextType::class,
                ['data' => $data = ($invoice_data['invoice_description']!=null) ? $invoice_data['invoice_description'] : ''])
            ->add('invoice_quantity', IntegerType::class,
                ['data' => $data = ($invoice_data['invoice_quantity']!=null) ? $invoice_data['invoice_quantity'] : 0])
            ->add('invoice_amount', MoneyType::class,
                ['data' => $data = ($invoice_data['invoice_amount']!=null) ? $invoice_data['invoice_amount'] : 0])
            ->add('invoice_vat', MoneyType::class,
                ['data' => $data = ($invoice_data['invoice_vat']!=null) ? $invoice_data['invoice_vat'] : 0])
            ->add('invoice_total', MoneyType::class,
                ['data' => $data = ($invoice_data['invoice_total']!=null) ? $invoice_data['invoice_total'] : 0])
            ->add('save', SubmitType::class, ['label' => 'Add Details'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $invoice_ob = $em->getRepository(InvoiceDetails::class)->findBy(['invoice_id'=>$id]);

            if(!empty($invoice_ob)){
                $invoice_ob = $invoice_ob[0];
                $invoice_ob->setInvoiceDescription($data->getInvoiceDescription());
                $invoice_ob->setInvoiceQuantity($data->getInvoiceQuantity());
                $invoice_ob->setInvoiceAmount($data->getInvoiceAmount());
                $invoice_ob->setInvoiceVat($data->getInvoiceVat());
                $invoice_ob->setInvoiceTotal($data->getInvoiceTotal());
                $em->merge($invoice_ob);
                $em->flush();
            } else {
                $em->persist($invoice);
                $em->flush();
            }

            $this->addFlash('success', 'Data saved');

            return $this->render('invoice/details.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        return $this->render('invoice/details.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/invoice", name="index")
     */
    public function index()
    {
        $query = $this->getDoctrine()
            ->getRepository(Invoice::class)
            ->createQueryBuilder('c')
            ->getQuery();
        $result = $query->getResult(Query::HYDRATE_ARRAY);

        return $this->render('invoice/list.html.twig', [
            'invoices' => $result,
        ]);
    }

}