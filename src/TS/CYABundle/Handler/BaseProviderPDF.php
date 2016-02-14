<?php
/**
 * Created by @roberto-slopez.
 * User: tscompany
 * Date: 14/02/16
 * Time: 03:50 PM
 */

namespace TS\CYABundle\Handler;

use PHPExcel_Style_Border,
    PHPExcel_Cell,
    PHPExcel_Style_Fill,
    PHPExcel_IOFactory,
    TS\CYABundle\Entity\Usuario,
    Liuggio\ExcelBundle\Factory,
    Doctrine\Bundle\DoctrineBundle\Registry,
    Symfony\Component\HttpFoundation\StreamedResponse;

abstract class BaseProviderPDF
{
    const FORMAT_EXCEL = 'EXCEL';
    const FORMAT_PDF = 'PDF';
    const FORMAT_CSV = 'CSV';
    const FORMAT_TSV = 'TSV';

    /**
     * @var array
     */
    private $datos;

    /**
     * @var Usuario
     */
    protected $user;

    /**
     * @var \DateTime
     */
    protected $startDate;

    /**
     * @var \DateTime
     */
    protected $endDate;

    /**
     * @var \PHPExcel_Worksheet
     */
    protected $excelWorkSheet;

    /**
     * @var \PHPExcel
     */
    protected $objPHPExcel;

    /**
     * @var Factory
     */
    protected $objFactory;

    /**
     * @var string
     */
    protected $fileName;

    /**
     * BaseProviderPDF constructor.
     * @param Factory $objFactory
     * @param Registry $doctrine
     * @param Usuario $user
     */
    public function __construct(Factory $objFactory, Registry $doctrine, Usuario $user)
    {
        $this->objFactory = $objFactory;
        $this->objPHPExcel = $this->objFactory->createPHPExcelObject();

        $this->objPHPExcel->getDefaultStyle()
            ->getAlignment()
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $this->excelWorkSheet = $this->objPHPExcel->setActiveSheetIndex(0);
        $this->excelWorkSheet->setTitle('Reporte');
        $this->excelWorkSheet->setShowGridlines(false);

        $this->doctrine = $doctrine;

        $this->fileName = sprintf('Cotizacion %s', date('Y_m_d_H_i_s'));
    }

    public function setDatos(array $datos)
    {
        $this->datos = $datos;

        return $this;
    }
}