<?php

use Illuminate\Database\Seeder;

class BoardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //List of boards as in dec/18/2016
        $collection = collect([
        ['id' => '1', 'name' => 'Consejo Nacional de Certificación en Anestesiología, A.C.'],
        ['id' => '2', 'name' => 'Consejo Mexicano de Angiolología y Cirugía Vascular, A.C.'],
        ['id' => '3', 'name' => 'Consejo Mexicano de Cardiología, A.C.'],
        ['id' => '4', 'name' => 'Consejo Mexicano de Cirugía General, A.C.'],
        ['id' => '5', 'name' => 'Consejo Mexicano de Cirugía Neurológica, A.C.'],
        ['id' => '6', 'name' => 'Consejo Mexicano de Cirugía Oral y Maxilofacial, A.C.'],
        ['id' => '7', 'name' => 'Consejo Mexicano de Cirugía Pediátrica, A.C.'],
        ['id' => '8', 'name' => 'Consejo Mexicano de Cirugía Plástica Estética y Reconstructiva, A.C.'],
        ['id' => '9', 'name' => 'Consejo Nacional de Cirugía del Tórax, A.C.'],
        ['id' => '10', 'name' => 'Consejo Mexicano de Comunicación, Audilogía, Otoneurología y Foniatria, A.C.'],
        ['id' => '11', 'name' => 'Consejo Mexicano de Dermatología, A.C.'],
        ['id' => '12', 'name' => 'Consejo Mexicano de Endocrinología, A.C.'],
        ['id' => '13', 'name' => 'Consejo Mexicano de especialistas en Coloproctología, A.C.'],
        ['id' => '14', 'name' => 'Consejo Mexicano de Gastroenterología, A.C.'],
        ['id' => '15', 'name' => 'Consejo Mexicano de Genética, A.C.'],
        ['id' => '16', 'name' => 'Consejo Mexicano de Geriatría, A.C.'],
        ['id' => '17', 'name' => 'Consejo Mexicano de Ginecología y Obstetricia, A.C.'],
        ['id' => '18', 'name' => 'Consejo Mexicano de Hematología, A.C.'],
        ['id' => '19', 'name' => 'Consejo Mexicano de Certificación en Infectología, A.C.'],
        ['id' => '20', 'name' => 'Consejo Nacional de Inmunología Clínica y Alergia, A.C.'],
        ['id' => '21', 'name' => 'Consejo Mexicano de Medicina Aeroespacial, A.C.'],
        ['id' => '22', 'name' => 'Consejo Mexicano de Medicina Crítica, A.C.'],
        ['id' => '23', 'name' => 'Consejo Nacional de Medicina del Deporte, A.C.'],
        ['id' => '24', 'name' => 'Consejo Mexicano de Certificación en Medicina Familiar, A.C.'],
        ['id' => '25', 'name' => 'Consejo Mexicano de Medicina Interna, A.C.'],
        ['id' => '26', 'name' => 'Consejo Mexicano de Medicina Legal y Forense, A.C.'],
        ['id' => '27', 'name' => 'Consejo Mexicano de Medicina de Rehabilitación, A.C.'],
        ['id' => '28', 'name' => 'Consejo Nacional Mexicano de Medicina del Trabajo, A.C.'],
        ['id' => '29', 'name' => 'Consejo Mexicano de Medicina de Urgencias, A.C.'],
        ['id' => '30', 'name' => 'Consejo Mexicano de Médicos Anatomopatólogos, A.C.'],
        ['id' => '31', 'name' => 'Consejo Mexicano de Médicos Nucleares, A.C.'],
        ['id' => '32', 'name' => 'Consejo Mexicano de Nefrología, A.C.'],
        ['id' => '33', 'name' => 'Consejo Nacional de Neumología, A.C.'],
        ['id' => '34', 'name' => 'Consejo Mexicano de Neurofisiología Clínica, A.C.'],
        ['id' => '35', 'name' => 'Consejo Mexicano de Neurología, A.C.'],
        ['id' => '36', 'name' => 'Consejo Mexicano de Oftalmología, A.C.'],
        ['id' => '37', 'name' => 'Consejo Mexicano de Oncología, A.C.'],
        ['id' => '38', 'name' => 'Consejo Mexicano de Ortopedia y Traumatología, A.C.'],
        ['id' => '39', 'name' => 'Consejo Mexicano de Otorrinolaringología y Cirugía de Cabeza y Cuello, A.C.'],
        ['id' => '40', 'name' => 'Consejo Mexicano de Patología Clínica y Medicina de Laboratorio, A.C.'],
        ['id' => '41', 'name' => 'Consejo Mexicano de Certificación en Pediatría, A.C.'],
        ['id' => '42', 'name' => 'Consejo Mexicano de Psiquiatría, A.C.'],
        ['id' => '43', 'name' => 'Consejo Mexicano de Radiología e Imagen, A.C.'],
        ['id' => '44', 'name' => 'Consejo Mexicano de Radioterapia, A.C.'],
        ['id' => '45', 'name' => 'Consejo Mexicano de Reumatología, A.C.'],
        ['id' => '46', 'name' => 'Consejo Nacional de Salud Pública, A.C.'],
        ['id' => '47', 'name' => 'Consejo Nacional Mexicano de Urología, A.C.'],
        ]);

        foreach ($collection as $var) {
            EMMA5\Board::create($var);
        }
    }
}
