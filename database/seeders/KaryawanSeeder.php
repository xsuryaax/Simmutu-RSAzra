<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataManagement = [
            ['nip' => '20141969', 'nama_karyawan' => 'DIENI ANANDA PUTRI, DR., MARS', 'unit_id' => 2, 'profesi' => 'MEDIS', 'role_id' => 9, 'atasan_langsung' => 'MANAGER'],
            ['nip' => '20061005', 'nama_karyawan' => 'GARCINIA SATIVA FIZRIA SETIADI, DR., MKM', 'unit_id' => 1, 'profesi' => 'MEDIS', 'role_id' => 9, 'atasan_langsung' => 'MANAGER'],
            ['nip' => '20253017', 'nama_karyawan' => 'INDRA THALIB, BSN., MM', 'unit_id' => 36, 'profesi' => 'NON MEDIS', 'role_id' => 9, 'atasan_langsung' => 'MANAGER'],
            ['nip' => '20253030', 'nama_karyawan' => 'IRMA RISMAYANTY, DR., MM', 'unit_id' => 1, 'profesi' => 'NON MEDIS', 'role_id' => 9, 'atasan_langsung' => 'DIREKTUR'],
            ['nip' => '19950015', 'nama_karyawan' => 'LAILA AZRA, DRA.', 'unit_id' => 1, 'profesi' => 'NON MEDIS', 'role_id' => 9, 'atasan_langsung' => 'PRESIDEN KOMISARIS'],
            ['nip' => '20253062', 'nama_karyawan' => 'LILI MARLIANI, DR., MARS', 'unit_id' => 1, 'profesi' => 'MEDIS', 'role_id' => 9, 'atasan_langsung' => 'MANAGER'],
            ['nip' => '20212767', 'nama_karyawan' => 'METRI JULIANTI, SE', 'unit_id' => 43, 'profesi' => 'NON MEDIS', 'role_id' => 9, 'atasan_langsung' => 'MANAGER'],
            ['nip' => '20071107', 'nama_karyawan' => 'M. RANGGA ADITYA', 'unit_id' => 1, 'profesi' => 'NON MEDIS', 'role_id' => 9, 'atasan_langsung' => 'DIREKTUR'],
            ['nip' => '20242964', 'nama_karyawan' => 'MUHAMAD MIFTAHUDIN, M. KOM', 'unit_id' => 23, 'profesi' => 'NON MEDIS', 'role_id' => 9, 'atasan_langsung' => 'MANAGER'],
            ['nip' => '20242957', 'nama_karyawan' => 'RIA FAJARROHMI, SE', 'unit_id' => 40, 'profesi' => 'NON MEDIS', 'role_id' => 7, 'atasan_langsung' => 'KEPALA'],
            ['nip' => '20111600', 'nama_karyawan' => 'RIYADI MAULANA, SH., MH., CLA., CCD', 'unit_id' => 47, 'profesi' => 'NON MEDIS', 'role_id' => 9, 'atasan_langsung' => 'MANAGER'],
            ['nip' => '19940189', 'nama_karyawan' => 'SENI MAULIDA FITALOKA, S.KEP., NERS, M.KEP', 'unit_id' => 50, 'profesi' => 'MEDIS', 'role_id' => 9, 'atasan_langsung' => 'MANAGER'],
            ['nip' => '20020462', 'nama_karyawan' => 'SITI KHOIRIAH', 'unit_id' => 24, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'STAFF'],
            ['nip' => '20253070', 'nama_karyawan' => 'THORIQ FARIED ISHAQ, S.I. KOM', 'unit_id' => 5, 'profesi' => 'NON MEDIS', 'role_id' => 9, 'atasan_langsung' => 'MANAGER'],
            ['nip' => '20253008', 'nama_karyawan' => 'TUMPAS BANGKIT PRAYUDA, SE', 'unit_id' => 20, 'profesi' => 'NON PROFESI', 'role_id' => 9, 'atasan_langsung' => 'MANAGER'],
            ['nip' => '20242988', 'nama_karyawan' => 'VERONIKA RINI HANDAYANI, A. MD', 'unit_id' => 24, 'profesi' => 'NON PROFESI', 'role_id' => 4, 'atasan_langsung' => 'STAFF'],
        ];

        $dataStaff = [
            ['nip' => '20121789', 'nama_karyawan' => 'ADE FIRMANSYAH', 'unit_id' => 3, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'KHANZA RIRI ARISTIANI, S.Gz'],
            ['nip' => '20212831', 'nama_karyawan' => 'ADE IRPAN, SKM', 'unit_id' => 4, 'profesi' => 'non medis', 'role_id' => 5, 'atasan_langsung' => 'THORIQ FARIED ISHAQ, S.I. KOM'],
            ['nip' => '19950244', 'nama_karyawan' => 'ADE SASMITA, SE', 'unit_id' => 5, 'profesi' => 'non medis', 'role_id' => 5, 'atasan_langsung' => 'THORIQ FARIED ISHAQ, S.I. KOM'],
            ['nip' => '20253041', 'nama_karyawan' => 'AGUNG WIBOWO, S.Ars', 'unit_id' => 6, 'profesi' => 'non medis', 'role_id' => 4, 'atasan_langsung' => 'THORIQ FARIED ISHAQ, S.I. KOM'],
            ['nip' => '20071152', 'nama_karyawan' => 'AGUS DARAJAT, Dr, Sp.A, M.Kes', 'unit_id' => 7, 'profesi' => 'medis', 'role_id' => 10, 'atasan_langsung' => 'RAHAYU AFIAH SURUR, DR'],
            ['nip' => '20253038', 'nama_karyawan' => 'AHMAD MAULANA APRYAWAN', 'unit_id' => 8, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'ERNA SUNARNI, AMAK'],
            ['nip' => '20081261', 'nama_karyawan' => 'AJENG PUSPA INDAH, S.Kep., Ners', 'unit_id' => 2, 'profesi' => 'medis', 'role_id' => 5, 'atasan_langsung' => 'DIENI ANANDA PUTRI, DR, MARS'],
            ['nip' => '20020506', 'nama_karyawan' => 'AJI SAPRUDIN', 'unit_id' => 9, 'profesi' => 'non medis', 'role_id' => 4, 'atasan_langsung' => 'ADE SASMITA, SE'],
            ['nip' => '20253031', 'nama_karyawan' => 'ALFIAN KURNIAWAN', 'unit_id' => 6, 'profesi' => 'non medis', 'role_id' => 5, 'atasan_langsung' => 'THORIQ FARIED ISHAQ, S.I. KOM'],
            ['nip' => '20212789', 'nama_karyawan' => 'AMARTIWI, S.Kep., Ners', 'unit_id' => 16, 'profesi' => 'medis', 'role_id' => 6, 'atasan_langsung' => 'YANTI HAPTIANI, S.Kep., Ners'],
            ['nip' => '20242987', 'nama_karyawan' => 'AMELIA SUSANTI, Amd.Kes', 'unit_id' => 7, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20101508', 'nama_karyawan' => 'ANASTASIA DIAN PARLINA, S.Kep., Ners', 'unit_id' => 17, 'profesi' => 'medis', 'role_id' => 5, 'atasan_langsung' => 'SENI MAULIDA FITALOKA, S.Kep., Ns, M.Kep'],
            ['nip' => '20212774', 'nama_karyawan' => 'ANDIKA DWIPRASOJO, Amd.Kep', 'unit_id' => 18, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'LESTARI RUMIYANI, S.Kep., Ns'],
            ['nip' => '20212779', 'nama_karyawan' => 'ANDI RENDRA HANDIKO, S.Tr', 'unit_id' => 19, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'INTAN ANANDA UTAMI, Amd OT'],
            ['nip' => '20232906', 'nama_karyawan' => 'ANDRI IFTIYOKO, SH', 'unit_id' => 20, 'profesi' => 'non medis', 'role_id' => 5, 'atasan_langsung' => 'TUMPAS BANGKIT PRAYUDA, SE'],
            ['nip' => '20202688', 'nama_karyawan' => 'ANGGITA SEVI, S.Farm', 'unit_id' => 21, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.Farm, Apt'],

            ['nip' => '20253095', 'nama_karyawan' => 'ANGGITA YULIANA PUTRI, S.Kep., Ners', 'unit_id' => 16, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'YANTI HAPTIANI, S.Kep., Ners'],
            ['nip' => '20212797', 'nama_karyawan' => 'ANGGI WIDIASTUTI, S.Kep., Ners', 'unit_id' => 22, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'SAMSIAH, S.Kep., Ners'],
            ['nip' => '20202717', 'nama_karyawan' => 'ANGGUN ASTRIANNA APRIANTI, AMK', 'unit_id' => 22, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'SAMSIAH, S.Kep., Ners'],
            ['nip' => '20242961', 'nama_karyawan' => 'ANISA OKTAVIANI, S.Kep., Ners', 'unit_id' => 16, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'YANTI HAPTIANI, S.Kep., Ners'],
            ['nip' => '19950208', 'nama_karyawan' => 'ANNA SUHARDINING, S.Kep., Ns', 'unit_id' => 17, 'profesi' => 'medis', 'role_id' => 5, 'atasan_langsung' => 'SENI MAULIDA FITALOKA, S.Kep., Ns, M.Kep'],
            ['nip' => '20222874', 'nama_karyawan' => 'ANSHAR FAISAL ISMI', 'unit_id' => 23, 'profesi' => 'non medis', 'role_id' => 4, 'atasan_langsung' => 'MUHAMAD MIFTAHUDIN, M.Kom'],
            ['nip' => '20192664', 'nama_karyawan' => 'ANTIKA PUTRI PRATAMI', 'unit_id' => 24, 'profesi' => 'non medis', 'role_id' => 4, 'atasan_langsung' => 'LILI MARLIANI, DR., MARS'],
            ['nip' => '20222851', 'nama_karyawan' => 'ARDELIA NURHAIDA, S.Farm', 'unit_id' => 21, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.Farm, Apt'],
            ['nip' => '20253039', 'nama_karyawan' => 'ARI DAYOS TABAKWAN, S.Kep., Ners', 'unit_id' => 17, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'ANASTASIA DIAN PARLINA, S.Kep., Ners'],
            ['nip' => '20253004', 'nama_karyawan' => 'ARINI VIANSARI, Amd.Kep', 'unit_id' => 25, 'profesi' => 'non medis', 'role_id' => 5, 'atasan_langsung' => 'IRMA RISMAYANTY, Dr, MM'],
            ['nip' => '20253066', 'nama_karyawan' => 'ARI NURYANI NAHAMPUAN, S.Kep., Ners', 'unit_id' => 12, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'SRI YULIANI, S.Kep., Ners'],
            ['nip' => '20253084', 'nama_karyawan' => 'ARLIANA LESTARI, Amd.Kep', 'unit_id' => 10, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'EKA SETIA WULANNINGSIH, S.Kep'],
            ['nip' => '20212784', 'nama_karyawan' => 'ASEP SARIF HIDAYATULLOH, S.Tr', 'unit_id' => 26, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'RAIMOND ANDROMEGA, DR., MPH'],
            ['nip' => '20253077', 'nama_karyawan' => 'AULIA MUNAJAT, S.Kep., Ners', 'unit_id' => 7, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20222857', 'nama_karyawan' => 'AULIA PUSPITA SARI, S.Farm', 'unit_id' => 21, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.Farm, Apt'],
            ['nip' => '20212787', 'nama_karyawan' => 'AYU ANDIRA, Amd.Kep', 'unit_id' => 13, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'SRI YULIANI, S.Kep., Ners'],
            ['nip' => '20192549', 'nama_karyawan' => 'AYU WULANDARI, AMK', 'unit_id' => 7, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20071134', 'nama_karyawan' => 'BAGYA HERMAWAN, BR.AMK', 'unit_id' => 27, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'DIAN MAHDIANI, S.Kep., Ners'],
            ['nip' => '20030527', 'nama_karyawan' => 'BAMBANG PRIYADI', 'unit_id' => 28, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'RIA FAJARROHMI, SE'],
            ['nip' => '20253028', 'nama_karyawan' => 'BELADINNA ZALFA ZAHIRAH, S.Kep., Ners', 'unit_id' => 7, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20061047', 'nama_karyawan' => 'BENI YULIA, AMK', 'unit_id' => 7, 'profesi' => 'medis', 'role_id' => 6, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20242978', 'nama_karyawan' => 'BINAR SASONO, Dr. Sp.KFR', 'unit_id' => 29, 'profesi' => 'medis', 'role_id' => 10, 'atasan_langsung' => 'GARCINIA SATIVA FIZRIA SETIADI, Dr, MKM'],
            ['nip' => '20061055', 'nama_karyawan' => 'BUDI HARTANTO', 'unit_id' => 30, 'profesi' => 'non medis', 'role_id' => 5, 'atasan_langsung' => 'M MAHFUD ISRO, SE'],
            ['nip' => '20020495', 'nama_karyawan' => 'BUYUNG HERMAWAN', 'unit_id' => 31, 'profesi' => 'non medis', 'role_id' => 4, 'atasan_langsung' => 'ALFIAN KURNIAWAN'],
            ['nip' => '20253049', 'nama_karyawan' => 'CHANDRA BHAKTI PERWIRA, DR', 'unit_id' => 32, 'profesi' => 'medis', 'role_id' => 6, 'atasan_langsung' => 'MUHAMMAD ARDYANSYAH PRATAMA, DR'],
            ['nip' => '20081257', 'nama_karyawan' => 'CHRISMA ADRYANA ALBANDJAR, Dr. Sp.An-KIC', 'unit_id' => 17, 'profesi' => 'medis', 'role_id' => 10, 'atasan_langsung' => 'ANNA SUHARDINING, S.Kep., Ns'],
            ['nip' => '20253078', 'nama_karyawan' => 'CHUTTIA RAMADANTI, S.Kep., Ners', 'unit_id' => 7, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20202734', 'nama_karyawan' => 'DEA RATNA PUSPITASARI, S.Kep., Ners', 'unit_id' => 12, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'SRI YULIANI, S.Kep., Ners'],
            ['nip' => '20253069', 'nama_karyawan' => 'DELLA AYU PRATIWI, SE', 'unit_id' => 30, 'profesi' => 'non medis', 'role_id' => 4, 'atasan_langsung' => 'BUDI HARTANTO'],
            ['nip' => '20091387', 'nama_karyawan' => 'DEVITA RIZKI AMELIANA, AMK', 'unit_id' => 33, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20242929', 'nama_karyawan' => 'DEWI KHANIA, Amd.Kes.Rad', 'unit_id' => 34, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'SEPTIAN NUGROHO, Amd.Rad'],
            ['nip' => '20202706', 'nama_karyawan' => 'DHESTY ANDHIANISA, Amd.Kep', 'unit_id' => 18, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'LESTARI RUMIYANI, S.Kep., Ns'],
            ['nip' => '20050938', 'nama_karyawan' => 'DHIKA PRAMESTIKA, S.Kep., Ns', 'unit_id' => 20, 'profesi' => 'medis', 'role_id' => 5, 'atasan_langsung' => 'TUMPAS BANGKIT PRAYUDA, SE'],
            ['nip' => '20222899', 'nama_karyawan' => 'DIAH AYU SEKARNINGTYAS, Amd.Ak', 'unit_id' => 30, 'profesi' => 'non medis', 'role_id' => 4, 'atasan_langsung' => 'BUDI HARTANTO'],
            ['nip' => '20172362', 'nama_karyawan' => 'DIANA ROSITA, AMK', 'unit_id' => 15, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'YANTI HAPTIANI, S.Kep., Ners'],
            ['nip' => '20020550', 'nama_karyawan' => 'DIAN MAHDIANI, S.Kep., Ners', 'unit_id' => 27, 'profesi' => 'medis', 'role_id' => 5, 'atasan_langsung' => 'SENI MAULIDA FITALOKA, S.Kep., Ns, M.Kep'],
            ['nip' => '20030642', 'nama_karyawan' => 'DIAN MATSYIWATI PUTRI SARI, S.Kep., Ners', 'unit_id' => 35, 'profesi' => 'medis', 'role_id' => 5, 'atasan_langsung' => 'DIENI ANANDA PUTRI, DR, MARS'],
            ['nip' => '20192595', 'nama_karyawan' => 'DIAN NURUL HIKMAH, Amd.Gizi', 'unit_id' => 3, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'KHANZA RIRI ARISTIANI, S.Gz'],
            ['nip' => '20101523', 'nama_karyawan' => 'DIAN YUSTINANDA, DR', 'unit_id' => 32, 'profesi' => 'medis', 'role_id' => 8, 'atasan_langsung' => 'LILI MARLIANI, DR., MARS'],
            ['nip' => '20202703', 'nama_karyawan' => 'DIDI NARSIDI, S.Farm', 'unit_id' => 21, 'profesi' => 'medis', 'role_id' => 4, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.Farm, Apt'],
            ['nip' => '20222871', 'nama_karyawan' => 'DINDA ANNISA FITRI, S.GZ', 'unit_id' => 3, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'KHANZA RIRI ARISTIANI, S.Gz'],
            ['nip' => '20192599', 'nama_karyawan' => 'DINI HENDRAYANI, S.KEP., NERS', 'unit_id' => 7, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20253044', 'nama_karyawan' => 'DWI ASTUTI, S.Psi', 'unit_id' => 36, 'profesi' => 'Non Medis', 'role_id' => 5, 'atasan_langsung' => 'INDRA THALIB, BSN., MM'],
            ['nip' => '20101481', 'nama_karyawan' => 'DWI IRMA SARI, S.Farm', 'unit_id' => 21, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.FARM, APT.'],
            ['nip' => '20101532', 'nama_karyawan' => 'DWI RETNO HANDAYANI, S.FARM, APT', 'unit_id' => 21, 'profesi' => 'Medis', 'role_id' => 6, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.FARM, APT.'],
            ['nip' => '19960257', 'nama_karyawan' => 'DYAH ISTIATI, S.KEP., NERS', 'unit_id' => 22, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'SAMSIAH, S.KEP., NERS'],
            ['nip' => '20192592', 'nama_karyawan' => 'EKA KURNIASARI, S.S', 'unit_id' => 37, 'profesi' => 'Non Medis', 'role_id' => 6, 'atasan_langsung' => 'REGAWA PARRIKESIT, A.MD'],
            ['nip' => '20040661', 'nama_karyawan' => 'EKA SETIA WULANNINGSIH, S.Kep', 'unit_id' => 10, 'profesi' => 'Medis', 'role_id' => 5, 'atasan_langsung' => 'SENI MAULIDA FITALOKA, S.Kep, Ns, M.Kep'],
            ['nip' => '20253087', 'nama_karyawan' => 'ELFA DIAN AGUSTINA, S.FARM, APT', 'unit_id' => 21, 'profesi' => 'Medis', 'role_id' => 5, 'atasan_langsung' => 'GARCINIA SATIVA FIZRIA SETIADI, Dr, MKM'],
            ['nip' => '20253034', 'nama_karyawan' => 'ELNI OKTAVIANI, DR', 'unit_id' => 32, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'MUHAMMAD ARDYANSYAH PRATAMA, DR'],
            ['nip' => '20192537', 'nama_karyawan' => 'ELSA SHYLVIA JUNIAR, AMD KEP', 'unit_id' => 10, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'EKA SETIA WULANNINGSIH, S.Kep'],
            ['nip' => '20030601', 'nama_karyawan' => 'EMELIA SAPTYA MURTININGSIH, AMK', 'unit_id' => 27, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'DIAN MAHDIANI, S.Kep., Ners'],
            ['nip' => '20202678', 'nama_karyawan' => 'EMILLIA HASANAH, S.Tr.Kes', 'unit_id' => 19, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'INTAN ANANDA UTAMI, Amd OT'],
            ['nip' => '20061039', 'nama_karyawan' => 'ENI SAKHNA, S.Kep., Ners', 'unit_id' => 38, 'profesi' => 'Medis', 'role_id' => 6, 'atasan_langsung' => 'YANTI HAPTIANI, S.Kep., Ners'],
            ['nip' => '20101424', 'nama_karyawan' => 'ERNA MINAYATINA, AMK', 'unit_id' => 22, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'SAMSIAH, S.KEP., NERS'],
            ['nip' => '20040830', 'nama_karyawan' => 'ERNA SUNARNI, AMAK', 'unit_id' => 8, 'profesi' => 'Medis', 'role_id' => 5, 'atasan_langsung' => 'GARCINIA SATIVA FIZRIA SETIADI, Dr, MKM'],
            ['nip' => '20253027', 'nama_karyawan' => 'ERVINA FITRIANI', 'unit_id' => 27, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'DIAN MAHDIANI, S.Kep., Ners'],
            ['nip' => '20202695', 'nama_karyawan' => 'ETI RAHMAWATI, AMD KEP', 'unit_id' => 7, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20081221', 'nama_karyawan' => 'ETI ROHAETI, AMKG', 'unit_id' => 7, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20242968', 'nama_karyawan' => 'EVA OKTOVIANA, AMK', 'unit_id' => 7, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20020429', 'nama_karyawan' => 'EVI MINTARSIH, AMK', 'unit_id' => 39, 'profesi' => 'Medis', 'role_id' => 6, 'atasan_langsung' => 'DIAN MAHDIANI, S.Kep., Ners'],
            ['nip' => '20192645', 'nama_karyawan' => 'EVI WULANDARI, A.MD', 'unit_id' => 30, 'profesi' => 'Non Medis', 'role_id' => 4, 'atasan_langsung' => 'BUDI HARTANTO'],
            ['nip' => '20192620', 'nama_karyawan' => 'FACHRI GINANJAR, A.MD', 'unit_id' => 40, 'profesi' => 'Non Medis', 'role_id' => 4, 'atasan_langsung' => 'RIA FAJARROHMI, SE'],
            ['nip' => '20192623', 'nama_karyawan' => 'FACHRULREZA DJAEMI, AMD', 'unit_id' => 41, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'SOEPARNO, AMd.Perkes., S.MIK'],
            ['nip' => '20253007', 'nama_karyawan' => 'FADHILAH ULFAH, S.FARM., APT', 'unit_id' => 21, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.FARM, APT.'],
            ['nip' => '20253085', 'nama_karyawan' => 'FAIZA DWI RAMADANIA, S.Tr.Kes', 'unit_id' => 42, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'DIAN MAHDIANI, S.Kep., Ners'],
            ['nip' => '19930083', 'nama_karyawan' => 'FATMAWATI', 'unit_id' => 24, 'profesi' => 'Non Medis', 'role_id' => 4, 'atasan_langsung' => 'SITI KHOIRIAH'],
            ['nip' => '20222861', 'nama_karyawan' => 'FEBI ANGGRAINI, AMD', 'unit_id' => 30, 'profesi' => 'Non Medis', 'role_id' => 4, 'atasan_langsung' => 'BUDI HARTANTO'],
            ['nip' => '20040861', 'nama_karyawan' => 'FERA ASRILIA, AMK', 'unit_id' => 33, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20253060', 'nama_karyawan' => 'FERDY DANIEL LATUPUTTY, S.Kep., Ners', 'unit_id' => 10, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'EKA SETIA WULANNINGSIH, S.Kep'],
            ['nip' => '20192579', 'nama_karyawan' => 'FERI ANGRIAWAN, S.Tr', 'unit_id' => 41, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'SOEPARNO, AMd.Perkes., S.MIK'],
            ['nip' => '20232916', 'nama_karyawan' => 'FIDA FIRDAUS PRIMIANDIKA', 'unit_id' => 34, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'SEPTIAN NUGROHO, AMD.Rad'],
            ['nip' => '20212812', 'nama_karyawan' => 'FINA FAUZIYAH, S.Kep., Ners', 'unit_id' => 16, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'YANTI HAPTIANI, S.Kep., Ners'],
            ['nip' => '20192646', 'nama_karyawan' => 'FIRMAN HAFITHUDIN SYAH, A.MD', 'unit_id' => 43, 'profesi' => 'Non Medis', 'role_id' => 6, 'atasan_langsung' => 'HADI KURNIAWAN, S.M'],
            ['nip' => '20081218', 'nama_karyawan' => 'FITRI WIJAYANTI, AM.Keb', 'unit_id' => 44, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'IRENE SRI SUMARNI, AM.Keb'],
            ['nip' => '20141999', 'nama_karyawan' => 'FITRIYANI MEGAWATI, AMD Perkes', 'unit_id' => 41, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'SOEPARNO, AMd.Perkes., S.MIK'],
            ['nip' => '20131947', 'nama_karyawan' => 'GARSIANA SRI HASANAH, S.FARM., APT', 'unit_id' => 21, 'profesi' => 'Medis', 'role_id' => 6, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.FARM, APT.'],
            ['nip' => '20252999', 'nama_karyawan' => 'GHANIS GUSVIRANTY BAYU, AMD.Keb', 'unit_id' => 20, 'profesi' => 'Non Medis', 'role_id' => 4, 'atasan_langsung' => 'DHIKA PRAMESTIKA, S.Kep., Ns'],
            ['nip' => '20253043', 'nama_karyawan' => 'GRACIA, S.Kep., Ners', 'unit_id' => 38, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'YANTI HAPTIANI, S.Kep., Ners'],
            ['nip' => '20020466', 'nama_karyawan' => 'HADI KURNIAWAN, S.M', 'unit_id' => 43, 'profesi' => 'Non Medis', 'role_id' => 5, 'atasan_langsung' => 'M MAHFUD ISRO, S.E'],
            ['nip' => '20202748', 'nama_karyawan' => 'HADIN AZIZ ABDURROHMAN, S.Tr', 'unit_id' => 41, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'SOEPARNO, AMd.Perkes., S.MIK'],
            ['nip' => '20253089', 'nama_karyawan' => 'HALIMATUSSA DIYAH WIDIASTI, S.Tr.Kes', 'unit_id' => 19, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'INTAN ANANDA UTAMI, Amd OT'],
            ['nip' => '20253014', 'nama_karyawan' => 'HANIFA AZZAHRA, S.FARM., APT', 'unit_id' => 21, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.FARM, APT.'],
            ['nip' => '20101421', 'nama_karyawan' => 'HANIFAH WINIARTI, AMK', 'unit_id' => 17, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'ANASTASIA DIAN PARLINA, S.Kep., Ners'],
            ['nip' => '20101421', 'nama_karyawan' => 'HANIFAH WINIARTI, AMK', 'unit_id' => 17, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ANASTASIA DIAN PARLINA, S.KEP., NERS'],
            ['nip' => '20020431', 'nama_karyawan' => 'HERI SILVIA, AMK', 'unit_id' => 18, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'LESTARI RUMIYANI, S.KEP., NS'],
            ['nip' => '20061012', 'nama_karyawan' => 'HILDA NEVIKAYATI, AMK', 'unit_id' => 18, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'LESTARI RUMIYANI, S.KEP., NS'],
            ['nip' => '20242935', 'nama_karyawan' => 'HUSNUL FUADAH, S. KEP., NERS', 'unit_id' => 16, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YANTI HAPTIANI, S.KEP., NERS'],
            ['nip' => '20242944', 'nama_karyawan' => 'IDA ROSIDA, S. KEP., NERS', 'unit_id' => 38, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YANTI HAPTIANI, S.KEP., NERS'],
            ['nip' => '20212793', 'nama_karyawan' => 'I DEWA AYU YUNITA PERMATA SARI, AMD KEP', 'unit_id' => 15, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YANTI HAPTIANI, S.KEP., NERS'],
            ['nip' => '20182466', 'nama_karyawan' => 'IHAH SOLIHAH, S.TR.KEB', 'unit_id' => 7, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20071157', 'nama_karyawan' => 'IKA PURNAMASARI, AMK', 'unit_id' => 11, 'profesi' => 'MEDIS', 'role_id' => 6, 'atasan_langsung' => 'EKA SETIA WULANNINGSIH, S.KEP'],
            ['nip' => '20101510', 'nama_karyawan' => 'IMELDA GRACE CAROLINA H, DR', 'unit_id' => 32, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'MUHAMMAD ARDYANSYAH PRATAMA, DR'],
            ['nip' => '20192563', 'nama_karyawan' => 'INDAH NURHASANAH, SE', 'unit_id' => 37, 'profesi' => 'NON MEDIS', 'role_id' => 6, 'atasan_langsung' => 'REGAWA PARRIKESIT., A. MD'],
            ['nip' => '20202687', 'nama_karyawan' => 'INDAH TRIYANI', 'unit_id' => 28, 'profesi' => 'MEDIS', 'role_id' => 5, 'atasan_langsung' => 'RIA FAJARROHMI, SE'],
            ['nip' => '20172271', 'nama_karyawan' => 'INDI INDRIYANI, AMD KEP', 'unit_id' => 22, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'SAMSIAH, S.KEP., NERS'],
            ['nip' => '20253097', 'nama_karyawan' => 'INDIVI AHMAD, S.TR.FT', 'unit_id' => 29, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'INTAN ANANDA UTAMI, AMD OT'],
            ['nip' => '20212842', 'nama_karyawan' => 'INDRI NURAIDA HAMDIAH, S.KEP., NERS', 'unit_id' => 7, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20111641', 'nama_karyawan' => 'INTAN ANANDA UTAMI, AMD OT', 'unit_id' => 19, 'profesi' => 'MEDIS', 'role_id' => 5, 'atasan_langsung' => 'GARCINIA SATIVA FIZRIA SETIADI, DR, MKM'],
            ['nip' => '20253025', 'nama_karyawan' => 'INTAN INDRI ARDIYANTI., M.TR.TGM', 'unit_id' => 7, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20192598', 'nama_karyawan' => 'IRAWATI KUMALA, S.KEP., NERS', 'unit_id' => 7, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '19990369', 'nama_karyawan' => 'IRENE SRI SUMARNI, AM.KEB', 'unit_id' => 44, 'profesi' => 'MEDIS', 'role_id' => 5, 'atasan_langsung' => 'SENI MAULIDA FITALOKA, S.KEP., NS, M.KEP'],
            ['nip' => '19930060', 'nama_karyawan' => 'IWAN SETIAWAN', 'unit_id' => 39, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'EVI MINTARSIH, AMK'],
            ['nip' => '20192647', 'nama_karyawan' => 'JAMALUDIN., A. MD', 'unit_id' => 43, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'HADI KURNIAWAN, S.M'],
            ['nip' => '20172359', 'nama_karyawan' => 'KARTA WARDANA, SST.FT', 'unit_id' => 19, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'INTAN ANANDA UTAMI, AMD OT'],
            ['nip' => '19950243', 'nama_karyawan' => 'KARYANI', 'unit_id' => 8, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'ERNA SUNARNI, AMAK'],
            ['nip' => '20253096', 'nama_karyawan' => 'KEISA KAMILA, A.MD.KES', 'unit_id' => 29, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'INTAN ANANDA UTAMI, Amd OT'],
            ['nip' => '20121745', 'nama_karyawan' => 'KHAERUL ANWAR RUDDIN', 'unit_id' => 3, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'KHANZA RIRI ARISTIANI, S.Gz'],
            ['nip' => '19960217', 'nama_karyawan' => 'KHAIRUN NISA NURAKHYATI, S.Kep., Ns, MARS', 'unit_id' => 36, 'profesi' => 'Non Medis', 'role_id' => 5, 'atasan_langsung' => 'INDRA THALIB, BSN., MM'],
            ['nip' => '20192540', 'nama_karyawan' => 'KHANZA RIRI ARISTIANI, S.Gz', 'unit_id' => 3, 'profesi' => 'Medis', 'role_id' => 5, 'atasan_langsung' => 'GARCINIA SATIVA FIZRIA SETIADI, Dr, MKM'],
            ['nip' => '20040854', 'nama_karyawan' => 'KRISTIANI, AMK', 'unit_id' => 33, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '19930156', 'nama_karyawan' => 'KUSWADI', 'unit_id' => 39, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'EVI MINTARSIH, AMK'],
            ['nip' => '20071151', 'nama_karyawan' => 'LAELAH MEITARNENGSIH, AMK', 'unit_id' => 18, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'LESTARI RUMIYANI, S.Kep., Ns'],
            ['nip' => '20192617', 'nama_karyawan' => 'LALA FADLIATUS SYAHADA, A.MD', 'unit_id' => 30, 'profesi' => 'Non Medis', 'role_id' => 4, 'atasan_langsung' => 'BUDI HARTANTO'],
            ['nip' => '20091398', 'nama_karyawan' => 'LANI RAHAYU, S.Kep., Ns', 'unit_id' => 12, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'SRI YULIANI, S.Kep., Ners'],
            ['nip' => '20050986', 'nama_karyawan' => 'LAYUNG SARI, S.Kep., Ners', 'unit_id' => 22, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'SAMSIAH, S.Kep., Ners'],
            ['nip' => '20020426', 'nama_karyawan' => 'LESTARI RUMIYANI, S.Kep., Ns', 'unit_id' => 18, 'profesi' => 'Medis', 'role_id' => 5, 'atasan_langsung' => 'SENI MAULIDA FITALOKA, S.Kep., Ns, M.Kep'],
            ['nip' => '20212791', 'nama_karyawan' => 'LILIS, Amd Kep', 'unit_id' => 7, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20242969', 'nama_karyawan' => 'LILIS MELDIANI, AMD.AK', 'unit_id' => 8, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'ERNA SUNARNI, AMAK'],
            ['nip' => '20182440', 'nama_karyawan' => 'LINDA ANNISA LISDIANI, AMD KEP', 'unit_id' => 7, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20253047', 'nama_karyawan' => 'LIRA SUCI RAMADHAN', 'unit_id' => 20, 'profesi' => 'Non Medis', 'role_id' => 4, 'atasan_langsung' => 'ANDRI IFTIYOKO, SH'],
            ['nip' => '20182442', 'nama_karyawan' => 'LISNA WULAN OKTAVIA ARTANTI, S.Kep., Ners', 'unit_id' => 38, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'YANTI HAPTIANI, S.Kep., Ners'],
            ['nip' => '20202733', 'nama_karyawan' => 'LUFTI TRI WAHYUNI, AMK', 'unit_id' => 15, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'YANTI HAPTIANI, S.Kep., Ners'],
            ['nip' => '20222892', 'nama_karyawan' => 'LUKMAN HAKIM, S.Farm', 'unit_id' => 21, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.FARM, APT.'],
            ['nip' => '20253026', 'nama_karyawan' => 'LUTFIAH NUR SHADRINA', 'unit_id' => 7, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20020486', 'nama_karyawan' => 'MAMAN TASMAN', 'unit_id' => 43, 'profesi' => 'Non Medis', 'role_id' => 4, 'atasan_langsung' => 'HADI KURNIAWAN, S.M'],
            ['nip' => '20040833', 'nama_karyawan' => 'MAMAT', 'unit_id' => 9, 'profesi' => 'Non Medis', 'role_id' => 4, 'atasan_langsung' => 'ADE SASMITA, SE'],
            ['nip' => '20182500', 'nama_karyawan' => 'MARIA ULFA, AMD KEP', 'unit_id' => 15, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'YANTI HAPTIANI, S.Kep., Ners'],
            ['nip' => '20263099', 'nama_karyawan' => 'MARIA ULFA, AMD KEP', 'unit_id' => 15, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'YANTI HAPTIANI, S.Kep., Ners'],
            ['nip' => '20182502', 'nama_karyawan' => 'MARISA LENI PUTRI, AMK', 'unit_id' => 27, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'DIAN MAHDIANI, S.Kep., Ners'],
            ['nip' => '20212766', 'nama_karyawan' => 'MARNI MUNAWAROH, AMD KEP', 'unit_id' => 7, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20253010', 'nama_karyawan' => 'MARTA DWI CAHYA LESTARI, AMD.Kes (Rad)', 'unit_id' => 34, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'SEPTIAN NUGROHO, AMD.Rad'],
            ['nip' => '20202719', 'nama_karyawan' => 'MEILIA RATNAPURI, AMD KEP', 'unit_id' => 15, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'YANTI HAPTIANI, S.Kep., Ners'],
            ['nip' => '20253065', 'nama_karyawan' => 'MILA RAHMAWATI, A.MD.RMIK', 'unit_id' => 41, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'SOEPARNO, AMd.Perkes., S.MIK'],
            ['nip' => '20253094', 'nama_karyawan' => 'MIRANTI, S.Kep., Ners', 'unit_id' => 10, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'EKA SETIA WULANNINGSIH, S.Kep'],
            ['nip' => '20020458', 'nama_karyawan' => 'M MAHFUD ISRO, S.E', 'unit_id' => 43, 'profesi' => 'Non Medis', 'role_id' => 7, 'atasan_langsung' => 'METRI JULIANTI, SE'],
            ['nip' => '20212825', 'nama_karyawan' => 'MOCHAMAD RYAN DWI PRATAMA PUTRA, SE', 'unit_id' => 30, 'profesi' => 'Non Medis', 'role_id' => 4, 'atasan_langsung' => 'BUDI HARTANTO'],
            ['nip' => '20061042', 'nama_karyawan' => 'MOCH IRFAN FIRDAUS, A.MD', 'unit_id' => 26, 'profesi' => 'Non Medis', 'role_id' => 4, 'atasan_langsung' => 'RAIMOND ANDROMEGA, DR., MPH'],
            ['nip' => '20020422', 'nama_karyawan' => 'MOHAMAD DANDI KURNIAWAN, S.Tr.Kes', 'unit_id' => 29, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'INTAN ANANDA UTAMI, Amd OT'],
            ['nip' => '20020488', 'nama_karyawan' => 'MOHAMMAD PATI SIDIK', 'unit_id' => 36, 'profesi' => 'Non Medis', 'role_id' => 4, 'atasan_langsung' => 'DWI ASTUTI, S.Psi'],
            ['nip' => '20253024', 'nama_karyawan' => 'MONE RIZKI DESANDRY', 'unit_id' => 20, 'profesi' => 'Non Medis', 'role_id' => 4, 'atasan_langsung' => 'ANDRI IFTIYOKO, SH'],
            ['nip' => '20030525', 'nama_karyawan' => 'MUHAMAD OKY PATI IDRIS', 'unit_id' => 43, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'M MAHFUD ISRO, S.E'],
            ['nip' => '20172398', 'nama_karyawan' => 'MUHAMMAD ARDYANSYAH PRATAMA, DR', 'unit_id' => 32, 'profesi' => 'Medis', 'role_id' => 8, 'atasan_langsung' => 'LILI MARLIANI, DR., MARS'],
            ['nip' => '20253023', 'nama_karyawan' => 'MUHAMMAD FARHAN SETIAWAN, S.Tr.Kes', 'unit_id' => 42, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'DIAN MAHDIANI, S.Kep., Ners'],
            ['nip' => '20242963', 'nama_karyawan' => 'MUHAMMAD FHADLUL SYAHRI, A.MD.Kes', 'unit_id' => 29, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'INTAN ANANDA UTAMI, Amd OT'],
            ['nip' => '20202676', 'nama_karyawan' => 'MUHAMMAD HUSNUL KHULUQ, S.Ak', 'unit_id' => 30, 'profesi' => 'Non Medis', 'role_id' => 4, 'atasan_langsung' => 'BUDI HARTANTO'],
            ['nip' => '20172382', 'nama_karyawan' => 'MUHAMMAD LAZUARDI E, AMK', 'unit_id' => 27, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'DIAN MAHDIANI, S.Kep., Ners'],
            ['nip' => '20101450', 'nama_karyawan' => 'MUIZAR', 'unit_id' => 9, 'profesi' => 'Non Medis', 'role_id' => 6, 'atasan_langsung' => 'ADE SASMITA, SE'],
            ['nip' => '20182443', 'nama_karyawan' => 'MUKHFI, AMD OT', 'unit_id' => 19, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'INTAN ANANDA UTAMI, Amd OT'],
            ['nip' => '20202746', 'nama_karyawan' => 'MULTAZAM SIDDIQ S, AMd Kes', 'unit_id' => 34, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'SEPTIAN NUGROHO, AMD.Rad'],
            ['nip' => '20222877', 'nama_karyawan' => 'MUTIARA AULIYAH SAFITRI, S.Kep., Ners', 'unit_id' => 18, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'LESTARI RUMIYANI, S.Kep., Ns'],
            ['nip' => '19990365', 'nama_karyawan' => 'MUTIARA MARDIJJAH, S.I.Kom', 'unit_id' => 20, 'profesi' => 'Non Medis', 'role_id' => 4, 'atasan_langsung' => 'TUMPAS BANGKIT PRAYUDA, SE'],
            ['nip' => '20222885', 'nama_karyawan' => 'NADIA RIZKIANA PUTRI, S.Tr.Kes', 'unit_id' => 29, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'INTAN ANANDA UTAMI, Amd OT'],
            ['nip' => '20242977', 'nama_karyawan' => 'NADILAH DWITA LESTARI, AMD.Kes', 'unit_id' => 7, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20242953', 'nama_karyawan' => 'NENENG NURJANAH, Amd TW', 'unit_id' => 19, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'INTAN ANANDA UTAMI, Amd OT'],
            ['nip' => '20253076', 'nama_karyawan' => 'NGAKIF MUZAHID, AMD.T', 'unit_id' => 6, 'profesi' => 'Non Medis', 'role_id' => 4, 'atasan_langsung' => 'ALFIAN KURNIAWAN'],
            ['nip' => '20081255', 'nama_karyawan' => 'NIA TRY RAHAYU AGUSTINI, AMK', 'unit_id' => 11, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'EKA SETIA WULANNINGSIH, S.Kep'],
            ['nip' => '20242950', 'nama_karyawan' => 'NIDA KHAIRUNNISA, S.Tr.Ds', 'unit_id' => 20, 'profesi' => 'Non Medis', 'role_id' => 4, 'atasan_langsung' => 'ANDRI IFTIYOKO, SH'],
            ['nip' => '20040752', 'nama_karyawan' => 'N. IDA LAELA RUBIANTI, AMK', 'unit_id' => 49, 'profesi' => 'Medis', 'role_id' => 5, 'atasan_langsung' => 'TETRIARIN CH. DARMO, AMK'],
            ['nip' => '20202721', 'nama_karyawan' => 'NIDA USSA’ADAH, AMD KEP', 'unit_id' => 17, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'ANASTASIA DIAN PARLINA, S.Kep., Ners'],
            ['nip' => '20202709', 'nama_karyawan' => 'NOVI EKA ANDRIYANI, S.FARM., APT', 'unit_id' => 21, 'profesi' => 'Medis', 'role_id' => 6, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.FARM, APT.'],
            ['nip' => '20192621', 'nama_karyawan' => 'NOVI YANTI, A.MD', 'unit_id' => 43, 'profesi' => 'Non Medis', 'role_id' => 4, 'atasan_langsung' => 'M MAHFUD ISRO, S.E'],
            ['nip' => '20253092', 'nama_karyawan' => 'NURABILLA MAHARANI CAYADEWI, S.Tr.Kep., Ners', 'unit_id' => 13, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'SRI YULIANI, S.Kep., Ners'],
            ['nip' => '20253063', 'nama_karyawan' => 'NUR HALIMAH NASUTION, S.Kep., Ners', 'unit_id' => 10, 'profesi' => 'Medis', 'role_id' => 4, 'atasan_langsung' => 'EKA SETIA WULANNINGSIH, S.Kep'],
            ['nip' => '20030567', 'nama_karyawan' => 'NURHASAN', 'unit_id' => 31, 'profesi' => 'Non Medis', 'role_id' => 4, 'atasan_langsung' => 'ALFIAN KURNIAWAN'],
            ['nip' => '20050944', 'nama_karyawan' => 'NURHASANAH, AMD TW', 'unit_id' => 19, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'INTAN ANANDA UTAMI, AMD OT'],
            ['nip' => '20253011', 'nama_karyawan' => 'NURIKA IRFIYANI., AMD. TLM', 'unit_id' => 8, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ERNA SUNARNI, AMAK'],
            ['nip' => '20242954', 'nama_karyawan' => 'NURI NUR PADILAH, S. KEP., NERS', 'unit_id' => 16, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YANTI HAPTIANI, S.KEP., NERS'],
            ['nip' => '20202735', 'nama_karyawan' => 'NURJANAH, AMKEB', 'unit_id' => 44, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'IRENE SRI SUMARNI, AM.KEB'],
            ['nip' => '20081216', 'nama_karyawan' => 'NURLELA, AMD TW', 'unit_id' => 19, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'INTAN ANANDA UTAMI, AMD OT'],
            ['nip' => '20253082', 'nama_karyawan' => 'NUR RAVICA APRILIA, S. KEP., NERS', 'unit_id' => 13, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'SRI YULIANI, S.KEP., NERS'],
            ['nip' => '20081292', 'nama_karyawan' => 'NUR ULFA DEWI, AMK', 'unit_id' => 18, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'LESTARI RUMIYANI, S.KEP., NS'],
            ['nip' => '20212777', 'nama_karyawan' => 'NURUL INDRIYANI, A MD. KEP', 'unit_id' => 16, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YANTI HAPTIANI, S.KEP., NERS'],
            ['nip' => '20202711', 'nama_karyawan' => 'NURUL SOBAH, AMD. FARM', 'unit_id' => 21, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.FARM, APT.'],
            ['nip' => '20242939', 'nama_karyawan' => 'OPI DAMAHYANTI, S.FARM., APT', 'unit_id' => 21, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.FARM, APT.'],
            ['nip' => '20253081', 'nama_karyawan' => 'PAHLEVI MARVELINO SIBORUTOROP., DR', 'unit_id' => 32, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'MUHAMMAD ARDYANSYAH PRATAMA, DR'],
            ['nip' => '20202686', 'nama_karyawan' => 'PANJI MARIJAN FIRDAUS, S.FARM', 'unit_id' => 21, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.FARM, APT.'],
            ['nip' => '20242938', 'nama_karyawan' => 'PARIDA PEBRUANTI, S. KEP., NERS', 'unit_id' => 18, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'LESTARI RUMIYANI, S.KEP., NS'],
            ['nip' => '20050919', 'nama_karyawan' => 'PATRICIA LUMINDA BATUBARA, DR', 'unit_id' => 32, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'MUHAMMAD ARDYANSYAH PRATAMA, DR'],
            ['nip' => '20253037', 'nama_karyawan' => 'PINA HARYANTI., AMD.FARM', 'unit_id' => 21, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.FARM, APT.'],
            ['nip' => '20061051', 'nama_karyawan' => 'PUJI ASTUTI, AMK', 'unit_id' => 49, 'profesi' => 'MEDIS', 'role_id' => 5, 'atasan_langsung' => 'TETRIARIN CH. DARMO, AMK'],
            ['nip' => '20202745', 'nama_karyawan' => 'PUTRY SUSILOWATI, AM.KEB', 'unit_id' => 7, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20202689', 'nama_karyawan' => 'QORI FADILAH, SST', 'unit_id' => 44, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'IRENE SRI SUMARNI, AM.KEB'],
            ['nip' => '20222900', 'nama_karyawan' => 'RACHEL JIHAN KAMILA, S.M', 'unit_id' => 30, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'BUDI HARTANTO'],
            ['nip' => '20253032', 'nama_karyawan' => 'RAFIKA ZAHRA, S.KEP., NERS', 'unit_id' => 10, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'EKA SETIA WULANNINGSIH, S.KEP'],
            ['nip' => '20253051', 'nama_karyawan' => 'RAHAYU AFIAH SURUR, DR', 'unit_id' => 45, 'profesi' => 'NON MEDIS', 'role_id' => 8, 'atasan_langsung' => 'LILI MARLIANI, DR., MARS'],
            ['nip' => '20253064', 'nama_karyawan' => 'RAHAYU PUSPAWANDARI, DR', 'unit_id' => 32, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'MUHAMMAD ARDYANSYAH PRATAMA, DR'],
            ['nip' => '20253086', 'nama_karyawan' => 'RAIMOND ANDROMEGA, DR., M.P.H', 'unit_id' => 26, 'profesi' => 'NON MEDIS', 'role_id' => 9, 'atasan_langsung' => 'LILI MARLIANI, DR., MARS'],
            ['nip' => '20253058', 'nama_karyawan' => 'RAKEUN MAYANG MUTIARA, S.FARM', 'unit_id' => 21, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.FARM, APT.'],
            ['nip' => '20212773', 'nama_karyawan' => 'RANDILUFTI SANTOSO, DR', 'unit_id' => 32, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'MUHAMMAD ARDYANSYAH PRATAMA, DR'],
            ['nip' => '20192558', 'nama_karyawan' => 'RANTI AGUSTIANI, AMD KEP', 'unit_id' => 17, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ANASTASIA DIAN PARLINA, S.KEP., NERS'],
            ['nip' => '20192618', 'nama_karyawan' => 'RARAS OCVERTYA., A. MD', 'unit_id' => 37, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'REGAWA PARRIKESIT., A. MD'],
            ['nip' => '20091320', 'nama_karyawan' => 'RATNA NURHAYATI, AMK', 'unit_id' => 22, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'SAMSIAH, S.KEP., NERS'],
            ['nip' => '20212788', 'nama_karyawan' => 'RATNA PURI, AMD KEP', 'unit_id' => 13, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'SRI YULIANI, S.KEP., NERS'],
            ['nip' => '20192541', 'nama_karyawan' => 'RATU SELPI CAHYANTI, AMD AK', 'unit_id' => 8, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ERNA SUNARNI, AMAK'],
            ['nip' => '20192650', 'nama_karyawan' => 'REGAWA PARRIKESIT., A. MD', 'unit_id' => 37, 'profesi' => 'NON MEDIS', 'role_id' => 5, 'atasan_langsung' => 'TUMPAS BANGKIT PRAYUDA., SE'],
            ['nip' => '20192561', 'nama_karyawan' => 'RENA FARHAH, AMD KEP', 'unit_id' => 7, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20040674', 'nama_karyawan' => 'RENI CAHYANTI, AM.KEB', 'unit_id' => 44, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'IRENE SRI SUMARNI, AM.KEB'],
            ['nip' => '20081172', 'nama_karyawan' => 'RENY MULYASARI, AMK', 'unit_id' => 14, 'profesi' => 'MEDIS', 'role_id' => 6, 'atasan_langsung' => 'SRI YULIANI, S.KEP., NERS'],
            ['nip' => '20202755', 'nama_karyawan' => 'RESTI FEBRIYANTI, AMD KES', 'unit_id' => 8, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ERNA SUNARNI, AMAK'],
            ['nip' => '20020417', 'nama_karyawan' => 'RETNA RAHAYUNINGSIH, AM.KEB', 'unit_id' => 44, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'IRENE SRI SUMARNI, AM.KEB'],
            ['nip' => '20172355', 'nama_karyawan' => 'RHISMA HILDA PRAWITA, STR. KL', 'unit_id' => 46, 'profesi' => 'NON MEDIS', 'role_id' => 6, 'atasan_langsung' => 'ADE IRPAN, SKM'],
            ['nip' => '20222898', 'nama_karyawan' => 'RICKY ADI PRATAMA, S.M', 'unit_id' => 30, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'BUDI HARTANTO'],
            ['nip' => '20202677', 'nama_karyawan' => 'RIKA RAMDAYANTI, S.M', 'unit_id' => 40, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'RIA FAJARROHMI, SE'],
            ['nip' => '20182412', 'nama_karyawan' => 'RINA AYU APRILIANTI, AMD AK', 'unit_id' => 8, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ERNA SUNARNI, AMAK'],
            ['nip' => '20172252', 'nama_karyawan' => 'RINA REDAWATI, AM.KEB', 'unit_id' => 7, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20253061', 'nama_karyawan' => 'RINDI KOMALASARI, S.KEP., NERS', 'unit_id' => 18, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'LESTARI RUMIYANI, S.KEP., NS'],
            ['nip' => '20081313', 'nama_karyawan' => 'RISANTI MARYONO, S.KEP., NERS', 'unit_id' => 18, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'LESTARI RUMIYANI, S.KEP., NS'],
            ['nip' => '20253012', 'nama_karyawan' => 'RISA NUR FADILLA., S. TR. KES', 'unit_id' => 8, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ERNA SUNARNI, AMAK'],
            ['nip' => '20040741', 'nama_karyawan' => 'RITA FITRIANI, AMKG', 'unit_id' => 7, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20040827', 'nama_karyawan' => 'RIZA SUKMA SARI, AMD', 'unit_id' => 21, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.FARM, APT.'],
            ['nip' => '20172374', 'nama_karyawan' => 'RIZKI WICAKSONO, DR', 'unit_id' => 32, 'profesi' => 'MEDIS', 'role_id' => 6, 'atasan_langsung' => 'MUHAMMAD ARDYANSYAH PRATAMA, DR'],
            ['nip' => '19960285', 'nama_karyawan' => 'R. MAMAT HERMANSYAH, S.TR.KES', 'unit_id' => 29, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'INTAN ANANDA UTAMI, AMD OT'],
            ['nip' => '20182431', 'nama_karyawan' => 'ROKA MALLA, AMD FT', 'unit_id' => 19, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'INTAN ANANDA UTAMI, AMD OT'],
            ['nip' => '20020428', 'nama_karyawan' => 'ROSALIA BR. PURBA, S. KEP., NS', 'unit_id' => 7, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '19940117', 'nama_karyawan' => 'RUSLI', 'unit_id' => 47, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'RIYADI MAULANA, SH., MH., CLA., CCD'],
            ['nip' => '20232920', 'nama_karyawan' => 'RYAN KHUNAM ALAMHARI, S. FARM', 'unit_id' => 21, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.FARM, APT.'],
            ['nip' => '20222887', 'nama_karyawan' => 'SAHILA RIZKIA, AMD GZ', 'unit_id' => 3, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'KHANZA RIRI ARISTIANI, S.GZ'],
            ['nip' => '20242980', 'nama_karyawan' => 'SAINT RYALIN FIRDAUS, AMD. KEB', 'unit_id' => 44, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'IRENE SRI SUMARNI, AM.KEB'],
            ['nip' => '20253055', 'nama_karyawan' => 'SALMA AHSANIAWATI, S.KEP., NERS', 'unit_id' => 12, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'SRI YULIANI, S.KEP., NERS'],
            ['nip' => '20253056', 'nama_karyawan' => 'SALSABILLA AULIA JATMIKO, S. TR. KEP., NERS', 'unit_id' => 18, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'LESTARI RUMIYANI, S.KEP., NS'],
            ['nip' => '20020434', 'nama_karyawan' => 'SAMSIAH, S.KEP., NERS', 'unit_id' => 22, 'profesi' => 'MEDIS', 'role_id' => 5, 'atasan_langsung' => 'SENI MAULIDA FITALOKA, S.KEP., NS, M.KEP'],
            ['nip' => '20040801', 'nama_karyawan' => 'SAMSON FEMI EFFENDI', 'unit_id' => 48, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ADE IRPAN, SKM'],
            ['nip' => '20212763', 'nama_karyawan' => 'SANDY PERMANA', 'unit_id' => 30, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'BUDI HARTANTO'],
            ['nip' => '20040754', 'nama_karyawan' => 'SANI INDRAYANA, AMAK', 'unit_id' => 8, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ERNA SUNARNI, AMAK'],
            ['nip' => '19950207', 'nama_karyawan' => 'SARI ROHATI, AMK', 'unit_id' => 33, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20111609', 'nama_karyawan' => 'SARSILAH, S.KEP., NERS', 'unit_id' => 17, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ANASTASIA DIAN PARLINA, S.KEP., NERS'],
            ['nip' => '20253079', 'nama_karyawan' => 'SATRIO GILANG PRATAMA, S.KEP., NERS', 'unit_id' => 12, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'SRI YULIANI, S.KEP., NERS'],
            ['nip' => '20192583', 'nama_karyawan' => 'SEKAR AYU WULANDARI, AMD KEP', 'unit_id' => 16, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YANTI HAPTIANI, S.KEP., NERS'],
            ['nip' => '20202685', 'nama_karyawan' => 'SELLY LESTIANA, S.SI., APT', 'unit_id' => 21, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.FARM, APT'],
            ['nip' => '20202694', 'nama_karyawan' => 'SENY SETIAWANTI, AMD KEP', 'unit_id' => 17, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ANASTASIA DIAN PARLINA, S.KEP., NERS'],
            ['nip' => '20091380', 'nama_karyawan' => 'SEPTIAN NUGROHO, AMD. RAD', 'unit_id' => 34, 'profesi' => 'MEDIS', 'role_id' => 5, 'atasan_langsung' => 'GARCINIA SATIVA FIZRIA SETIADI, DR., MKM'],
            ['nip' => '20253029', 'nama_karyawan' => 'SETIADI, DR', 'unit_id' => 32, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'MUHAMMAD ARDYANSYAH PRATAMA, DR'],
            ['nip' => '20222846', 'nama_karyawan' => 'SHINTA KUSUMA WARDANI, S.KEP., NERS', 'unit_id' => 15, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YANTI HAPTIANI, S.KEP., NERS'],
            ['nip' => '20192557', 'nama_karyawan' => 'SINTIA RESTU DEVI, AMD KEP', 'unit_id' => 7, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20253048', 'nama_karyawan' => 'SISCA AMALIAH', 'unit_id' => 26, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'RAIMOND ANDROMEGA, DR., M.P.H'],
            ['nip' => '20202712', 'nama_karyawan' => 'SISCHA, S. FARM', 'unit_id' => 21, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.FARM, APT'],
            ['nip' => '20232918', 'nama_karyawan' => 'SITA AISAH ANGGITA, S. SOS', 'unit_id' => 20, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ANDRI IFTIYOKO, SH'],
            ['nip' => '20040852', 'nama_karyawan' => 'SITAH UMU HAKIM, AMK', 'unit_id' => 50, 'profesi' => 'MEDIS', 'role_id' => 5, 'atasan_langsung' => 'SENI MAULIDA FITALOKA, S.KEP., NERS, M.KEP'],
            ['nip' => '20182495', 'nama_karyawan' => 'SITI NUR HIDAYAH, AMD KEP', 'unit_id' => 13, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'SRI YULIANI, S.KEP., NERS'],
            ['nip' => '20242931', 'nama_karyawan' => 'SITI NURMILAH, S.KEP., NERS', 'unit_id' => 15, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YANTI HAPTIANI, S.KEP., NERS'],
            ['nip' => '20253067', 'nama_karyawan' => 'SITI SARI WULANDARI, S.KEP., NERS', 'unit_id' => 7, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20222881', 'nama_karyawan' => 'SOBUR SETIAWAN, S.KEP., NERS', 'unit_id' => 14, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'SRI YULIANI, S.KEP., NERS'],
            ['nip' => '20040795', 'nama_karyawan' => 'SOEPARNO, AMD.PERKES., S.MIK', 'unit_id' => 41, 'profesi' => 'MEDIS', 'role_id' => 5, 'atasan_langsung' => 'GARCINIA SATIVA FIZRIA SETIADI, DR., MKM'],
            ['nip' => '20192624', 'nama_karyawan' => 'SRI ANNISA NURAENI, AMK', 'unit_id' => 13, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'SRI YULIANI, S.KEP., NERS'],
            ['nip' => '20121748', 'nama_karyawan' => 'SRI FATMIANI, AMD', 'unit_id' => 3, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'KHANZA RIRI ARISTIANI, S.GZ'],
            ['nip' => '20212765', 'nama_karyawan' => 'SRI LESTARI DAMAYANTI, S.KEP., NERS', 'unit_id' => 13, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'SRI YULIANI, S.KEP., NERS'],
            ['nip' => '20172357', 'nama_karyawan' => 'SRI NURHAYATI, AMAK', 'unit_id' => 8, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ERNA SUNARNI, AMAK'],
            ['nip' => '20162170', 'nama_karyawan' => 'SRI WAHYULI, A. MD', 'unit_id' => 30, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'BUDI HARTANTO'],
            ['nip' => '20101419', 'nama_karyawan' => 'SRI YULIANI, S.KEP., NERS', 'unit_id' => 12, 'profesi' => 'MEDIS', 'role_id' => 5, 'atasan_langsung' => 'SENI MAULIDA FITALOKA, S.KEP., NERS, M.KEP'],
            ['nip' => '19960284', 'nama_karyawan' => 'SUGIONO', 'unit_id' => 51, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ADE IRPAN, SKM'],
            ['nip' => '20253042', 'nama_karyawan' => 'SUHAERIYAH, S.FARM', 'unit_id' => 21, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.FARM, APT'],
            ['nip' => '20253080', 'nama_karyawan' => 'SUHERMAN, S.KEP', 'unit_id' => 27, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'DIAN MAHDIANI, S.KEP., NERS'],
            ['nip' => '20212834', 'nama_karyawan' => 'SUMAYYAH FITRI KARIMAH, AMD KEB', 'unit_id' => 44, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'IRENE SRI SUMARNI, AM.KEB'],
            ['nip' => '19950219', 'nama_karyawan' => 'SUNARDI', 'unit_id' => 51, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ADE IRPAN, SKM'],
            ['nip' => '19950176', 'nama_karyawan' => 'SUPADMI, AMAK', 'unit_id' => 8, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ERNA SUNARNI, AMAK'],
            ['nip' => '20192616', 'nama_karyawan' => 'SURYADI, SE', 'unit_id' => 43, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'HADI KURNIAWAN, S.M'],
            ['nip' => '20121845', 'nama_karyawan' => 'SYAIDA ROHMANI, AMD FT', 'unit_id' => 29, 'profesi' => 'MEDIS', 'role_id' => 6, 'atasan_langsung' => 'INTAN ANANDA UTAMI, AMD OT'],
            ['nip' => '20202682', 'nama_karyawan' => 'TANTI NURIYANTI, S.KEP', 'unit_id' => 27, 'profesi' => 'MEDIS', 'role_id' => 6, 'atasan_langsung' => 'DIAN MAHDIANI, S.KEP., NERS'],
            ['nip' => '20162109', 'nama_karyawan' => 'TANTY HERDIYANI, DR. SP.PK', 'unit_id' => 8, 'profesi' => 'MEDIS', 'role_id' => 10, 'atasan_langsung' => 'GARCINIA SATIVA FIZRIA SETIADI, DR., MKM'],
            ['nip' => '20232926', 'nama_karyawan' => 'TARY SHINTYA SOPANDI, S. PD', 'unit_id' => 40, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'RIA FAJARROHMI, SE'],
            ['nip' => '20242970', 'nama_karyawan' => 'TASYA PUTRI OKTAVIA, AMD AK', 'unit_id' => 8, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ERNA SUNARNI, AMAK'],
            ['nip' => '19970291', 'nama_karyawan' => 'TETRIARIN CH. DARMO, AMK', 'unit_id' => 49, 'profesi' => 'MEDIS', 'role_id' => 5, 'atasan_langsung' => 'IRMA RISMAYANTY, DR., MM'],
            ['nip' => '19950116', 'nama_karyawan' => 'TITA ANGGANA PUSPA', 'unit_id' => 20, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'TUMPAS BANGKIT PRAYUDA, SE'],
            ['nip' => '20101451', 'nama_karyawan' => 'TRI ARYANI, A. MD', 'unit_id' => 37, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'REGAWA PARRIKESIT, A. MD'],
            ['nip' => '20061048', 'nama_karyawan' => 'TRI AYU AMALIA, A. MD', 'unit_id' => 40, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'RIA FAJARROHMI, SE'],
            ['nip' => '20111631', 'nama_karyawan' => 'TRISNA UMBARA PRIASMARA, A. MD', 'unit_id' => 37, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'REGAWA PARRIKESIT, A. MD'],
            ['nip' => '20071128', 'nama_karyawan' => 'UJANG RUKMA', 'unit_id' => 31, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ALFIAN KURNIAWAN'],
            ['nip' => '20242967', 'nama_karyawan' => 'ULPATUL MILLAH, S. FARM., APT', 'unit_id' => 21, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.FARM, APT'],
            ['nip' => '20222886', 'nama_karyawan' => 'UMAR BAIDHOWI, S. KOM', 'unit_id' => 23, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'MUHAMAD MIFTAHUDIN, M. KOM'],
            ['nip' => '20252995', 'nama_karyawan' => 'VERAWATY, M. FARM., APT', 'unit_id' => 21, 'profesi' => 'MEDIS', 'role_id' => 6, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.FARM, APT'],
            ['nip' => '20253013', 'nama_karyawan' => 'VIDYAZAHRA ARASHA DEDI, A.MD. AK', 'unit_id' => 8, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ERNA SUNARNI, AMAK'],
            ['nip' => '20212775', 'nama_karyawan' => 'VIVI AHMALIA, S.KEP., NERS', 'unit_id' => 10, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'EKA SETIA WULANNINGSIH, S.KEP'],
            ['nip' => '20040809', 'nama_karyawan' => 'WAWAN PURWANTO, S. KOM', 'unit_id' => 37, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'REGAWA PARRIKESIT, A. MD'],
            ['nip' => '20172383', 'nama_karyawan' => 'WIDA KARANTINA, AMK', 'unit_id' => 15, 'profesi' => 'MEDIS', 'role_id' => 6, 'atasan_langsung' => 'YANTI HAPTIANI, S.KEP., NERS'],
            ['nip' => '20050985', 'nama_karyawan' => 'WIDIAWATI, S.KEP., NERS', 'unit_id' => 17, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ANASTASIA DIAN PARLINA, S.KEP., NERS'],
            ['nip' => '20212778', 'nama_karyawan' => 'WIDYA OKTAVYANA, A.MD. KEP', 'unit_id' => 38, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YANTI HAPTIANI, S.KEP., NERS'],
            ['nip' => '19960267', 'nama_karyawan' => 'WIJIL RUMANTINI, AMD RAD', 'unit_id' => 34, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'SEPTIAN NUGROHO, AMD. RAD'],
            ['nip' => '20172348', 'nama_karyawan' => 'WINA NATA PUTRI, S.KEP., NERS', 'unit_id' => 22, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'SAMSIAH, S.KEP., NERS'],
            ['nip' => '20212772', 'nama_karyawan' => 'WISESA NANDIWARDHANA, DR', 'unit_id' => 32, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'MUHAMMAD ARDYANSYAH PRATAMA, DR'],
            ['nip' => '20253046', 'nama_karyawan' => 'WISNA MERIZKY, DR', 'unit_id' => 32, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'MUHAMMAD ARDYANSYAH PRATAMA, DR'],
            ['nip' => '20111698', 'nama_karyawan' => 'WITA ROSTANIA, DR., SP.A', 'unit_id' => 7, 'profesi' => 'MEDIS', 'role_id' => 10, 'atasan_langsung' => 'RAHAYU AFIAH SURUR, DR'],
            ['nip' => '20172347', 'nama_karyawan' => 'WULAN SARI, AMK', 'unit_id' => 16, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YANTI HAPTIANI, S.KEP., NERS'],
            ['nip' => '20131904', 'nama_karyawan' => 'YANA HERMAWAN, SE', 'unit_id' => 30, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'BUDI HARTANTO'],
            ['nip' => '19980340', 'nama_karyawan' => 'YANTI HAPTIANI, S.KEP., NERS', 'unit_id' => 15, 'profesi' => 'MEDIS', 'role_id' => 5, 'atasan_langsung' => 'SENI MAULIDA FITALOKA, S.KEP., NERS, M.KEP'],
            ['nip' => '20253083', 'nama_karyawan' => 'YENIMANDEZA PUTRY, S.KEP., NERS', 'unit_id' => 10, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'EKA SETIA WULANNINGSIH, S.KEP'],
            ['nip' => '20061036', 'nama_karyawan' => 'YENI ROHENDA, AMK', 'unit_id' => 17, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ANASTASIA DIAN PARLINA, S.KEP., NERS'],
            ['nip' => '20050891', 'nama_karyawan' => 'YENI YULIA, AMK', 'unit_id' => 10, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'EKA SETIA WULANNINGSIH, S.KEP'],
            ['nip' => '20253057', 'nama_karyawan' => 'YOGI, S.FARM', 'unit_id' => 21, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ELFA DIAN AGUSTINA, S.FARM, APT'],
            ['nip' => '20081310', 'nama_karyawan' => 'YOSE SLAMET SAPUTRA, SE', 'unit_id' => 43, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'M MAHFUD ISRO, S.E'],
            ['nip' => '20050927', 'nama_karyawan' => 'YULIANA, AMK', 'unit_id' => 7, 'profesi' => 'MEDIS', 'role_id' => 5, 'atasan_langsung' => 'SENI MAULIDA FITALOKA, S.KEP., NERS, M.KEP'],
            ['nip' => '20242966', 'nama_karyawan' => 'YULISA FADHILLAH, S.TR. DS', 'unit_id' => 20, 'profesi' => 'NON MEDIS', 'role_id' => 4, 'atasan_langsung' => 'ANDRI IFTIYOKO, SH'],
            ['nip' => '20081267', 'nama_karyawan' => 'YULITA DIAN LESTARI, AM.KEB', 'unit_id' => 44, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'IRENE SRI SUMARNI, AM.KEB'],
            ['nip' => '20253075', 'nama_karyawan' => 'YUNITA SARI, S.KEP., NERS', 'unit_id' => 7, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YULIANA, AMK'],
            ['nip' => '20222879', 'nama_karyawan' => 'YUSTIKA DAMAYANTI, S.KEP., NERS', 'unit_id' => 14, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'SRI YULIANI, S.KEP., NERS'],
            ['nip' => '20101418', 'nama_karyawan' => 'YUYUN POMADINI, AMK', 'unit_id' => 38, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'YANTI HAPTIANI, S.KEP., NERS'],
            ['nip' => '20253098', 'nama_karyawan' => 'ZALLITA SAKTYA HARARI, A.MD. RAD', 'unit_id' => 34, 'profesi' => 'MEDIS', 'role_id' => 4, 'atasan_langsung' => 'SEPTIAN NUGROHO, AMD. RAD'],
        ];


        $allKaryawan = array_merge($dataManagement, $dataStaff);
        $processedNips = [];

        foreach ($allKaryawan as $karyawan) {
            $nip = $karyawan['nip'];

            // Skip duplicates by NIP
            if (!empty($nip) && in_array($nip, $processedNips)) {
                continue;
            }
            if (!empty($nip)) {
                $processedNips[] = $nip;
            }

            // Mencegah error jika data nama kosong
            if (empty($karyawan['nama_karyawan'])) {
                continue;
            }

            $namaLengkap = $karyawan['nama_karyawan'];

            // Normalize Profesi to match Enum ['Medis', 'Non Medis']
            $profesiRaw = strtolower($karyawan['profesi'] ?? '');
            $profesi = null;
            if (strpos($profesiRaw, 'non') !== false) {
                $profesi = 'Non Medis';
            } else if (strpos($profesiRaw, 'medis') !== false) {
                $profesi = 'Medis';
            }

            // 1. LOGIC USERNAME (Kata pertama . Kata kedua dalam format huruf kecil tanpa koma/kredit gelar)
            // Hilangkan tanda baca yang sering muncul di nama dan gelar (, . dll) supaya split kata bersih
            $cleanName = preg_replace('/[,.]/', ' ', $namaLengkap); // jadikan spasi
            $words = array_values(array_filter(explode(' ', trim($cleanName))));

            $firstName = strtolower($words[0] ?? 'user');
            $secondName = isset($words[1]) ? '.' . strtolower($words[1]) : '';

            $username = $firstName . $secondName;

            // Pastikan username unik sebelum distore (antisipasi jika ada 2 orang bernama sama misal Budi.Santoso)
            $originalUsername = $username;
            $counter = 1;
            while (User::where('username', $username)->exists()) {
                $username = $originalUsername . $counter;
                $counter++;
            }

            // 2. EMAIL (Sistem laravel butuh email unik)
            $email = $username . '@rsazra.co.id';

            // 3. LOGIC PASSWORD TANPA UBAH DATABASE
            // Jadikan "rsazra" sebagai Default Password
            $passwordToHash = 'rsazra';
            $password = Hash::make($passwordToHash);

            User::updateOrCreate(
                ['username' => $username], // kondisi supaya tidak dobel dibrun ulang
                [
                    'nama_lengkap' => $namaLengkap,
                    'nip' => $nip ?: null,
                    'email' => $email,
                    'password' => $password,
                    'role_id' => $karyawan['role_id'],
                    'unit_id' => $karyawan['unit_id'],
                    'profesi' => $profesi,
                    'atasan_langsung' => $karyawan['atasan_langsung'],
                    'status_user' => 'aktif',
                ]
            );
        }

        $this->command->info("Seeder Karyawan berhasil dijalankan!");
    }
}