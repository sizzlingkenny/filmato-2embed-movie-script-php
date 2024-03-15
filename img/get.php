<style>
form {
	margin: 5% auto;
	border-radius: .3rem;
	padding: 20px;
	border: #2274ac40 1px solid;
	text-align: center;	
}
@media only screen and (max-width:800px) {
	form {
		width: 85%;
		margin: 5% auto;
		border-radius: .3rem;
		padding: 20px;
		border: #2274ac40 1px solid;
		text-align: center;
	}
}    

input {
    width: 100%;
    padding: 20px;
    border-radius: 6px;
    margin-bottom: 10px;
    border: 1px solid #839af5;
	background:#f7f7f7;
}
.btn {
    width: 100%;
    padding: .5rem;
    border: 0;
    background: #2a5182;
    font-size: 1.2em;
    color: #fff;
    text-shadow: 1px 1px 0px rgba(0, 0, 0, .4);
    box-shadow: 0px 3px 0px #2a5182;
    margin-top: 1.2rem;
}
.btn:hover {
    background: #00398c;
    color: #b5b5b5;
    box-shadow: none;
}
.form-control {
    display: block;
    width: 100%;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #d6d8db;
    background-color: #3c4760;
    background-clip: padding-box;
    border: 1px solid #72a7db;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
.progress {
    position: relative;
    margin: 20px;
    height: 1.2rem;
	font-family: 'oswald'
}
.progress-bar {
    background-color: #7eeed8;
    width: 100%;
    height: 1.2rem;
}
progress::-webkit-progress-value {
    background: #2a5182;
}
progress::-webkit-progress-bar {
    background: #1e1e3c;
}
progress::-moz-progress-bar {
    background: #2a5182;
}
</style>
<form id="upload_form" enctype="multipart/form-data" method="post" style="background:#fff;">
	<div class="form-group">
		<input type="file" name="uploadingfile" id="uploadingfile" required>
	</div>
	<div class="form-group">
		<input id="uploadingfilebtn" class="btn btn-primary" type="button" value="Upload File" name="btnSubmit" onclick="uploadFileHandler()">
	</div>
	<div class="form-group">
		<div id="progressDiv" style="display:none;">
			<div id="spinner" style="width:100%;margin-top:-20px;">
				<img src="https://raw.githubusercontent.com/sizzlingkenny/filmato-2embed-movie-script-php/main/img/spinner.gif" style="width:220px;">
			</div>
			<progress id="progressBar" value="0" max="100" style="width:100%;height:1.5rem;border:none;margin-top:25px;background:#bbb;"></progress>
		</div>
	</div>
	<div class="form-group" style="margin-top:30px;">
		<div id="status"></div>
		<p id="uploaded_progress"></p>
	</div>				
</form>

<script>
    function _(abc) {
    return document.getElementById(abc);
}
function uploadFileHandler() {
    document.getElementById('progressDiv').style.display='block';
    var file = _("uploadingfile").files[0];
    var formdata = new FormData();
    formdata.append("uploadingfile", file);
    var ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    ajax.open("POST", "get.php");
    ajax.send(formdata);
}
function progressHandler(event) {
    var loaded = new Number((event.loaded / 1048576));//Make loaded a "number" and divide bytes to get Megabytes
    var total = new Number((event.total / 1048576));//Make total file size a "number" and divide bytes to get Megabytes
    _("uploaded_progress").innerHTML = "Uploaded <span style='color:red;'>" + loaded.toPrecision(5) + "</span> MB out of <span style='color:red'>" + total.toPrecision(5) + "</span> MB";//String output
    var percent = (event.loaded / event.total) * 100;//Get percentage of upload progress
    _("progressBar").value = Math.round(percent);//Round value to solid
	_("status").innerHTML = Math.round(percent) + "% uploaded";//String output
	document.getElementById('uploadingfile').style.display = 'none';
	document.getElementById('uploadingfilebtn').style.display = 'none';
	
	$("#spinner").show();
}
function completeHandler(event) {
    _("status").innerHTML = event.target.responseText;//Build and show response text
    _("progressBar").value = 0;//Set progress bar to 0
    document.getElementById('progressDiv').style.display = 'none';//Hide progress bar
}
function errorHandler(event) {
    _("status").innerHTML = "Upload Failed";//Switch status to upload failed
}
function abortHandler(event) {
    _("status").innerHTML = "Upload Aborted";//Switch status to aborted
}
</script>

<?php
if (!$_FILES["uploadingfile"]["tmp_name"]) {}else{

$data = array(
    'file' => new CurlFile($_FILES["uploadingfile"]["tmp_name"], $_FILES["uploadingfile"]["type"],   $_FILES["uploadingfile"]["name"]),
    'fld_id' => '16507',
    'key' => '664uss7bq1vy6gqx72l'
);

// Prepare the cURL call to upload the external script
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://ymlkgw3t2hmz.sw-cdnstreamwish.com/upload/01");
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:54.0) Gecko/20100101 Firefox/54.0");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$res = curl_exec($ch);
curl_close($ch);

$obj = json_decode($res, true);
$swid = $obj['files']['0']['filecode'];
$filename = $obj['files']['0']['filename'];

echo $filename.'<br>';
echo $swid;

}
?>