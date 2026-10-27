<head>
<meta charset="utf-8">
<title>Hospify administrator workspace</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Hospify administrator workspace">
<link rel="shortcut icon" href="assets/images/favicon.ico">
<link href="assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css">
<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
<link href="assets/css/app.min.css" rel="stylesheet" type="text/css">
<link href="assets/libs/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css">
<link href="assets/libs/footable/footable.core.min.css" rel="stylesheet" type="text/css">
<link href="../../../assets2/css/hospify-modern.css" rel="stylesheet" type="text/css">
<script src="assets/js/swal.js"></script>
<?php if(isset($success)): ?><script>window.setTimeout(function(){if(typeof swal==='function'){swal('Success',<?= json_encode((string)$success) ?>,'success');}},100);</script><?php endif; ?>
<?php if(isset($err)): ?><script>window.setTimeout(function(){if(typeof swal==='function'){swal('Notice',<?= json_encode((string)$err) ?>,'error');}},100);</script><?php endif; ?>
</head>