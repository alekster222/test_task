<?php

namespace App\Repository;

use App\Entity\Attachment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Attachment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Attachment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Attachment[]    findAll()
 * @method Attachment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttachmentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Attachment::class);
    }

	public function save($attachment) {
		$this->_em->persist($attachment);
		$this->_em->flush();

		return $attachment;
	}

	public function remove($attachment) {
		$this->_em->remove($attachment);
		$this->_em->flush();
	}

	public function getArrayList($doc) {
		return $this->createQueryBuilder('a')
            ->where('a.document = :doc')
            ->setParameter('doc', $doc->getId())
            ->getQuery()
            ->getArrayResult()
        ;
	}

    function isImage($filename) {
        $is = @getimagesize($filename);

        if (!$is)  {
            return false;
        } elseif (!in_array($is[2], array(1,2,3)) ) {
            return false;
        }
        else {
            return true;
        }
    }
}
