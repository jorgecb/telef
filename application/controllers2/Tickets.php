<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index() {
        if ($this->session->userdata('logged_id')) {
            $this->load->helper('form');
            $sesion = $this->session->userdata('logged_id');
            $data['main_content'] = 'tickets/tickets_generador';
            $data['titutlo'] = 'Teleferico Taxco :: Generador de Tickets';
            $data['subtitulo'] = 'Generador de Tickets';
            $data['menu'] = 'generador';
            $data['usuario'] = $sesion['usuario'];
            $data['nombre'] = $sesion['nombre'];
            $data['rol'] = $sesion['rol'];
            $this->load->view('includes/template', $data);
        } else
            redirect('login', 'refresh');
    }

    public function venta() {
        if ($this->session->userdata('logged_id')) {
            $this->load->helper('form');
            $sesion = $this->session->userdata('logged_id');
            $data['main_content'] = 'tickets/venta';
            $data['titutlo'] = 'Teleferico Taxco :: Generador de Tickets';
            $data['subtitulo'] = 'Venta de Tickets';
            $data['menu'] = 'venta';
            $data['usuario'] = $sesion['usuario'];
            $data['nombre'] = $sesion['nombre'];
            $data['rol'] = $sesion['rol'];
            $this->load->view('includes/template', $data);
        } else
            redirect('login', 'refresh');
    }

    public function validar() {
        if ($this->session->userdata('logged_id')) {
            $this->load->helper('form');
            $sesion = $this->session->userdata('logged_id');
            $data['main_content'] = 'tickets/validar';
            $data['titutlo'] = 'Teleferico Taxco :: Generador de Tickets';
            $data['subtitulo'] = 'Validar Entrada';
            $data['menu'] = 'validar';
            $data['usuario'] = $sesion['usuario'];
            $data['nombre'] = $sesion['nombre'];
            $data['rol'] = $sesion['rol'];
            $this->load->view('includes/template', $data);
        } else
            redirect('login', 'refresh');
    }

    public function reimprimir() {
        if ($this->session->userdata('logged_id')) {
            $this->load->helper('form');
            $sesion = $this->session->userdata('logged_id');
                     
            $ultimaventa=$this->venta->last( $sesion['usuario']);         
                     
            $data['main_content'] = 'tickets/reimprimir';
            $data['titutlo'] = 'Teleferico Taxco :: reimpresion de Tickets';
            $data['subtitulo'] = 'Reimprimir Entrada';
            $data['menu'] = 'reimprimir';
            $data['usuario'] = $sesion['usuario'];
            $data['nombre'] = $sesion['nombre'];
            $data['rol'] = $sesion['rol'];
            $data['last'] = $ultimaventa->codes;
            $this->load->view('includes/template', $data);
        } else
            redirect('login', 'refresh');
    }

    public function tipotickets() {
        if ($this->session->userdata('logged_id')) {
            $resp = array(
                'result' => true,
                'tipos' => '',
            );
            $result = $this->preciotickets->select();
            $i = 64;
            foreach ($result->result()as $row) {
                $i++;
                $resp['tipos'].= '<option value="' . $row->id_preciotickets . '" >' . chr($i) . '-' . $row->tipo . '- $' . $row->precio . '</option>';
            }
            echo json_encode($resp);
        } else
            redirect('login', 'refresh');
    }
public function findmotivo() {
        if ($this->session->userdata('logged_id')) {
            $result = $this->detalleventa->findunic($this->input->get('term'));
            $resp =  array();
           
            
            foreach ($result->result()as $row) {
                             $resp[]= $row->motivodescuento  ;              
            } 
            echo json_encode($resp);
          
        } else
            redirect('login', 'refresh');
    }
    public function printertiket() {
        if ($this->session->userdata('logged_id')) {
            $this->load->library('Tiket_print');
            $this->load->library('barcode');

            $pdf = new Tiket_print('P', 'mm');

            $fontSize = 12;
            $pdf->SetFont('Courier', '', $fontSize);
            $pdf->SetTextColor(0, 0, 0);

            $sesion = $this->session->userdata('logged_id');
            $usuario = $sesion['usuario'];
            $pos = 0;
            
            
            
            
            $codigos =is_array($this->input->post('codes'))? $this->input->post('codes'):explode(',', $this->input->post('codes'));
            
            
            
            
            for ($i = 0; $i < count($codigos); $i++) {
                $code = $codigos[$i];
                //if($i%10==0 and $i>1)
                $format = array(80, 140);
                $pdf->AddPage('P', $format);
                // -------------------------------------------------- //
                //                  PROPERTIES
                // -------------------------------------------------- //
                //var_dump($code);
                $detalleventa=$this->detalleventa->codeinfo($code);
                $detalleticket = $this->detalletickets->datos($code);
                $ticketgenerado = $this->ticketsgenerados->datos($detalleticket->id_ticketsgenerados);
                $precio_ticket = $this->preciotickets->datos($ticketgenerado->id_preciotickets);
                //var_dump($detalleventa);
$pdf->Image('img/logo.png',10,10,-300);				
                $pdf->SetY(20);
				
			//	$pdf->Image('img/logo.png',10,10,-300);
				
				
                $pdf->Cell(10, 10, $detalleventa->folio_venta, 0, 0, 'L');
                $pdf->SetX(70);
                $pdf->Cell(10, 10, date("d/m/Y h:i:s"), 0, 1, 'R');
                $marge = 0;   // between barcode and hri in pixel
                $x = 40;
                $y = 50;  // barcode center
                $height = 20;   // barcode heighprintticketverit in 1D ; module size in 2D
                $width = 0.4375;    // barcode height in 1D ; not use in 2D
                $angle = 0;   // rotation in degrees
                //$code     = '1'; // barcode, of course ;)
                $type = 'ean13';
                $black = '000000'; // color in hexa
                // -------------------------------------------------- //
                //                      HRI
                // -------------------------------------------------- //
                $alto = 155;
                $pdf->SetFont('Helvetica', 'B', $fontSize);
                $pdf->Cell(60, 6, 'Teleferico Taxco', 0, 1, 'C');
                $pdf->SetFont('Courier', '', $fontSize);
                //$pdf -> SetX(10);		
                $pdf->Cell(60, 4, utf8_decode($precio_ticket->tipo), 0, 0, 'C');
                //$pdf -> SetX(50);
                //$pdf -> SetY(30);
                //$pdf -> SetX(50);
                //$pdf -> SetY(135);
                //$pdf -> SetX(80);
                $data = Barcode::fpdf($pdf, $black, $x, $y, $angle, $type, array('code' => $code), $width, $height);
                $pdf->SetY(63);
                $pdf->Cell(60, 4, $data['hri'], 0, 1, 'C');
                $personas = (($detalleticket->redondo == 1) ? ($detalleticket->open / 2) : $detalleticket->open);
                $pdf->SetFont('Helvetica', 'B', $fontSize);
                $pdf->Cell(60, 6, $personas . " persona" . (($personas > 1) ? "s" : ""), 0, 1, 'C');
                $pdf->SetFont('Courier', '', $fontSize);
           
                  if( $precio_ticket->horas_vigencia==1){
			
                            $pdf->SetFont('Helvetica', 'B', $fontSize);
                            $pdf->MultiCell(65, 5, "Ticket valido durante " . $precio_ticket->horas_vigencia . " hora.", 0, 'J');
			    $pdf->SetFont('Courier', '', $fontSize);

                   }
                $pdf->MultiCell(57, 3, "Este boleto solo puede ser utilizado el mismo dia de compra en el horario de funcionamiento del teleferico.", 0, 'J');
             $pdf->Cell(60, 4,''.$detalleventa->motivodescuento, 0, 1, 'C'); 
              $pdf->SetFont('Helvetica', 'B', $fontSize);
               $pdf->Cell(60, 4,'Precio por persona. $'.$precio_ticket->precio, 0, 1, 'R');   
            }
            $pdf->AutoPrint();
            $pdf->Output();
        } else
            redirect('login', 'refresh');
    }

    public function generador() {
        if ($this->session->userdata('logged_id')) {
            $this->load->library('fpdf');
            $this->load->library('barcode');

            $pdf = new FPDF('P', 'pt');
            $pdf->AddPage('P', 'Letter');
            $fontSize = 10;
            $pdf->SetFont('Arial', 'B', $fontSize);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetAutoPageBreak(true, 0);
            $sesion = $this->session->userdata('logged_id');
            $usuario = $sesion['usuario'];

            $ticketgenerado = array(
                'id_preciotickets' => $this->input->post('tipoticket'),
                'cantidad' => $this->input->post('cantidad'),
                'usuario_crea' => $usuario,
                'fecha_creacion' => date('Y-m-d H:i:s'),
            );
            $id_ticketsgenerados = $this->ticketsgenerados->insert($ticketgenerado);

            $pos = 0;
            $precio_ticket = $this->preciotickets->datos($this->input->post('tipoticket'));
            for ($i = 0; $i < $this->input->post('cantidad'); $i++) {
                if ($i % 10 == 0 and $i > 1)
                    $pdf->AddPage('P', 'Letter');

                // -------------------------------------------------- //
                //                  PROPERTIES
                // -------------------------------------------------- //


                $marge = 10;   // between barcode and hri in pixel
                if ((($i + 1) % 2) != 0)
                    $x = 125;
                else
                    $x = 420;  // barcode center
                if ($pos == 0)
                    $y = 80;  // barcode center
                else {
                    if ((($i + 1) % 2) != 0)
                        $y += 155;
                }

                $height = 50;   // barcode height in 1D ; module size in 2D
                $width = 2;    // barcode height in 1D ; not use in 2D
                $angle = 0;   // rotation in degrees
                //$code     = '1'; // barcode, of course ;)
                $type = 'ean13';
                $black = '000000'; // color in hexa
                // -------------------------------------------------- //
                //            ALLOCATE FPDF RESSOURCE
                // -------------------------------------------------- //
                // -------------------------------------------------- //
                //                      BARCODE
                // -------------------------------------------------- //

                $existe = true;
                $code = '';
                while ($existe) {
                    for ($j = 0; $j < 12; $j++) {
                        $min = ($j == 0) ? 1 : 0;
                        $code .= mt_rand($min, 9);
                    }
                    $data = Barcode::fpdf($pdf, $black, $x, $y, $angle, $type, array('code' => $code), $width, $height);
                    $existe = $this->detalletickets->existecb($data['hri']);
                }
                $detalleticket = array(
                    'codigo_barras' => $data['hri'],
                    'fecha_vigencia' => $this->input->post('tipoticket') == 1 ? date('Y-m-d H:i:s', strtotime('+1 day')) : date('Y-m-d H:i:s', strtotime('+1 week')), // Compara si los tickets generados son de tipo empleado donde le sume un dia y si no una semana
                    'id_estatus' => 1,
                    'id_ticketsgenerados' => $id_ticketsgenerados,
                    'contador' => $this->input->post('tipoticket') < 5 ? 1 : 2,
                );
                $result = $this->detalletickets->insert($detalleticket);
                // -------------------------------------------------- //
                //                      HRI
                // -------------------------------------------------- //
                $alto = 155;
                $pdf->SetY(10 + ($pos * $alto));
                if ((($i + 1) % 2) != 0)
                    $pdf->SetX(10);
                else
                    $pdf->SetX(300);
                $pdf->Cell(235, 150, '', 1, 1, 'L');
                $pdf->SetY(15 + ($pos * $alto));
                if ((($i + 1) % 2) != 0)
                    $pdf->SetX(15);
                else
                    $pdf->SetX(305);
                $pdf->Cell(20, 10, utf8_decode($precio_ticket->tipo), 0, 0, 'L');
                if ((($i + 1) % 2) != 0)
                    $pdf->SetX(185);
                else
                    $pdf->SetX(475);
                $pdf->Cell(20, 10, 'Vigencia', 0, 1, 'L');
                $pdf->SetY(30 + ($pos * $alto));
                if ((($i + 1) % 2) != 0)
                    $pdf->SetX(180);
                else
                    $pdf->SetX(470);
                $pdf->Cell(20, 10, $precio_ticket->horas_vigencia . ' hora(s)', 0, 0, 'L');
                $pdf->SetY(135 + ($pos * $alto));
                if ((($i + 1) % 2) != 0)
                    $pdf->SetX(80);
                else
                    $pdf->SetX(380);
                $pdf->Cell(20, 10, 'Teleferico Taxco', 0, 0, 'L');
                $len = $pdf->GetStringWidth($data['hri']);
                Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge, $angle, $xt, $yt);
                $pdf->TextWithRotation($x + $xt, $y + $yt, $data['hri'], $angle);

                if ((($i + 1) % 2) == 0)
                    $pos++;
                if ($pos == 5)
                    $pos = 0;
            }
            $pdf->Output();
        } else
            redirect('login', 'refresh');
    }

    public function verificacb() {
        if ($this->session->userdata('logged_id')) {
            $result = $this->detalletickets->verificacb($this->input->post('codigobarras'));
            $resp = array(
                'result' => false,
                'mensaje' => '',
                'tipo' => '',
                'descuento' => '',
                'subtotal' => '',
            );
            if ($result->num_rows() > 0) {
                $row = $result->row();
                if ($row->id_estatus == 1) {
                    $resp['result'] = true;
                    $ticketgenerado = $this->ticketsgenerados->datos($row->id_ticketsgenerados);
                    $precioticket = $this->preciotickets->datos($ticketgenerado->id_preciotickets);
                    $resp ['tipo'] = $precioticket->tipo;
                    $resp ['descuento'] = ($ticketgenerado->descuento * 100) . '%';
                    $resp ['subtotal'] = $precioticket->precio * (1 - $ticketgenerado->descuento);
                    echo json_encode($resp);
                } else {
                    $estatus = $this->catestatus->datos($row->id_estatus);
                    $resp['mensaje'] = 'El ticket se encuentra en estado: ' . $estatus->descripcion;
                    echo json_encode($resp);
                }
            } else {
                $resp['mensaje'] = 'Este ticket no existe';
                echo json_encode($resp);
            }
        } else
            redirect('login', 'refresh');
    }

    public function busca() {
        if ($this->session->userdata('logged_id')) {
            $result = $this->detalleventa->find($this->input->post('token'));
            $resp = array(          
          'codes' => ''
          );
            
            foreach ($result->result()as $row) {
                             $resp['codes'].= '<li onclick="envia(this.innerHTML)"> '.$row->codigo_barras .'-'.$row->motivodescuento;                
            } 
            echo json_encode($resp);
          
        } else
            redirect('login', 'refresh');
    }
    public function validacb() {
        /* $result = $this->detalletickets->verificacb($this->input->post('codigobarras'));
          $resp = array(
          'result' => false,
          'mensaje' => ''
          );
          if ($result->num_rows()>0){
          $row = $result->row();
          if ($row->id_estatus==2)
          {
          if (date('Y-m-d')<=$row->fecha_vigencia){
          $resp['result']=true;
          echo json_encode($resp);
          }

          else{
          $resp['mensaje']='Este ticket esta caducado';
          echo json_encode($resp);
          }
          }
          else{
          $resp['mensaje']='Este ticket se encuentra en otro estatus diferente al de vendido';
          echo json_encode($resp);
          }
          }
          else{
          $resp['mensaje']='Este ticket no existe';
          echo json_encode($resp);
          }
          } */
        if ($this->session->userdata('logged_id')) {
            $detalleticket = $this->detalletickets->datos($this->input->post('codigobarras'));
            $estatus = $this->catestatus->datos($detalleticket->id_estatus);
            echo $estatus->descripcion;
        } else
            redirect('login', 'refresh');
    }

    public function cambiavencido() {
        if ($this->session->userdata('logged_id')) {
            $estatus = array(
                'id_estatus' => 4,
            );
            echo $this->detalletickets->update($this->input->post('codigobarras'), $estatus);
        } else
            redirect('login', 'refresh'); 
    }
     public function delete() {  
        if ($this->session->userdata('logged_id')) {
            $estatus = array(
                'id_estatus' => 1,
            );
			            $sesion = $this->session->userdata('logged_id');
			$eliminado = array(
                'code' => $this->input->post('codigobarras'),
				'motivo' => $this->input->post('motivo'),
				'fecha' => date('Y-m-d H:i:s'),
				'usuario'=>$sesion['usuario']
            );
            $detalleticket = $this->detalletickets->datos($this->input->post('codigobarras'));
            if($detalleticket->contador==0){
                   $this->detalletickets->update($this->input->post('codigobarras'), $estatus);
				   $this->detalleventa->deleteHis($eliminado);
                   echo $this->detalleventa->delete($this->input->post('codigobarras'));
            }
            else{
                echo false;
            }
         
        } else 
            redirect('login', 'refresh');
    } 

    public function generarventa() {
        if ($this->session->userdata('logged_id')) {
            $sesion = $this->session->userdata('logged_id');
            $usuario = $sesion['usuario'];
            $venta = array(
                'cambio' => $this->input->post('cambio'),
                'subtotal' => $this->input->post('subtotal'),
                'iva' => $this->input->post('iva'),
                'total' => $this->input->post('total'),
                'fecha' => date('Y-m-d H:i:s'),
                'usuario' => $usuario,
                'id_formapago_venta' => $this->input->post('formapago'),
            );
            echo $this->venta->insert($venta);
        } else
            redirect('login', 'refresh');
    }

    public function agregadetalle() {
        if ($this->session->userdata('logged_id')) {

            date_default_timezone_set('Mexico/General');

            $detalleticket = $this->detalletickets->datos($this->input->post('codigobarras'));
            $ticketgenerado = $this->ticketsgenerados->datos($detalleticket->id_ticketsgenerados);
            $precioticket = $this->preciotickets->datos($ticketgenerado->id_preciotickets);
            $detalle = array(
                'folio_venta' => $this->input->post('folio'),
                'codigo_barras' => $this->input->post('codigobarras'),
                'id_preciotickets' => $ticketgenerado->id_preciotickets,
                'subtotal' => $this->input->post('subtotal'),
                'descuento' => $this->input->post('descuento') / 100,
                'motivodescuento' => $this->input->post('motivodescuento')
            );
            if ($this->detalleventa->insert($detalle) != 0) {
                $estatus = array(
                    'id_estatus' => 2,
                );
                echo $this->detalletickets->update($this->input->post('codigobarras'), $estatus);
                $actual = date('Y-m-d H:i:s');
                $active = strtotime('+' . $precioticket->horas_vigencia . ' hour', strtotime($actual));
                $fecha_vigencia = array(
                    'fecha_vigencia' => date('Y-m-d H:i:s', $active)
                );

                echo $this->detalletickets->update($this->input->post('codigobarras'), $fecha_vigencia);
            } else
                echo false;
        } else
            redirect('login', 'refresh');
    }

    public function reporte() {
        if ($this->session->userdata('logged_id')) {
            $this->load->helper('form');
            $sesion = $this->session->userdata('logged_id');
            $data['main_content'] = 'tickets/reporte';
            $data['titutlo'] = 'Teleferico Taxco :: Generador de Tickets';
            $data['subtitulo'] = 'Reporte de Tickets';
            $data['menu'] = 'tickets';
            $data['usuario'] = $sesion['usuario'];
            $data['nombre'] = $sesion['nombre'];
            $data['rol'] = $sesion['rol'];
            $page = $this->input->get('page');
            if (isset($page))
                $data['page'] = $page;
            else
                $data['page'] = 1;
            $this->load->view('includes/template', $data);
        } else
            redirect('login', 'refresh');
    }
	public function borrados() {
        if ($this->session->userdata('logged_id')) {
            $this->load->helper('form');
            $sesion = $this->session->userdata('logged_id');
            $data['main_content'] = 'tickets/eliminado';
            $data['titutlo'] = 'Teleferico Taxco :: Generador de Tickets';
            $data['subtitulo'] = 'Reporte de Tickets';
            $data['menu'] = 'tickets';
            $data['usuario'] = $sesion['usuario'];
            $data['nombre'] = $sesion['nombre'];
            $data['rol'] = $sesion['rol'];
            $page = $this->input->get('page');
            if (isset($page))
                $data['page'] = $page;
            else
                $data['page'] = 1;
            $this->load->view('includes/template', $data);
        } else
            redirect('login', 'refresh');
    }

    public function exportapdf() {
        if ($this->session->userdata('logged_id')) {
            $this->load->library('fpdf');
            $this->load->library('barcode');
            $data = array(
                'fechainicio' => $this->input->post('fechainicio'),
                'fechafin' => $this->input->post('fechafin'),
            );
            if (!empty($data["fechainicio"]))
                $data["fechainicio"] = (new DateTime($data["fechainicio"]))->format('Y-m-d H:i:s');

            if (!empty($data["fechafin"]))
                $data["fechafin"] = (new DateTime($data["fechafin"]))->format('Y-m-d H:i:s');
            $pdf = new FPDF('P', 'pt');
            $pdf->AddPage('P', 'Letter');
            $fontSize = 10;
            $pdf->SetFont('Arial', 'B', $fontSize);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetAutoPageBreak(true, 0);

            $pdf->Cell(535, 25, 'REPORTE DE ACCESOS', 0, 1, 'C');
            $pdf->Cell(535, 25, $this->input->post('fechainicio') . ' al ' . $this->input->post('fechafin'), 0, 1, 'C');

            $tipos = $this->detalletickets->acumuladores_tipo($data);
            
            $pdf->Cell(150, 25, 'Tipo', 1, 0, 'C');
            $pdf->Cell(100, 25, 'Venta', 1, 0, 'C');
            $pdf->Cell(100, 25, 'Accesos', 1, 0, 'C');
            $pdf->Cell(100, 25, 'Restantes', 1, 0, 'C');
            $pdf->Cell(100, 25, 'Proporcion', 1, 1, 'C');
            foreach ($tipos->result()as $tipo) {
                $accesos = ($tipo->redondo == 0) ? $tipo->entradas : ($tipo->entradas/2);
                $catidad=($tipo->redondo == 0) ? $tipo->cantidad : $tipo->cantidad / 2;
                $pdf->Cell(150, 25, utf8_decode($tipo->tipo), 1, 0, 'C');
                $pdf->Cell(100, 25,$catidad , 1, 0, 'C');
                $pdf->Cell(100, 25, $accesos, 1, 0, 'C');
                $pdf->Cell(100, 25, ($catidad - $accesos), 1, 0, 'C');

                $pdf->Cell(100, 25, $tipo->entradas . "-" . $tipo->cantidad, 1, 1, 'C');
            }
           $pdf->Cell(75, 25, '', 0, 1, 'R');
            $pdf->Cell(75, 25, '', 0, 1, 'R');
              $pdf->AddPage('P', 'Letter');
            $pdf->Cell(535, 25, 'ACCESO DE MAESTROS', 0, 1, 'C');
            $pdf->Cell(535, 25, $this->input->post('fechainicio') . ' al ' . $this->input->post('fechafin'), 0, 1, 'C');
                 $pdf->Cell(100, 25, '', 0, 0, 'R');
            $pdf->Cell(150, 25, 'Codigo de Barras', 1, 0, 'C');
            $pdf->Cell(95, 25, 'Fecha/hora', 1, 0, 'C');
            $pdf->Cell(95, 25, '', 1, 1, 'C');

            $result = $this->detalletickets->master($data);
            $lastmaster='';
            $masters=0; 
            foreach ($result->result()as $row) {                
                if($lastmaster!=$row->codigo_barras){
                    $lastmaster=$row->codigo_barras;
                           $masters++; 
                }
                $pdf->Cell(100, 25, '', 0, 0, 'R');
               
                $pdf->Cell(150, 25, $row->codigo_barras, 'T', 0, 'C');
                $pdf->Cell(95, 25, date('d/M/y H:i:s', strtotime($row->time)), 'T', 0, 'C');               
                $pdf->Cell(95, 25, "maestro ".$masters, 'T', 1, 'C'); 
            } 
            $filename = 'test.pdf';
            $pdf->Output($filename, 'F');
            echo $filename;
        } else
            redirect('login', 'refresh');
    }
  public function exportadel() {
        if ($this->session->userdata('logged_id')) {
            $this->load->library('fpdf');
            $this->load->library('barcode');
            $data = array(
                'fechainicio' => $this->input->post('fechainicio'),
                'fechafin' => $this->input->post('fechafin'),
            );
            if (!empty($data["fechainicio"]))
                $data["fechainicio"] = (new DateTime($data["fechainicio"]))->format('Y-m-d H:i:s');

            if (!empty($data["fechafin"]))
                $data["fechafin"] = (new DateTime($data["fechafin"]))->format('Y-m-d H:i:s');
            $pdf = new FPDF('P', 'pt');
            $pdf->AddPage('P', 'Letter');
            $fontSize = 10;
            $pdf->SetFont('Arial', 'B', $fontSize);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetAutoPageBreak(true, 0);
			
              
            $pdf->Cell(535, 25, 'TIKETS ELIMINADOS', 0, 1, 'C');
            $pdf->Cell(535, 25, $this->input->post('fechainicio') . ' al ' . $this->input->post('fechafin'), 0, 1, 'C');
                 
			 
            $pdf->Cell(150, 25, 'Codigo de Barras', 1, 0, 'C');
            $pdf->Cell(95, 25, 'Fecha/hora', 1, 0, 'C');
			$pdf->Cell(95, 25, 'Usuario', 1, 0, 'C');
			$pdf->Cell(200, 25, 'Motivo', 1, 1, 'C');
            
$result = $this->detalletickets->deletes($data);
			
            
            foreach ($result->result()as $row) {                
                $pdf->Cell(150, 25, $row->code, 'T', 0, 'C');
                $pdf->Cell(95, 25, date('d/M/y H:i:s', strtotime($row->fecha)), 'T', 0, 'C');               
                $pdf->Cell(95, 25, $row->usuario, 'T', 0, 'C'); 
				$pdf->Cell(200, 25, $row->motivo, 'T', 1, 'C'); 
            } 
            $filename = 'cancelados.pdf';
            $pdf->Output($filename, 'F');
            
        } else
            redirect('login', 'refresh');
    }
 
    public function buscar() {
        if ($this->session->userdata('logged_id')) {
            $data = array(
                'fechainicio' => $this->input->post('fechainicio'),
                'fechafin' => $this->input->post('fechafin'),
            );
            if (!empty($data["fechainicio"]))
                $data["fechainicio"] = (new DateTime($data["fechainicio"]))->format('Y-m-d');

            if (!empty($data["fechafin"]))
                $data["fechafin"] = (new DateTime($data["fechafin"]))->format('Y-m-d');

            $resp = array(
                'result' => true,
                'reporte_tickets' => '',
            );
            $result = $this->ticketsgenerados->select($data);
            foreach ($result->result()as $row) {
                $precioticket = $this->preciotickets->datos($row->id_preciotickets);
                $resp['reporte_tickets'].= '<tr><td>' . $row->id_ticketsgenerados . '</td><td>' . date('d/M/y', strtotime($row->fecha_creacion)) . '</td><td>' . $precioticket->tipo . '</td><td></td><td></td><td></td></tr>';
                $result2 = $this->detalletickets->detalle($row->id_ticketsgenerados);
                foreach ($result2->result()as $detalle) {
                    $catestatus = $this->catestatus->datos($detalle->id_estatus);
                    $resp['reporte_tickets'].= '<tr><td></td><td></td><td></td><td>' . $detalle->codigo_barras . '</td><td>' . $detalle->fecha_vigencia . '</td><td>' . $catestatus->descripcion . '</td></tr>';
                }
            }
            echo json_encode($resp);
        } else
            redirect('login', 'refresh');
    }

    public function reporteticket() {
        if ($this->session->userdata('logged_id')) {
            $rangofecha = array(
                'fechainicio' => $this->input->post('fechainicio'),
                'fechafin' => $this->input->post('fechafin'),
            );
            if (!empty($rangofecha["fechainicio"]))
                $rangofecha["fechainicio"] = (new DateTime($rangofecha["fechainicio"]))->format('Y-m-d H:i:s');

            if (!empty($rangofecha["fechafin"]))
                $rangofecha["fechafin"] = (new DateTime($rangofecha["fechafin"]))->format('Y-m-d H:i:s');

            $config['base_url'] = base_url() . 'tickets/reporte';
            $config['first_url'] = base_url() . 'tickets/reporte/';
            $config['uri_segment'] = 3;
            $config['use_page_numbers'] = TRUE;
            $config['page_query_string'] = TRUE;
            $config['query_string_segment'] = 'page';
            $config['total_rows'] = $this->detalletickets->total_filas($rangofecha);
            $config['per_page'] = '5';
            $config['num_links'] = 4;
            $config['first_link'] = 'Primero';
            $config['last_link'] = 'Último';
            $config['next_link'] = 'Siguiente';
            $config['prev_link'] = 'Anterior';
            $data['total_rows'] = $config['total_rows'];
            $inicio = 0;
            if ($this->input->get('page'))
                $inicio = ($this->input->get('page') - 1) * $config['per_page'];
            $this->pagination->initialize($config);
            $noticias = $this->detalletickets->get_detalle_tickets($config['per_page'], $inicio, $rangofecha);
            $this->table->set_heading('#GENERACION', 'FECHA CREACION', 'TIPO', 'CODIGO DE BARRAS', 'FECHA VIGENCIA', 'ESTATUS');
            $template = array('table_open' => '<table border="0" id="reporte" cellpadding="4" cellspacing="0">');
            $this->table->set_template($template);
            $data['tabla'] = $this->table->generate($noticias);
            $data['link'] = $this->pagination->create_links();
            echo json_encode($data);
        } else
            redirect('login', 'refresh');
    }

    public function listaformapago() {
        if ($this->session->userdata('logged_id')) {
            $resp = array(
                'result' => true,
                'lista_formapago' => '',
            );
            $result = $this->catformapago->select();
            foreach ($result->result()as $row)
                $resp['lista_formapago'].= '<option value="' . $row->id_formapago . '" >' . $row->descripcion . '</option>';
            echo json_encode($resp);
        } else
            redirect('login', 'refresh');
    }

}

?>
