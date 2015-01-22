<?php

use DataDikdas\Model as M;
use Symfony\Component\HttpFoundation\Request;

$app = require_once __DIR__ . '/bootstrap.php';

// Index --> test by http://silex/
$app->get('/', function (Request $request) use ($app) {
    // if (@!$_SESSION["username"]) {
	if ($app['session']->get('user') && $app['session']->get('sekolah')){
	    return $app['twig']->render('main.php', array(
	        'error' => $app['security.last_error']($request),
	        'last_username' => $app['session']->get('_security.last_username'),
	        'haha' => 'foo'
	    ));
    } else {
	    return $app['twig']->render('login.html', array(
	        'error' => $app['security.last_error']($request),
	        'last_username' => $app['session']->get('_security.last_username'),
	        'haha' => 'foo'
	    ));
    }	
})->bind('homepage');

// Info Generation
$app->get('/InfoGen/{overwrite}', 'DataDikdas\Util\InfoGen::generate');
$app->get('/InfoGen', 'DataDikdas\Util\InfoGen::generate');

// Unit Test Generation 
$app->get('/TestGen', 'DataDikdas\Util\TestGen::generate');
$app->get('/TestGenSingle', 'DataDikdas\Util\TestGen::singleTest');

// Models Generation
$app->get('/ModelGen', 'DataDikdas\Util\ModelGen::generate');

// Frontend Generation
$app->get('/FrontEndGen/test', 'DataDikdas\Util\FrontEndGen::test');
$app->get('/FrontEndGen/{overwrite}', 'DataDikdas\Util\FrontEndGen::generate');
$app->get('/FrontEndGen', 'DataDikdas\Util\FrontEndGen::generate');
$app->get('/PrintGen', 'DataDikdas\Util\PrintGen::generate');

// Menu
$app->get('/Menu', 'DataDikdas\Util\Menu::write');

// Buat Test Menu
$app->get('/TestFk', 'DataDikdas\Util\TestFk::doTest');
$app->get('/runEksekusiRombel', 'DataDikdas\CustomRest::runEksekusiRombel');

// Harusnya memakai rest tapi dicegat
$app->get('/rest/PtkTerdaftar', 'DataDikdas\CustomRest::getPtkTerdaftar');
$app->get('/rest/Ptk', 'DataDikdas\CustomRest::getPtk');
// $app->get('/rest/PesertaDidikBaru', 'DataDikdas\CustomRest::getPesertaDidikBaru');
// $app->get('/rest/PtkBaru', 'DataDikdas\CustomRest::getPtkBaru');
$app->get('/rest/NilaiRapor', 'DataDikdas\CustomRest::getMatvelJoinRapor');
$app->put('/rest/NilaiRapor/{which}', 'DataDikdas\CustomRest::saveNilaiRapor');
$app->get('/rest/TemplateUn', 'DataDikdas\CustomRest::getTemplateUn');
$app->get('/rest/JenisPtk', 'DataDikdas\CustomRest::getJenisPtk');
$app->get('/rest/MatevRapor', 'DataDikdas\CustomRest::getMatevRapor');

$app->post('/rest/PesertaDidikLongitudinal', 'DataDikdas\CustomRest::postDataLongitudinalPesertaDidik');
$app->post('/rest/PrasaranaLongitudinal', 'DataDikdas\CustomRest::postDataLongitudinalPrasarana');
$app->post('/rest/SaranaLongitudinal', 'DataDikdas\CustomRest::postDataLongitudinalSarana');
$app->post('/rest/BukuAlatLongitudinal', 'DataDikdas\CustomRest::postDataLongitudinalBukuAlat');
$app->post('/rest/PtkTerdaftar', 'DataDikdas\CustomRest::postPtkTerdaftar');
$app->post('/rest/RegistrasiPesertaDidik', 'DataDikdas\CustomRest::postRegistrasiPesertaDidik');

// RESTful backend
$app->get('/rest/{model}', 'DataDikdas\Rest::get');
$app->post('/rest/{model}', 'DataDikdas\Rest::post');
$app->put('/rest/{model}/{which}', 'DataDikdas\Rest::put');
$app->delete('/rest/{model}/{which}', 'DataDikdas\Rest::delete');
$app->get('/rest/child_delete/{model}', 'DataDikdas\Rest::child_delete');

// Others
$app->get('/download/{which}', function (Request $request) use ($app) {
	
	$root_path = realpath(__DIR__.D."..");
	
	switch($request->get('which')) {
		case "FormulirSekolah": $file = $root_path.D."other".D."Formulir".D."Form_Sekolah.pdf"; break;
		case "FormulirPTK": $file = $root_path.D."other".D."Formulir".D."Form_PTK.pdf"; break;
		case "FormulirPD": $file = $root_path.D."other".D."Formulir".D."Form_PD.pdf"; break;
		case "FAQ": $file = $root_path.D."other".D."FAQ".D."FAQ_01082014.pdf"; break;
		case "ManualAplikasi": $file = $root_path.D."other".D."Manual".D."Manual_Aplikasi_Dapodikdas_v300_01082014.pdf"; break;
		case "ManualPTK": $file = $root_path.D."other".D."Manual".D."Manual_Validasi_Pengisian_PTK_2014_ver_3.pdf"; break;
		default: break;
	}
	
	$stream = function () use ($file) {
		readfile($file);
	};

	return $app->stream($stream, 200, array(
			'Content-Type' => 'application/pdf',
			'Content-length' => filesize($file),
			'Content-Disposition' => 'attachment; filename="'.basename($file).'"'
	));
});

// Validation Backend
$app->get('/validation', 'DataDikdas\Validation::checkAll');

// Registration Backend
$app->post('/registration', 'DataDikdas\Registration::saveRegistration');

// Custom RESTs untuk Beranda
$app->get('/checkingPgHba', 'DataDikdas\CustomRest::checkingPgHba');
$app->get('/customrest/kerusakanPrasarana', 'DataDikdas\CustomRest::getKerusakanPrasarana');
$app->get('/customrest/rombelPortal', 'DataDikdas\CustomRest::getRombelPortal');
$app->get('/customrest/pesertaDidikList', 'DataDikdas\CustomRest::getPesertaDidikList');
$app->get('/customrest/checkingPdb', 'DataDikdas\CustomRest::getCheckingPdb');
$app->post('/customrest/luluskanTingkatAkhir', 'DataDikdas\CustomRest::luluskanTingkatAkhir');
$app->post('/customrest/saveJurusanSp', 'DataDikdas\CustomRest::saveJurusanSp');
$app->post('/customrest/savePdb', 'DataDikdas\CustomRest::savePdb');
$app->post('/customrest/savePtkNew', 'DataDikdas\CustomRest::savePtkNew');
$app->post('/customrest/cekPembelajaran', 'DataDikdas\CustomRest::cekPembelajaran');
$app->post('/customrest/autoCreateMatevRapor', 'DataDikdas\CustomRest::autoCreateMatevRapor');

// Excel Backend
$app->get('/Excel/{which}', 'DataDikdas\Excel::getExcel');
$app->get('/ExcelValidation/{print}', 'DataDikdas\Validation::checkAll');

// Custom customRest
$app->get('/customrest/ptk', 'DataDikdas\CustomRest::getPtk');
$app->get('/customrest/pesertadidik', 'DataDikdas\CustomRest::getPesertaDidik');
$app->get('/customrest/AnggotaRombelWithNisn', 'DataDikdas\CustomRest::getAnggotaRombelWithNisn');

// mengecek kode registrasi
$app->post('/cekkoreg', 'DataDikdas\CustomRest::cekKoreg');
// mengganti status keaktifan pengguna

// Custom RESTs untuk Pembelajaran
$app->get('/customrest/pembelajaran', 'DataDikdas\CustomRest::getPembelajaran');

$app->post('/customrest/{model}', 'DataDikdas\Rest::post');
$app->put('/customrest/{model}/{which}', 'DataDikdas\Rest::put');
$app->delete('/customrest/{model}/{which}', 'DataDikdas\Rest::delete');

// Custom REST untuk salin data periodik
$app->post('/salinPeriodik', 'DataDikdas\CustomRest::salinDataPeriodik');

// Custom REST untuk kenaikan kelas
$app->post('/kenaikankelas', 'DataDikdas\CustomRest::doKenaikanKelas');

// Custom REST untuk Kecamatan
$app->get('/customrest/kecamatan', 'DataDikdas\CustomRest::getKecamatan');

// Custom REST untuk Chart Sarpras
$app->get('/customrest/chartsarpras', 'DataDikdas\CustomRest::getChartSarpras');

// Custom REST untuk Chart Sarpras
$app->get('/customrest/allanggotarombel/{which}', 'DataDikdas\CustomRest::getAllAnggotaRombel');

// Session sekarang diambil melalui Ajax
$app->get('/session', 'DataDikdas\CustomRest::getSession');

$app->get('/kosongkanKkPd', 'DataDikdas\CustomRest::kosongkanKkPd');

// Download Export UN
$app->get('/ExportUn/{tipe}', 'DataDikdas\Excel::getExcelUn');

// Custom REST untuk FeedProxy
$app->get('/feed_proxy', 'DataDikdas\CustomRest::feed_proxy');
$app->post('/feed_proxy', 'DataDikdas\CustomRest::feed_proxy');

// Script Khusus
$app->get('/runBatchFile', 'DataDikdas\CustomRest::runBatchFile');

// Login Backend
$app->post('/login', 'DataDikdas\CustomRest::getLogin');

// Get sync_log date
$app->get('/sync_log', 'DataDikdas\CustomRest::getSyncLog');

// Get Counter
$app->get('/counter', 'DataDikdas\CustomRest::compareDataAndTable');
$app->get('/compare', 'DataDikdas\CustomRest::compareRemoteAndLokal');

// Logout
$app->get('/destauth', function(Request $request) use ($app) {
	$app['session']->clear();
	return $app->redirect('/');
});

// Backup Generation
$app->post('/BackupGen', 'DataDikdas\Util\BackupGen::go');

// Unduh File Offline
$app->get('/UnduhFileOffline/{nama_file}', 'DataDikdas\Util\BackupGen::downloadFileOffline');

// BSD
$app->get('/bsd', 'DataDikdas\CustomRest::sendByBSD');

return $app;