<?php

function replaceInDir($dir) {
    if (!is_dir($dir)) return;
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        if (is_dir($path)) {
            replaceInDir($path);
        } else {
            if (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
                $content = file_get_contents($path);
                
                $replacements = [
                    'IndikatorMutu' => 'spm',
                    "route('master-indikator" => "route('master-spm",
                    "route('laporan-analis" => "route('laporan-spm",
                    "route('analisa-data" => "route('analisa-spm",
                    'indikator_id' => 'spm_id',
                    'indikators' => 'spms',
                    '$indikator' => '$spm',
                    'nama_indikator' => 'nama_spm',
                    'target_indikator' => 'target_spm',
                    'status_indikator' => 'status_spm',
                    'Indikator Mutu' => 'SPM',
                    'Master Indikator' => 'Master SPM',
                    'Pengisian Indikator' => 'Pengisian SPM',
                    'Analisa Indikator' => 'Analisa SPM',
                    'Data Indikator Laporan' => 'Data SPM Laporan',
                    'INDIKATOR' => 'SPM',
                    '$selectedIndikatorId' => '$selectedSpmId',
                    '$selectedIndikator' => '$selectedSpm',
                    'firstIndikator' => 'firstSpm',
                    'kategori_indikator' => 'kategori_spm',
                    'master-indikator' => 'master-spm',
                    "laporan-analis" => "laporan-spm",
                    "analisa-data" => "analisa-spm",
                    "Data Indikator" => "Data SPM",
                    "Indikator" => "SPM",
                    "indikator" => "spm",
                ];

                foreach ($replacements as $search => $replace) {
                    $content = str_replace($search, $replace, $content);
                }

                file_put_contents($path, $content);
            }
        }
    }
}

replaceInDir(__DIR__ . '/resources/views/menu/spm');
echo "Replacement complete.";
