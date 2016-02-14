<?php

namespace TS\CYABundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TS\CYABundle\Entity\Exam;
use TS\CYABundle\Form\ExamType;

/**
 * Exam controller.
 *
 * @Route("/admin/exam")
 */
class ExamController extends Controller
{
    /**
     * Lists all Exam entities.
     *
     * @Route("/", name="admin_exam_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $exams = $em->getRepository('TSCYABundle:Exam')->findAll();

        return $this->render('exam/index.html.twig', array(
            'exams' => $exams,
        ));
    }

    /**
     * Creates a new Exam entity.
     *
     * @Route("/new", name="admin_exam_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $exam = new Exam();
        $form = $this->createForm('TS\CYABundle\Form\ExamType', $exam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($exam);
            $em->flush();

            return $this->redirectToRoute('admin_exam_show', array('id' => $exam->getId()));
        }

        return $this->render('exam/new.html.twig', array(
            'exam' => $exam,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Exam entity.
     *
     * @Route("/{id}", name="admin_exam_show")
     * @Method("GET")
     */
    public function showAction(Exam $exam)
    {
        $deleteForm = $this->createDeleteForm($exam);

        return $this->render('exam/show.html.twig', array(
            'exam' => $exam,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Exam entity.
     *
     * @Route("/{id}/edit", name="admin_exam_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Exam $exam)
    {
        $deleteForm = $this->createDeleteForm($exam);
        $editForm = $this->createForm('TS\CYABundle\Form\ExamType', $exam);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($exam);
            $em->flush();

            return $this->redirectToRoute('admin_exam_edit', array('id' => $exam->getId()));
        }

        return $this->render('exam/edit.html.twig', array(
            'exam' => $exam,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Exam entity.
     *
     * @Route("/{id}", name="admin_exam_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Exam $exam)
    {
        $form = $this->createDeleteForm($exam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($exam);
            $em->flush();
        }

        return $this->redirectToRoute('admin_exam_index');
    }

    /**
     * Creates a form to delete a Exam entity.
     *
     * @param Exam $exam The Exam entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Exam $exam)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_exam_delete', array('id' => $exam->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
