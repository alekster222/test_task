<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Document;
use App\Entity\Attachment;
use App\Form\DocumentType;


class DocumentController extends Controller
{
    /**
     * @Route("/", name="document_list")
     * @var Request $request
     * @return string
     */
    public function index(Request $request) {

		$repository = $this->getDoctrine()->getRepository(Document::class);
		$docs = $repository->findAll();

		return $this->render('list.html.twig', array(
            'docs' => $docs
        ));
    }

	 /**
     * @Route("/create", name="document_create")
     * @var Request $request
     * @return string
     */
    public function create(Request $request) {

		$doc = new Document();

		$form = $this->createForm(DocumentType::class, $doc);
        $form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$repository = $this->getDoctrine()->getRepository(Document::class);
			$fileRepository = $this->getDoctrine()->getRepository(Attachment::class);
			$doc = $repository->save($doc);

			$uploads = $this->container->getParameter('upload_directory');
			$dir = $_SESSION['document_upload'];

			$attach_path = $uploads.'tmp/'.$dir;

            $arr_files = scandir($attach_path);
            foreach($arr_files as $filename) {
                if (in_array($filename, ['.', '..'])) {
                    continue;
                }
                $fileinfo = pathinfo($attach_path.'/'.$filename);
                $system_name = md5(time().$filename). '.' .$fileinfo['extension'];
                rename($attach_path.'/'.$filename, $uploads.'/'.$system_name);

                $db_file = new Attachment();
                $db_file->setName($system_name);
                $db_file->setOrigName($filename);
				$db_file->setFilesize(filesize($uploads.'/'.$system_name));
				$db_file->setDocument($doc);
                $fileRepository->save($db_file);
            }

            $_SESSION['document_upload'] = "";

			return $this->redirectToRoute('document_list');
		}

		return $this->render('edit.html.twig', array(
            'form' => $form->createView(),
			'is_new' => true
        ));
    }

	/**
     * @Route("/update/{id}", name="document_update")
     * @var Request $request, Integer $id
     * @return string
     */
    public function update(Request $request, $id) {

		$repository = $this->getDoctrine()->getRepository(Document::class);
		$fileRepository = $this->getDoctrine()->getRepository(Attachment::class);

		$doc = $repository->find($id);
		$attachments = $fileRepository->getArrayList($doc);
		$form = $this->createForm(DocumentType::class, $doc);
        $form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$doc = $repository->save($doc);

			$uploads = $this->container->getParameter('upload_directory');
			$dir = $_SESSION['document_upload'];

			$attach_path = $uploads.'tmp/'.$dir;

            $arr_files = scandir($attach_path);
            foreach($arr_files as $filename) {
                if (in_array($filename, ['.', '..'])) {
                    continue;
                }
                $fileinfo = pathinfo($attach_path.'/'.$filename);
                $system_name = md5(time().$filename). '.' .$fileinfo['extension'];
                rename($attach_path.'/'.$filename, $uploads.'/'.$system_name);

                $db_file = new Attachment();
                $db_file->setName($system_name);
                $db_file->setOrigName($filename);
				$db_file->setFilesize(filesize($uploads.'/'.$system_name));
				$db_file->setDocument($doc);
                $fileRepository->save($db_file);
            }

            $_SESSION['document_upload'] = "";

			return $this->redirectToRoute('document_list');
		}
		
		return $this->render('edit.html.twig', array(
            'form' => $form->createView(),
			'files' => $attachments
        ));
    }

	/**
     * @Route("/remove/{id}", name="document_remove")
     * @var Request $request, Integer $id
     * @return string
     */
    public function remove(Request $request, $id) {

		$repository = $this->getDoctrine()->getRepository(Document::class);
		$doc = $repository->find($id);

		$repository->remove($doc);

		return $this->redirectToRoute('document_list');
    }

	/**
     * @Route("/view/{id}", name="document_view")
     * @var Request $request, Integer $id
     * @return string
     */
    public function view(Request $request, $id) {

		$repository = $this->getDoctrine()->getRepository(Document::class);
		$docs = $repository->findAll();

		return $this->render('view.html.twig', array(
            'docs' => $docs
        ));
    }






        // $chamberRepository = $this->getDoctrine()->getRepository(Chamber::class);
        // $chamber = is_object($chamberRepository->find(Chamber::MAIN_CHAMBER)) ? $chamberRepository->find(Chamber::MAIN_CHAMBER) : new Chamber();

        // $scheduleRepository = $this->getDoctrine()->getRepository(ChamberSchedule::class);
        // $fileRepository = $this->getDoctrine()->getRepository(File::class);

        // $form = $this->createForm(ChamberType::class, $chamber);
        // $form->handleRequest($request);

        // if ($form->isSubmitted()) {
            // if ($form->isValid()) {
                // if ($chamber->getId()) {
                    // $chamber->setUpdatedAt(new \DateTime());
                // }

                // $chamber = $chamberRepository->save($chamber);

                // $schedule = $request->get('shedule');
                // $schedule_arr = $scheduleRepository->findBy(['chamber' => $chamber]);
                // if (!empty($schedule_arr)) {
                    // foreach($schedule_arr as $day => $item) {
                        // $item->setWorkStart($schedule['begin_work'][$day] ? new \DateTime($schedule['begin_work'][$day]) : NULL);
                        // $item->setWorkEnd($schedule['end_work'][$day] ? new \DateTime($schedule['end_work'][$day]) : NULL);
                        // $item->setLunchStart($schedule['begin_lunch'][$day] ? new \DateTime($schedule['begin_lunch'][$day]) : NULL);
                        // $item->setLunchEnd($schedule['end_lunch'][$day] ? new \DateTime($schedule['end_lunch'][$day]) : NULL);
                        // $item->checkNoLunch();
                        // $scheduleRepository->save($item);
                    // }
                // } else {
                    // foreach($schedule['begin_work'] as $day => $value) {
                        // $item = new ChamberSchedule();
                        // $weekday = $day + 1;
                        // $item->setChamber($chamber);
                        // $item->setWeekday($weekday);
                        // $item->setWorkStart($schedule['begin_work'][$day] ? new \DateTime($schedule['begin_work'][$day]) : NULL);
                        // $item->setWorkEnd($schedule['end_work'][$day] ? new \DateTime($schedule['end_work'][$day]) : NULL);
                        // $item->setLunchStart($schedule['begin_lunch'][$day] ? new \DateTime($schedule['begin_lunch'][$day]) : NULL);
                        // $item->setLunchEnd($schedule['end_lunch'][$day] ? new \DateTime($schedule['end_lunch'][$day]) : NULL);
                        // $item->checkNoLunch();
                        // $scheduleRepository->save($item);
                    // }
                // }

                // /*files*/
                // if (!empty($_SESSION['chamber_upload'])) {
                    // $uploads = $this->container->getParameter('upload_directory');
                    // $dir = $_SESSION['document_upload'];
                    // $arr_files = scandir($uploads.$dir);
                    // foreach($arr_files as $filename) {
                        // if (in_array($filename, ['.', '..'])) {
                            // continue;
                        // }
                        // $fileinfo = pathinfo($uploads.$dir.'/'.$filename);
                        // $system_name = md5(time().$filename). '.' .$fileinfo['extension'];
                        // rename($uploads.$dir.'/'.$filename, $uploads.'/'.$system_name);

                        // $db_file = new File();
                        // $db_file->setEntity(get_class($chamber));
                        // $db_file->setRecordId(Chamber::MAIN_CHAMBER);
                        // $db_file->setSrc($system_name);
                        // $fileRepository->save($db_file);
                    // }

                    // $_SESSION['chamber_upload'] = "";
                   // unlink($uploads.$dir);
                // }
            // }
        // }

        // $schedule_arr = $scheduleRepository->findByChamber($chamber);

        // $files = $fileRepository->findByEntity($chamber);



    /**
     * @Route("/document/file-upload", name="document_file_upload", options={"expose"=true})
     * @var Request $request
     * @return JsonResponse
     */
    public function fileUpload(Request $request) {
        $uploads = $this->container->getParameter('upload_directory');
		if (empty($_SESSION['document_upload'])) {
			$_SESSION['document_upload'] = md5(time());
		}
		$dir = $_SESSION['document_upload'];

        $file = $request->files->get('file');

        $file->move(
            $uploads."tmp/".$dir,
            $file->getClientOriginalName()
        );

        return new JsonResponse(['success' => true], 200);
    }

    /**
     * @Route("/document/file-remove", name="document_file_remove", options={"expose"=true})
     * @var Request $request
     * @return JsonResponse
     */
    public function fileRemove(Request $request) {
        $filename = $request->get('name');
		$uploads = $this->container->getParameter('upload_directory');

        $repository = $this->getDoctrine()->getRepository(Attachment::class);

		$db_file = $fileRepository->findOneBy(['orig_name' => $filename]);

		if (is_object($db_file)) {
            $fileRepository->remove($db_file);
            unlink($uploads.$filename);
        } elseif (file_exists($uploads.$dir.'/'.$filename)) {
            unlink($uploads.'tmp/'.$filename);
		}

        return new JsonResponse(['success' => true], 200);
    }
}
