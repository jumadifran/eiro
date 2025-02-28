<?php

class model_rw_inspection_excel extends CI_Model {

    private $rw_inspection = null;
    private $rw_image_category = null;
    private $phpexcel;
    private $page;
    private $sheet;
    private $default_margin;
    private $border = array();
    private $margins;

    public function __construct() {
        parent::__construct();

        // Load PHPExcel dari third_party directory
        $this->load->library('PHPExcel');
        $this->load->model('model_rw_inspection');

        $this->phpexcel = new PHPExcel(); // Inisialisasi PHPExcel object

        // Border styles untuk outline
        $this->border['outline'] = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );
    }

    public function initialize($rw_inspection, $rw_image_category) {
        // Simpan data rw_inspection yang diterima
        $this->rw_inspection = $rw_inspection;
        $this->rw_image_category = $rw_image_category;

        // Inisialisasi margin default
        $this->default_margin = 0.5 / 2.54;

        // Setup properti lembar Excel
        $this->phpexcel->getProperties()
                ->setCreator("Quality Assurance Team")
                ->setTitle("Test Report")
                ->setSubject("Hardness Test Report");

        // Setup margins
        $this->sheet = $this->phpexcel->getActiveSheet();

        // Mengatur lebar kolom
        $this->sheet->getColumnDimension('B')->setWidth(30);
        $this->sheet->getColumnDimension('C')->setWidth(30);
       
        $this->sheet->getColumnDimension('E')->setWidth(30);
        $this->sheet->getColumnDimension('F')->setWidth(30);

        // Set default font ke Times New Roman, ukuran 14
        $this->sheet->getDefaultStyle()->getFont()->setName('Times New Roman')->setSize(14);

        //rw Inspection
        $this->sheet->setCellValue('B1', "RW Inspection")
        ->mergeCells('B1:F3'); 
    
    // Mengatur font agar bold dan lebih besar
    $this->sheet->getStyle('B1:F3')->getFont()->setBold(true)->setSize(14);
    
    // Mengatur teks agar rata tengah (horizontal & vertical)
    $this->sheet->getStyle('B1:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->sheet->getStyle('B1:F3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    
    // Menambahkan border ke seluruh area B1:F3
    $borderStyle = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => 'FF000000'),
            ),
        ),
    );
    $this->sheet->getStyle('B1:F3')->applyFromArray($borderStyle);
    $this->sheet->getStyle('B1:F3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $this->sheet->getStyle('B1:F3')->getFill()->getStartColor()->setARGB('FFFFFF00'); // Kuning

    //End FInal Area
    $this->sheet->setCellValue('B4', "Assembly Area")
        ->mergeCells('B4:F5'); 
    
    // Mengatur font agar bold dan lebih besar
    $this->sheet->getStyle('B4:F5')->getFont()->setBold(true)->setSize(14);
    
    // Mengatur teks agar rata tengah (horizontal & vertical)
    $this->sheet->getStyle('B4:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->sheet->getStyle('B4:F5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    
    // Menambahkan border ke seluruh area B1:F3
    $borderStyle = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => 'FF000000'),
            ),
        ),
    );
    $this->sheet->getStyle('B4:F5')->applyFromArray($borderStyle);
    $this->sheet->getStyle('B4:F5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $this->sheet->getStyle('B4:F5')->getFill()->getStartColor()->setARGB('FFFFCC00'); // Kuning


        // **Memindahkan teks "Quality Assurance Department" ke B2:B5**
        $this->sheet->setCellValue('B6', "PT EBAKO NUSANTARA\nJl. Terboyo Industri Barat Dalam II Blok N/3C\nKawasan Industri Terboyo Park - Semarang\nJawa Tengah - Indonesia")
        ->mergeCells('B6:C9');
    
    // Mengaktifkan fitur wrap text agar teks tersusun ke bawah
    $this->sheet->getStyle('B6')->getAlignment()->setWrapText(true);
    
    // Opsional: Menyesuaikan tinggi baris agar teks terlihat rapi
    $this->sheet->getRowDimension(6)->setRowHeight(-1);
    
    $this->sheet->getStyle('B6')->getFont()->setBold(true);
    $this->sheet->getStyle('B6')->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $this->sheet->getStyle('B6:C9')->applyFromArray($borderStyle);
        

        // **Menambahkan logo di F2:F5**
        $imagePath = FCPATH . 'files/logo.png';
        if (file_exists($imagePath)) {
            $logo = new PHPExcel_Worksheet_Drawing();
            $logo->setPath($imagePath);
            $this->sheet->mergeCells('E6:F9'); // Memindahkan logo ke F2:F5
            $logo->setCoordinates('E6'); // Posisi logo di F2
            $logo->setHeight(80); // Sesuaikan ukuran gambar
            $logo->setOffsetX(10); // Offset horizontal
            $logo->setOffsetY(10); // Offset vertikal
            $logo->setWorksheet($this->sheet);
        }
        $this->sheet->getStyle('E6:F9')->applyFromArray($borderStyle);
        // **Apply border untuk seluruh header**
        $this->sheet->getStyle('B6:F9')->applyFromArray($this->border['outline']);


         // Header Kiri (Customer, Customer Code, Ebako Code)
         $this->sheet->setCellValue('B10', "Customer");
         $this->sheet->setCellValue('C10',$this->rw_inspection->client_name);
         $this->sheet->setCellValue('B11', "Customer Code");
         $this->sheet->setCellValue('C11',$this->rw_inspection->customer_code);
         $this->sheet->setCellValue('B12', "Ebako Code");
         $this->sheet->setCellValue('C12',$this->rw_inspection->ebako_code);
 
         // Header Kanan (Po Client No, RW Inspection Date, Inspector)
         $this->sheet->setCellValue('E10', "Po Client No");
         $this->sheet->setCellValue('F10',$this->rw_inspection->po_client_no);
         $this->sheet->setCellValue('E11', "RW Inspection Date");
         $this->sheet->setCellValue('F11',$this->rw_inspection->rw_inspection_date);
         $this->sheet->setCellValue('E12', "Inspector");
         $this->sheet->setCellValue('F12',$this->rw_inspection->user_added);

         // Style border untuk setiap sel
            $borderStyle = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => 'FF000000'),
                    ),
                ),
            );

            // Menerapkan border ke seluruh sel yang digunakan
            $this->sheet->getStyle('B10:C12')->applyFromArray($borderStyle);
            $this->sheet->getStyle('E10:F12')->applyFromArray($borderStyle);


            //rw inspection dokumentation
            $this->sheet->setCellValue('B14', "RW Image Category")
            ->mergeCells('B14:F15'); 

            // Mengatur font agar bold dan lebih besar
            $this->sheet->getStyle('B14:F15')->getFont()->setBold(true)->setSize(14);

            // Mengatur teks agar rata tengah (horizontal & vertical)
            $this->sheet->getStyle('B14:F15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->sheet->getStyle('B14:F15')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->sheet->getStyle('B14:F15')->applyFromArray($borderStyle);

            //Image
            $this->sheet->setCellValue('B16',"Image");
            $this->sheet->getStyle('B16')->applyFromArray($borderStyle);
            // Image Category
            $this->sheet->setCellValue('C16', "Image Category");
            
            $this->sheet->getStyle('C16:D16')->applyFromArray($borderStyle);

           // Description
            $this->sheet->setCellValue('E16',"Description");
            $this->sheet->getStyle('E16')->applyFromArray($borderStyle);
            $this->sheet->mergeCells('E16:F16');
            //Submtied
            // $this->sheet->setCellValue('F16',"Submited");
            // $this->sheet->getStyle('F16')->applyFromArray($borderStyle);
            

            //isi
            $row = 17; // Mulai dari baris 17

            foreach ($this->rw_image_category as $category) {
                // View Position
                $this->sheet->setCellValue("C$row", $category->view_position);
                $this->sheet->getStyle("C$row")->applyFromArray($borderStyle);
                $this->sheet->getStyle("C$row")->getAlignment()->setWrapText(true);
                
                // Description
                $this->sheet->setCellValue("E$row", $category->description);
                $this->sheet->getStyle("E$row")->getAlignment()->setWrapText(true);
                $this->sheet->getStyle("E$row")->applyFromArray($borderStyle);

                $this->sheet->mergeCells("E$row:F$row");
                $this->sheet->getStyle("E$row:F$row")->applyFromArray($borderStyle);
                
                // Submitted (Boolean ke "True"/"False")
                // $submittedValue = $this->rw_inspection->submited ? "True" : "False";
                // $this->sheet->setCellValue("F$row", $submittedValue);
                // $this->sheet->getStyle("F$row")->getAlignment()->setWrapText(true);
                // $this->sheet->getStyle("F$row")->applyFromArray($borderStyle);

                // Gambar (Kolom B)
                
               
                 // Menentukan ukuran standar gambar
                $defaultWidth = 100;  // Lebar gambar (px)
                $defaultHeight = 100; // Tinggi gambar (px)
                $defaultRowHeight = 80; // Tinggi baris agar sesuai dengan gambar
                $column = 'B'; // Kolom tempat gambar dimasukkan

                if (trim($category->filename) != "") {
                    $imagePath = FCPATH . 'files/rw_inspection/' . $this->rw_inspection->id . '/' . $category->filename;

                    if (file_exists($imagePath)) {
                        $objDrawing = new PHPExcel_Worksheet_Drawing();
                        $objDrawing->setPath($imagePath);
                        
                        // Set ukuran gambar seragam
                        $objDrawing->setWidth($defaultWidth);
                        $objDrawing->setHeight($defaultHeight);

                        // Atur posisi dan offset agar tidak tumpang tindih
                        $objDrawing->setCoordinates($column . $row);
                        $objDrawing->setOffsetX(5);
                        $objDrawing->setOffsetY(5);

                        // Tambahkan gambar ke worksheet
                        $objDrawing->setWorksheet($this->sheet);

                        // Set lebar kolom agar gambar tidak terpotong
                        $this->sheet->getColumnDimension($column)->setWidth(20); 

                        // Set tinggi baris agar sesuai dengan ukuran gambar
                        $this->sheet->getRowDimension($row)->setRowHeight($defaultRowHeight);
                        
                    } else {
                        $this->sheet->setCellValue($column . $row, 'No Image');
                        $this->sheet->getStyle($column . $row)->getFont()->setItalic(true);
                    }
                } else {
                    $this->sheet->setCellValue($column . $row, 'No Image');
                    $this->sheet->getStyle($column . $row)->getFont()->setItalic(true);
                }

                // Pindah ke baris berikutnya
                $row++;

                
            }
                
            
            



        
    }

    public function download($filename = 'Rw_inspection.xlsx') {
        // Bersihkan output buffer
        ob_clean();

        // Set headers untuk file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        // Output file Excel
        $writer = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel2007');
        $writer->save('php://output');
    }
}
